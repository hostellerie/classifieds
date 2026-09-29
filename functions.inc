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
require_once $_CONF['path_system'].'classes/config.class.php';
$c = config::get_instance();
$_CLASSIFIEDS_CONF = $c->get_config('classifieds');

/*
* Include specific classifieds config file
*/
require_once ($_CONF['path'] . 'plugins/classifieds/classifieds.php');

/**
 * Include plugin files.
 *
 * The historical Pro edition is now integrated into the standard plugin.
 * Legacy files under path_data/classifieds_data/proversion are intentionally
 * not loaded so the old and new implementations can never run together.
 */
require_once $_CONF['path'] . 'plugins/classifieds/lib-notifications.php';
require_once $_CONF['path'] . 'plugins/classifieds/lib-republish.php';
require_once $_CONF['path'] . 'plugins/classifieds/lib-contact.php';




// +---------------------------------------------------------------------------+
// | Geeklog Plugin API Implementation                                         |
// +---------------------------------------------------------------------------+

function plugin_getheadercode_classifieds()
{
    global $_CONF, $_CLASSIFIEDS_CONF, $_SCRIPTS;

    $retval = '';
    $_SCRIPTS->setJavaScriptLibrary('jquery');

    $retval .= '    <link rel="stylesheet" href="' . $_CLASSIFIEDS_CONF['site_url']
        . '/css/classifieds_130.css" type="text/css" media="screen"' . XHTML . '>' . LB;

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
function plugin_savecomment_classifieds($title, $comment, $id, $pid, $postmode)
{
    global $LANG03, $_CLASSIFIEDS_CONF;

    $retval = '';

    $ret = CMT_saveComment ($title, $comment, $id, $pid, 'classifieds', $postmode);
    if ($ret > 0) { // failure //FIXME: some failures should not return to comment form
        $retval .= CMT_commentForm ($title, $comment, $id, $pid, 'classifieds',
                                   $LANG03[14], $postmode);
		if (!defined('COMMENT_ON_SAME_PAGE')) {
            $retval = COM_createHTMLDocument($retval, array('pagetitle' => $LANG03[1]));
        } else {
            if (!COMMENT_ON_SAME_PAGE) {
                $retval = COM_createHTMLDocument($retval, array('pagetitle' => $LANG03[1]));
            }
        }
    } else { // success
        $retval = COM_refresh ($_CLASSIFIEDS_CONF['site_url']
                                . "/index.php?mode=v&ad=$id");
    }

    return $retval;
}

/**
 * classifieds: delete a comment
 *
 * @param   int     $cid    Comment to be deleted
 * @param   string  $id     Item id to which $cid belongs
 * @return  mixed   false for failure, HTML string (redirect?) for success
 */
function plugin_deletecomment_classifieds($cid, $id)
{
    global $_CONF, $_TABLES, $_USER,$_CLASSIFIEDS_CONF;

    $retval = '';

    $has_editPermissions = SEC_hasRights ('classifieds.admin');
    $result = DB_query ("SELECT owner_id,group_id,perm_owner,perm_group,perm_members,perm_anon FROM {$_TABLES['cl']} WHERE clid = '{$id}'");
    $A = DB_fetchArray ($result);

    if ($has_editPermissions && SEC_hasAccess ($A['owner_id'],
            $A['group_id'], $A['perm_owner'], $A['perm_group'],
            $A['perm_members'], $A['perm_anon']) == 3) {
        CMT_deleteComment($cid, $id, 'classifieds');
        $retval .= COM_refresh ($_CLASSIFIEDS_CONF['site_url']
                                 . "/index.php?mode=v&ad=$id&amp;aid=-1");
    } else {
        COM_errorLog ("User {$_USER['username']} (IP: {$_SERVER['REMOTE_ADDR']}) "
                    . "tried to illegally delete comment $cid from poll $id");
        $retval .= COM_refresh ($_CONF['site_url'] . '/index.php');
    }

    return $retval;
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
function plugin_displaycomment_classifieds ($id, $cid, $title, $order, $format, $page, $view)
{
    global $_TABLES, $LANG_ACCESS, $LANG_classifieds;

    $retval = '';

    $sql = "SELECT COUNT(*) AS count, owner_id, group_id, perm_owner, "
        . "perm_group, perm_members, perm_anon "
        . "FROM {$_TABLES['cl']} "
        . "WHERE (clid = '$id')" . COM_getPermSQL('AND')
        . ' LIMIT 1';
    $result = DB_query ($sql);
    $A = DB_fetchArray ($result);
    $allowed = $A['count'];
	
	//Comment 
	$A['commentcode'] = 0;

    if ($allowed == 1) {
        $delete_option = (SEC_hasRights ('classifieds.edit') &&
                (SEC_hasAccess ($A['owner_id'], $A['group_id'],
                    $A['perm_owner'], $A['perm_group'], $A['perm_members'],
                    $A['perm_anon']) == 3));
        $retval .= CMT_userComments ($id, $title, 'classifieds', $order, $format,
                                     $cid, $page, $view, $delete_option,
                                     $A['commentcode']);
    } else {
        $retval .= COM_startBlock ($LANG_ACCESS['accessdenied'], '',
                        COM_getBlockTemplate ('_msg_block', 'header'))
                . $LANG_STATIC['deny_msg']
                . COM_endBlock (COM_getBlockTemplate ('_msg_block', 'footer'));
    }

    return $retval;
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

function plugin_dopluginsearch_classifieds($query, $datestart, $dateend, $topic, $type, $author, $keyType, $page, $perpage)
{
    global $_TABLES, $_CLASSIFIEDS_CONF, $LANG_CLASSIFIEDS_1;

    // Make sure the query is SQL safe
    $query = trim($query);
	
    //TODO image in search results
    $sql = "SELECT clid AS id, title, text as description, UNIX_TIMESTAMP(created) AS date, owner_id AS uid, hits, ";
    $sql .= "CONCAT('/{$_CLASSIFIEDS_CONF['classifieds_folder']}/index.php?mode=v&ad=', clid) AS url ";
    $sql .= "FROM {$_TABLES['cl']} AS a ";
    $sql .= "LEFT JOIN {$_TABLES['cl_pic']} AS i
            ON i.pi_pid = a.clid AND i.pi_img_num IN (SELECT MIN(pi_img_num) FROM {$_TABLES['cl_pic']} WHERE pi_img_num = 1 AND pi_pid = a.clid) 	
	        WHERE a.deleted = '0' 
			AND TO_DAYS(NOW()) - TO_DAYS(a.created) <= {$_CLASSIFIEDS_CONF['active_days']}
            AND a.enable = '1' ";
    $sql .= COM_getPermSQL('AND') . ' ';

    if (!empty($datestart) && !empty($dateend)) {
        $delim = substr($datestart, 4, 1);
        if (!empty($delim)) {
            $DS = explode($delim, $datestart);
            $DE = explode($delim, $dateend);
            $startdate = mktime(0,0,0,$DS[1],$DS[2],$DS[0]);
            $enddate = mktime(23,59,59,$DE[1],$DE[2],$DE[0]);
            $sql .= "AND (UNIX_TIMESTAMP(created) BETWEEN '$startdate' AND '$enddate') ";
        }
    }
    if (!empty ($author)) {
        $sql .= "AND (owner_id = '$author') ";
    }

    $search = new SearchCriteria('classifieds', $LANG_CLASSIFIEDS_1['plugin_name']);

    $columns = array('title', 'text');
    list($sql,$ftsql) = $search->buildSearchSQL($keyType, $query, $columns, $sql);

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
    global $_CONF, $_CLASSIFIEDS_CONF, $_TABLES, $LANG_CLASSIFIEDS_1;

    if ($op == 'tagname') {
        return 'classifieds';
    } elseif ($op == 'parse') {
        $cid = COM_applyFilter($autotag['parm1']);
        if (! empty($cid)) {
            $url = $_CLASSIFIEDS_CONF['site_url'] . '/index.php?mode=v&ad=' . $cid;
            if (empty($autotag['parm2'])) {
                $linktext = DB_getItem($_TABLES['cl'], 'title', "clid = '$cid'"); // or get title from db
            } else {
                $linktext = $autotag['parm2'];
            }
            $link = COM_createLink($linktext, $url);
            $content = str_replace($autotag['tagstr'], $link, $content);
        }

        return $content;
    }
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

    $retval = array();
    if (SEC_hasRights('classifieds.admin')) {
        $retval = array($LANG_CLASSIFIEDS_1['plugin_name'],
            $_CONF['site_admin_url'] . '/plugins/classifieds/index.php',
            plugin_geticon_classifieds());
    }

    return $retval;
}

/**
* Return plugin entry for the Admins Only block
*
* @return array Array containing (plugin name, plugin admin url, # of plugin items or '')
*/
function plugin_getadminoption_classifieds()
{
    global $_CONF, $LANG_CLASSIFIEDS_1;

    if (SEC_hasRights('classifieds.admin')) {
        return array($LANG_CLASSIFIEDS_1['plugin_name'],
            $_CONF['site_admin_url'] . '/plugins/classifieds/index.php', 0);
    }
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
* Update the plugin
*
* @return   int     Number of message to display or true for success
*
*/
function plugin_upgrade_classifieds()
{
    global $_CONF, $_CLASSIFIEDS_CONF, $_TABLES, $_DB_table_prefix;

    $installed_version = DB_getItem($_TABLES['plugins'], 'pi_version',
                                    "pi_name = 'classifieds'");
    $code_version = plugin_chkVersion_classifieds();
    if ($installed_version == $code_version) {
        // nothing to do
        return true;
    }

    require_once $_CONF['path'] . 'plugins/classifieds/autoinstall.php';
	require_once $_CONF['path'] . 'plugins/classifieds/install_defaults.php';
	require_once $_CONF['path_system'] . 'classes/config.class.php';

    if (! plugin_compatible_with_this_version_classifieds('classifieds')) {
        return 3002;
    }

    // other update code goes here
	 switch( $installed_version ) {
        
		case '1.0':
			$c = config::get_instance();
			
			//This is main subgroup #0
		    $c->add('sg_main', NULL, 'subgroup', 0, 0, NULL, 0, true, 'classifieds');
		
		    //Main settings   
		    $c->add('fs_main', NULL, 'fieldset', 0, 0, NULL, 0, true, 'classifieds');
            $c->add('classifieds_folder', $_CLASSIFIEDS_DEFAULT['classifieds_folder'],
                'text', 0, 0, 0, 10, true, 'classifieds');
		    $c->add('active_days', $_CLASSIFIEDS_DEFAULT['active_days'],
                'text', 0, 0, 0, 20, true, 'classifieds');
		    $c->add('site_name', $_CLASSIFIEDS_DEFAULT['site_name'],
                'text', 0, 0, 0, 30, true, 'classifieds');

		    //images
            $c->add('fs_images', NULL, 'fieldset', 0, 1, NULL, 0, true, 'classifieds');
		    $c->add('max_image_width', $_CLASSIFIEDS_DEFAULT['max_image_width'],
                'text', 0, 1, 0, 101, true, 'classifieds');
		    $c->add('max_image_height', $_CLASSIFIEDS_DEFAULT['max_image_height'],
                'text', 0, 1, 0, 102, true, 'classifieds');
		    $c->add('max_image_size', $_CLASSIFIEDS_DEFAULT['max_image_size'],
                'text', 0, 1, 0, 103, true, 'classifieds');
		    $c->add('thumb_width', $_CLASSIFIEDS_DEFAULT['thumb_width'],
				'text', 0, 1, 0, 104, true, 'classifieds');
		    $c->add('thumb_height', $_CLASSIFIEDS_DEFAULT['thumb_height'],
				'text', 0, 1, 0, 105, true, 'classifieds');
		    $c->add('max_thumbnail_size', $_CLASSIFIEDS_DEFAULT['max_thumbnail_size'],
                'text', 0, 1, 0, 106, true, 'classifieds');
		    $c->add('max_images_per_ad', $_CLASSIFIEDS_DEFAULT['max_images_per_ad'],
                'text', 0, 1, 0, 107, true, 'classifieds');
		
				
            //display
		    $c->add('fs_display', NULL, 'fieldset', 0, 2, NULL, 0, true, 'classifieds');
		    $c->add('menulabel', $_CLASSIFIEDS_DEFAULT['menulabel'],
                'text', 0, 2, 0, 201, true, 'classifieds');
		    $c->add('hide_classifieds_menu', $_CLASSIFIEDS_DEFAULT['hide_classifieds_menu'],
                'select', 0, 2, 3, 202, true, 'classifieds');
		    $c->add('classifieds_main_header', $_CLASSIFIEDS_DEFAULT['classifieds_main_header'],
                'text', 0, 2, 0, 203, true, 'classifieds');
		    $c->add('classifieds_main_footer', $_CLASSIFIEDS_DEFAULT['classifieds_main_footer'],
                'text', 0, 2, 0, 204, true, 'classifieds');
		    $c->add('classifieds_edit_header', $_CLASSIFIEDS_DEFAULT['classifieds_edit_header'],
                'text', 0, 2, 0, 205, true, 'classifieds');
		    $c->add('help_page', $_CLASSIFIEDS_DEFAULT['help_page'],
                'text', 0, 2, 0, 206, true, 'classifieds');
		    $c->add('currency', $_CLASSIFIEDS_DEFAULT['currency'],
                'select', 0, 2, 20, 207, true, 'classifieds');
		    $c->add('date_format', $_CLASSIFIEDS_DEFAULT['date_format'],
                'text', 0, 2, 0, 208, true, 'classifieds');
		    $c->add('time_format', $_CLASSIFIEDS_DEFAULT['time_format'],
                'text', 0, 2, 0, 209, true, 'classifieds');
		    $c->add('maxPerPage', $_CLASSIFIEDS_DEFAULT['maxPerPage'],
                'text', 0, 2, 0, 210, true, 'classifieds');
				
		    //email
		    $c->add('fs_email', NULL, 'fieldset', 0, 3, NULL, 0, true, 'classifieds');
		    $c->add('create_ad_email_user', $_CLASSIFIEDS_DEFAULT['create_ad_email_user'],
                'select', 0, 3, 3, 301, true, 'classifieds');
		    $c->add('mod_ad_email_user', $_CLASSIFIEDS_DEFAULT['mod_ad_email_user'],
                'select', 0, 3, 3, 302, true, 'classifieds');
		    $c->add('delete_ad_email_user', $_CLASSIFIEDS_DEFAULT['delete_ad_email_user'],
                'select', 0, 3, 3, 303, true, 'classifieds');
		    $c->add('expire_ad_email_user', $_CLASSIFIEDS_DEFAULT['expire_ad_email_user'],
                'select', 0, 3, 3, 304, true, 'classifieds');
		
		    //permissions
		    $c->add('fs_permissions', NULL, 'fieldset', 0, 4, NULL, 0, true, 'classifieds');
		    $c->add('classifieds_login_required', $_CLASSIFIEDS_DEFAULT['classifieds_login_required'],
                'select', 0, 4, 3, 401, true, 'classifieds');
		    $c->add('default_permissions', $_CLASSIFIEDS_DEFAULT['default_permissions'],
                '@select', 0, 4, 12, 402, true, 'classifieds');
		
		case '1.0.1':
		    DB_query("CREATE TABLE {$_TABLES['cl_users']} (
                      user_id mediumint(8) unsigned NOT NULL,
                      tel varchar(20) NOT NULL,
                      postcode VARCHAR(20) NOT NULL,
                      city VARCHAR(30) NOT NULL,
                      PRIMARY KEY (user_id)
                      ) ENGINE=MyISAM
                      ",0);
		case '1.0.4':
			DB_query("ALTER TABLE {$_TABLES['cl']} 
		    ADD modif int(11) default '0' AFTER hits
		    ",0);
			
		case '1.0.5':
		    $c = config::get_instance();
		    $c->add('create_ad_email_admin', $_CLASSIFIEDS_DEFAULT['create_ad_email_admin'],
                'select', 0, 3, 3, 301, true, 'classifieds');
		    $c->add('mod_ad_email_admin', $_CLASSIFIEDS_DEFAULT['mod_ad_email_admin'],
                'select', 0, 3, 3, 302, true, 'classifieds');
		    $c->add('delete_ad_email_admin', $_CLASSIFIEDS_DEFAULT['delete_ad_email_admin'],
                'select', 0, 3, 3, 303, true, 'classifieds');
		    $c->add('expire_ad_email_admin', $_CLASSIFIEDS_DEFAULT['expire_ad_email_admin'],
                'select', 0, 3, 3, 304, true, 'classifieds');
		case '1.0.6':
		    DB_query("ALTER TABLE {$_TABLES['cl_users']} 
		    ADD status tinyint(1) DEFAULT '0',
            ADD siren varchar(20)
		    ",0);
		case '1.0.7':
		    DB_query("ALTER TABLE {$_TABLES['cl']} 
		    ADD notification tinyint(1) DEFAULT '0' AFTER modified
		    ",0);
		case '1.1':
		case '1.1.0':
		case '1.1.1':
        case '1.1.2':
		    $c = config::get_instance();
            $c->del('site_name', 'classifieds');
            $c->add('allow_republish', 0,
                'select', 0, 2, 3, 220, true, 'classifieds');
        case '1.1.3':
            //create ad users group
			DB_save($_TABLES['groups'],
                'grp_name,grp_descr',
                "'Classifieds Users','Users in this group posted at least one ad'");
			// Add user to ad users group
            $ad_users = DB_getItem($_TABLES['groups'], 'grp_id',
                             "grp_name='Classifieds Users'");
			$sql = "SELECT DISTINCT owner_id FROM {$_TABLES['cl']}";
			$users = DB_query($sql);
			require_once $_CONF['path_system'] . 'lib-user.php';
			 while ($A = DB_fetchArray($users)) {
                USER_addGroup ($ad_users, $A['owner_id']);
		    }
		case '1.1.4':
		case '1.2':		
		    //create publish feature
			DB_save($_TABLES['features'],
                'ft_name,ft_descr',
                "'classifieds.publish','Can publish classifieds'");
		case '1.2.1':
		case '1.3.0':
		case '1.3.1':
		case '1.3.2':
			
		default:
		    // update plugin version number
            $inst_parms = plugin_autoinstall_classifieds('classifieds');
            $pi_gl_version = $inst_parms['info']['pi_gl_version'];

            DB_query("UPDATE {$_TABLES['plugins']} SET pi_version = '$code_version', pi_gl_version = '$pi_gl_version' WHERE pi_name = 'classifieds'");
			COM_errorLog( "Updated classifieds plugin from v$installed_version to v$code_version", 1 );
			
            // Legacy folder migration is retained only for very old persisted states.
            // A normal 1.3.2 -> 1.4.0 upgrade must not rename/delete shared plugin
            // public files merely because new code has been deployed.
            $needsLegacyFolderMigration = version_compare($installed_version, '1.3.2', '<');
            if ($needsLegacyFolderMigration
                && $_CLASSIFIEDS_CONF['classifieds_folder'] != 'classifieds'
                && $_CLASSIFIEDS_CONF['classifieds_folder'] != '') {
                if ( rename($_CONF['path_html'] . $_CLASSIFIEDS_CONF['classifieds_folder'],$_CONF['path_html'] . $_CLASSIFIEDS_CONF['classifieds_folder'].'_old') ) {
                     COM_errorLog("CLASSIFIEDS - Renamed {$_CLASSIFIEDS_CONF['classifieds_folder']} folder." );
                } else {
                    COM_errorLog("CLASSIFIEDS - Can't rename {$_CLASSIFIEDS_CONF['classifieds_folder']} folder." );
                }
                sleep (5);
                if( rename($_CONF['path_html'] . 'classifieds',$_CONF['path_html'] . $_CLASSIFIEDS_CONF['classifieds_folder']) ) {
                     COM_errorLog("CLASSIFIEDS - Moved classifieds files to {$_CLASSIFIEDS_CONF['classifieds_folder']} folder." );
                } else {
                    COM_errorLog("CLASSIFIEDS - Can't move classifieds files to {$_CLASSIFIEDS_CONF['classifieds_folder']} folder." );
				    // For ftp update
				    rename($_CONF['path_html'] . $_CLASSIFIEDS_CONF['classifieds_folder'].'_old',$_CONF['path_html'] . $_CLASSIFIEDS_CONF['classifieds_folder']);
					COM_errorLog("CLASSIFIEDS - Check your {$_CLASSIFIEDS_CONF['classifieds_folder']} folder." );
                }
                CLASSIFIEDS_delTree($_CONF['path_html'] . $_CLASSIFIEDS_CONF['classifieds_folder'].'_old');
            }

	}
    return true;
}

function CLASSIFIEDS_delTree($dir) {
   $files = array_diff(scandir($dir), array('.','..'));
    foreach ($files as $file) {
      (is_dir("$dir/$file") && !is_link($dir)) ? CLASSIFIEDS_delTree("$dir/$file") : unlink("$dir/$file");
    }
    return rmdir($dir);
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
function plugin_profileblocksdisplay_classifieds ($uid)
{
    global $_TABLES, $LANG_CLASSIFIEDS_1;
    
    $retval .= COM_startBlock($LANG_CLASSIFIEDS_1['plugin_name']);
    $retval .= CLASSIFIEDS_displayAds($uid,0,'','',1);
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
                $arr[$var] = htmlspecialchars(strip_tags($arr[$var]));
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
	$menu->set_var('pro', $LANG_CLASSIFIEDS_1['pro']);
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
    $cookieType = isset($_COOKIE['ads_type']) ? (string) $_COOKIE['ads_type'] : '';
    $cookieCat = isset($_COOKIE['ads_cat']) ? (string) $_COOKIE['ads_cat'] : '';
    $type = '';
    $checked_category = '';

    if ($page <= 0) {
        $page = 1;
    }

    //Check if picture folder is writable
    if ( !file_exists($_CLASSIFIEDS_CONF['path_images']) || !is_writable($_CLASSIFIEDS_CONF['path_images']) ) {
        $msg = '<p>' . $LANG_CLASSIFIEDS_1['image_not_writable'] . '</p>';
        return $msg;
    }
	

    // Get ads from database
    $sql = "SELECT a.*, i.pi_filename, c.category, c.catdeleted
            FROM {$_TABLES['cl']} AS a
            LEFT JOIN {$_TABLES['cl_pic']} AS i
            ON i.pi_pid = a.clid AND i.pi_img_num IN (SELECT MIN(pi_img_num) FROM {$_TABLES['cl_pic']} WHERE pi_img_num >= 1 AND pi_pid = a.clid) 
	    	LEFT JOIN {$_TABLES['cl_cat']} AS c
            ON c.cid = a.catid WHERE c.catdeleted=0 
			";
	
	if ($my == 0) $sql .= "AND a.deleted = '0' ";
	if ($my == 1) $sql .= "AND 1 = 1 ";
	
    if ( ($my != 1) || ($profile == 1) ) {
        $sql .= " AND TO_DAYS(NOW()) - TO_DAYS(a.created) <= {$_CLASSIFIEDS_CONF['active_days']} 
	    	";
	}

    if ( ($user > 1) && ($my == 1) ) {
	    $sql .= "AND a.owner_id = {$user} ";
	}
	if ( ($user > 1) && ($my == 0) ) {
	    $sql .= "AND a.owner_id = {$user} ";
	}
	if ( COM_isAnonUser() && ($my == 1) ) {
	    return CLASSIFIEDS_loginRequiredForm();
	}
	
    $sql_index = $sql;

    if ( ($my == 0) && ($profile == 0) ) {
	    // If applicable, limit by category
	    $category = '';
        if (is_numeric($cookieCat) && $cookieCat !== '0') {
            $category = ' AND a.catid = ' . (int) $cookieCat;
        }
	    if ($catid !== '' && $catid !== '--' && $catid !== '0' && is_numeric($catid)) {
	        $category = ' AND a.catid = ' . (int) $catid;
        } else if ($catid === '0') {
		    $category = '';
		}
	    $sql_index .= $category;
		
		// If applicable, limit by type
	    // TODO remove cookie filter
		//($_COOKIE['ads_type'] == 'o') ? $type = " AND a.type = '0'" : 0;
	    //($_COOKIE['ads_type'] == 'd') ? $type = " AND a.type = '1'" : 0;
        if ($mode === 'o') {
            $type = " AND a.type = '0'";
        } elseif ($mode === 'd') {
            $type = " AND a.type = '1'";
        }
	    $sql_index .= $type;
	}

    $sql_index .= " ORDER BY created DESC";

    // If applicable, handle pagination of query
    if (isset($_CLASSIFIEDS_CONF['maxPerPage']) && $_CLASSIFIEDS_CONF['maxPerPage'] > 0) {
        // Count Ads from database
        $countResult = DB_query(
            "SELECT COUNT(*) AS total FROM {$_TABLES['cl']} "
            . "WHERE deleted = '0' "
            . "AND TO_DAYS(NOW()) <= " . (int) $_CLASSIFIEDS_CONF['active_days'] . " + TO_DAYS(created)"
        );
        $countRow = DB_fetchArray($countResult);
        $count = isset($countRow['total']) ? (int) $countRow['total'] : 0;

        // Make sure page count is reasonable, if not, fix it.
        if ((($page - 1) * (int) $_CLASSIFIEDS_CONF['maxPerPage']) > $count) {
            $page = max(1, (int) ceil($count / (int) $_CLASSIFIEDS_CONF['maxPerPage']));
        }
        // Add limit for pagination (if applicable)
        if ( is_numeric($limit) ) {
		    $sql_index .= ' LIMIT ' . $limit;
		}
		else if ($count > $_CLASSIFIEDS_CONF['maxPerPage']) {
            $offset = ($page - 1) * (int) $_CLASSIFIEDS_CONF['maxPerPage'];
            $sql_index .= ' LIMIT ' . $offset . ', ' . (int) $_CLASSIFIEDS_CONF['maxPerPage'];
        }
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
        if ($cookieType === 'o' || $mode === 'o') {
            $type_label = $LANG_CLASSIFIEDS_1['offers'];
        } elseif ($cookieType === 'd' || $mode === 'd') {
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
		$categories .= CLASSIFIEDS_adOptionList("{$_TABLES['cl']} AS a,{$_TABLES['cl_cat']} AS c", 'c.cid, c.category, c.pid, a.catid', $checked_category, 'catorder', "(c.cid=a.catid AND a.deleted=0 AND TO_DAYS(NOW()) - TO_DAYS(a.created) <= {$_CLASSIFIEDS_CONF['active_days']}) OR (c.pid=0) GROUP BY c.cid");
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
		$active = true;
		$active_days = floor((time() - $created['1'])/(24*3600));
		if (  ($active_days >= $_CLASSIFIEDS_CONF['active_days']) ) {
			$active = false;
		}

		if ($A['deleted'] == 1) {
		    $ad->set_var('class', ' class="ad-list-deleted"');
		} else if (  $active == false ) {
		    $ad->set_var('class', ' class="ad-list-old"');
		} else {
		    $ad->set_var('class', ' class="ad-list-active"');
		}
	
	    //Date
	    $date = strftime( $_CLASSIFIEDS_CONF['date_format'], $created['1']);
		
	    $ad->set_var('date', $date);
	
	    //Time
	    $time = strftime( $_CLASSIFIEDS_CONF['time_format'], $created['1']);
	    $ad->set_var('time', $time);

	    $title = ucfirst(mb_strtolower($A['title'], $_CONF['default_charset']));
		
		//First Ad image	
	    if ($A['pi_filename'] == '') {
		    $ad->set_var('small_pic', '');
	    } else if( is_numeric($limit) ) {
		    $ad->set_var('small_pic', '<a href="'. $_CLASSIFIEDS_CONF['site_url'] . '/index.php?mode=v&amp;ad=' . $A['clid'] . '&amp;seo=' . str_replace(' ', '-', $title) .  '"><img src="'. $_CLASSIFIEDS_CONF['site_url'] . '/timthumb.php?src=' . $_CLASSIFIEDS_CONF['url_images'] . $A['pi_filename'] . '&amp;w=15&amp;h=15" alt="' . $A['name'] . '" /></a>');
	    } else {
		    $ad->set_var('small_pic', '<a href="'. $_CLASSIFIEDS_CONF['site_url'] . '/index.php?mode=v&amp;ad=' . $A['clid'] . '&amp;seo=' . str_replace(' ', '-', $title) . '"><img src="'. $_CLASSIFIEDS_CONF['site_url'] . '/timthumb.php?src=' . $_CLASSIFIEDS_CONF['url_images'] . $A['pi_filename'] . '&amp;w='. $_CLASSIFIEDS_CONF['thumb_width'] . '&amp;h='. $_CLASSIFIEDS_CONF['thumb_height'] . '" alt="' . $A['name'] . '" /></a>');
	    }
	
	    //Title
		if ( is_numeric($limit) ) {
		    $ad->set_var('title', '<a href="'. $_CLASSIFIEDS_CONF['site_url'] . '/index.php?mode=v&amp;ad=' . $A['clid'] . '&amp;seo=' . str_replace(' ', '-', $title) . '" title="' . $title . '">' . substr($title,0,40) . ((strlen($title) > 40) ? '...' : '') . '</a>');
		} else {
    	    $ad->set_var('title', '<a href="'. $_CLASSIFIEDS_CONF['site_url'] . '/index.php?mode=v&amp;ad=' . $A['clid'] . '&amp;seo=' . str_replace(' ', '-', $title) . '">' . $title . '</a>');
	    }
	    //Edit link
	    if (SEC_hasRights('classifieds.admin') && ($active == true) && ($A['deleted'] == 0) ) {
	        $ad->set_var('edit', "<a href=\"{$_CLASSIFIEDS_CONF['site_url']}/index.php?mode=e&amp;op=edit&amp;ad={$A['clid']}\">
			<img src=\"{$_CLASSIFIEDS_CONF['site_url']}/images/edit.png\" align=\"top\" alt=\"\" /></a>");
	    }else {
        $ad->set_var('edit', '');
        }
	
	    //Price
	    if ($A['price'] != 0) {
		    $ad->set_var('price', number_format($A['price'], $_CONF['decimal_count'], $_CONF['decimal_separator'], $_CONF['thousand_separator']));
			$ad->set_var('currency', $_CLASSIFIEDS_CONF['currency']);
		} else {
		    $ad->set_var('price', '');
			$ad->set_var('currency', '');
		}
	
	    //Category
	    $ad->set_var('cat', $A['category']);
	
	    //Postal
	    $ad->set_var('postcode', $A['postcode']);
	
	    //City
		$city = ucwords(mb_strtolower($A['city'], $_CONF['default_charset']));
	    $ad->set_var('city', $city);
		
		if ($my == 1) {
		    $admin_ad = '<td class="ad-list-views">
			 <ul><li>' . $A['hits'] . ' ' . $LANG_CLASSIFIEDS_1['hits'] . '</li>';
			 //repost
			if (($active == false && $A['deleted'] == 0
                && !empty($_CLASSIFIEDS_CONF['allow_republish'])
                && SEC_hasRights('classifieds.publish'))
                || (SEC_hasRights('classifieds.admin') && $active == false)) {
			    $admin_ad .= '<li><a href="' . $_CLASSIFIEDS_CONF['site_url']
                    . '/index.php?op=repost&amp;mode=e&amp;ad=' . (int) $A['clid']
                    . '&amp;' . CSRF_TOKEN . '=' . SEC_createToken() . '">'
                    . $LANG_CLASSIFIEDS_2['copy_button'] . '</a></li>'; 
			}
		     $admin_ad .= '</ul></td>';
		    $ad->set_var('views',$admin_ad );
		} else {
		    $ad->set_var('views', '');
		}
	
	    $retval .= $ad->parse('', 'ad');
    }
	
    // Display pagination
    if ( (isset($_CLASSIFIEDS_CONF['maxPerPage'])) && ($_CLASSIFIEDS_CONF['maxPerPage'] > 0) &&
            ($count > $_CLASSIFIEDS_CONF['maxPerPage']) && $limit == '' ) {
        $ad->set_var('pagination', COM_printPageNavigation($_CLASSIFIEDS_CONF['site_url'] . '/index.php', 
		$page, ceil($count / $_CLASSIFIEDS_CONF['maxPerPage'])));
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

function CLASSIFIEDS_viewAd ($clid) 
{
    global $_TABLES, $_CLASSIFIEDS_CONF, $_CONF, $LANG_CLASSIFIEDS_1, $LANG_CLASSIFIEDS_2, $_USER;
    
    if (($_USER['uid'] < 2) && ($_CLASSIFIEDS_CONF['classifieds_login_required'] == 1)) {
	    $retval = COM_siteHeader('menu', $LANG_CLASSIFIEDS_1['plugin_name']);
		$retval .= CLASSIFIEDS_loginRequiredForm();
		$retval .= COM_siteFooter(1);
        return $retval;
        exit;
    }
	// query database for Ad
    $sql = "SELECT a.*, u.username, c.category 
	                 FROM {$_TABLES['cl']} as a
					 LEFT JOIN {$_TABLES['users']} AS u
                     ON u.uid = a.owner_id
					 LEFT JOIN {$_TABLES['cl_cat']} AS c
                     ON c.cid = a.catid
					 WHERE a.clid = {$clid} ";
	
	$res = DB_query($sql);

    // count number of returned results, if unexpected redirect to Ad list
    if (DB_numRows($res) != 1) {
        echo COM_refresh($_CLASSIFIEDS_CONF['site_url'] . '/index.php');
	    exit;
    }

    $A = DB_fetchArray($res);
	
	if (!SEC_hasRights('classifieds.admin') && $A['deleted']) {
	    $retval = COM_siteHeader('menu', $pagetitle);
	    $retval .= CLASSIFIEDS_user_menu();
	    $retval .= CLASSIFIEDS_message($LANG_CLASSIFIEDS_1['deleted_ad']);
		$retval .= '&nbsp;<h2>' . $LANG_CLASSIFIEDS_1['last_ads'] . '</h2>';
		$retval .= CLASSIFIEDS_centerblock_lastAds(20);
		$retval .= COM_siteFooter(0);
        return $retval;
	}
	$created = COM_getUserDateTimeFormat($A['created']);
	$active = true;
	$active_days = (time() - $created['1'])/(24*3600);
	if (  ($active_days > $_CLASSIFIEDS_CONF['active_days']) ) {
		$active = false;
	}
	
	//if ads is not active 
	if ($active == false &&  !SEC_hasRights('classifieds.admin')) {
	    $retval = COM_siteHeader('menu', $LANG_CLASSIFIEDS_1['plugin_name']);
		$retval .= CLASSIFIEDS_user_menu();
		$retval .= $LANG_CLASSIFIEDS_1['ads_not_available'];
		$retval .= COM_siteFooter(1);
        return $retval;
        exit;
    }

    $pagetitle = $A['title'] . ' - ' . $A['category'] . ' - ' . $LANG_CLASSIFIEDS_1['plugin_name'];
	$retval = COM_siteHeader('menu', $pagetitle);
	$retval .= CLASSIFIEDS_user_menu();
	$retval .= CLASSIFIEDS_message(isset($_GET['msg']) ? $_GET['msg'] : '');

    $ad = new Template($_CONF['path'] . 'plugins/classifieds/templates');
    $ad->set_file(array('ad' => 'ad_detail.thtml'));
    $ad->set_var('site_url', $_CONF['site_url']);
    $ad->set_var('classifieds_folder', $_CLASSIFIEDS_CONF['site_url']);
    
	//Title
	($A['deleted'] == 1) ? $deleted = '<font color="red">' . $LANG_CLASSIFIEDS_1['deleted'] . '</font> ' : '';
	$ad->set_var('title', $deleted . $A['title']);
	//Edit link
	if (SEC_hasRights('classifieds.admin') && ($active == true) && ($A['deleted'] == 0) ) {
	    $ad->set_var('edit', "<a href=\"{$_CLASSIFIEDS_CONF['site_url']}/index.php?mode=e&amp;op=edit&amp;ad={$A['clid']}\">
		<img src=\"{$_CLASSIFIEDS_CONF['site_url']}/images/edit.png\" align=\"absmiddle\" alt=\"\" /></a>");
	}else {
    $ad->set_var('edit', '');
    }

    //online
	$date = strftime( $_CLASSIFIEDS_CONF['date_format'], $created['1']);
	$time = strftime( $_CLASSIFIEDS_CONF['time_format'], $created['1']);
	$ad->set_var('postby', '<p>' . $LANG_CLASSIFIEDS_1['posted_by'] . ' <a href="'. $_CLASSIFIEDS_CONF['site_url'] .
	'/index.php?mode=p&amp;u=' . $A['owner_id'] .  '">'. $A['username'] . '</a> ' .
	$LANG_CLASSIFIEDS_1['on'] . ' ' . $date . ' ' . $LANG_CLASSIFIEDS_1['at'] . ' ' . $time . '</p>');
	
	//pictures
	$icount = DB_count($_TABLES['cl_pic'],'pi_pid', $clid);
    $size = $_CLASSIFIEDS_CONF['max_thumbnail_size'];
    if ($icount > 0) {
	    $result_pic = DB_query("SELECT * FROM {$_TABLES['cl_pic']} WHERE pi_pid = '". $clid ."' ORDER BY pi_img_num");
	    for ($z = 1; $z <= $icount; $z++) {
		    $I = DB_fetchArray($result_pic);
			//Big picture
	        if ($z == 1) {
                $big_picture = '<img src="' . $_CLASSIFIEDS_CONF['site_url'] . '/timthumb.php?src=' .
				$_CLASSIFIEDS_CONF['url_images'] . $I['pi_filename'] . '&amp;w=480" alt="' . $A['title'] . '" />';
	            $ad->set_var('big_picture', $big_picture);
            }

		    $saved_images .= '<a class="lightbox" href="' .  $_CLASSIFIEDS_CONF['site_url'] . '/timthumb.php?src=' .
			$_CLASSIFIEDS_CONF['url_images'] . $I['pi_filename'] . '&amp;w=640"><img src="' .
			$_CLASSIFIEDS_CONF['site_url'] . '/timthumb.php?src=' .  $_CLASSIFIEDS_CONF['url_images'] .
			$I['pi_filename'] . '&amp;w=' . $size . '&amp;h=' . $size . '" alt="' . $A['title'] . '" /></a>';

	    }
    }
    if ($icount == 0) {
	    $ad->set_var('big_picture', '');
	    $ad->set_var('pictures', '');
    } else {
        $info_picture = '<p class="info_picture"><img src="' .  $_CLASSIFIEDS_CONF['site_url'] .
		'/images/enlarge.png" alt="" align="absmiddle" /> ' . $LANG_CLASSIFIEDS_1['enlarge_picture'] .'</p>';
	    $ad->set_var('pictures', '<div id="ad-pictures">' . $saved_images . $info_picture . '</div>');
    }
		
    // Contact advertiser
    $contactUrl = $_CLASSIFIEDS_CONF['site_url']
        . '/index.php?mode=c&amp;ad=' . (int) $A['clid'];

    $ad->set_var(
        'contact',
        '<h3>' . $LANG_CLASSIFIEDS_1['contact_advertiser'] . '</h3><p>'
        . '<a href="' . $contactUrl . '">' . $LANG_CLASSIFIEDS_1['send_email'] . '</a></p>'
    );

	//Tel
	if (($A['hide_tel'] == 0) && ($A['tel'] != '')) {
    	$ad->set_var('tel', '<p>'. $A['username'] . $LANG_CLASSIFIEDS_1['double_point'] . ' ' . $A['tel'] . '</p>');
	} else {
	    $ad->set_var('tel', '');
	}
	//Siren
	if (($A['status'] == 1) && ($A['siren'] != '')) {
    	$ad->set_var('siren', '<p>'. $LANG_CLASSIFIEDS_2['siren'] . $LANG_CLASSIFIEDS_1['double_point'] . ' ' . $A['siren'] . '</p>');
	} else {
	    $ad->set_var('siren', '');
	}
	//admin
	$admin = $LANG_CLASSIFIEDS_1['manage_ad'];
	//if (SEC_hasAccess2($A) == 3) {
	    $admin .= ' (' . $A['hits'] . ' ' . $LANG_CLASSIFIEDS_1['hits'] . ')';
	//}
	
	$ad->set_var('admin', '<h3>' . $admin .'</h3>');
	
	if ( SEC_hasAccess2($A) == 3 && $A['deleted'] == 0 && $active == true ) {
		//modify
		$ad->set_var('modify', '<p><a href="'. $_CLASSIFIEDS_CONF['site_url'] . '/index.php?mode=e&amp;op=edit&amp;ad=' .
		$A['clid'] . '">' . $LANG_CLASSIFIEDS_1['modify_ad'] . '</a></p>');
		
		//delete
		$ad->set_var('delete', '<p><a href="'. $_CLASSIFIEDS_CONF['site_url']
                    . '/index.php?mode=e&amp;op=del&amp;ad=' . (int) $A['clid']
                    . '&amp;' . CSRF_TOKEN . '=' . SEC_createToken() .
		'" onclick="return confirm(\'' . $LANG_CLASSIFIEDS_1['delete_confirm'] . '\');">' . $LANG_CLASSIFIEDS_1['delete_ad'] . '</a></p>');
	} else {
	    $ad->set_var('modify', '');
		$ad->set_var('delete', '');
	}

    //save ad
	$ad->set_var('save', '<p><a href="'. $_CLASSIFIEDS_CONF['site_url'] . '/index.php?mode=s&amp;ad=' .
	$A['clid'] . '">' . $LANG_CLASSIFIEDS_1['save_ad'] . '</a></p>');
	
	//report
	$ad->set_var('report', '<p><a href="'. $_CLASSIFIEDS_CONF['site_url'] . '/index.php?mode=r&amp;ad=' .
	$A['clid'] . '">' . $LANG_CLASSIFIEDS_1['report'] . '</a></p>');
	
	//view all
	if ($_USER['uid'] == $A['owner_id']) {
	    $ad->set_var('view_all', '');
	} else {
	    $ad->set_var('view_all', '<p><a href="'. $_CLASSIFIEDS_CONF['site_url'] . '/index.php?mode=va&amp;u=' .
	    $A['owner_id'] . '">' . $LANG_CLASSIFIEDS_1['view_all'] . '</a></p>');
	}
	
	//Price
	    if ($A['price'] != 0) {
		    $ad->set_var('price', '<span class="ad-col1">' .$LANG_CLASSIFIEDS_1['price'] . $LANG_CLASSIFIEDS_1['double_point'] .
	' <strong>' . number_format($A['price'], $_CONF['decimal_count'], $_CONF['decimal_separator'], $_CONF['thousand_separator']));
	        $ad->set_var('currency', $_CLASSIFIEDS_CONF['currency'] . '</strong></span>');
		} else {
		    $ad->set_var('price', '<span class="ad-col1">' . $LANG_CLASSIFIEDS_1['price'] . $LANG_CLASSIFIEDS_1['double_point'] .
	' --</span>');
			$ad->set_var('currency', '');
		}

	//postal
	$ad->set_var('postal', '<span class="ad-col2">' . $LANG_CLASSIFIEDS_1['postcode'] .
	$LANG_CLASSIFIEDS_1['double_point'] . ' <strong>' . $A['postcode'] . '</strong></span>');
	
	//category
	$ad->set_var('category', '<div style="clear:both;"></div><p>'. $LANG_CLASSIFIEDS_1['category'] .
	$LANG_CLASSIFIEDS_1['double_point'] . ' <strong>' . $A['category'] . '</strong></p>');
	
	//detail
	$ad->set_var('detail', '<p class="ad-detail">'. PLG_replacetags(nl2br($A['text'])) . '</p>');
	
	//Facebook, Twitter, Google+
	$ad->set_var('relay', '<h3>' . $LANG_CLASSIFIEDS_1['relay'] . '</h3>');
	$ad->set_var('classifieds_name', $A['title']);
	$ad->set_var('classifieds_url', $_CLASSIFIEDS_CONF['site_url'] . '/index.php?mode=v&ad=' . $clid);
	
	//Comments
	
	$comment_page = 1;
	$delete_option = (SEC_hasRights('classifieds.admin') &&
                        SEC_hasAccess($A['owner_id'], $A['group_id'],
                        $A['perm_owner'], $A['perm_group'], $A['perm_members'],
                        $A['perm_anon']) == 3 ? true : false);
						
	require_once $_CONF['path_system'] . 'lib-comment.php';
	
	$ad->set_var('commentbar',
                            CMT_userComments($clid, $A['title'], 'classifieds',
                                        'ASC', 'flat', 0, $comment_page, false,
                                        $delete_option, 0));

    $retval .= $ad->parse('', 'ad');

	$retval .= COM_siteFooter(0);

    //hit +1
    hitAd($A['clid']);

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

function CLASSIFIEDS_missingField ($field)
{
    global $LANG_CLASSIFIEDS_2, $_TABLES;
	
	$fields_array = '';
	if ($field['catid'] != '') $pid = DB_getItem($_TABLES['cl_cat'], 'pid', "cid = {$field['catid']}");
	($field['catid'] == '0' || $field['catid'] != '' && $pid == 0) ? $fields_array[] .= $LANG_CLASSIFIEDS_2['category'] : 0;
	($field['type'] == '-1') ? $fields_array[] .= $LANG_CLASSIFIEDS_2['type'] : 0;
	($field['title'] == '') ? $fields_array[] .= $LANG_CLASSIFIEDS_2['title'] : 0;
    ($field['text'] == '') ? $fields_array[] .= $LANG_CLASSIFIEDS_2['text'] : 0;
	($field['status'] == '-1') ? $fields_array[] .= $LANG_CLASSIFIEDS_2['status'] : 0;
    ($field['tel'] == '') ? $fields_array[] .= $LANG_CLASSIFIEDS_2['tel'] : 0;
	($field['postcode'] == '') ? $fields_array[] .= $LANG_CLASSIFIEDS_2['postcode'] : 0;
	($field['city'] == '') ? $fields_array[] .= $LANG_CLASSIFIEDS_2['city'] : 0;
    
	return $fields_array;

}

function CLASSIFIEDS_checkAdAccess ($ad)
{
    global $_TABLES;
	
	$access = false;
	// query database for Ad
    $sql = "SELECT * FROM {$_TABLES['cl']} WHERE clid = {$ad} ";	
	$res = DB_query($sql);
    $A = DB_fetchArray($res);
	if (!SEC_hasRights('classifieds.admin')) {
	    if ($A['deleted'] != '0') {
		    return false;
        } else {
    		$access = true;
		}
        return $access;		
	} else {
	    return true;
	}
}

/**
* Display a "to access this area you need to be logged in" message
*
* @return   string      HTML for the message
*
*/
function CLASSIFIEDS_loginRequiredForm()
{
    global $_CONF, $LANG_CLASSIFIEDS_LOGIN;

    $cfg = array(
        'title'   => $LANG_CLASSIFIEDS_LOGIN[1],
        'message' => $LANG_CLASSIFIEDS_LOGIN[2]
    );

    return CLASSIFIEDS_loginForm($cfg);
}

/**
* Creates a <option> list from a database list for use in category form
*
* Creates option list form field using given arguments
*
* @param        string      $table      Database Table to get data from
* @param        string      $selection  Comma delimited string of fields to pull The first field is the value of the option and the second is the label to be displayed.  This is used in a SQL statement and can include DISTINCT to start.
* @param        string/array      $selected   Value (from $selection) to set to SELECTED or default
* @param        int         $sortcol    Which field to sort option list
* @param        string      $where      Optional WHERE clause to use in the SQL Selection
* @see function COM_checkList
* @return   string  Formated HTML of option values
*
*/
function CLASSIFIEDS_catOptionList( $table, $selection, $selected='', $sortcol='', $where='')
{
    global $_DB_table_prefix;

    $retval = '';

    $LangTableName = '';
    if( substr( $table, 0, strlen( $_DB_table_prefix )) == $_DB_table_prefix )
    {
        $LangTableName = 'LANG_' . substr( $table, strlen( $_DB_table_prefix ));
    }
    else
    {
        $LangTableName = 'LANG_' . $table;
    }

    global $$LangTableName;

    if( isset( $$LangTableName ))
    {
        $LangTable = $$LangTableName;
    }
    else
    {
        $LangTable = array();
    }

    $sql = "SELECT $selection FROM $table";
    if( $where != '' )
    {
        $sql .= " WHERE $where";
    }
	if ($sortcol != '') {
        $sql .= " ORDER BY {$sortcol} ASC";
	}
	$result = DB_query( $sql );
    $nrows = DB_numRows( $result );

    for( $i = 0; $i < $nrows; $i++ )
    {
        $A = DB_fetchArray( $result, true );
		if ( $A['pid'] == '0' ) {
            $retval .= '<option value="' . $A[0] . '"';

            if( is_array( $selected ) AND count( $selected ) > 0 )
            {
                foreach( $selected as $selected_item )
                {
                    if( ($A[0] == $selected_item) && ( $A[3] != '0' ) )
                    {
                        $retval .= ' selected="selected"';
                    }
				    if( $A[3] == '0' )
                    {
                        $retval .= ' disabled="disabled"';
                    }
                }
            }
            elseif( !is_array( $selected ) AND $A[0] == $selected )
            {
                $retval .= ' selected="selected"';
            }

            $retval .= '>';
            if( empty( $LangTable[$A[0]] ))
            {
                $retval .= $A[1];
            }
            else
            {
                $retval .= $LangTable[$A[0]];
            }
            $retval .= '</option>' . LB;
		}
    }

    return $retval;
}

/**
* Creates a <option> list for use in category form
*
* @return   string  Formated HTML of option values
*
*/
function CLASSIFIEDS_adOptionList( $table, $selection, $selected='', $sortcol='', $where='' )
{
    global $_DB_table_prefix, $_TABLES;

    $retval = '';

    $LangTableName = '';
    if( substr( $table, 0, strlen( $_DB_table_prefix )) == $_DB_table_prefix )
    {
        $LangTableName = 'LANG_' . substr( $table, strlen( $_DB_table_prefix ));
    }
    else
    {
        $LangTableName = 'LANG_' . $table;
    }

    global $$LangTableName;

    if( isset( $$LangTableName ))
    {
        $LangTable = $$LangTableName;
    }
    else
    {
        $LangTable = array();
    }

    $sql = "SELECT $selection  
	        FROM $table
			";

    if( $where != '' )
    {
        $sql .= " WHERE $where";
    }
	if ($sortcol != '') {
        $sql .= " ORDER BY {$sortcol} ASC";
	}
	$result = DB_query( $sql );
    $nrows = DB_numRows( $result );

    for( $i = 0; $i < $nrows; $i++ )
    {
        $A = DB_fetchArray( $result, true );
		($A['pid'] != '0') ? $spacer = '&nbsp; &nbsp;' : $spacer ='';
        $retval .= '<option value="' . $A[0] . '"';

        if( is_array( $selected ) AND count( $selected ) > 0 )
        {
            foreach( $selected as $selected_item )
            {
                if( ($A[0] == $selected_item) && ( $A['pid'] != '0' ) )
                {
                    $retval .= ' selected="selected"';
                }
            }
        }
        elseif( !is_array( $selected ) AND $A[0] == $selected AND $A['pid'] != '0' )
        {
            $retval .= ' selected="selected"';
        }
		if( $A['pid'] == '0' )
        {
            $retval .= 'style="background-color: rgb(230, 230, 230);" disabled="disabled"';
        }

        $retval .= '>';
        if( empty( $LangTable[$A[0]] ))
        {
            $retval .= $spacer . $A[1];
        }
        else
        {
            $retval .= $spacer . $LangTable[$A[0]];
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

/**
* Displays a login form
*
* This is the version of the login form displayed in the content area of the
* page (not the side bar). It will present all options (remote authentication
* - including OpenID, new registration link, etc.) according to the current
* configuration settings.
*
* @param    array   $use_config     options to override some of the defaults
* @return   string                  HTML of the login form
*
*/
function CLASSIFIEDS_loginForm($use_config = array())
{
    global $_CONF, $LANG01, $LANG04;

    $retval = '';

    $default_config = array(
        // display options
        'hide_forgotpw_link' => false,

        // for hidden fields to be included in the form
        'hidden_fields'     => '',

        // options to locally override some specific $_CONF options
        'no_3rdparty_login' => false, // $_CONF['user_login_method']['3rdparty']
        'no_openid_login'   => false, // $_CONF['user_login_method']['openid']
        'no_newreg_link'    => false, // $_CONF['disable_new_user_registration']
        'no_plugin_vars'    => false, // call PLG_templateSetVars?

        // default texts
        'title'       => $LANG04[65], // Try Logging in Again
        'message'     => $LANG04[66], // You may have mistyped ...
        'button_text' => $LANG04[80]  // Login
    );

    $config = array_merge($default_config, $use_config);

    $loginform = new Template($_CONF['path_layout'] . 'users');
    $loginform->set_file('login', 'loginform.thtml');
    $loginform->set_var('xhtml', XHTML);
    $loginform->set_var('site_url', $_CONF['site_url']);
    $loginform->set_var('site_admin_url', $_CONF['site_admin_url']);
    $loginform->set_var('layout_url', $_CONF['layout_url']);

    $loginform->set_var('start_block_loginagain',
                        COM_startBlock($config['title']));
    $loginform->set_var('lang_message', $config['message']);
    if ($config['no_newreg_link'] || $_CONF['disable_new_user_registration']) {
        $loginform->set_var('lang_newreglink', '');
    } else {
        $loginform->set_var('lang_newreglink', $LANG04[123]);
    }

    $loginform->set_var('lang_username', $LANG04[2]);
    $loginform->set_var('lang_password', $LANG01[57]);
    if ($config['hide_forgotpw_link']) {
        $loginform->set_var('lang_forgetpassword', '');
        $loginform->set_var('forgetpassword_link', '');
    } else {
        $loginform->set_var('lang_forgetpassword', $LANG04[25]);
        $forget = COM_createLink($LANG04[25], $_CONF['site_url']
                                              . '/users.php?mode=getpassword',
                                 array('rel' => 'nofollow'));
        $loginform->set_var('forgetpassword_link', $forget);
    }
    $loginform->set_var('lang_login', $config['button_text']);
    $loginform->set_var('end_block', COM_endBlock());

    // 3rd party remote authentification.
    $services = '';
    if (!$config['no_3rdparty_login'] &&
            $_CONF['user_login_method']['3rdparty'] &&
            ($_CONF['usersubmission'] == 0)) {
        $modules = SEC_collectRemoteAuthenticationModules();
        if (count($modules) > 0) {
            if (!$_CONF['user_login_method']['standard'] &&
                    (count($modules) == 1)) {
                $select = '<input type="hidden" name="service" value="'
                        . $modules[0] . '"' . XHTML . '>' . $modules[0];
            } else {
                // Build select
                $select = '<select name="service">';
                if ($_CONF['user_login_method']['standard']) {
                    $select .= '<option value="">' .  $_CONF['site_name']
                            . '</option>';
                }
                foreach ($modules as $service) {
                    $select .= '<option value="' . $service . '">' . $service
                            . '</option>';
                }
                $select .= '</select>';
            }

            $loginform->set_file('services', 'services.thtml');
            $loginform->set_var('lang_service', $LANG04[121]);
            $loginform->set_var('select_service', $select);
            $loginform->parse('output', 'services');
            $services .= $loginform->finish($loginform->get_var('output'));
        }
    }
    if (! empty($config['hidden_fields'])) {
        // allow caller to (ab)use {services} for hidden fields
        $services .= $config['hidden_fields'];
    }
    $loginform->set_var('services', $services);

    // OpenID remote authentification.
    if (!$config['no_openid_login'] && $_CONF['user_login_method']['openid'] &&
            ($_CONF['usersubmission'] == 0) &&
            !$_CONF['disable_new_user_registration']) {
        $loginform->set_file('openid_login', '../loginform_openid.thtml');
        $loginform->set_var('lang_openid_login', $LANG01[128]);
        $loginform->set_var('input_field_size', 40);

        // for backward compatibility - not used any more
        $app_url = isset($_SERVER['SCRIPT_URI'])
                 ? $_SERVER['SCRIPT_URI']
                 : 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
        $loginform->set_var('app_url', $app_url);

        $loginform->parse('output', 'openid_login');
        $loginform->set_var('openid_login',
            $loginform->finish($loginform->get_var('output')));
    } else {
        $loginform->set_var('openid_login', '');
    }

    if (! $config['no_plugin_vars']) {
        PLG_templateSetVars('loginform', $loginform);
    }
    $loginform->parse('output', 'login');

    $retval .= $loginform->finish($loginform->get_var('output'));

    return $retval;
}


?>