<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Classifieds Plugin 1.4.0                                                  |
// +---------------------------------------------------------------------------+
// | lib-edit.php                                                             |
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

/**
 * This function creates an Ad Form
 *
 * Creates an Form for an Ad using the supplied defaults (if specified).
 *
 * @param array $ad array of values describing an Ad
 * @return string HTML string of Ad form
 */
function CLASSIFIEDS_getAdForm($ad = array()) {

    global $_CONF, $_CLASSIFIEDS_CONF, $LANG_CLASSIFIEDS_2, $LANG_CLASSIFIEDS_ADMIN, $_TABLES, $LANG24, $LANG_ADMIN, $_USER;

    $defaults = array(
        'clid' => '',
        'catid' => '',
        'type' => '',
        'title' => '',
        'text' => '',
        'price' => 0,
        'status' => '',
        'siren' => '',
        'tel' => '',
        'hide_tel' => 0,
        'postcode' => '',
        'city' => '',
        'created' => '',
        'modified' => '',
        'deleted' => 0,
        'owner_id' => isset($_USER['uid']) ? (int) $_USER['uid'] : 0,
        'group_id' => 1,
        'perm_owner' => 3,
        'perm_group' => 2,
        'perm_members' => 2,
        'perm_anon' => 2
    );
    $ad = is_array($ad) ? array_merge($defaults, $ad) : $defaults;

	if ($_USER['uid'] < 2) {
	    return SEC_loginRequiredForm();
	}
	if(!SEC_hasRights('classifieds.publish')) {
	
	    	//Give publish rights to logged-in users if there is no group with this feature
			$ft_id = DB_getItem($_TABLES['features'], 'ft_id', "ft_name = 'classifieds.publish'");
			$grp_id = DB_getItem($_TABLES['access'], 'acc_grp_id', "acc_ft_id = $ft_id");
            //COM_errorLog('Classifieds feature: ' . $ft_id . ' | Group: ' . $grp_id );
			if ($grp_id == '') {
			    // Give access
			} else {
			    // Display message
				return $LANG_CLASSIFIEDS_2['access_reserved'] . ' <strong>"' . DB_getItem($_TABLES['groups'], 'grp_name', "grp_id = $grp_id") . '"</strong>';
			}
	    
	}
	
	$active = true;
	if ($ad['clid'] !== '' && $ad['created'] !== '') {
	    $created = COM_getUserDateTimeFormat($ad['created']);
        $createdTimestamp = isset($created[1]) ? (int) $created[1] : 0;
	    $active_days = $createdTimestamp > 0 ? (time() - $createdTimestamp)/(24*3600) : 0;
		if ( ($active_days > $_CLASSIFIEDS_CONF['active_days']) ) {
			$active = false;
		}

		if ( (SEC_hasAccess2($ad) != 3 || $ad['deleted'] == 1 || $active == false) && !SEC_hasRights('classifieds.admin')) {
			echo COM_refresh($_CLASSIFIEDS_CONF['site_url'] . "/index.php?error=0");
			exit;
		}
	}
	
	//Display form
	($ad['clid'] == '') ? $retval = COM_startBlock($LANG_CLASSIFIEDS_2['insert_new_ad']) :
	$retval = COM_startBlock($LANG_CLASSIFIEDS_2['edit_label'] . ' ' . $ad['title']);

    $template = new Template($_CONF['path'] . 'plugins/classifieds/templates');
    $template->set_file(array('ad' => 'ad_form.thtml'));
    $template->set_var('site_url', $_CLASSIFIEDS_CONF['site_url']);
	$template->set_var('xhtml', XHTML);
    $token = SEC_createToken();
    $template->set_var('gltoken_name', CSRF_TOKEN);
    $template->set_var('gltoken', $token);
	
	if (is_numeric($ad['clid'])) {
        $template->set_var('clid', '<input type="hidden" name="clid" value="' . $ad['clid'] .'" />');
    } else {
        $template->set_var('clid', '');
    }
		
	//Your Ad
	$template->set_var('your_ad', $LANG_CLASSIFIEDS_2['your_ad']);
	
	//category
	$categories = '';
    $template->set_var('category_label', $LANG_CLASSIFIEDS_2['category']);
    $categories .= '<option value="0">' . $LANG_CLASSIFIEDS_2['choose_category'] . '</option>';

	$categories .= CLASSIFIEDS_adCategoryOptions($ad['catid']);
	$template->set_var('categories', $categories);
	
	//type
	$template->set_var('type_label', $LANG_CLASSIFIEDS_2['type']);
	
	if ($ad['type'] == '1') {
        $template->set_var('type_d', ' selected');
        $template->set_var('type_o', '');
	}
    elseif ($ad['type'] == '0'){
        $template->set_var('type_d', '');
        $template->set_var('type_o', ' selected');
	} else {
	    $template->set_var('type_d', '');
        $template->set_var('type_o', '');
	}
	
	$choosetype = '<option value="-1">' . $LANG_CLASSIFIEDS_2['choose_type'] . '</option>';
	$template->set_var('choose_type', $choosetype);
	$template->set_var('offer', $LANG_CLASSIFIEDS_2['offer']);
	$template->set_var('demand', $LANG_CLASSIFIEDS_2['demand']);

	//title
    $template->set_var('title_label', $LANG_CLASSIFIEDS_2['title']);
	$template->set_var('title', $ad['title']);
	$template->set_var('currency', $_CLASSIFIEDS_CONF['currency']);

    //text
    $template->set_var('text_label', $LANG_CLASSIFIEDS_2['text']);
	$template->set_var('text', $ad['text']);

	//Price
	$template->set_var('price_label', $LANG_CLASSIFIEDS_2['price']);
	$template->set_var('price', number_format(floatval($ad['price']), $_CONF['decimal_count']));
	
	//images
	$template->set_var('images', $LANG_CLASSIFIEDS_2['images']);
	$fileinputs = '';
    $saved_images = '';
    $icount = 0;
    if ($_CLASSIFIEDS_CONF['max_images_per_ad'] > 0) {
	    if ($ad['clid'] != '') {
            $icount = DB_count($_TABLES['cl_pic'],'pi_pid', $ad['clid']);
            if ($icount > 0) {
                $result_pics = DB_query(
                "SELECT pi_img_num, pi_filename FROM {$_TABLES['cl_pic']} "
                . "WHERE pi_pid = '" . (int) $ad['clid'] . "' ORDER BY pi_img_num"
            );
                for ($z = 1; $z <= $icount; $z++) {
                    $I = DB_fetchArray($result_pics);
                    $filename = rawurlencode(basename($I['pi_filename']));
                    $imageUrl = $_CLASSIFIEDS_CONF['url_images'] . $filename;
                    $saved_images .= '<div><p>' . $z . ') '
                        . '<a class="lightbox" href="' . $imageUrl . '">'
                        . '<img class="classifieds-gallery-thumb" loading="lazy" src="'
                        . $imageUrl . '" alt="'
                        . htmlspecialchars($ad['title'], ENT_QUOTES, $_CONF['default_charset'])
                        . '" /></a>'
                        . '&nbsp;&nbsp;&nbsp;' . $LANG_ADMIN['delete']
                        . ': <input type="checkbox" name="delete[' .$I['pi_img_num']
                        . ']"' . XHTML . '><br' . XHTML . '></p></div>';
                }
            }
		}

        $newallowed = $_CLASSIFIEDS_CONF['max_images_per_ad'] - $icount;
        for ($z = $icount + 1; $z <= $_CLASSIFIEDS_CONF['max_images_per_ad']; $z++) {
            $fileinputs .= $z . ') <input type="file" dir="ltr" name="file'
                        . $z . '"' . XHTML . '> ';
            if ($z < $_CLASSIFIEDS_CONF['max_images_per_ad']) {
                $fileinputs .= '<br' . XHTML . '>';
            }
        }
    }
    $template->set_var('saved_images', $saved_images);
    $template->set_var('image_form_elements', $fileinputs);
	
	//your details
	if (!is_numeric($ad['clid'])) {
	    $data = DB_query(
            "SELECT status, tel, postcode, city, siren "
            . "FROM {$_TABLES['cl_users']} "
            . "WHERE user_id = " . (int) $_USER['uid'] . " LIMIT 1"
        );
		$user_data = DB_fetchArray($data, true);
        if (is_array($user_data)) {
            foreach (array('status', 'tel', 'postcode', 'city', 'siren') as $field) {
                if (isset($user_data[$field])) {
                    $ad[$field] = $user_data[$field];
                }
            }
        }
	}
    $template->set_var('your_details', $LANG_CLASSIFIEDS_2['your_details']);

	$template->set_var('status_label', $LANG_CLASSIFIEDS_2['status']);
	$template->set_var('private', $LANG_CLASSIFIEDS_2['private']);
	$template->set_var('professional', $LANG_CLASSIFIEDS_2['professional']);
	if ($ad['status'] == '1') {
        $template->set_var('pro_yes', ' selected');
        $template->set_var('pro_no', '');
	}
    elseif ($ad['status'] == '0'){
        $template->set_var('pro_yes', '');
        $template->set_var('pro_no', ' selected');
    }
    else {
        $template->set_var('pro_no', '');
        $template->set_var('pro_yes', '');
	}
	$choose_status = '<option value="-1">' . $LANG_CLASSIFIEDS_2['choose_status'] . '</option>';
	$template->set_var('choose_status', $choose_status);

	$template->set_var('siren_label', $LANG_CLASSIFIEDS_2['siren']);
	$template->set_var('siren', $ad['siren']);

	$template->set_var('tel_label', $LANG_CLASSIFIEDS_2['tel']);
	$template->set_var('tel', $ad['tel']);

	$template->set_var('hide_tel_label', $LANG_CLASSIFIEDS_2['hide_tel']);
	$template->set_var('hide_tel', $ad['hide_tel']);
	if ($ad['hide_tel'] == '1') {
        $template->set_var('tel_ckecked', ' checked="checked"');
	}
    else {
        $template->set_var('tel_ckecked', '');
	}

	$template->set_var('postcode_label', $LANG_CLASSIFIEDS_2['postcode']);
	$template->set_var('postcode', $ad['postcode']);

    $template->set_var('city_label', $LANG_CLASSIFIEDS_2['city']);
	$template->set_var('city', $ad['city']);

	
	//submit
	$template->set_var('save_button', $LANG_CLASSIFIEDS_2['save_button']);
	$template->set_var('delete_button', $LANG_CLASSIFIEDS_2['delete_button']);
	$template->set_var('validate_button', $LANG_CLASSIFIEDS_2['validate_button']);
	$template->set_var('required_field', $LANG_CLASSIFIEDS_2['required_field']);
	
    if (SEC_hasRights('classifieds.admin') && $ad['clid'] !== '') {
        $dateCreated = COM_getUserDateTimeFormat($ad['created']);
        $dateModified = COM_getUserDateTimeFormat($ad['modified']);
        $template->set_var(
            'created',
            '<p>' . $LANG_CLASSIFIEDS_ADMIN['created']
            . $LANG_CLASSIFIEDS_1['double_point'] . ' ' . $dateCreated[0] . '</p>'
        );
        $template->set_var(
            'modified',
            '<p>' . $LANG_CLASSIFIEDS_ADMIN['modified']
            . $LANG_CLASSIFIEDS_1['double_point'] . ' ' . $dateModified[0] . '</p>'
        );
    } else {
        $template->set_var('created', '');
        $template->set_var('modified', '');
    }

		
    $retval .= $template->parse('output', 'ad');

    $retval .= COM_endBlock();
    return $retval;
}

function CLASSIFIEDS_missingFieldCat($field)
{
    global $LANG_CLASSIFIEDS_ADMIN, $_TABLES;

    $fields = array();
    $cid = isset($field['cid']) ? (int) $field['cid'] : 0;
    $pid = isset($field['pid']) ? (int) $field['pid'] : 0;

    if (empty($field['category'])) {
        $fields[] = $LANG_CLASSIFIEDS_ADMIN['category'];
    }

    if ($cid > 0 && $pid === $cid) {
        $fields[] = $LANG_CLASSIFIEDS_ADMIN['parent_category'];
        return array_values(array_unique($fields));
    }

    if ($pid !== 0) {
        $parentResult = DB_query(
            "SELECT pid, catdeleted FROM {$_TABLES['cl_cat']} "
            . "WHERE cid = " . $pid . " LIMIT 1"
        );
        $parent = DB_fetchArray($parentResult);

        if (!is_array($parent)
            || (int) $parent['pid'] !== 0
            || !empty($parent['catdeleted'])) {
            $fields[] = $LANG_CLASSIFIEDS_ADMIN['parent_category'];
        }
    }

    if ($cid > 0) {
        $childCount = DB_count($_TABLES['cl_cat'], 'pid', $cid);
        $adCount = DB_count($_TABLES['cl'], 'catid', $cid);

        // A parent with children must remain a root category.
        if ($childCount > 0 && $pid !== 0) {
            $fields[] = $LANG_CLASSIFIEDS_ADMIN['parent_category'];
        }

        // A category containing ads must remain a selectable child category.
        if ($adCount > 0 && $pid === 0) {
            $fields[] = $LANG_CLASSIFIEDS_ADMIN['parent_category'];
        }
    }

    return array_values(array_unique($fields));
}

/**
 * This function creates an cat Form
 *
 * Creates an Form for an cat using the supplied defaults (if specified).
 *
 * @param array $catid array of values describing an cat
 * @return string HTML string of cat form
 */
function CLASSIFIEDS_getCatForm($catid = array()) {

    global $_CONF, $_CLASSIFIEDS_CONF, $LANG_CLASSIFIEDS_2, $LANG_CLASSIFIEDS_ADMIN, $_TABLES, $LANG24, $LANG_ADMIN, $_USER;

    $defaults = array(
        'cid' => '',
        'pid' => 0,
        'category' => '',
        'catorder' => 0,
        'catdeleted' => 0,
        'position' => ''
    );
    $catid = is_array($catid) ? array_merge($defaults, $catid) : $defaults;
	
	//Display form
	($catid['cid'] == '') ? $retval = COM_startBlock($LANG_CLASSIFIEDS_ADMIN['insert_new_cat']) :
	$retval = COM_startBlock($LANG_CLASSIFIEDS_ADMIN['edit_label'] . ' ' . $catid['category']);

    $template = new Template($_CONF['path'] . 'plugins/classifieds/templates');
    $template->set_file(array('cat' => 'cat_form.thtml'));
    $template->set_var('site_admin_url', $_CONF['site_admin_url']);
	$template->set_var('xhtml', XHTML);
    $token = SEC_createToken();
    $template->set_var('gltoken_name', CSRF_TOKEN);
    $template->set_var('gltoken', $token);
	
	if (is_numeric($catid['cid'])) {
        $template->set_var('cid', '<input type="hidden" name="cid" value="' . $catid['cid'] .'" />');
    } else {
        $template->set_var('cid', '');
    }

	$template->set_var('cat_informations', $LANG_CLASSIFIEDS_ADMIN['cat_informations']);
	//parent category
	$categories = '';
    $template->set_var('parent_category_label', $LANG_CLASSIFIEDS_ADMIN['parent_category']);
    $categories .= '<option value="0">' . $LANG_CLASSIFIEDS_ADMIN['root'] . '</option>';

    if ($catid['cid']) {
        $categories .= CLASSIFIEDS_parentCategoryOptions($catid['pid'], $catid['cid']);
    } else {
        $categories .= CLASSIFIEDS_parentCategoryOptions($catid['pid']);
    }
	$template->set_var('categories', $categories);
	
	//category
    $template->set_var('category_label', $LANG_CLASSIFIEDS_ADMIN['category']);
	$template->set_var('category', $catid['category']);

    // Root categories keep a numeric order. Child categories use a semantic
    // first / after / last position so administrators never manipulate raw
    // catorder values for siblings.
    $template->set_var('catorder_label', $LANG_CLASSIFIEDS_ADMIN['catorder']);
    $template->set_var('catorder', (int) $catid['catorder']);
    $template->set_var('child_position_label', $LANG_CLASSIFIEDS_ADMIN['child_position']);

    $currentPid = (int) $catid['pid'];
    $currentCid = (int) $catid['cid'];
    $selectedPosition = (isset($catid['position'])
        && preg_match('/^(?:first|last|after:[0-9]+)$/', (string) $catid['position']))
        ? (string) $catid['position']
        : (($currentPid > 0 && $currentCid > 0)
            ? CLASSIFIEDS_childCategoryPosition($currentPid, $currentCid)
            : 'last');

    $template->set_var(
        'child_position_options',
        CLASSIFIEDS_childCategoryPositionOptions(
            $currentPid,
            $currentCid,
            $selectedPosition
        )
    );
    $template->set_var('root_order_hidden', $currentPid > 0 ? ' hidden="hidden"' : '');
    $template->set_var('child_position_hidden', $currentPid > 0 ? '' : ' hidden="hidden"');

	//active
	$template->set_var('catdeleted_label', $LANG_CLASSIFIEDS_ADMIN['catdeleted']);
	if ($catid['catdeleted'] == '1') {
        $template->set_var('select_disable', ' selected="selected"');
        $template->set_var('select_enable', '');
	} else{
        $template->set_var('select_disable', '');
        $template->set_var('select_enable', ' selected="selected"');
    }
	$template->set_var('enable', $LANG_CLASSIFIEDS_ADMIN['enable']);
	$template->set_var('disable', $LANG_CLASSIFIEDS_ADMIN['disable']);
	//submit
	$template->set_var('save_button', $LANG_CLASSIFIEDS_2['save_button']);
	$template->set_var('delete_button', $LANG_CLASSIFIEDS_2['delete_button']);
	$template->set_var('validate_button', $LANG_CLASSIFIEDS_2['validate_button']);
	$template->set_var('required_field', $LANG_CLASSIFIEDS_2['required_field']);
	
    $deleteAction = '';
    if ($catid['cid'] !== '') {
        $deleteAction = '<a href="' . $_CONF['site_admin_url']
            . '/plugins/classifieds/index.php?mode=cat&amp;op=delete&amp;cid='
            . (int) $catid['cid']
            . '&amp;' . CSRF_TOKEN . '=' . $token . '">'
            . $LANG_CLASSIFIEDS_2['delete_button'] . '</a>';
    }
    $template->set_var('delete_action', $deleteAction);

    $retval .= $template->parse('output', 'cat');

    $retval .= COM_endBlock();
    return $retval;
}


?>