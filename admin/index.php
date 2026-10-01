<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Classifieds Plugin 1.4.0                                                    |
// +---------------------------------------------------------------------------+
// | index.php                                                                 |
// |                                                                           |
// | Plugin administration page                                                |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2010 by the following authors:                              |
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

require_once '../../../lib-common.php';
require_once '../../auth.inc.php';

if (!isset($_PLUGINS) || !in_array('classifieds', $_PLUGINS, true)) {
    echo COM_refresh($_CONF['site_admin_url'] . '/moderation.php');
    exit;
}

$display = '';

// Ensure user even has the rights to access this page
if (!SEC_hasRights('classifieds.admin')) {
    $display = COM_showMessageText($MESSAGE[29], $MESSAGE[30]);

    // Log attempt to access.log
    COM_accessLog("User {$_USER['username']} tried to illegally access the Classifieds plugin administration screen.");

    echo COM_createHTMLDocument(
        $display,
        array(
            'what' => 'menu',
            'pagetitle' => $MESSAGE[30],
            'httpstatus' => 403
        )
    );
    exit;
}

$vars = array('mode'       => 'alpha',
              'op'         => 'alpha',
              'msg'        => 'text',
              'cid'        => 'number',
			  'pid'        => 'number',
			  'category'   => 'text',              'catdeleted' => 'number',
              'position'    => 'text',
              'csv_action'  => 'alpha',
);

CLASSIFIEDS_filterVars($vars, $_REQUEST);

/**
 * Render the native Geeklog Configuration entry as a POST control.
 *
 * Geeklog Configuration expects conf_group through POST on the supported
 * compatibility baseline. Keep one canonical implementation so navigation and
 * first-use guidance cannot diverge.
 *
 * @param string $label
 * @param string $buttonClass
 * @return string
 */
function CLASSIFIEDS_adminConfigurationControl($label, $buttonClass = 'plugin-admin-nav__item')
{
    global $_CONF;

    return '<form class="plugin-admin-nav__form" method="post" action="'
        . $_CONF['site_admin_url'] . '/configuration.php">'
        . '<input type="hidden" name="conf_group" value="classifieds">'
        . '<button class="' . htmlspecialchars($buttonClass, ENT_QUOTES, $_CONF['default_charset'])
        . '" type="submit">'
        . htmlspecialchars($label, ENT_QUOTES, $_CONF['default_charset'])
        . '</button></form>';
}

/**
 * Persistent Classifieds administration navigation.
 *
 * @param string $mode Current admin section
 * @return string
 */
function CLASSIFIEDS_admin_menu($mode = '')
{
    global $_CONF, $LANG_CLASSIFIEDS_1, $LANG_CLASSIFIEDS_ADMIN;

    $adsActive = ($mode !== 'cat');
    $catActive = ($mode === 'cat');

    $retval = '<nav class="plugin-admin-nav" aria-label="'
        . htmlspecialchars($LANG_CLASSIFIEDS_ADMIN['administration'], ENT_QUOTES, $_CONF['default_charset'])
        . '"><div class="plugin-admin-nav__primary">';

    $retval .= '<a class="plugin-admin-nav__item'
        . ($adsActive ? ' is-active' : '') . '"'
        . ($adsActive ? ' aria-current="page"' : '')
        . ' href="' . $_CONF['site_admin_url'] . '/plugins/classifieds/index.php">'
        . htmlspecialchars($LANG_CLASSIFIEDS_1['classifieds_list'], ENT_QUOTES, $_CONF['default_charset'])
        . '</a>';

    $retval .= '<a class="plugin-admin-nav__item'
        . ($catActive ? ' is-active' : '') . '"'
        . ($catActive ? ' aria-current="page"' : '')
        . ' href="' . $_CONF['site_admin_url'] . '/plugins/classifieds/index.php?mode=cat">'
        . htmlspecialchars($LANG_CLASSIFIEDS_1['categories_list'], ENT_QUOTES, $_CONF['default_charset'])
        . '</a>';

    $retval .= CLASSIFIEDS_adminConfigurationControl(
        $LANG_CLASSIFIEDS_ADMIN['configuration']
    );

    $retval .= '</div></nav>';

    return $retval;
}

/**
 * Render concise first-use guidance from a theme-neutral template.
 *
 * @return string
 */
function CLASSIFIEDS_adminGettingStarted()
{
    global $_CONF, $_CLASSIFIEDS_CONF, $LANG_CLASSIFIEDS_ADMIN;

    $template = new Template($_CONF['path'] . 'plugins/classifieds/templates/admin');
    $template->set_file(array('help' => 'getting_started.thtml'));
    $template->set_var('getting_started_title', $LANG_CLASSIFIEDS_ADMIN['getting_started_title']);
    $template->set_var('getting_started_intro', $LANG_CLASSIFIEDS_ADMIN['getting_started_intro']);
    $template->set_var('getting_started_configure', $LANG_CLASSIFIEDS_ADMIN['getting_started_configure']);
    $template->set_var('getting_started_categories', $LANG_CLASSIFIEDS_ADMIN['getting_started_categories']);
    $template->set_var('getting_started_public', $LANG_CLASSIFIEDS_ADMIN['getting_started_public']);
    $template->set_var(
        'configuration_control',
        CLASSIFIEDS_adminConfigurationControl(
            $LANG_CLASSIFIEDS_ADMIN['getting_started_configure'],
            'plugin-admin-help__action'
        )
    );
    $template->set_var('categories_url', $_CONF['site_admin_url'] . '/plugins/classifieds/index.php?mode=cat');
    $template->set_var('public_url', $_CLASSIFIEDS_CONF['site_url'] . '/index.php');

    return $template->parse('output', 'help');
}

function CLASSIFIEDS_listAds()
{
    global $_CONF, $_TABLES, $_IMAGE_TYPE, $LANG_ADMIN, $LANG_CLASSIFIEDS_ADMIN;

    require_once $_CONF['path_system'] . 'lib-admin.php';

    $retval = '';

    $header_arr = array(      // display 'text' and use table field 'field'
        array('text' => $LANG_ADMIN['edit'], 'field' => 'edit', 'sort' => false),
        array('text' => $LANG_CLASSIFIEDS_ADMIN['clid'], 'field' => 'clid', 'sort' => true),
		array('text' => $LANG_CLASSIFIEDS_ADMIN['created'], 'field' => 'created', 'sort' => true),
        array('text' => $LANG_CLASSIFIEDS_ADMIN['title'], 'field' => 'title', 'sort' => true),
        array('text' => $LANG_CLASSIFIEDS_ADMIN['owner_id'], 'field' => 'owner_id', 'sort' => true)
    );
    $defsort_arr = array('field' => 'clid', 'direction' => 'desc');

    $text_arr = array(
        'has_extras' => true,
        'form_url' => $_CONF['site_admin_url'] . '/plugins/classifieds/index.php'
    );
	
    $sql = "SELECT clid, created, title, owner_id, group_id, "
        . "perm_owner, perm_group, perm_members, perm_anon "
        . "FROM {$_TABLES['cl']}";

    $query_arr = array(
        'table'          => 'cl',
        'sql'            => $sql,
        'query_fields'   => array('clid', 'created', 'title', 'owner_id'),
        'default_filter' => ''
    );

    $retval .= ADMIN_list('classifieds', 'plugin_getListField_classifieds',
                          $header_arr, $text_arr, $query_arr, $defsort_arr);

    return $retval;
}

/**
*   Get an individual field for the classifieds screen.
*
*   @param  string  $fieldname  Name of field (from the array, not the db)
*   @param  mixed   $fieldvalue Value of the field
*   @param  array   $A          Array of all fields from the database
*   @param  array   $icon_arr   System icon array
*   @param  object  $EntryList  This entry list object
*   @return string              HTML for field display in the table
*/
function plugin_getListField_classifieds($fieldname, $fieldvalue, $A, $icon_arr)
{
    global $_CONF, $LANG_ADMIN, $LANG_STATIC, $_TABLES, $_CLASSIFIEDS_CONF;

    switch($fieldname) {
        case "edit":
		    $edit_url = $_CLASSIFIEDS_CONF['site_url'] . '/index.php?mode=e&amp;op=edit&amp;ad=' . $A['clid'];
            $retval = COM_createLink($icon_arr['edit'], $edit_url);
            break;
        case "title":
            $url = $_CLASSIFIEDS_CONF['site_url'] .
                                 '/index.php?mode=v&amp;ad=' . $A['clid'];
            $retval = COM_createLink($A['title'], $url);
            break;
		case "owner_id":
            $uid_url = $_CONF['site_url'] .
                                 '/users.php?mode=profile&uid=' . $A['owner_id'];
            $retval = COM_createLink($A['owner_id'], $uid_url);
            break;
        default:
            $retval = htmlspecialchars((string) $fieldvalue, ENT_QUOTES, $_CONF['default_charset']);
            break;
    }
    return $retval;
}

function CLASSIFIEDS_listCategories()
{
    global $_CONF, $_TABLES, $_IMAGE_TYPE, $LANG_ADMIN, $LANG_CLASSIFIEDS_ADMIN;

    require_once $_CONF['path_system'] . 'lib-admin.php';

    $retval = '';
	
    $menu_arr = array(
        array(
            'url' => $_CONF['site_admin_url'] . '/plugins/classifieds/index.php?mode=cat&amp;op=new',
            'text' => $LANG_CLASSIFIEDS_ADMIN['create_new_cat']
        ),
        array(
            'url' => $_CONF['site_admin_url'] . '/plugins/classifieds/index.php?mode=cat&amp;op=csvimport',
            'text' => $LANG_CLASSIFIEDS_ADMIN['csv_import']
        ),
        array(
            'url' => $_CONF['site_admin_url'] . '/plugins/classifieds/index.php?mode=cat&amp;op=csvtemplate',
            'text' => $LANG_CLASSIFIEDS_ADMIN['csv_template']
        ),
        array(
            'url' => $_CONF['site_admin_url'] . '/plugins/classifieds/index.php?mode=cat&amp;op=csvhelp',
            'text' => $LANG_CLASSIFIEDS_ADMIN['csv_documentation']
        )
    );
    $retval .= ADMIN_createMenu($menu_arr, '', '');


    $header_arr = array(      // display 'text' and use table field 'field'
        array('text' => $LANG_ADMIN['edit'], 'field' => 'edit', 'sort' => false),
        array('text' => $LANG_CLASSIFIEDS_ADMIN['cid'], 'field' => 'cid', 'sort' => true),
		array('text' => $LANG_CLASSIFIEDS_ADMIN['category'], 'field' => 'category', 'sort' => true),
		array('text' => $LANG_CLASSIFIEDS_ADMIN['pid'], 'field' => 'pid', 'sort' => true),
        array('text' => $LANG_CLASSIFIEDS_ADMIN['catorder'], 'field' => 'catorder', 'sort' => true),
		array('text' => $LANG_CLASSIFIEDS_ADMIN['catdeleted'], 'field' => 'catdeleted', 'sort' => true)
    );
    $defsort_arr = array('field' => 'catorder', 'direction' => 'asc');

    $text_arr = array(
        'has_extras' => true,
        'form_url' => $_CONF['site_admin_url'] . '/plugins/classifieds/index.php?mode=cat'
    );
	
    $sql = "SELECT cid, pid, category, catorder, catdeleted, owner_id, group_id, "
        . "perm_owner, perm_group, perm_members, perm_anon "
        . "FROM {$_TABLES['cl_cat']}";

    $query_arr = array(
        'table'          => 'cl_cat',
        'sql'            => $sql,
        'query_fields'   => array('cid', 'pid', 'category', 'catorder', 'catdeleted'),
        'default_filter' => ''
    );

    $retval .= ADMIN_list('classifieds', 'plugin_getListField_classifieds_categories',
                          $header_arr, $text_arr, $query_arr, $defsort_arr);

    return $retval;
}

/**
*   Get an individual field for the classifieds screen.
*
*   @param  string  $fieldname  Name of field (from the array, not the db)
*   @param  mixed   $fieldvalue Value of the field
*   @param  array   $A          Array of all fields from the database
*   @param  array   $icon_arr   System icon array
*   @param  object  $EntryList  This entry list object
*   @return string              HTML for field display in the table
*/
function plugin_getListField_classifieds_categories($fieldname, $fieldvalue, $A, $icon_arr)
{
    global $_CONF, $LANG_CLASSIFIEDS_ADMIN, $_TABLES, $_CLASSIFIEDS_CONF;

    switch($fieldname) {
        case "edit":
		    $edit_url = $_CONF['site_admin_url'] . '/plugins/classifieds/index.php?mode=cat&amp;op=edit&amp;cid=' . $A['cid'];
            $retval = COM_createLink($icon_arr['edit'], $edit_url);
            break;
		case "pid":
		    if ($A['pid'] == '0') {
			    $retval = $LANG_CLASSIFIEDS_ADMIN['root'];
			} else {
			    $retval = htmlspecialchars(
                    (string) DB_getItem($_TABLES['cl_cat'], 'category', 'cid = ' . (int) $A['pid']),
                    ENT_QUOTES,
                    $_CONF['default_charset']
                );
			}
            break;
		case "catdeleted":
            if ($fieldvalue == 0) {
			$retval = '<img src="'. $_CLASSIFIEDS_CONF['site_url'] . '/images/green_dot.gif" alt="">';
			} else {
			$retval = '<img src="'. $_CLASSIFIEDS_CONF['site_url'] . '/images/red_dot.gif" alt="">';
			}
            break;
        default:
            $retval = htmlspecialchars((string) $fieldvalue, ENT_QUOTES, $_CONF['default_charset']);
            break;
    }
    return $retval;
}

/**
 * Render the category CSV import form.
 *
 * @return string
 */
function CLASSIFIEDS_categoryCsvForm()
{
    global $_CONF, $LANG_CLASSIFIEDS_ADMIN;

    $action = $_CONF['site_admin_url'] . '/plugins/classifieds/index.php?mode=cat&amp;op=csvimport';
    $token = SEC_createToken();

    $html = '<div class="classifieds-csv-import">'
        . '<p>' . htmlspecialchars($LANG_CLASSIFIEDS_ADMIN['csv_help'], ENT_QUOTES, $_CONF['default_charset']) . '</p>'
        . '<p><code>key,category,parent_key,order</code></p>'
        . '<p><a href="' . $_CONF['site_admin_url'] . '/plugins/classifieds/index.php?mode=cat&amp;op=csvhelp">'
        . htmlspecialchars($LANG_CLASSIFIEDS_ADMIN['csv_documentation_link'], ENT_QUOTES, $_CONF['default_charset'])
        . '</a></p>'
        . '<form method="post" enctype="multipart/form-data" action="' . $action . '">'
        . '<input type="hidden" name="mode" value="cat">'
        . '<input type="hidden" name="op" value="csvimport">'
        . '<input type="hidden" name="csv_action" value="preview">'
        . '<input type="hidden" name="' . CSRF_TOKEN . '" value="' . htmlspecialchars($token, ENT_QUOTES, $_CONF['default_charset']) . '">'
        . '<label for="classifieds-category-csv"><strong>'
        . htmlspecialchars($LANG_CLASSIFIEDS_ADMIN['csv_file'], ENT_QUOTES, $_CONF['default_charset'])
        . '</strong></label><br>'
        . '<input id="classifieds-category-csv" name="category_csv" type="file" accept=".csv,text/csv,text/plain" required>'
        . '<p><button type="submit">'
        . htmlspecialchars($LANG_CLASSIFIEDS_ADMIN['csv_preview'], ENT_QUOTES, $_CONF['default_charset'])
        . '</button></p></form></div>';

    return $html;
}

/**
 * Render end-user documentation for preparing a category CSV file.
 *
 * @return string
 */
function CLASSIFIEDS_categoryCsvHelp()
{
    global $_CONF, $LANG_CLASSIFIEDS_ADMIN;

    $e = function ($value) use ($_CONF) {
        return htmlspecialchars($value, ENT_QUOTES, $_CONF['default_charset']);
    };

    $html = '<div class="classifieds-csv-help">'
        . '<p>' . $e($LANG_CLASSIFIEDS_ADMIN['csv_doc_intro']) . '</p>'
        . '<h3>' . $e($LANG_CLASSIFIEDS_ADMIN['csv_doc_format_title']) . '</h3>'
        . '<p>' . $e($LANG_CLASSIFIEDS_ADMIN['csv_doc_format_text']) . '</p>'
        . '<pre><code>key,category,parent_key,order'
        . "\nvehicles,Vehicles,,10"
        . "\ncars,Cars,vehicles,10"
        . "\nmotorcycles,Motorcycles,vehicles,20"
        . "\nreal-estate,Real estate,,20"
        . "\nreal-estate-sale,Sale,real-estate,10"
        . "\nreal-estate-rental,Rental,real-estate,20</code></pre>"
        . '<h3>' . $e($LANG_CLASSIFIEDS_ADMIN['csv_doc_columns_title']) . '</h3>'
        . '<dl>'
        . '<dt><code>key</code></dt><dd>' . $e($LANG_CLASSIFIEDS_ADMIN['csv_doc_key']) . '</dd>'
        . '<dt><code>category</code></dt><dd>' . $e($LANG_CLASSIFIEDS_ADMIN['csv_doc_category']) . '</dd>'
        . '<dt><code>parent_key</code></dt><dd>' . $e($LANG_CLASSIFIEDS_ADMIN['csv_doc_parent']) . '</dd>'
        . '<dt><code>order</code></dt><dd>' . $e($LANG_CLASSIFIEDS_ADMIN['csv_doc_order']) . '</dd>'
        . '</dl>'
        . '<h3>' . $e($LANG_CLASSIFIEDS_ADMIN['csv_doc_hierarchy_title']) . '</h3>'
        . '<p>' . $e($LANG_CLASSIFIEDS_ADMIN['csv_doc_hierarchy_text']) . '</p>'
        . '<pre><code>property,Property,,10'
        . "\nsale,For sale,property,10"
        . "\napartments,Apartments,sale,10"
        . "\nhouses,Houses,sale,20</code></pre>"
        . '<h3>' . $e($LANG_CLASSIFIEDS_ADMIN['csv_doc_rules_title']) . '</h3>'
        . '<ul>'
        . '<li>' . $e($LANG_CLASSIFIEDS_ADMIN['csv_doc_rule_utf8']) . '</li>'
        . '<li>' . $e($LANG_CLASSIFIEDS_ADMIN['csv_doc_rule_header']) . '</li>'
        . '<li>' . $e($LANG_CLASSIFIEDS_ADMIN['csv_doc_rule_key']) . '</li>'
        . '<li>' . $e($LANG_CLASSIFIEDS_ADMIN['csv_doc_rule_parent']) . '</li>'
        . '<li>' . $e($LANG_CLASSIFIEDS_ADMIN['csv_doc_rule_order']) . '</li>'
        . '<li>' . $e($LANG_CLASSIFIEDS_ADMIN['csv_doc_rule_existing']) . '</li>'
        . '<li>' . $e($LANG_CLASSIFIEDS_ADMIN['csv_doc_rule_preview']) . '</li>'
        . '</ul>'
        . '<h3>' . $e($LANG_CLASSIFIEDS_ADMIN['csv_doc_workflow_title']) . '</h3>'
        . '<ol>'
        . '<li>' . $e($LANG_CLASSIFIEDS_ADMIN['csv_doc_step_template']) . '</li>'
        . '<li>' . $e($LANG_CLASSIFIEDS_ADMIN['csv_doc_step_edit']) . '</li>'
        . '<li>' . $e($LANG_CLASSIFIEDS_ADMIN['csv_doc_step_preview']) . '</li>'
        . '<li>' . $e($LANG_CLASSIFIEDS_ADMIN['csv_doc_step_confirm']) . '</li>'
        . '</ol>'
        . '<p><a href="' . $_CONF['site_admin_url'] . '/plugins/classifieds/index.php?mode=cat&amp;op=csvtemplate">'
        . $e($LANG_CLASSIFIEDS_ADMIN['csv_template']) . '</a> &middot; '
        . '<a href="' . $_CONF['site_admin_url'] . '/plugins/classifieds/index.php?mode=cat&amp;op=csvimport">'
        . $e($LANG_CLASSIFIEDS_ADMIN['csv_import']) . '</a></p>'
        . '</div>';

    return $html;
}

/**
 * Render a validated CSV preview and confirmation form.
 *
 * @param string $csv
 * @param array $rows
 * @return string
 */
function CLASSIFIEDS_categoryCsvPreview($csv, $rows)
{
    global $_CONF, $LANG_CLASSIFIEDS_ADMIN;

    $preview = CLASSIFIEDS_previewCategoryImport($rows);
    $createCount = 0;
    $skipCount = 0;
    $html = '<div class="classifieds-csv-preview"><p><strong>'
        . htmlspecialchars($LANG_CLASSIFIEDS_ADMIN['csv_preview_title'], ENT_QUOTES, $_CONF['default_charset'])
        . '</strong></p><table class="admin-list-table"><thead><tr>'
        . '<th>' . htmlspecialchars($LANG_CLASSIFIEDS_ADMIN['csv_key'], ENT_QUOTES, $_CONF['default_charset']) . '</th>'
        . '<th>' . htmlspecialchars($LANG_CLASSIFIEDS_ADMIN['category'], ENT_QUOTES, $_CONF['default_charset']) . '</th>'
        . '<th>' . htmlspecialchars($LANG_CLASSIFIEDS_ADMIN['csv_parent_key'], ENT_QUOTES, $_CONF['default_charset']) . '</th>'
        . '<th>' . htmlspecialchars($LANG_CLASSIFIEDS_ADMIN['catorder'], ENT_QUOTES, $_CONF['default_charset']) . '</th>'
        . '<th>' . htmlspecialchars($LANG_CLASSIFIEDS_ADMIN['csv_status'], ENT_QUOTES, $_CONF['default_charset']) . '</th>'
        . '</tr></thead><tbody>';

    foreach ($preview as $row) {
        $isCreate = ($row['status'] === 'create');
        if ($isCreate) {
            $createCount++;
        } else {
            $skipCount++;
        }

        $html .= '<tr><td><code>' . htmlspecialchars($row['key'], ENT_QUOTES, $_CONF['default_charset']) . '</code></td>'
            . '<td>' . htmlspecialchars($row['category'], ENT_QUOTES, $_CONF['default_charset']) . '</td>'
            . '<td>' . htmlspecialchars($row['parent_key'], ENT_QUOTES, $_CONF['default_charset']) . '</td>'
            . '<td>' . (int) $row['order'] . '</td>'
            . '<td>' . htmlspecialchars(
                $isCreate ? $LANG_CLASSIFIEDS_ADMIN['csv_status_create'] : $LANG_CLASSIFIEDS_ADMIN['csv_status_skip'],
                ENT_QUOTES,
                $_CONF['default_charset']
            ) . '</td></tr>';
    }
    $html .= '</tbody></table>';

    $html .= '<p>' . sprintf(
        htmlspecialchars($LANG_CLASSIFIEDS_ADMIN['csv_preview_summary'], ENT_QUOTES, $_CONF['default_charset']),
        $createCount,
        $skipCount
    ) . '</p>';

    $token = SEC_createToken();
    $html .= '<form method="post" action="'
        . $_CONF['site_admin_url'] . '/plugins/classifieds/index.php?mode=cat&amp;op=csvimport">'
        . '<input type="hidden" name="mode" value="cat">'
        . '<input type="hidden" name="op" value="csvimport">'
        . '<input type="hidden" name="csv_action" value="confirm">'
        . '<input type="hidden" name="' . CSRF_TOKEN . '" value="' . htmlspecialchars($token, ENT_QUOTES, $_CONF['default_charset']) . '">'
        . '<input type="hidden" name="csv_payload" value="'
        . htmlspecialchars(base64_encode($csv), ENT_QUOTES, $_CONF['default_charset']) . '">'
        . '<button type="submit">'
        . htmlspecialchars($LANG_CLASSIFIEDS_ADMIN['csv_confirm'], ENT_QUOTES, $_CONF['default_charset'])
        . '</button></form></div>';

    return $html;
}

// MAIN

if ($_REQUEST['mode'] === 'cat' && $_REQUEST['op'] === 'csvtemplate') {
    $filename = 'classifieds-categories-template.csv';
    $csv = "key,category,parent_key,order\n"
        . "vehicles,Vehicles,,10\n"
        . "cars,Cars,vehicles,10\n"
        . "motorcycles,Motorcycles,vehicles,20\n"
        . "real-estate,Real estate,,20\n"
        . "real-estate-sale,Sale,real-estate,10\n"
        . "real-estate-rental,Rental,real-estate,20\n";

    header('Content-Type: text/csv; charset=UTF-8');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    echo "\xEF\xBB\xBF" . $csv;
    exit;
}

$display .= CLASSIFIEDS_admin_menu($_REQUEST['mode']);

// If any message
$display .= CLASSIFIEDS_message($_REQUEST['msg']);

switch ($_REQUEST['mode']) {
    case 'cat' :
		require_once ($_CONF['path'] . 'plugins/classifieds/lib-edit.php');

        switch ($_REQUEST['op']) {
            case 'delete':
                if (!SEC_checkToken()) {
                    $display .= COM_showMessageText(
                        $LANG_CLASSIFIEDS_ADMIN['deletion_fail'],
                        $LANG_CLASSIFIEDS_2['error']
                    );
                    break;
                }

                $cid = (int) $_REQUEST['cid'];
                $adCount = DB_count($_TABLES['cl'], 'catid', $cid);
                $childCount = DB_count($_TABLES['cl_cat'], 'pid', $cid);

                if ($cid <= 0 || $adCount > 0 || $childCount > 0) {
                    $msg = $LANG_CLASSIFIEDS_ADMIN['category_in_use'];
                } else {
                    DB_delete($_TABLES['cl_cat'], 'cid', $cid);
                    if (DB_affectedRows('') == 1) {
                        PLG_itemDeleted('category:' . $cid, 'classifieds');
                        $msg = $LANG_CLASSIFIEDS_ADMIN['deletion_succes'];
                    } else {
                        $msg = $LANG_CLASSIFIEDS_ADMIN['deletion_fail'];
                    }
                }

                echo COM_refresh(
                    $_CONF['site_admin_url']
                    . '/plugins/classifieds/index.php?mode=cat&amp;msg=' . urlencode($msg)
                );
                exit;

            case 'save':
                if (!SEC_checkToken()) {
                    $display .= COM_showMessageText(
                        $LANG_CLASSIFIEDS_2['save_fail'],
                        $LANG_CLASSIFIEDS_2['error']
                    );
                    break;
                }

                if ($_REQUEST['cid'] == $_REQUEST['pid']) {
                    $_REQUEST['pid'] = '0';
                }

                $missingfields = CLASSIFIEDS_missingFieldCat($_REQUEST);
                if (!empty($missingfields)) {
                    $display .= COM_startBlock($LANG_CLASSIFIEDS_2['error']);
                    $display .= $LANG_CLASSIFIEDS_2['missing_field'];
                    $display .= '<ul>';
                    foreach ($missingfields as $value) {
                        $display .= '<li>' . $value . '</li>';
                    }
                    $display .= '</ul>';
                    $display .= $LANG_CLASSIFIEDS_2['check_it'];
                    $display .= COM_endBlock();
                    $display .= CLASSIFIEDS_getCatForm($_REQUEST);
                    break;
                }

                $category = DB_escapeString(COM_getTextContent($_REQUEST['category']));
                $pid = (int) $_REQUEST['pid'];
                $catdeleted = !empty($_REQUEST['catdeleted']) ? 1 : 0;
                $position = isset($_REQUEST['position'])
                    ? strtolower(trim((string) $_REQUEST['position']))
                    : 'last';
                if (!preg_match('/^(?:first|last|after:[0-9]+)$/', $position)) {
                    $position = 'last';
                }

                $cid = (!empty($_REQUEST['cid']) && is_numeric($_REQUEST['cid']))
                    ? (int) $_REQUEST['cid']
                    : 0;
                $oldPid = null;

                if ($cid > 0) {
                    $oldPid = (int) DB_getItem(
                        $_TABLES['cl_cat'],
                        'pid',
                        'cid = ' . $cid
                    );
                }

                // catorder is internal only. The semantic position is applied
                // after saving and both the current and former sibling groups
                // are normalized automatically.
                if ($cid > 0) {
                    $sql = "pid = '{$pid}', "
                         . "category = '{$category}', "
                         . "catorder = '0', "
                         . "catdeleted = '{$catdeleted}'";
                    $sql = "UPDATE {$_TABLES['cl_cat']} SET {$sql} WHERE cid = {$cid}";
                } else {
                    $sql = "pid = '{$pid}', "
                         . "category = '{$category}', "
                         . "catorder = '0', "
                         . "catdeleted = '{$catdeleted}', "
                         . "owner_id = '" . (int) $_USER['uid'] . "'";
                    $sql = "INSERT INTO {$_TABLES['cl_cat']} SET {$sql}";
                }

                DB_query($sql);
                if (!DB_error()) {
                    if ($cid <= 0) {
                        $cid = (int) DB_insertId();
                    }

                    CLASSIFIEDS_applyChildCategoryPosition(
                        $cid,
                        $pid,
                        $position,
                        $oldPid
                    );

                    if (!DB_error()) {
                        PLG_itemSaved('category:' . $cid, 'classifieds');
                    }
                }

                if (DB_error()) {
                    $msg = isset($LANG_CLASSIFIEDS_ADMIN['save_fail'])
                        ? $LANG_CLASSIFIEDS_ADMIN['save_fail']
                        : $LANG_CLASSIFIEDS_2['save_fail'];
                } else {
                    $msg = isset($LANG_CLASSIFIEDS_ADMIN['save_success'])
                        ? $LANG_CLASSIFIEDS_ADMIN['save_success']
                        : $LANG_CLASSIFIEDS_2['save_success'];
                }

                echo COM_refresh(
                    $_CONF['site_admin_url']
                    . '/plugins/classifieds/index.php?msg=' . urlencode($msg)
                    . '&amp;mode=cat'
                );
                exit;

            case 'edit':
                $cid = (int) $_REQUEST['cid'];
                if ($cid <= 0) {
                    echo COM_refresh(
                        $_CONF['site_admin_url'] . '/plugins/classifieds/index.php?mode=cat'
                    );
                    exit;
                }

                $res = DB_query(
                    "SELECT cid, pid, category, catorder, catdeleted, owner_id, group_id, "
                    . "perm_owner, perm_group, perm_members, perm_anon "
                    . "FROM {$_TABLES['cl_cat']} WHERE cid = " . $cid . " LIMIT 1"
                );
                $categoryRow = DB_fetchArray($res);
                if (!is_array($categoryRow)) {
                    echo COM_refresh(
                        $_CONF['site_admin_url'] . '/plugins/classifieds/index.php?mode=cat'
                    );
                    exit;
                }

                $display .= CLASSIFIEDS_getCatForm($categoryRow);
                break;

            case 'csvhelp':
                $display .= COM_startBlock($LANG_CLASSIFIEDS_ADMIN['csv_documentation']);
                $display .= CLASSIFIEDS_categoryCsvHelp();
                $display .= COM_endBlock();
                break;

            case 'csvimport':
                require_once $_CONF['path'] . 'plugins/classifieds/lib-categories.php';

                $csvAction = isset($_REQUEST['csv_action'])
                    ? preg_replace('/[^a-z]/', '', strtolower((string) $_REQUEST['csv_action']))
                    : '';

                if ($csvAction === '') {
                    $display .= COM_startBlock($LANG_CLASSIFIEDS_ADMIN['csv_import']);
                    $display .= CLASSIFIEDS_categoryCsvForm();
                    $display .= COM_endBlock();
                    break;
                }

                if (!SEC_checkToken()) {
                    $display .= COM_showMessageText(
                        $LANG_CLASSIFIEDS_ADMIN['csv_error_token'],
                        $LANG_CLASSIFIEDS_2['error']
                    );
                    break;
                }

                if ($csvAction === 'preview') {
                    $csv = '';
                    if (!isset($_FILES['category_csv'])
                        || !is_array($_FILES['category_csv'])
                        || !isset($_FILES['category_csv']['error'])
                        || (int) $_FILES['category_csv']['error'] !== UPLOAD_ERR_OK
                        || empty($_FILES['category_csv']['tmp_name'])
                        || !is_uploaded_file($_FILES['category_csv']['tmp_name'])) {
                        $display .= CLASSIFIEDS_categoryImportErrorsHtml(array('upload'));
                        $display .= CLASSIFIEDS_categoryCsvForm();
                        break;
                    }

                    if ((int) $_FILES['category_csv']['size'] > 262144) {
                        $display .= CLASSIFIEDS_categoryImportErrorsHtml(array('too_large'));
                        $display .= CLASSIFIEDS_categoryCsvForm();
                        break;
                    }

                    $csv = file_get_contents($_FILES['category_csv']['tmp_name']);
                    if ($csv === false) {
                        $display .= CLASSIFIEDS_categoryImportErrorsHtml(array('read_failed'));
                        $display .= CLASSIFIEDS_categoryCsvForm();
                        break;
                    }

                    $parsed = CLASSIFIEDS_parseCategoryCsv($csv);
                    $display .= COM_startBlock($LANG_CLASSIFIEDS_ADMIN['csv_import']);
                    if (!empty($parsed['errors'])) {
                        $display .= CLASSIFIEDS_categoryImportErrorsHtml($parsed['errors']);
                        $display .= CLASSIFIEDS_categoryCsvForm();
                    } else {
                        $display .= CLASSIFIEDS_categoryCsvPreview($csv, $parsed['rows']);
                    }
                    $display .= COM_endBlock();
                    break;
                }

                if ($csvAction === 'confirm') {
                    $payload = isset($_POST['csv_payload']) ? (string) $_POST['csv_payload'] : '';
                    $csv = base64_decode($payload, true);
                    if ($csv === false || strlen($csv) > 262144) {
                        $display .= CLASSIFIEDS_categoryImportErrorsHtml(array('payload'));
                        break;
                    }

                    // Re-parse and re-validate on confirmation; never trust the preview request.
                    $parsed = CLASSIFIEDS_parseCategoryCsv($csv);
                    if (!empty($parsed['errors'])) {
                        $display .= CLASSIFIEDS_categoryImportErrorsHtml($parsed['errors']);
                        break;
                    }

                    $import = CLASSIFIEDS_importCategories($parsed['rows']);
                    if ($import['error'] !== '') {
                        $display .= CLASSIFIEDS_categoryImportErrorsHtml(array($import['error']));
                        break;
                    }

                    $msg = sprintf(
                        $LANG_CLASSIFIEDS_ADMIN['csv_import_success'],
                        (int) $import['created'],
                        (int) $import['skipped']
                    );
                    echo COM_refresh(
                        $_CONF['site_admin_url']
                        . '/plugins/classifieds/index.php?mode=cat&amp;msg=' . urlencode($msg)
                    );
                    exit;
                }

                $display .= CLASSIFIEDS_categoryImportErrorsHtml(array('invalid'));
                break;

			case 'new':
			    $display .= COM_startBlock($LANG_CLASSIFIEDS_1['plugin_name']);
		        $display .= CLASSIFIEDS_getCatForm();
		        $display .= COM_endBlock();
				break;
            default:
			    $display .= COM_startBlock($LANG_CLASSIFIEDS_1['plugin_name']);
		        $display .= CLASSIFIEDS_listCategories();
		        $display .= COM_endBlock();
		}
		break;
		
	default :
        $display .= CLASSIFIEDS_adminGettingStarted();
        $display .= COM_startBlock($LANG_CLASSIFIEDS_1['plugin_name']);

        // Reflect the same publication policy enforced by public mutations.
        $publishGroups = CLASSIFIEDS_publishGroups();
        $groupCount = count($publishGroups);

        if ($groupCount === 0) {
            $display .= '<p>' . $LANG_CLASSIFIEDS_ADMIN['publish_all_logged_in'] . '</p>';
        } else {
            $label = ($groupCount === 1)
                ? $LANG_CLASSIFIEDS_ADMIN['publish_restricted_group']
                : $LANG_CLASSIFIEDS_ADMIN['publish_restricted_groups'];
            $display .= '<p>' . sprintf($label, $groupCount) . '</p><ul>';
            foreach ($publishGroups as $groupName) {
                $display .= '<li>'
                    . htmlspecialchars($groupName, ENT_QUOTES, $_CONF['default_charset'])
                    . '</li>';
            }
            $display .= '</ul>';
        }

        if (!is_dir($_CLASSIFIEDS_CONF['path_images'])
            || !is_writable($_CLASSIFIEDS_CONF['path_images'])) {
            $display .= CLASSIFIEDS_message(
                '<p>' . $LANG_CLASSIFIEDS_1['image_not_writable'] . '</p>'
            );
        } else {
            $display .= CLASSIFIEDS_listAds();
        }
		$display .= COM_endBlock();
}

echo CLASSIFIEDS_renderPage(
    $display,
    $LANG_CLASSIFIEDS_1['plugin_name'] . ' - ' . $LANG_CLASSIFIEDS_ADMIN['administration']
);

?>
