<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Classifieds Plugin 1.4.0-dev                                                  |
// +---------------------------------------------------------------------------+
// | functions.inc                                                             |
// |                                                                           |
// | This file does two things: 1) it implements the necessary Geeklog Plugin  |
// | API methods and 2) implements all the common code needed by this plugin.  |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2014 by the following authors:                              |
// |                                                                           |
// | Authors: ::Ben - cordiste AT free DOT fr                                  |
// +---------------------------------------------------------------------------+
// | Created with the Geeklog Plugin Toolkit.                                  |
// +---------------------------------------------------------------------------+
// |                                                                           |
// | This program is free software; you can redistribute it and/or             |
// | modify it under the terms of the GNU General Public License               |
// | as published by the Free Software Foundation; either version 2            |
// | of the License, or (at your option) any later version.                    |
// |                                                                           |
// | This program is distributed in the hope that it will be useful,           |
// | but WITHOUT ANY WARRANTY; without even the implied warranty of            |
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the             |
// | GNU General Public License for more details.                              |
// |                                                                           |
// | You should have received a copy of the GNU General Public License         |
// | along with this program; if not, write to the Free Software Foundation,   |
// | Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.           |
// |                                                                           |
// +---------------------------------------------------------------------------+

/**
* @package Classifieds
*/

if (strpos(strtolower($_SERVER['PHP_SELF']), 'functions.inc') !== false) {
    die ('This file can not be used on its own.');
}

/**
 * Language file include
 */
$plugin_path = $_CONF['path'] . 'plugins/classifieds/';
$langfile = $plugin_path . 'language/' . $_CONF['language'] . '.php';

if (file_exists($langfile)) {
    require_once $langfile;
} else {
    require_once $plugin_path . 'language/english.php';
}
/**
 * Load our config
 */
require_once $_CONF['path_system'] . 'classes/config.class.php';
require_once $plugin_path . 'install_defaults.php';

$c = config::get_instance();
$storedClassifiedsConfig = $c->get_config('classifieds');
if (!is_array($storedClassifiedsConfig)) {
    $storedClassifiedsConfig = array();
}

$_CLASSIFIEDS_CONF = array_merge(
    $_CLASSIFIEDS_DEFAULT,
    $storedClassifiedsConfig
);

/*
 * Include derived Classifieds paths/URLs.
 */
require_once $_CONF['path'] . 'plugins/classifieds/classifieds.php';

/**
 * Include plugin files.
 *
 * The historical Pro edition is now integrated into the standard plugin.
 * Legacy files under path_data/classifieds_data/proversion are intentionally
 * not loaded so the old and new implementations can never run together.
 */
require_once $_CONF['path'] . 'plugins/classifieds/lib-notifications.php';
require_once $_CONF['path'] . 'plugins/classifieds/lib-images.php';
require_once $_CONF['path'] . 'plugins/classifieds/lib-republish.php';
require_once $_CONF['path'] . 'plugins/classifieds/lib-ads.php';
require_once $_CONF['path'] . 'plugins/classifieds/lib-contact.php';




// +---------------------------------------------------------------------------+
// | Geeklog Plugin API Implementation                                         |
// +---------------------------------------------------------------------------+

function plugin_getheadercode_classifieds()
{
    global $_CONF, $_CLASSIFIEDS_CONF;

    $retval = '';

    $cssPath = $_CLASSIFIEDS_CONF['path_html'] . 'css/classifieds.css';
    $cssVersion = is_file($cssPath) ? filemtime($cssPath) : plugin_chkVersion_classifieds();

    $retval .= '    <link rel="stylesheet" href="' . $_CLASSIFIEDS_CONF['site_url']
        . '/css/classifieds.css?v=' . rawurlencode((string) $cssVersion)
        . '" type="text/css" media="screen"' . XHTML . '>' . LB;

    return $retval;
}

function plugin_commentsupport_classifieds()
{
    // Classifieds Module will use comments
    return true;
}

/**
* Provide URL and ID for the link to a comment's parent
*
* @return   array   array consisting of the base URL and the ID name
*
*/
function plugin_getcommenturlid_classifieds()
{
    global $_CLASSIFIEDS_CONF;

    return array($_CLASSIFIEDS_CONF['site_url']
                                . "/index.php" , 'mode=v&ad');
}

/**
 * classifieds saves a comment
 *
 * @param   string  $type   Plugin to save comment
 * @param   string  $title  comment title
 * @param   string  $comment comment text
 * @param   string  $id     Item id to which $cid belongs
 * @param   int     $pid    comment parent
 * @param   string  $postmode 'html' or 'text'
 * @return  mixed   false for failure, HTML string (redirect?) for success
 */
function plugin_commentenabled_classifieds($id)
{
    global $_CLASSIFIEDS_CONF, $_TABLES;

    $clid = (int) $id;
    if ($clid <= 0 || !CLASSIFIEDS_checkAdAccess($clid)) {
        return COMMENT_CODE_DISABLED;
    }

    $result = DB_query(
        "SELECT created, deleted, enable FROM {$_TABLES['cl']} "
        . "WHERE clid = " . $clid . " LIMIT 1"
    );
    $ad = DB_fetchArray($result);
    if (!is_array($ad) || !empty($ad['deleted']) || empty($ad['enable'])) {
        return COMMENT_CODE_DISABLED;
    }

    $created = COM_getUserDateTimeFormat($ad['created']);
    $createdTimestamp = isset($created[1]) ? (int) $created[1] : 0;
    if ($createdTimestamp <= 0) {
        return COMMENT_CODE_DISABLED;
    }

    $ageDays = (time() - $createdTimestamp) / 86400;
    if ($ageDays > (int) $_CLASSIFIEDS_CONF['active_days']) {
        return COMMENT_CODE_CLOSED;
    }

    return COMMENT_CODE_ENABLED;
}

/**
 * Save a comment attached to a Classifieds ad.
 */
function plugin_savecomment_classifieds($title, $comment, $id, $pid, $postmode)
{
    global $_CONF, $LANG03, $_CLASSIFIEDS_CONF;

    $clid = (int) $id;
    if (plugin_commentenabled_classifieds($clid) != COMMENT_CODE_ENABLED) {
        COM_handle404($_CLASSIFIEDS_CONF['site_url'] . '/index.php');
    }

    $retval = '';
    $ret = CMT_saveComment(
        $title,
        $comment,
        (string) $clid,
        $pid,
        'classifieds',
        $postmode
    );

    if (($ret > 0) || is_string($ret)) {
        if (is_string($ret)) {
            $retval .= $ret;
        }

        $retval .= CMT_commentForm(
            $title,
            $comment,
            (string) $clid,
            $pid,
            'classifieds',
            $LANG03[14],
            $postmode
        );

        if (!defined('COMMENT_ON_SAME_PAGE') || !COMMENT_ON_SAME_PAGE) {
            $retval = COM_createHTMLDocument(
                $retval,
                array('pagetitle' => $LANG03[1])
            );
        }

        return $retval;
    }

    $url = plugin_idToURL_classifieds('classifieds', $clid);
    if (($_CONF['commentsubmission'] == 1)
        && !SEC_hasRights('comment.submit')) {
        $url .= '&msg=15';
    }

    return COM_refresh($url);
}

/**
 * classifieds: delete a comment
 *
 * @param   int     $cid    Comment to be deleted
 * @param   string  $id     Item id to which $cid belongs
 * @return  mixed   false for failure, HTML string (redirect?) for success
 */
function plugin_deletecomment_classifieds($cid, $id, $returnBoolean = false)
{
    global $_CONF, $_TABLES, $_USER, $_CLASSIFIEDS_CONF;

    $clid = (int) $id;
    $retval = false;

    $result = DB_query(
        "SELECT owner_id, group_id, perm_owner, perm_group, perm_members, perm_anon "
        . "FROM {$_TABLES['cl']} WHERE clid = " . $clid . " LIMIT 1"
    );
    $A = DB_fetchArray($result);

    $canDelete = is_array($A)
        && (SEC_hasRights('classifieds.admin')
            || SEC_hasAccess(
                $A['owner_id'],
                $A['group_id'],
                $A['perm_owner'],
                $A['perm_group'],
                $A['perm_members'],
                $A['perm_anon']
            ) == 3);

    if ($canDelete) {
        CMT_deleteComment($cid, (string) $clid, 'classifieds');

        if ($returnBoolean) {
            return true;
        }

        return COM_refresh(
            $_CLASSIFIEDS_CONF['site_url']
            . '/index.php?mode=v&ad=' . $clid . '&amp;aid=-1'
        );
    }

    $username = isset($_USER['username']) ? $_USER['username'] : 'anonymous';
    COM_errorLog(
        'Classifieds: user ' . $username
        . ' tried to delete comment ' . (int) $cid
        . ' from ad ' . $clid . ' without permission.'
    );

    if ($returnBoolean) {
        return false;
    }

    return COM_refresh($_CONF['site_url'] . '/index.php');
}

/**
* Plugin should display [a] comment[s]
*
* @param   string  $id     Unique idenifier for item comment belongs to
* @param   int     $cid    Comment id to display (possibly including sub-comments)
* @param   string  $title  Page/comment title
* @param   string  $order  'ASC' or 'DESC' or blank
* @param   string  $format 'threaded', 'nested', or 'flat'
* @param   int     $page   Page number of comments to display
* @param   boolean $view   True to view comment (by cid), false to display (by $pid)
* @return  mixed   results of calling the plugin_displaycomment_ function
*/
function plugin_displaycomment_classifieds($id, $cid, $title, $order, $format, $page, $view)
{
    global $_TABLES, $LANG_ACCESS, $LANG_CLASSIFIEDS_1;

    $clid = (int) $id;
    if ($clid <= 0) {
        return COM_showMessageText(
            $LANG_CLASSIFIEDS_1['ads_not_available'],
            $LANG_ACCESS['accessdenied']
        );
    }

    $sql = "SELECT owner_id, group_id, perm_owner, perm_group, perm_members, perm_anon "
        . "FROM {$_TABLES['cl']} "
        . "WHERE clid = " . $clid
        . " AND deleted = 0"
        . COM_getPermSQL('AND')
        . " LIMIT 1";

    $result = DB_query($sql);
    $A = DB_fetchArray($result);

    if (!is_array($A)) {
        return COM_showMessageText(
            $LANG_CLASSIFIEDS_1['ads_not_available'],
            $LANG_ACCESS['accessdenied']
        );
    }

    $deleteOption = SEC_hasRights('classifieds.admin')
        || SEC_hasAccess(
            $A['owner_id'],
            $A['group_id'],
            $A['perm_owner'],
            $A['perm_group'],
            $A['perm_members'],
            $A['perm_anon']
        ) == 3;

    return CMT_userComments(
        (string) $clid,
        $title,
        'classifieds',
        $order,
        $format,
        $cid,
        $page,
        $view,
        $deleteOption,
        0
    );
}

/**
* Returns the item(s) for this plugin that should appear on the main menu
*
* NOTE: this MUST return the url/value pairs in the following format
* $<arrayname>[<label>] = <url>
*
* @return   mixed   menu entry, or boolean false if disabled / hidden
*
*/
function plugin_getmenuitems_classifieds()
{
    global $_CLASSIFIEDS_CONF;
	
	if ($_CLASSIFIEDS_CONF['hide_classifieds_menu'] == 1) return;

    $url = $_CLASSIFIEDS_CONF['site_url'] . '/index.php';
    $menuitems[$_CLASSIFIEDS_CONF['menulabel']] = $url;

    return $menuitems;
}

/**
* Geeklog is asking us to provide any items that show up in the type
* drop-down on search.php.  Let's users search for ads.
*
* @return   array   (plugin name/entry title) pair for the dropdown
*
*/

function plugin_searchtypes_classifieds()
{
    global $LANG_CLASSIFIEDS_1;

    $tmp['classifieds'] = $LANG_CLASSIFIEDS_1['plugin_name'];

    return $tmp;
}


/**
* This searches for entries matching the user query and returns an array for the
* header and table rows back to search.php where it will be formated and printed
*
* @param    string  $query      Keywords user is looking for
* @param    date    $datestart  Start date to get results for
* @param    date    $dateend    End date to get results for
* @param    string  $topic      The topic they were searching in
* @param    string  $type       Type of items they are searching, or 'all' (deprecated)
* @param    int     $author     Get all results by this author
* @param    string  $keyType    search key type: 'all', 'phrase', 'any'
* @param    int     $page       page number of current search (deprecated)
* @param    int     $perpage    number of results per page (deprecated)
* @return   object              search result object
*
*/

function plugin_dopluginsearch_classifieds(
    $query,
    $datestart,
    $dateend,
    $topic,
    $type,
    $author,
    $keyType,
    $page,
    $perpage
) {
    global $_TABLES, $_CLASSIFIEDS_CONF, $LANG_CLASSIFIEDS_1;

    $activeDays = max(0, (int) $_CLASSIFIEDS_CONF['active_days']);

    $sql = "SELECT a.clid AS id, a.title, a.text AS description, "
        . "UNIX_TIMESTAMP(a.created) AS date, a.owner_id AS uid, a.hits, "
        . "CONCAT('/" . DB_escapeString($_CLASSIFIEDS_CONF['classifieds_folder'])
        . "/index.php?mode=v&ad=', a.clid) AS url "
        . "FROM {$_TABLES['cl']} AS a "
        . "INNER JOIN {$_TABLES['cl_cat']} AS c ON c.cid = a.catid "
        . "WHERE a.deleted = 0 "
        . "AND a.enable = 1 "
        . "AND c.catdeleted = 0 "
        . "AND TO_DAYS(NOW()) - TO_DAYS(a.created) <= " . $activeDays . " "
        . COM_getPermSQL('AND', 0, 2, 'a') . ' ';

    if (!empty($datestart) && !empty($dateend)) {
        $delim = substr($datestart, 4, 1);
        if ($delim !== '') {
            $start = explode($delim, $datestart);
            $end = explode($delim, $dateend);
            if (count($start) === 3 && count($end) === 3) {
                $startdate = mktime(0, 0, 0, (int) $start[1], (int) $start[2], (int) $start[0]);
                $enddate = mktime(23, 59, 59, (int) $end[1], (int) $end[2], (int) $end[0]);
                $sql .= "AND UNIX_TIMESTAMP(a.created) BETWEEN "
                    . (int) $startdate . " AND " . (int) $enddate . " ";
            }
        }
    }

    $author = (int) $author;
    if ($author > 0) {
        $sql .= "AND a.owner_id = " . $author . " ";
    }

    $search = new SearchCriteria('classifieds', $LANG_CLASSIFIEDS_1['plugin_name']);
    list($sql, $ftsql) = $search->buildSearchSQL(
        $keyType,
        trim($query),
        array('a.title', 'a.text'),
        $sql
    );

    $search->setSQL($sql);
    $search->setFTSQL($ftsql);
    $search->setRank(3);

    return $search;
}


/**
* Implements a [classifieds:] autotag.
*
* @param    string  $op         operation to perform
* @param    string  $content    item (e.g. story text), including the autotag
* @param    array   $autotag    parameters used in the autotag
* @param    mixed               tag names (for $op='tagname') or formatted content
*
*/

function plugin_autotags_classifieds($op, $content = '', $autotag = '')
{
    if ($op === 'tagname') {
        return 'classifieds';
    }

    if ($op !== 'parse' || !is_array($autotag)) {
        return $content;
    }

    $clid = isset($autotag['parm1']) ? (int) $autotag['parm1'] : 0;
    if ($clid <= 0) {
        return $content;
    }

    $title = plugin_getiteminfo_classifieds($clid, 'title');
    if ($title === '' || is_array($title)) {
        return $content;
    }

    $linktext = !empty($autotag['parm2']) ? $autotag['parm2'] : $title;
    $url = plugin_idToURL_classifieds('classifieds', $clid);
    $link = COM_createLink($linktext, $url);

    return str_replace($autotag['tagstr'], $link, $content);
}


/**
 * Return normalized Classifieds item information to generic Geeklog consumers.
 *
 * @param mixed  $id
 * @param string $what
 * @param int    $uid
 * @param array  $options
 * @return mixed
 */
function plugin_getiteminfo_classifieds($id, $what, $uid = 0, $options = array())
{
    global $_CLASSIFIEDS_CONF, $_TABLES;

    $properties = explode(',', $what);
    $fields = array('a.clid', 'a.deleted', 'a.enable');

    foreach ($properties as $property) {
        switch ($property) {
            case 'date-created':
                $fields[] = 'UNIX_TIMESTAMP(a.created) AS c_unixdate';
                break;
            case 'date-modified':
                $fields[] = 'UNIX_TIMESTAMP(a.modified) AS m_unixdate';
                break;
            case 'title':
                $fields[] = 'a.title';
                break;
            case 'description':
            case 'excerpt':
                $fields[] = 'a.text';
                break;
            case 'id':
            case 'url':
                $fields[] = 'a.clid';
                break;
        }
    }

    $fields = array_unique($fields);
    $sql = 'SELECT ' . implode(',', $fields) . " FROM {$_TABLES['cl']} AS a";

    if ($id === '*') {
        $sql .= " WHERE a.deleted = 0 AND a.enable = 1"
            . " AND TO_DAYS(NOW()) - TO_DAYS(a.created) <= "
            . (int) $_CLASSIFIEDS_CONF['active_days'];
    } else {
        $itemId = (int) $id;
        if ($itemId <= 0) {
            return array();
        }
        $sql .= ' WHERE a.clid = ' . $itemId
            . ' AND a.deleted = 0 AND a.enable = 1'
            . ' AND TO_DAYS(NOW()) - TO_DAYS(a.created) <= '
            . (int) $_CLASSIFIEDS_CONF['active_days'];
    }

    $sql .= COM_getPermSQL('AND', $uid, 2, 'a');

    if ($id !== '*') {
        $sql .= ' LIMIT 1';
    }

    $result = DB_query($sql);
    $retval = array();

    while ($A = DB_fetchArray($result)) {
        $props = array();

        foreach ($properties as $property) {
            switch ($property) {
                case 'date-created':
                    $props['date-created'] = isset($A['c_unixdate']) ? (int) $A['c_unixdate'] : 0;
                    break;
                case 'date-modified':
                    $props['date-modified'] = isset($A['m_unixdate']) ? (int) $A['m_unixdate'] : 0;
                    break;
                case 'id':
                    $props['id'] = (int) $A['clid'];
                    break;
                case 'title':
                    $props['title'] = isset($A['title']) ? $A['title'] : '';
                    break;
                case 'description':
                    $props['description'] = isset($A['text'])
                        ? trim(strip_tags($A['text']))
                        : '';
                    break;
                case 'excerpt':
                    $description = isset($A['text']) ? trim(strip_tags($A['text'])) : '';
                    $props['excerpt'] = (strlen($description) > 255)
                        ? substr($description, 0, 252) . '...'
                        : $description;
                    break;
                case 'url':
                    $props['url'] = plugin_idToURL_classifieds('classifieds', $A['clid']);
                    break;
                default:
                    $props[$property] = '';
                    break;
            }
        }

        if ($id === '*') {
            $retval[] = $props;
        } else {
            $values = array();
            foreach ($properties as $property) {
                $values[] = isset($props[$property]) ? $props[$property] : '';
            }
            $retval = (count($values) === 1) ? $values[0] : $values;
            break;
        }
    }

    return $retval;
}

/**
 * Return public Classifieds URLs for Geeklog XML sitemap generation.
 *
 * @param int $uid
 * @param int $limit
 * @return array
 */
function plugin_collectSitemapItems_classifieds($uid = 1, $limit = 0)
{
    global $_CLASSIFIEDS_CONF, $_TABLES;

    $uid = (int) $uid;
    $limit = (int) $limit;

    $sql = "SELECT a.clid, UNIX_TIMESTAMP(a.modified) AS modified "
        . "FROM {$_TABLES['cl']} AS a "
        . "WHERE a.deleted = 0 "
        . "AND a.enable = 1 "
        . "AND TO_DAYS(NOW()) - TO_DAYS(a.created) <= "
        . (int) $_CLASSIFIEDS_CONF['active_days']
        . COM_getPermSQL('AND', $uid, 2, 'a')
        . " ORDER BY a.modified DESC";

    if ($limit > 0) {
        $sql .= ' LIMIT ' . $limit;
    }

    $result = DB_query($sql);
    $items = array();

    while ($A = DB_fetchArray($result)) {
        $items[] = array(
            'url' => plugin_idToURL_classifieds('classifieds', $A['clid']),
            'date-modified' => isset($A['modified']) ? (int) $A['modified'] : 0,
            'change-freq' => 'weekly',
            'priority' => 0.6
        );
    }

    return $items;
}

/**
 * Resolve a Classifieds item URL without requiring the item to exist.
 *
 * @param string $sub_type
 * @param mixed  $item_id
 * @return string
 */
function plugin_idToURL_classifieds($sub_type, $item_id)
{
    global $_CLASSIFIEDS_CONF;

    return $_CLASSIFIEDS_CONF['site_url']
        . '/index.php?mode=v&ad=' . (int) $item_id;
}

/**
 * Declare provider-neutral Classifieds capabilities.
 *
 * @return array
 */
function plugin_getcapabilities_classifieds()
{
    return array(
        'schema' => 1,
        'roles' => array('content', 'service'),
        'capabilities' => array(
            'content.read',
            'content.collection',
            'content.search',
            'content.url.resolve',
            'content.lifecycle',
            'dashboard.summary'
        )
    );
}

/**
 * Enable bounded Geeklog services exposed by Classifieds.
 *
 * @return bool
 */
function plugin_wsEnabled_classifieds()
{
    return true;
}

/**
 * Return an administration dashboard summary.
 *
 * @param array $args
 * @param array &$output
 * @param array &$svc_msg
 * @return int
 */
function service_dashboard_summary_classifieds($args, &$output, &$svc_msg)
{
    global $_CONF, $_CLASSIFIEDS_CONF, $_TABLES, $LANG_CLASSIFIEDS_ADMIN;

    if (!SEC_hasRights('classifieds.admin')) {
        return PLG_RET_PERMISSION_DENIED;
    }

    $activeDays = (int) $_CLASSIFIEDS_CONF['active_days'];

    $active = (int) DB_getItem(
        $_TABLES['cl'],
        'COUNT(*)',
        "deleted = 0 AND enable = 1 "
        . "AND TO_DAYS(NOW()) - TO_DAYS(created) <= " . $activeDays
    );
    $expired = (int) DB_getItem(
        $_TABLES['cl'],
        'COUNT(*)',
        "deleted = 0 AND enable = 1 "
        . "AND TO_DAYS(NOW()) - TO_DAYS(created) > " . $activeDays
    );
    $deleted = (int) DB_getItem(
        $_TABLES['cl'],
        'COUNT(*)',
        "deleted = 1"
    );
    $categories = (int) DB_getItem(
        $_TABLES['cl_cat'],
        'COUNT(*)',
        "catdeleted = 0"
    );

    $alerts = array();
    $status = 'ok';

    if (!is_dir($_CLASSIFIEDS_CONF['path_images'])
        || !is_writable($_CLASSIFIEDS_CONF['path_images'])) {
        $status = 'warning';
        $alerts[] = array(
            'id' => 'storage',
            'status' => 'warning',
            'message' => $LANG_CLASSIFIEDS_ADMIN['dashboard_storage_warning']
        );
    }

    $output = array(
        'schema' => 1,
        'status' => $status,
        'metrics' => array(
            array(
                'id' => 'active',
                'label' => $LANG_CLASSIFIEDS_ADMIN['dashboard_active'],
                'value' => $active
            ),
            array(
                'id' => 'expired',
                'label' => $LANG_CLASSIFIEDS_ADMIN['dashboard_expired'],
                'value' => $expired
            ),
            array(
                'id' => 'deleted',
                'label' => $LANG_CLASSIFIEDS_ADMIN['dashboard_deleted'],
                'value' => $deleted
            ),
            array(
                'id' => 'categories',
                'label' => $LANG_CLASSIFIEDS_ADMIN['dashboard_categories'],
                'value' => $categories
            )
        ),
        'alerts' => $alerts,
        'links' => array(
            array(
                'label' => $LANG_CLASSIFIEDS_ADMIN['dashboard_manage'],
                'url' => $_CONF['site_admin_url'] . '/plugins/classifieds/index.php'
            )
        ),
        'updated' => time()
    );

    $svc_msg = array();

    return PLG_RET_OK;
}

/**
* Return plugin entry for "Command and Control" (moderation.php)
*
* @return  array  Array containing (plugin name, admin url, url of plugin icon)
*
*/
function plugin_cclabel_classifieds()
{
    global $_CONF, $LANG_CLASSIFIEDS_1;

    if (!SEC_hasRights('classifieds.admin')) {
        return false;
    }

    return array(
        $LANG_CLASSIFIEDS_1['plugin_name'],
        $_CONF['site_admin_url'] . '/plugins/classifieds/index.php',
        plugin_geticon_classifieds()
    );
}

/**
* Return plugin entry for the Admins Only block
*
* @return array Array containing (plugin name, plugin admin url, # of plugin items or '')
*/
function plugin_getadminoption_classifieds()
{
    global $_CONF, $LANG_CLASSIFIEDS_1;

    if (!SEC_hasRights('classifieds.admin')) {
        return array();
    }

    return array(
        $LANG_CLASSIFIEDS_1['plugin_name'],
        $_CONF['site_admin_url'] . '/plugins/classifieds/index.php',
        ''
    );
}

/**
* Returns the user option for this plugin
*
* Adds the plugin to the user menu
*
* Universal Plugin:  modify/uncomment use it
*
* @return   array   Array containing (plugin name, plugin user url, 0)
*
*/
function plugin_getuseroption_classifieds() {
    global $_CLASSIFIEDS_CONF, $_USER, $LANG_CLASSIFIEDS_1;

    if (COM_isAnonUser()) return '';

    $menuitems = array();

    $menuitems[] = array($LANG_CLASSIFIEDS_1['my_ads'], $_CLASSIFIEDS_CONF['site_url'] . '/index.php?mode=my', 0);

    return $menuitems;
}

/**
* Returns the URL of the plugin's icon
*
* @return   string      URL of the icon
*
*/
function plugin_geticon_classifieds()
{
    global $_CONF;

    // popular alternative location:
    // return $_CONF['site_url'] . '/classifieds/images/classifieds.png';

    return $_CONF['site_admin_url'] . '/plugins/classifieds/images/classifieds.png';
}

/**
 * Returns the current plugin code version
 *
 * @return string    plugin version
 */
function plugin_chkVersion_classifieds()
{
    global $_CONF;

    require_once $_CONF['path'] . 'plugins/classifieds/autoinstall.php';

    $inst_parms = plugin_autoinstall_classifieds('classifieds');

    return $inst_parms['info']['pi_version'];
}

/**
 * Return localized help for native Geeklog configuration options.
 *
 * @param string $id
 * @return string
 */
function plugin_getconfigtooltip_classifieds($id)
{
    global $LANG_configtooltips;

    if (isset($LANG_configtooltips['classifieds'])
        && isset($LANG_configtooltips['classifieds'][$id])) {
        return $LANG_configtooltips['classifieds'][$id];
    }

    return '';
}

/**
 * Repair native configuration metadata without changing administrator values.
 *
 * @return bool
 */
function CLASSIFIEDS_upgradeConfiguration()
{
    global $_TABLES, $_CLASSIFIEDS_DEFAULT;

    require_once dirname(__FILE__) . '/install_defaults.php';

    $c = config::get_instance();

    // config::add() deletes/recreates an existing row, so never call it
    // blindly during an upgrade. Only create genuinely missing entries.
    $definitions = array(
        'sg_main' => array(NULL, 'subgroup', 0, 0, NULL, 0, true),
        'tab_main' => array(NULL, 'tab', 0, 0, NULL, 0, true),

        'fs_main' => array(NULL, 'fieldset', 0, 0, NULL, 0, true),
        'classifieds_folder' => array($_CLASSIFIEDS_DEFAULT['classifieds_folder'], 'text', 0, 0, NULL, 10, true),
        'active_days' => array($_CLASSIFIEDS_DEFAULT['active_days'], 'text', 0, 0, NULL, 20, true),

        'fs_images' => array(NULL, 'fieldset', 0, 1, NULL, 0, true),
        'max_image_width' => array($_CLASSIFIEDS_DEFAULT['max_image_width'], 'text', 0, 1, NULL, 101, true),
        'max_image_height' => array($_CLASSIFIEDS_DEFAULT['max_image_height'], 'text', 0, 1, NULL, 102, true),
        'max_image_size' => array($_CLASSIFIEDS_DEFAULT['max_image_size'], 'text', 0, 1, NULL, 103, true),
        'max_images_per_ad' => array($_CLASSIFIEDS_DEFAULT['max_images_per_ad'], 'text', 0, 1, NULL, 107, true),

        'fs_display' => array(NULL, 'fieldset', 0, 2, NULL, 0, true),
        'menulabel' => array($_CLASSIFIEDS_DEFAULT['menulabel'], 'text', 0, 2, NULL, 201, true),
        'hide_classifieds_menu' => array($_CLASSIFIEDS_DEFAULT['hide_classifieds_menu'], 'select', 0, 2, 3, 202, true),
        'classifieds_main_header' => array($_CLASSIFIEDS_DEFAULT['classifieds_main_header'], 'text', 0, 2, NULL, 203, true),
        'classifieds_main_footer' => array($_CLASSIFIEDS_DEFAULT['classifieds_main_footer'], 'text', 0, 2, NULL, 204, true),
        'classifieds_edit_header' => array($_CLASSIFIEDS_DEFAULT['classifieds_edit_header'], 'text', 0, 2, NULL, 205, true),
        'help_page' => array($_CLASSIFIEDS_DEFAULT['help_page'], 'text', 0, 2, NULL, 206, true),
        'currency' => array($_CLASSIFIEDS_DEFAULT['currency'], 'text', 0, 2, NULL, 207, true),
        'maxPerPage' => array($_CLASSIFIEDS_DEFAULT['maxPerPage'], 'text', 0, 2, NULL, 210, true),
        'allow_republish' => array(0, 'select', 0, 2, 3, 220, true),

        'fs_email' => array(NULL, 'fieldset', 0, 3, NULL, 0, true),
        'create_ad_email_user' => array($_CLASSIFIEDS_DEFAULT['create_ad_email_user'], 'select', 0, 3, 3, 301, true),
        'mod_ad_email_user' => array($_CLASSIFIEDS_DEFAULT['mod_ad_email_user'], 'select', 0, 3, 3, 302, true),
        'delete_ad_email_user' => array($_CLASSIFIEDS_DEFAULT['delete_ad_email_user'], 'select', 0, 3, 3, 303, true),
        'expire_ad_email_user' => array($_CLASSIFIEDS_DEFAULT['expire_ad_email_user'], 'select', 0, 3, 3, 304, true),
        'create_ad_email_admin' => array($_CLASSIFIEDS_DEFAULT['create_ad_email_admin'], 'select', 0, 3, 3, 305, true),
        'mod_ad_email_admin' => array($_CLASSIFIEDS_DEFAULT['mod_ad_email_admin'], 'select', 0, 3, 3, 306, true),
        'delete_ad_email_admin' => array($_CLASSIFIEDS_DEFAULT['delete_ad_email_admin'], 'select', 0, 3, 3, 307, true),
        'expire_ad_email_admin' => array($_CLASSIFIEDS_DEFAULT['expire_ad_email_admin'], 'select', 0, 3, 3, 308, true),

        'fs_permissions' => array(NULL, 'fieldset', 0, 4, NULL, 0, true),
        'classifieds_login_required' => array($_CLASSIFIEDS_DEFAULT['classifieds_login_required'], 'select', 0, 4, 3, 401, true),
        'default_permissions' => array($_CLASSIFIEDS_DEFAULT['default_permissions'], '@select', 0, 4, 12, 402, true)
    );

    foreach ($definitions as $name => $definition) {
        $exists = (int) DB_getItem(
            $_TABLES['conf_values'],
            'COUNT(*)',
            "group_name = 'classifieds' AND name = '" . DB_escapeString($name) . "'"
        );

        if ($exists === 0) {
            $c->add(
                $name,
                $definition[0],
                $definition[1],
                $definition[2],
                $definition[3],
                $definition[4],
                $definition[5],
                $definition[6],
                'classifieds',
                0
            );
        }
    }

    // Repair metadata only. Never touch the persisted administrator value.
    foreach ($definitions as $name => $definition) {
        $selectionArray = ($definition[4] === NULL) ? -1 : (int) $definition[4];

        DB_query(
            "UPDATE {$_TABLES['conf_values']} SET "
            . "type = '" . DB_escapeString($definition[1]) . "', "
            . "subgroup = " . (int) $definition[2] . ", "
            . "fieldset = " . (int) $definition[3] . ", "
            . "selectionArray = " . $selectionArray . ", "
            . "sort_order = " . (int) $definition[5] . ", "
            . "tab = 0 "
            . "WHERE group_name = 'classifieds' "
            . "AND name = '" . DB_escapeString($name) . "'"
        );

        if (DB_error()) {
            COM_errorLog(
                'Classifieds: unable to repair configuration metadata for ' . $name
            );
            return false;
        }
    }

    // Remove settings that existed only for the deleted TimThumb component.
    foreach (array(
        'thumb_width',
        'thumb_height',
        'max_thumbnail_size',
        'date_format',
        'time_format'
    ) as $obsolete) {
        if ((int) DB_getItem(
            $_TABLES['conf_values'],
            'COUNT(*)',
            "group_name = 'classifieds' AND name = '" . $obsolete . "'"
        ) > 0) {
            $c->del($obsolete, 'classifieds');
        }
    }

    // Verify that the native configuration group can be read after migration.
    $migrated = $c->get_config('classifieds');
    if (!is_array($migrated)
        || !isset($migrated['active_days'])
        || !isset($migrated['max_images_per_ad'])
        || !isset($migrated['default_permissions'])) {
        COM_errorLog('Classifieds: configuration migration verification failed.');
        return false;
    }

    return true;
}

/**
 * Modernize existing Classifieds tables without changing their logical schema.
 *
 * @return bool
 */
function CLASSIFIEDS_upgradeDatabase()
{
    global $_TABLES;

    foreach (array('cl', 'cl_cat', 'cl_pic', 'cl_users') as $tableKey) {
        DB_query("ALTER TABLE {$_TABLES[$tableKey]} ENGINE=InnoDB");
        if (DB_error()) {
            COM_errorLog('Classifieds: failed to convert table ' . $_TABLES[$tableKey] . ' to InnoDB.');
            return false;
        }
    }

    return true;
}

function plugin_upgrade_classifieds()
{
    global $_CONF, $_TABLES;

    $installedVersion = DB_getItem(
        $_TABLES['plugins'],
        'pi_version',
        "pi_name = 'classifieds'"
    );
    $codeVersion = plugin_chkVersion_classifieds();

    if ($installedVersion === $codeVersion) {
        return true;
    }

    require_once $_CONF['path'] . 'plugins/classifieds/autoinstall.php';
    require_once $_CONF['path_system'] . 'classes/config.class.php';

    if (!plugin_compatible_with_this_version_classifieds('classifieds')) {
        return 3002;
    }

    // 1.4.0 has one explicit migration baseline: the last public 1.3.2
    // release. Older installations should first be upgraded with the historical
    // 1.3.2 package instead of carrying all legacy migrations in modern code.
    if (version_compare($installedVersion, '1.3.2', '<')) {
        COM_errorLog(
            'Classifieds 1.4.0 requires Classifieds 1.3.2 as the upgrade baseline. '
            . 'Installed version: ' . $installedVersion
        );
        return false;
    }

    if (!CLASSIFIEDS_upgradeConfiguration()) {
        return false;
    }

    if (!CLASSIFIEDS_upgradeDatabase()) {
        return false;
    }

    if (!CLASSIFIEDS_ensureImageDirectory()) {
        return false;
    }

    $install = plugin_autoinstall_classifieds('classifieds');
    $glVersion = $install['info']['pi_gl_version'];

    DB_query(
        "UPDATE {$_TABLES['plugins']} SET "
        . "pi_version = '" . DB_escapeString($codeVersion) . "', "
        . "pi_gl_version = '" . DB_escapeString($glVersion) . "' "
        . "WHERE pi_name = 'classifieds'"
    );

    if (DB_error()) {
        return false;
    }

    COM_errorLog(
        'Updated Classifieds plugin from v'
        . $installedVersion . ' to v' . $codeVersion,
        1
    );

    return true;
}

/**
* Automatic uninstall function for plugins
*
* This code is automatically uninstalling the plugin.
* It passes an array to the core code function that removes
* tables, groups, features and php blocks from the tables.
* Additionally, this code can perform special actions that cannot be
* foreseen by the core code (interactions with other plugins for example)
*
* @return   array   Plugin information
*
*/
function plugin_autouninstall_classifieds()
{
    $out = array (
        /* give the name of the tables, without $_TABLES[] */
        'tables' => array('cl','cl_cat','cl_pic','cl_users'),
        /* give the full name of the group, as in the db */
        'groups' => array('Classifieds Admin', 'Classifieds Users'),
        /* give the full name of the feature, as in the db */
        'features' => array('classifieds.admin', 'classifieds.publish'),
        /* give the full name of the block, including 'phpblock_', etc */
        'php_blocks' => array(),
        /* give all vars with their name */
        'vars' => array()
    );

    return $out;
}

/**
* Add a block on user profile to display ads posted by user
*
*/
function plugin_profileblocksdisplay_classifieds($uid)
{
    global $LANG_CLASSIFIEDS_1;

    $uid = (int) $uid;
    $retval = COM_startBlock($LANG_CLASSIFIEDS_1['plugin_name']);
    $retval .= CLASSIFIEDS_displayAds($uid, 0, '', '', 1);
    $retval .= COM_endBlock();

    return $retval;
}

/**
 * Filters submitted variables
 *
 * Uses geeklog functions to filter submitted variables for illegal content.  Any editing is
 * done in place and no value is returned
 *
 * @param array $vars associative array of variable name => type (type in (number,alpha,text,html))
 * @param array &$arr reference to associative array of variable name => value
 */
function CLASSIFIEDS_filterVars($vars, &$arr)
{
    foreach ($vars as $var => $type) {
        if (!isset($arr[$var])) {
            $arr[$var] = '';
            continue;
        }

        if (is_array($arr[$var])) {
            // Scalar request fields are expected here. Reject arrays rather than
            // allowing them to trigger warnings or unexpected SQL/string casts.
            $arr[$var] = '';
            continue;
        }

        switch ($type) {
            case 'number':
                $arr[$var] = COM_applyFilter($arr[$var], true);
                break;

            case 'html':
                $arr[$var] = COM_checkHTML($arr[$var], 'classifieds.admin');
                break;

            case 'text':
                $arr[$var] = trim(strip_tags($arr[$var]));
                break;

            case 'alpha':
            default:
                $arr[$var] = COM_applyFilter($arr[$var], false);
                break;
        }
    }
}

/**
 * Returns user menu display
 *
 * Generates the user menu from the template and returns the result as a string of HTML
 *
 * @return string HTML of user menu
 */
function CLASSIFIEDS_user_menu() 
{
    global $_CONF, $_CLASSIFIEDS_CONF, $LANG_CLASSIFIEDS_1, $_TABLES;

    $retval = COM_startBlock();

    // generate the menu from the template
    $menu = new Template($_CONF['path'] . 'plugins/classifieds/templates/menus');
    $menu->set_file(array('menu' => 'user_menu.thtml'));
    $menu->set_var('site_url', $_CLASSIFIEDS_CONF['site_url']);
	$menu->set_var('place_an_ad', $LANG_CLASSIFIEDS_1['place_an_ad']);
	$menu->set_var('all_ads', $LANG_CLASSIFIEDS_1['all_ads']);
	$menu->set_var('offer', $LANG_CLASSIFIEDS_1['offer']);
	$menu->set_var('demand', $LANG_CLASSIFIEDS_1['demand']);
	$menu->set_var('my_ads', $LANG_CLASSIFIEDS_1['my_ads']);
	$menu->set_var('help', $LANG_CLASSIFIEDS_1['help']);
	
	if (SEC_hasRights('classifieds.admin')) {
        $menu->set_var('admin', '| ' . '<a href="' . $_CONF['site_url'] . '/admin/plugins/classifieds/index.php">' . $LANG_CLASSIFIEDS_1['admin'] . '</a>');
    } else {
	    $menu->set_var('admin', '');
	}
	
    $retval .= $menu->parse('output', 'menu');

    $retval .= COM_endBlock();

    // retval results
    return $retval;
}

function CLASSIFIEDS_centerblock_lastAds ($limit = 10) 
{
    global $_CLASSIFIEDS_CONF, $LANG_CLASSIFIEDS_1;
    return CLASSIFIEDS_displayAds ($user = 1, $my = 0, $username='', $view_cat='', $profile=1, $limit) .
	'<small><strong><a href="' . $_CLASSIFIEDS_CONF['site_url'] . '/index.php">'. $LANG_CLASSIFIEDS_1['view_all_ads'] . '</a></strong></small><p>&nbsp;</p>';
}

function CLASSIFIEDS_displayAds ($user = 1, $my = 0, $username='', $view_cat='', $profile=0, $limit= '')
{
    global $_CONF, $_CLASSIFIEDS_CONF, $LANG_CLASSIFIEDS_1, $LANG_CLASSIFIEDS_2, $_TABLES, $_USER;

    $retval = '';
    $page = isset($_REQUEST['page']) ? (int) $_REQUEST['page'] : 1;
    $mode = isset($_REQUEST['mode']) ? (string) $_REQUEST['mode'] : '';
    $catid = isset($_REQUEST['catid']) ? (string) $_REQUEST['catid'] : '';
    $message = isset($_GET['msg']) ? (string) $_GET['msg'] : '';
    $cookieCat = isset($_COOKIE['ads_cat']) ? (string) $_COOKIE['ads_cat'] : '';
    $checked_category = '';

    if ($page <= 0) {
        $page = 1;
    }

    //Check if picture folder is writable
    if ( !file_exists($_CLASSIFIEDS_CONF['path_images']) || !is_writable($_CLASSIFIEDS_CONF['path_images']) ) {
        $msg = '<p>' . $LANG_CLASSIFIEDS_1['image_not_writable'] . '</p>';
        return $msg;
    }
	

    if (COM_isAnonUser() && $my == 1) {
        return SEC_loginRequiredForm();
    }

    $user = (int) $user;
    $activeDays = max(0, (int) $_CLASSIFIEDS_CONF['active_days']);

    $where = array('c.catdeleted = 0');

    if ($my == 1) {
        if ($user > 1) {
            $where[] = 'a.owner_id = ' . $user;
        }
    } else {
        $where[] = 'a.deleted = 0';
        $where[] = 'a.enable = 1';
        $where[] = 'TO_DAYS(NOW()) - TO_DAYS(a.created) <= ' . $activeDays;
        $permSql = trim(COM_getPermSQL('AND', 0, 2, 'a'));
        if (stripos($permSql, 'AND ') === 0) {
            $permSql = trim(substr($permSql, 4));
        }
        if ($permSql !== '') {
            $where[] = $permSql;
        }

        if ($user > 1) {
            $where[] = 'a.owner_id = ' . $user;
        }
    }

    if ($my == 0 && $profile == 0) {
        $categoryId = 0;

        if (is_numeric($cookieCat) && (int) $cookieCat > 0) {
            $categoryId = (int) $cookieCat;
        }

        if ($catid !== '' && $catid !== '--' && is_numeric($catid)) {
            $categoryId = (int) $catid;
        }

        if ($catid === '0') {
            $categoryId = 0;
        }

        if ($categoryId > 0) {
            $where[] = 'a.catid = ' . $categoryId;
        }

        if ($mode === 'o') {
            $where[] = 'a.type = 0';
        } elseif ($mode === 'd') {
            $where[] = 'a.type = 1';
        }
    }

    $whereSql = implode(' AND ', array_filter($where));

    $sql_index = "SELECT a.*, i.pi_filename, c.category, c.catdeleted "
        . "FROM {$_TABLES['cl']} AS a "
        . "LEFT JOIN {$_TABLES['cl_pic']} AS i "
        . "ON i.pi_pid = a.clid "
        . "AND i.pi_img_num = ("
        . "SELECT MIN(p.pi_img_num) FROM {$_TABLES['cl_pic']} AS p "
        . "WHERE p.pi_pid = a.clid"
        . ") "
        . "INNER JOIN {$_TABLES['cl_cat']} AS c ON c.cid = a.catid "
        . "WHERE " . $whereSql
        . " ORDER BY a.created DESC";

    $countSql = "SELECT COUNT(*) AS total "
        . "FROM {$_TABLES['cl']} AS a "
        . "INNER JOIN {$_TABLES['cl_cat']} AS c ON c.cid = a.catid "
        . "WHERE " . $whereSql;

    $countResult = DB_query($countSql);
    $countRow = DB_fetchArray($countResult);
    $count = isset($countRow['total']) ? (int) $countRow['total'] : 0;

    // Keep the requested page inside the filtered result set.
    $perPage = isset($_CLASSIFIEDS_CONF['maxPerPage'])
        ? max(0, (int) $_CLASSIFIEDS_CONF['maxPerPage'])
        : 0;

    if ($perPage > 0 && $count > 0) {
        $lastPage = max(1, (int) ceil($count / $perPage));
        if ($page > $lastPage) {
            $page = $lastPage;
        }
    }

    if (is_numeric($limit)) {
        $sql_index .= ' LIMIT ' . max(0, (int) $limit);
    } elseif ($perPage > 0 && $count > $perPage) {
        $offset = ($page - 1) * $perPage;
        $sql_index .= ' LIMIT ' . $offset . ', ' . $perPage;
    }

    // query
    $ad_res = DB_query($sql_index);

	//if any message
	if ($profile != 1 && $message !== '') $retval .= CLASSIFIEDS_message($message);
	
    if ( ($user > 1) && ($my == 0) && ($profile == 0) ) {
		    $retval = COM_startBlock($LANG_CLASSIFIEDS_1['all_ads_from'] . ' <a href="'. $_CLASSIFIEDS_CONF['site_url'] .
	'/index.php?mode=p&amp;u=' . $user .  '">'. $username . '</a> ');
		}
	if ( ($my == 1) && ($user == $_USER['uid'])   ) {
		    $retval = COM_startBlock($LANG_CLASSIFIEDS_1['my_ads']);
		}

    // Create Ad template
    $ad = new Template($_CONF['path'] . 'plugins/classifieds/templates');
	if ( is_numeric($limit) ) {
        $ad->set_file(array('start'   => 'ads_list_start.thtml',
                            'end'     => 'ads_list_end.thtml',
                            'ad'      => 'last_ads_list_item.thtml'));
	} else {
	    $ad->set_file(array('start'   => 'ads_list_start.thtml',
                            'end'     => 'ads_list_end.thtml',
                            'ad'      => 'ads_list_item.thtml'));
	}
    $ad->set_var('edit', '');
    $ad->set_var('site_url', $_CLASSIFIEDS_CONF['site_url']);
    $ad->set_var('user_id', $_USER['uid']);

    //Todo seach block
	if ( ($profile == 0) && ($my != 1) && ($user == 1) ) {
	    //type label
		$type_label = $LANG_CLASSIFIEDS_1['offers_demands'];
        if ($mode === 'o') {
            $type_label = $LANG_CLASSIFIEDS_1['offers'];
        } elseif ($mode === 'd') {
            $type_label = $LANG_CLASSIFIEDS_1['demands'];
        }
	
        //category drop down
	    $categories = '';
		$categories .= '<option value="--">' . $LANG_CLASSIFIEDS_1['choose_category'] . '</option>';
        $categories .= '<option value="0">' . $LANG_CLASSIFIEDS_1['all_categories'] . '</option>';
        if (is_numeric($cookieCat)) {
            $checked_category = (int) $cookieCat;
        }
        if ($catid !== '' && is_numeric($catid)) {
            $checked_category = (int) $catid;
        }
		$categories .= CLASSIFIEDS_adCategoryOptions($checked_category);
        $search_box = '<div id="ad-list-searchbox">
                        <form action="' . $_CLASSIFIEDS_CONF['site_url'] . '/index.php" id="classifieds_cat" method="post"><strong>' .
						    $type_label .
						    '</strong>&nbsp;&nbsp; <select name="catid">' . $categories .
						    '</select>
						<input type="submit" name="submit" value="' . $LANG_CLASSIFIEDS_1['search_button'] . '" '.
						XHTML .'>
						</form>
					 </div>';
		$ad->set_var('search_box', $search_box);
	} else {
	    $ad->set_var('search_box', '');
	}

    $retval .= $ad->parse('', 'start');
	
	//No ad
	if ( DB_numRows($ad_res) < 1 ) {
        if ( $profile == 0 ) {
            $retval .= COM_startBlock($LANG_CLASSIFIEDS_1['no_ad']);
            $retval .= $LANG_CLASSIFIEDS_1['no_ad_message'];
            $retval .= COM_endBlock();
        } else {
           return $LANG_CLASSIFIEDS_1['profile_no_ad'];
        }
    }
	//legend
	if ( $my == 1 ) {
	    $ad->set_var('list-legend', 'class="ad-list-legend"');
	} else {
	    $ad->set_var('list-legend', 'style="display:none"');
	}
	
	$ad->set_var('ad-list-active', $LANG_CLASSIFIEDS_1['ad-list-active']);
	$ad->set_var('ad-list-old', $LANG_CLASSIFIEDS_1['ad-list-old']);
	$ad->set_var('ad-list-delete', $LANG_CLASSIFIEDS_1['ad-list-delete']);

    // Display each ads
    while ($A = DB_fetchArray($ad_res)) {
    
        $created = COM_getUserDateTimeFormat($A['created']);
        $createdTimestamp = isset($created[1]) ? (int) $created[1] : 0;
        $activeDays = $createdTimestamp > 0
            ? (time() - $createdTimestamp) / 86400
            : PHP_INT_MAX;
        $active = ($activeDays <= (int) $_CLASSIFIEDS_CONF['active_days']);

		if ($A['deleted'] == 1) {
		    $ad->set_var('class', ' class="ad-list-deleted"');
		} else if (  $active == false ) {
		    $ad->set_var('class', ' class="ad-list-old"');
		} else {
		    $ad->set_var('class', ' class="ad-list-active"');
		}
	
	    //Date
        list($date, ) = COM_getUserDateTimeFormat($createdTimestamp, 'dateonly');
        list($time, ) = COM_getUserDateTimeFormat($createdTimestamp, 'timeonly');

        $ad->set_var('date', $date);
        $ad->set_var('time', $time);

	    $title = ucfirst(mb_strtolower($A['title'], $_CONF['default_charset']));
		
		//First Ad image	
	    if ($A['pi_filename'] == '') {
		    $ad->set_var('small_pic', '');
	    } else if( is_numeric($limit) ) {
		    $ad->set_var(
                'small_pic',
                '<a href="' . plugin_idToURL_classifieds('classifieds', $A['clid']) . '">'
                . '<img class="classifieds-thumb classifieds-thumb--small" loading="lazy" src="'
                . $_CLASSIFIEDS_CONF['url_images'] . rawurlencode($A['pi_filename'])
                . '" alt="' . htmlspecialchars($title, ENT_QUOTES, $_CONF['default_charset']) . '" /></a>'
            );
	    } else {
		    $ad->set_var(
                'small_pic',
                '<a href="' . plugin_idToURL_classifieds('classifieds', $A['clid']) . '">'
                . '<img class="classifieds-thumb" loading="lazy" src="'
                . $_CLASSIFIEDS_CONF['url_images'] . rawurlencode($A['pi_filename'])
                . '" alt="' . htmlspecialchars($title, ENT_QUOTES, $_CONF['default_charset']) . '" /></a>'
            );
	    }
	
        // Title
        $escapedTitle = htmlspecialchars(
            $title,
            ENT_QUOTES,
            $_CONF['default_charset']
        );
        $adUrl = htmlspecialchars(
            plugin_idToURL_classifieds('classifieds', $A['clid']),
            ENT_QUOTES,
            $_CONF['default_charset']
        );

        if (is_numeric($limit)) {
            $shortTitle = (strlen($title) > 40)
                ? substr($title, 0, 40) . '...'
                : $title;
            $ad->set_var(
                'title',
                '<a href="' . $adUrl . '" title="' . $escapedTitle . '">'
                . htmlspecialchars($shortTitle, ENT_QUOTES, $_CONF['default_charset'])
                . '</a>'
            );
        } else {
            $ad->set_var(
                'title',
                '<a href="' . $adUrl . '">' . $escapedTitle . '</a>'
            );
        }

	    //Edit link
	    if (SEC_hasRights('classifieds.admin') && ($active == true) && ($A['deleted'] == 0) ) {
            $ad->set_var(
                'edit',
                '<a href="' . $_CLASSIFIEDS_CONF['site_url']
                . '/index.php?mode=e&amp;op=edit&amp;ad=' . (int) $A['clid'] . '">'
                . '<img src="' . $_CLASSIFIEDS_CONF['site_url']
                . '/images/edit.png" alt="" /></a>'
            );
	    }else {
        $ad->set_var('edit', '');
        }
	
	    //Price
	    if ($A['price'] != 0) {
		    $ad->set_var('price', number_format($A['price'], $_CONF['decimal_count'], $_CONF['decimal_separator'], $_CONF['thousand_separator']));
            $ad->set_var(
                'currency',
                htmlspecialchars(
                    $_CLASSIFIEDS_CONF['currency'],
                    ENT_QUOTES,
                    $_CONF['default_charset']
                )
            );
		} else {
		    $ad->set_var('price', '');
			$ad->set_var('currency', '');
		}
	
	    //Category
        $ad->set_var(
            'cat',
            htmlspecialchars(
                isset($A['category']) ? $A['category'] : '',
                ENT_QUOTES,
                $_CONF['default_charset']
            )
        );
	
	    //Postal
        $ad->set_var(
            'postcode',
            htmlspecialchars($A['postcode'], ENT_QUOTES, $_CONF['default_charset'])
        );
	
	    //City
        $city = ucwords(mb_strtolower($A['city'], $_CONF['default_charset']));
        $ad->set_var(
            'city',
            htmlspecialchars($city, ENT_QUOTES, $_CONF['default_charset'])
        );
		
        if ($my == 1) {
            $admin_ad = '<div class="ad-list-views"><ul><li>'
                . (int) $A['hits'] . ' ' . $LANG_CLASSIFIEDS_1['hits'] . '</li>';

            if (($active == false && $A['deleted'] == 0
                && !empty($_CLASSIFIEDS_CONF['allow_republish'])
                && SEC_hasRights('classifieds.publish'))
                || (SEC_hasRights('classifieds.admin') && $active == false)) {
                $admin_ad .= '<li><a href="' . $_CLASSIFIEDS_CONF['site_url']
                    . '/index.php?op=repost&amp;mode=e&amp;ad=' . (int) $A['clid']
                    . '&amp;' . CSRF_TOKEN . '=' . SEC_createToken() . '">'
                    . $LANG_CLASSIFIEDS_2['copy_button'] . '</a></li>';
            }

            $admin_ad .= '</ul></div>';
            $ad->set_var('views', $admin_ad);
        } else {
            $ad->set_var('views', '');
        }
	
	    $retval .= $ad->parse('', 'ad');
    }
	
    // Display pagination
    if ($perPage > 0 && $count > $perPage && $limit == '') {
        $ad->set_var(
            'pagination',
            COM_printPageNavigation(
                $_CLASSIFIEDS_CONF['site_url'] . '/index.php',
                $page,
                (int) ceil($count / $perPage)
            )
        );
    } else {
        $ad->set_var('pagination', '');
    }

    $retval .= $ad->parse('', 'end');

    return $retval;
}

/**
 *  Increment hit counter for ad
 *
 */
function hitAd ($ad)
{
    global $_TABLES;
    
    DB_query("UPDATE {$_TABLES['cl']} SET hits = hits + 1 WHERE clid = '$ad'");
}

/**
 *  Increment modification counter for ad
 *
 */
function modifAd ($ad)
{
    global $_TABLES;
    
    DB_query("UPDATE {$_TABLES['cl']} SET modif = modif + 1 WHERE clid = '$ad'");
}

function CLASSIFIEDS_viewAd($clid)
{
    global $_TABLES, $_CLASSIFIEDS_CONF, $_CONF;
    global $LANG_CLASSIFIEDS_1, $LANG_CLASSIFIEDS_2, $_USER;

    $clid = (int) $clid;
    if ($clid <= 0) {
        return COM_refresh($_CLASSIFIEDS_CONF['site_url'] . '/index.php');
    }

    if (($_USER['uid'] < 2) && !empty($_CLASSIFIEDS_CONF['classifieds_login_required'])) {
        return COM_siteHeader('menu', $LANG_CLASSIFIEDS_1['plugin_name'])
            . SEC_loginRequiredForm()
            . COM_siteFooter(1);
    }

    if (!CLASSIFIEDS_checkAdAccess($clid)) {
        return COM_siteHeader('menu', $LANG_CLASSIFIEDS_1['plugin_name'])
            . CLASSIFIEDS_user_menu()
            . CLASSIFIEDS_message($LANG_CLASSIFIEDS_1['ads_not_available'])
            . COM_siteFooter(1);
    }

    $sql = "SELECT a.*, u.username, c.category "
        . "FROM {$_TABLES['cl']} AS a "
        . "LEFT JOIN {$_TABLES['users']} AS u ON u.uid = a.owner_id "
        . "LEFT JOIN {$_TABLES['cl_cat']} AS c ON c.cid = a.catid "
        . "WHERE a.clid = " . $clid . " LIMIT 1";

    $res = DB_query($sql);
    $A = DB_fetchArray($res);

    if (!is_array($A)) {
        return COM_refresh($_CLASSIFIEDS_CONF['site_url'] . '/index.php');
    }

    $isAdmin = SEC_hasRights('classifieds.admin');
    $created = COM_getUserDateTimeFormat($A['created']);
    $createdTimestamp = isset($created[1]) ? (int) $created[1] : 0;
    $activeDays = $createdTimestamp > 0
        ? (time() - $createdTimestamp) / 86400
        : PHP_INT_MAX;
    $active = ($activeDays <= (int) $_CLASSIFIEDS_CONF['active_days']);

    if (!$isAdmin && (empty($A['enable']) || !empty($A['deleted']) || !$active)) {
        return COM_siteHeader('menu', $LANG_CLASSIFIEDS_1['plugin_name'])
            . CLASSIFIEDS_user_menu()
            . CLASSIFIEDS_message($LANG_CLASSIFIEDS_1['ads_not_available'])
            . COM_siteFooter(1);
    }

    $title = (string) $A['title'];
    $category = isset($A['category']) ? (string) $A['category'] : '';
    $pageTitle = $title
        . ($category !== '' ? ' - ' . $category : '')
        . ' - ' . $LANG_CLASSIFIEDS_1['plugin_name'];

    $description = trim(strip_tags((string) $A['text']));
    if (strlen($description) > 160) {
        $description = substr($description, 0, 157) . '...';
    }

    $metaTags = array();
    if ($description !== '') {
        $metaTags[] = array(
            'name' => 'description',
            'content' => $description
        );
    }

    if ($isAdmin && (!empty($A['deleted']) || !$active || empty($A['enable']))) {
        $metaTags[] = array(
            'name' => 'robots',
            'content' => 'noindex,follow'
        );
    }

    $headerCode = PLG_getMetaTags('classifieds', (string) $clid, $metaTags);
    $canonicalUrl = plugin_idToURL_classifieds('classifieds', $clid);
    $headerCode .= '<link rel="canonical" href="'
        . htmlspecialchars($canonicalUrl, ENT_QUOTES, $_CONF['default_charset'])
        . '"' . XHTML . '>' . LB;

    $retval = COM_siteHeader('menu', $pageTitle, $headerCode);
    $retval .= CLASSIFIEDS_user_menu();

    $message = isset($_REQUEST['msg']) ? (string) $_REQUEST['msg'] : '';
    if ($message !== '') {
        $retval .= CLASSIFIEDS_message($message);
    }

    $ad = new Template($_CONF['path'] . 'plugins/classifieds/templates');
    $ad->set_file(array('ad' => 'ad_detail.thtml'));

    $deletedLabel = !empty($A['deleted'])
        ? '<span class="classifieds-ad__deleted">' . $LANG_CLASSIFIEDS_1['deleted'] . '</span> '
        : '';
    $ad->set_var('title', $deletedLabel . htmlspecialchars(
        $title,
        ENT_QUOTES,
        $_CONF['default_charset']
    ));

    if ($isAdmin && $active && empty($A['deleted'])) {
        $ad->set_var(
            'edit',
            '<a href="' . $_CLASSIFIEDS_CONF['site_url']
            . '/index.php?mode=e&amp;op=edit&amp;ad=' . $clid . '">'
            . '<img src="' . $_CLASSIFIEDS_CONF['site_url']
            . '/images/edit.png" alt="" /></a>'
        );
    } else {
        $ad->set_var('edit', '');
    }

    if ($createdTimestamp > 0) {
        list($date, ) = COM_getUserDateTimeFormat($createdTimestamp, 'dateonly');
        list($time, ) = COM_getUserDateTimeFormat($createdTimestamp, 'timeonly');
    } else {
        $date = '';
        $time = '';
    }

    $username = isset($A['username']) ? (string) $A['username'] : '';
    $ad->set_var(
        'postby',
        '<p>' . $LANG_CLASSIFIEDS_1['posted_by']
        . ' <a href="' . $_CLASSIFIEDS_CONF['site_url']
        . '/index.php?mode=p&amp;u=' . (int) $A['owner_id'] . '">'
        . htmlspecialchars($username, ENT_QUOTES, $_CONF['default_charset'])
        . '</a> ' . $LANG_CLASSIFIEDS_1['on'] . ' ' . $date
        . ' ' . $LANG_CLASSIFIEDS_1['at'] . ' ' . $time . '</p>'
    );

    $icount = DB_count($_TABLES['cl_pic'], 'pi_pid', $clid);
    $savedImages = '';

    if ($icount > 0) {
        $resultPic = DB_query(
            "SELECT pi_filename FROM {$_TABLES['cl_pic']} "
            . "WHERE pi_pid = '" . $clid . "' ORDER BY pi_img_num"
        );

        $z = 0;
        while ($I = DB_fetchArray($resultPic)) {
            $z++;
            $filename = rawurlencode(basename($I['pi_filename']));
            $imageUrl = $_CLASSIFIEDS_CONF['url_images'] . $filename;
            $alt = htmlspecialchars($title, ENT_QUOTES, $_CONF['default_charset']);

            if ($z === 1) {
                $ad->set_var(
                    'big_picture',
                    '<img class="classifieds-main-image" loading="eager" src="'
                    . $imageUrl . '" alt="' . $alt . '" />'
                );
            }

            $savedImages .= '<a class="lightbox" href="' . $imageUrl . '">'
                . '<img class="classifieds-gallery-thumb" loading="lazy" src="'
                . $imageUrl . '" alt="' . $alt . '" /></a>';
        }
    }

    if ($icount == 0) {
        $ad->set_var('big_picture', '');
        $ad->set_var('pictures', '');
    } else {
        $infoPicture = '<p class="info_picture"><img src="'
            . $_CLASSIFIEDS_CONF['site_url'] . '/images/enlarge.png" alt="" /> '
            . $LANG_CLASSIFIEDS_1['enlarge_picture'] . '</p>';
        $ad->set_var(
            'pictures',
            '<div id="ad-pictures">' . $savedImages . $infoPicture . '</div>'
        );
    }

    if (empty($A['hide_tel']) && !empty($A['tel'])) {
        $ad->set_var(
            'tel',
            '<p>' . htmlspecialchars($username, ENT_QUOTES, $_CONF['default_charset'])
            . $LANG_CLASSIFIEDS_1['double_point'] . ' '
            . htmlspecialchars($A['tel'], ENT_QUOTES, $_CONF['default_charset'])
            . '</p>'
        );
    } else {
        $ad->set_var('tel', '');
    }

    if (!empty($A['status']) && !empty($A['siren'])) {
        $ad->set_var(
            'siren',
            '<p>' . $LANG_CLASSIFIEDS_2['siren']
            . $LANG_CLASSIFIEDS_1['double_point'] . ' '
            . htmlspecialchars($A['siren'], ENT_QUOTES, $_CONF['default_charset'])
            . '</p>'
        );
    } else {
        $ad->set_var('siren', '');
    }

    $ad->set_var(
        'admin',
        '<h3>' . $LANG_CLASSIFIEDS_1['manage_ad'] . ' ('
        . (int) $A['hits'] . ' ' . $LANG_CLASSIFIEDS_1['hits'] . ')</h3>'
    );

    $canEdit = SEC_hasAccess2($A) >= 3 && empty($A['deleted']) && $active;
    if ($canEdit) {
        $ad->set_var(
            'modify',
            '<p><a href="' . $_CLASSIFIEDS_CONF['site_url']
            . '/index.php?mode=e&amp;op=edit&amp;ad=' . $clid . '">'
            . $LANG_CLASSIFIEDS_1['modify_ad'] . '</a></p>'
        );
        $ad->set_var(
            'delete',
            '<p><a href="' . $_CLASSIFIEDS_CONF['site_url']
            . '/index.php?mode=e&amp;op=del&amp;ad=' . $clid
            . '&amp;' . CSRF_TOKEN . '=' . SEC_createToken() . '">'
            . $LANG_CLASSIFIEDS_1['delete_ad'] . '</a></p>'
        );
    } else {
        $ad->set_var('modify', '');
        $ad->set_var('delete', '');
    }

    $ad->set_var(
        'report',
        '<p><a href="' . $_CLASSIFIEDS_CONF['site_url']
        . '/index.php?mode=r&amp;ad=' . $clid . '">'
        . $LANG_CLASSIFIEDS_1['report'] . '</a></p>'
    );

    if ((int) $_USER['uid'] === (int) $A['owner_id']) {
        $ad->set_var('view_all', '');
    } else {
        $ad->set_var(
            'view_all',
            '<p><a href="' . $_CLASSIFIEDS_CONF['site_url']
            . '/index.php?mode=va&amp;u=' . (int) $A['owner_id'] . '">'
            . $LANG_CLASSIFIEDS_1['view_all'] . '</a></p>'
        );
    }

    if ((float) $A['price'] != 0.0) {
        $ad->set_var(
            'price',
            '<span class="ad-col1">' . $LANG_CLASSIFIEDS_1['price']
            . $LANG_CLASSIFIEDS_1['double_point'] . ' <strong>'
            . number_format(
                $A['price'],
                $_CONF['decimal_count'],
                $_CONF['decimal_separator'],
                $_CONF['thousand_separator']
            )
        );
        $ad->set_var(
            'currency',
            htmlspecialchars(
                $_CLASSIFIEDS_CONF['currency'],
                ENT_QUOTES,
                $_CONF['default_charset']
            ) . '</strong></span>'
        );
    } else {
        $ad->set_var(
            'price',
            '<span class="ad-col1">' . $LANG_CLASSIFIEDS_1['price']
            . $LANG_CLASSIFIEDS_1['double_point'] . ' --</span>'
        );
        $ad->set_var('currency', '');
    }

    $ad->set_var(
        'postal',
        '<span class="ad-col2">' . $LANG_CLASSIFIEDS_1['postcode']
        . $LANG_CLASSIFIEDS_1['double_point'] . ' <strong>'
        . htmlspecialchars($A['postcode'], ENT_QUOTES, $_CONF['default_charset'])
        . '</strong></span>'
    );

    $ad->set_var(
        'category',
        '<p>' . $LANG_CLASSIFIEDS_1['category']
        . $LANG_CLASSIFIEDS_1['double_point'] . ' <strong>'
        . htmlspecialchars($category, ENT_QUOTES, $_CONF['default_charset'])
        . '</strong></p>'
    );

    $ad->set_var(
        'detail',
        '<div class="ad-detail">' . PLG_replaceTags(nl2br($A['text'])) . '</div>'
    );


    $commentPage = 1;
    $deleteOption = (
        $isAdmin
        && SEC_hasAccess(
            $A['owner_id'],
            $A['group_id'],
            $A['perm_owner'],
            $A['perm_group'],
            $A['perm_members'],
            $A['perm_anon']
        ) == 3
    );

    require_once $_CONF['path_system'] . 'lib-comment.php';
    $ad->set_var(
        'commentbar',
        CMT_userComments(
            $clid,
            $title,
            'classifieds',
            'ASC',
            'flat',
            0,
            $commentPage,
            false,
            $deleteOption,
            0
        )
    );

    $retval .= $ad->parse('', 'ad');
    $retval .= COM_siteFooter(0);

    hitAd($clid);

    return $retval;
}


function CLASSIFIEDS_message ($message, $title='')
{
    global $LANG_CLASSIFIEDS_2;
	
    $retval = '';
	if (!empty($message)) {
        if ($title != '') {
            $retval = COM_startBlock($title, '', 'blockheader-message.thtml');
        } else {
            $retval = COM_startBlock($LANG_CLASSIFIEDS_2['message'], '', 'blockheader-message.thtml');
        }
        $retval .= $message;
        $retval .= COM_endBlock('blockfooter-message.thtml');
    }
	return $retval;
}

function CLASSIFIEDS_missingField($field)
{
    global $LANG_CLASSIFIEDS_2, $_TABLES;

    $fields = array();
    $catid = isset($field['catid']) ? (int) $field['catid'] : 0;

    if ($catid <= 0) {
        $fields[] = $LANG_CLASSIFIEDS_2['category'];
    } else {
        $categoryResult = DB_query(
            "SELECT pid, catdeleted FROM {$_TABLES['cl_cat']} "
            . "WHERE cid = " . $catid . " LIMIT 1"
        );
        $category = DB_fetchArray($categoryResult);

        if (!is_array($category)
            || (int) $category['pid'] === 0
            || !empty($category['catdeleted'])) {
            $fields[] = $LANG_CLASSIFIEDS_2['category'];
        }
    }

    if (!isset($field['type']) || (int) $field['type'] === -1) {
        $fields[] = $LANG_CLASSIFIEDS_2['type'];
    }
    if (empty($field['title'])) {
        $fields[] = $LANG_CLASSIFIEDS_2['title'];
    }
    if (empty($field['text'])) {
        $fields[] = $LANG_CLASSIFIEDS_2['text'];
    }
    if (!isset($field['status']) || (int) $field['status'] === -1) {
        $fields[] = $LANG_CLASSIFIEDS_2['status'];
    }
    if (empty($field['tel'])) {
        $fields[] = $LANG_CLASSIFIEDS_2['tel'];
    }
    if (empty($field['postcode'])) {
        $fields[] = $LANG_CLASSIFIEDS_2['postcode'];
    }
    if (empty($field['city'])) {
        $fields[] = $LANG_CLASSIFIEDS_2['city'];
    }

    return $fields;
}

function CLASSIFIEDS_checkAdAccess($ad)
{
    global $_TABLES;

    $ad = (int) $ad;
    if ($ad <= 0) {
        return false;
    }

    $result = DB_query(
        "SELECT owner_id, group_id, perm_owner, perm_group, perm_members, perm_anon, deleted "
        . "FROM {$_TABLES['cl']} WHERE clid = " . $ad . " LIMIT 1"
    );
    $row = DB_fetchArray($result);
    if (!is_array($row)) {
        return false;
    }

    if (SEC_hasRights('classifieds.admin')) {
        return true;
    }

    if (!empty($row['deleted'])) {
        return false;
    }

    return SEC_hasAccess(
        $row['owner_id'],
        $row['group_id'],
        $row['perm_owner'],
        $row['perm_group'],
        $row['perm_members'],
        $row['perm_anon']
    ) >= 2;
}

/**
 * Build selectable parent-category options.
 *
 * Only root categories can be parents.
 *
 * @param int $selected
 * @param int $exclude
 * @return string
 */
function CLASSIFIEDS_parentCategoryOptions($selected = 0, $exclude = 0)
{
    global $_CONF, $_TABLES;

    $selected = (int) $selected;
    $exclude = (int) $exclude;

    $sql = "SELECT cid, category FROM {$_TABLES['cl_cat']} "
        . "WHERE pid = 0 AND catdeleted = 0";
    if ($exclude > 0) {
        $sql .= " AND cid <> " . $exclude;
    }
    $sql .= " ORDER BY catorder ASC, category ASC";

    $result = DB_query($sql);
    $retval = '';

    while ($row = DB_fetchArray($result)) {
        $cid = (int) $row['cid'];
        $retval .= '<option value="' . $cid . '"'
            . ($cid === $selected ? ' selected="selected"' : '')
            . '>'
            . htmlspecialchars($row['category'], ENT_QUOTES, $_CONF['default_charset'])
            . '</option>' . LB;
    }

    return $retval;
}

/**
 * Build ad-category options.
 *
 * Root categories are shown as disabled group labels; child categories are
 * selectable destinations for ads.
 *
 * @param int $selected
 * @return string
 */
function CLASSIFIEDS_adCategoryOptions($selected = 0)
{
    global $_CONF, $_TABLES;

    $selected = (int) $selected;
    $result = DB_query(
        "SELECT cid, pid, category FROM {$_TABLES['cl_cat']} "
        . "WHERE catdeleted = 0 ORDER BY pid ASC, catorder ASC, category ASC"
    );

    $retval = '';
    while ($row = DB_fetchArray($result)) {
        $cid = (int) $row['cid'];
        $pid = (int) $row['pid'];
        $label = htmlspecialchars(
            $row['category'],
            ENT_QUOTES,
            $_CONF['default_charset']
        );

        if ($pid === 0) {
            $retval .= '<option value="' . $cid . '" disabled="disabled">'
                . $label . '</option>' . LB;
        } else {
            $retval .= '<option value="' . $cid . '"'
                . ($cid === $selected ? ' selected="selected"' : '')
                . '>&nbsp;&nbsp;' . $label . '</option>' . LB;
        }
    }

    return $retval;
}

function CLASSIFIEDS_getTextContent($text)
{
    // replace <br> with spaces so that Text<br>Text becomes two words
    $text = preg_replace('/\<br(\s*)?\/?\>/i', ' ', $text);

    // add extra space between tags, e.g. <p>Text</p><p>Text</p>
    $text = str_replace('><', '> <', $text);

    // only now remove all HTML tags
    $text = strip_tags($text);

    // replace all tabs, newlines, and carrriage returns with spaces
    $text = str_replace("\011", ' ', $text);

    // replace entities with plain spaces
    $text = str_replace(array('&#20;', '&#160;', '&nbsp;'), ' ', $text);

    // collapse whitespace
    //$text = preg_replace('/\s\s+/', ' ', $text);

    return trim($text);
}


?>