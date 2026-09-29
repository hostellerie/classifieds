<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Classifieds Plugin 1.3                                                    |
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

$display = '';

// Ensure user even has the rights to access this page
if (! SEC_hasRights('classifieds.admin')) {
    $display .= COM_siteHeader('menu', $MESSAGE[30])
             . COM_showMessageText($MESSAGE[29], $MESSAGE[30])
             . COM_siteFooter();

    // Log attempt to access.log
    COM_accessLog("User {$_USER['username']} tried to illegally access the Classifieds plugin administration screen.");

    echo $display;
    exit;
}

$vars = array('mode'       => 'alpha',
              'op'         => 'alpha',
              'msg'        => 'text',
              'cid'        => 'number',
			  'pid'        => 'number',
			  'category'   => 'text',
			  'catorder'   => 'number',
              'catdeleted' => 'number',
);

CLASSIFIEDS_filterVars($vars, $_REQUEST);

/**
 * Returns admin menu display
 *
 * Generates the admin menu from the template and returns the result as a string of HTML
 *
 * @return string HTML of admin menu
 */
function CLASSIFIEDS_admin_menu () 
{
    global $_CONF, $LANG_CLASSIFIEDS_1, $_TABLES;

    $retval = COM_startBlock();

    // generate the menu from the template
    $menu = new Template($_CONF['path'] . 'plugins/classifieds/templates/menus');
    $menu->set_file(array('menu' => 'admin_menu.thtml'));
    $menu->set_var('site_url', $_CONF['site_url']);
	$menu->set_var('classifieds', $LANG_CLASSIFIEDS_1['plugin_name']);
	$menu->set_var('classifieds_list', $LANG_CLASSIFIEDS_1['classifieds_list']);
	$menu->set_var('categories_list', $LANG_CLASSIFIEDS_1['categories_list']);
	
    $retval .= $menu->parse('output', 'menu');

    $retval .= COM_endBlock();

    // retval results
    return $retval;
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
	
	$sql = "SELECT
	            *
            FROM {$_TABLES['cl']}
			WHERE 1=1 ";

    $query_arr = array(
        'table'          => 'cl',
        'sql'            => $sql,
        'query_fields'   => array('clid', 'created', 'title', 'owner_id'),
        'default_filter' => COM_getPermSQL ('AND', 0, 3)
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
            $retval = stripslashes($fieldvalue);
            break;
    }
    return $retval;
}

function CLASSIFIEDS_listCategories()
{
    global $_CONF, $_TABLES, $_IMAGE_TYPE, $LANG_ADMIN, $LANG_CLASSIFIEDS_ADMIN;

    require_once $_CONF['path_system'] . 'lib-admin.php';

    $retval = '';
	
	$retval .= '<p><a href="' . $_CONF['site_admin_url'] . '/plugins/classifieds/index.php?mode=cat&amp;op=new">' . $LANG_CLASSIFIEDS_ADMIN['create_new_cat'] . '</a></p>';

    reorderCategories();	

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
	
	$sql = "SELECT
	            *
            FROM {$_TABLES['cl_cat']}
			WHERE 1=1 ";

    $query_arr = array(
        'table'          => 'cl_cat',
        'sql'            => $sql,
        'query_fields'   => array('cid', 'pid', 'category', 'catorder', 'catdeleted'),
        'default_filter' => COM_getPermSQL ('AND', 0, 3)
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
			    $retval = stripslashes(DB_getItem($_TABLES['cl_cat'], 'category', "cid = {$A['pid']}"));
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
            $retval = stripslashes($fieldvalue);
            break;
    }
    return $retval;
}

// MAIN

$display .= COM_siteHeader('menu', $LANG_CLASSIFIEDS_1['plugin_name']);

$display .= CLASSIFIEDS_admin_menu();

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

                DB_delete($_TABLES['cl_cat'], 'cid', (int) $_REQUEST['cid']);
                if (DB_affectedRows('') == 1) {
                    $msg = $LANG_CLASSIFIEDS_ADMIN['deletion_succes'];
                } else {
                    $msg = $LANG_CLASSIFIEDS_ADMIN['deletion_fail'];
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
                $catorder = empty($_REQUEST['catorder']) ? 0 : (int) $_REQUEST['catorder'];
                $catdeleted = !empty($_REQUEST['catdeleted']) ? 1 : 0;

                if (!empty($_REQUEST['cid']) && is_numeric($_REQUEST['cid'])) {
                    $cid = (int) $_REQUEST['cid'];
                    $sql = "pid = '{$pid}', "
                         . "category = '{$category}', "
                         . "catorder = '{$catorder}', "
                         . "catdeleted = '{$catdeleted}'";
                    $sql = "UPDATE {$_TABLES['cl_cat']} SET {$sql} WHERE cid = {$cid}";
                } else {
                    if ($catorder <= 0) {
                        $catorder = (int) DB_getItem(
                            $_TABLES['cl_cat'],
                            'catorder',
                            'cid = ' . $pid
                        ) + 1;
                    }

                    $sql = "pid = '{$pid}', "
                         . "category = '{$category}', "
                         . "catorder = '{$catorder}', "
                         . "catdeleted = '{$catdeleted}', "
                         . "owner_id = '" . (int) $_USER['uid'] . "'";
                    $sql = "INSERT INTO {$_TABLES['cl_cat']} SET {$sql}";
                }

                DB_query($sql);
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
	    $display .= COM_startBlock($LANG_CLASSIFIEDS_1['plugin_name']);

        $display .= '<img src="' . $_CONF['site_admin_url'] . '/plugins/classifieds/images/classifieds.png" alt="" align="left" hspace="10">' 
                 . $LANG_CLASSIFIEDS_ADMIN['plugin_doc'] . ' <a href="http://geeklog.fr/wiki/plugins:classifieds" target="_blank">' 
                 . $LANG_CLASSIFIEDS_ADMIN['online'] . '</a>. ' . $LANG_CLASSIFIEDS_ADMIN['plugin_conf'] 
                 . ' <a href="#" onclick="classifieds_conf_link.submit()">'. $LANG_CLASSIFIEDS_ADMIN['online']
                 . '</a>. ' . "<form name='classifieds_conf_link' action='{$_CONF['site_admin_url']}/configuration.php' method='POST'><input type='hidden' name='conf_group' value='classifieds'></form>";	
        $display .= '<div style="clear:both;"></div>';
        
		//Display group list with classifieds.publish right or warning
		$ft_id = DB_getItem($_TABLES['features'], 'ft_id', "ft_name = 'classifieds.publish'");
		$sql = "SELECT * FROM {$_TABLES['access']} as a LEFT JOIN {$_TABLES['groups']} AS g ON a.acc_grp_id = g.grp_id WHERE a.acc_ft_id = $ft_id ";
		$result = DB_query($sql);
        $i = 0;
		$gr_nb = DB_numRows($result);
		if ($gr_nb == 0) {
		    $display .= '<p>' . $LANG_CLASSIFIEDS_ADMIN['no_group_access'] . '</p><ol>';
		} else if ($gr_nb ==1) {
		    $display .= '<p>' . $gr_nb . ' ' . $LANG_CLASSIFIEDS_ADMIN['group_access'] . '</p><ol>';
		} else {
		    $display .= '<p>' . $gr_nb . ' ' . $LANG_CLASSIFIEDS_ADMIN['groups_access'] . '</p><ol>';
		}
	
		while ($A = DB_fetchArray($result)) {
		    $display .= '<li>' . $A['grp_name'] . '</li>';
			$i++;
		} 
		$display .= '</ol>';
		
		//Select group to give classifieds.publish right
		
        //Check if picture folder is writable
        if ( !file_exists($_CLASSIFIEDS_CONF['path_images']) || !is_writable($_CLASSIFIEDS_CONF['path_images']) ) {
            $display .= CLASSIFIEDS_message('<p>'. $LANG_CLASSIFIEDS_1['image_not_writable'] . '</p><p> >> '. $_CLASSIFIEDS_CONF['path_images'] . '</p>');
        } else {
            // check jquery plugin
            if (!in_array('jquery', $_PLUGINS)) {
                $display .= '<p>'. $LANG_CLASSIFIEDS_1['install_jquery'] . '</p><p> >> <a href="http://geeklog.fr/wiki/plugins:jquery" target="_blank">jQuery plugin</a></p>';
            }
            $display .= CLASSIFIEDS_listAds();
        }
		$display .= COM_endBlock();
}

$display .= COM_siteFooter();

echo $display;

?>
