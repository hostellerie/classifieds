<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Classifieds Plugin 1.4.0-dev                                                  |
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
function CLASSIFIEDS_getAdForm($ad = array(), $copy=false) {

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
	    return CLASSIFIEDS_loginRequiredForm();
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
    $template->set_var('gltoken_name', CSRF_TOKEN);
    $template->set_var('gltoken', SEC_createToken());
	
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

	$categories .= CLASSIFIEDS_adOptionList($_TABLES['cl_cat'], 'cid,category,pid', $ad['catid'], 'catorder', "catdeleted=0");
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
                $result_pics = DB_query("SELECT * FROM {$_TABLES['cl_pic']} WHERE pi_pid = '". $ad['clid'] ."'");
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
	    $data = DB_query("SELECT *
            FROM {$_TABLES['cl_users']} 
			WHERE user_id = {$_USER['uid']}
		");
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
	
	//Admin options
	if (SEC_hasRights('classifieds.admin')) {
        $admin_select = LB . '<select name="op">' . LB;
        if (!$copy) {
            $admin_select .= '<option value="save" selected="selected">' . $LANG_CLASSIFIEDS_2['save_button'] . '</option>' . LB;
            if ($ad['clid'] != '') $admin_select .= '<option value="delete">' . $LANG_CLASSIFIEDS_2['delete_button'] . '</option>'  . LB;
        }
        if (($ad['clid'] != '') && !empty($_CLASSIFIEDS_CONF['allow_republish'])) {
            $admin_select .= CLASSIFIEDS_getBonusAdminButton();
        }
        $admin_select .= LB . '</select>' . LB;
	    $template->set_var('admin_options', $admin_select);
		$datecreated = COM_getUserDateTimeFormat($ad['created']);
	    $datemodified = COM_getUserDateTimeFormat($ad['modified']);
		$template->set_var('created', '<p>' . $LANG_CLASSIFIEDS_ADMIN['created']  . $LANG_CLASSIFIEDS_1['double_point'] . ' ' . $datecreated[0] . '</p>');
	    $template->set_var('modified', '<p>' . $LANG_CLASSIFIEDS_ADMIN['modified']  . $LANG_CLASSIFIEDS_1['double_point'] . ' ' . $datemodified[0] . '</p>');
	} else {
	    $template->set_var('admin_options', '');
        $template->set_var('created', '');
	    $template->set_var('modified', '');
	}
		
    $retval .= $template->parse('output', 'ad');

    $retval .= COM_endBlock();
    return $retval;
}

function CLASSIFIEDS_saveImage($ad, $FILES, $clid)
{
    global $_CONF, $_CLASSIFIEDS_CONF, $_TABLES;

    $clid = (int) $clid;
    if ($clid <= 0) {
        return false;
    }

    $args = is_array($ad) ? $ad : array();
    $FILES = is_array($FILES) ? $FILES : array();

    $deleteNumbers = array();
    if (isset($args['delete']) && is_array($args['delete'])) {
        foreach (array_keys($args['delete']) as $imageNumber) {
            $imageNumber = (int) $imageNumber;
            if ($imageNumber > 0) {
                $deleteNumbers[$imageNumber] = $imageNumber;
            }
        }
    }

    $existingCount = (int) DB_count($_TABLES['cl_pic'], 'pi_pid', $clid);
    $remainingCount = max(0, $existingCount - count($deleteNumbers));
    $maxImages = max(0, (int) $_CLASSIFIEDS_CONF['max_images_per_ad']);
    $availableSlots = max(0, $maxImages - $remainingCount);

    $uploadFiles = array();
    foreach ($FILES as $key => $file) {
        if (!is_array($file) || empty($file['name'])) {
            continue;
        }
        $uploadFiles[$key] = $file;
        if (count($uploadFiles) >= $availableSlots) {
            break;
        }
    }

    $uploadedNames = array();
    $insertedNumbers = array();

    if (!empty($uploadFiles) && $availableSlots > 0) {
        require_once $_CONF['path_system'] . 'classes/upload.class.php';

        $upload = new upload();

        if (!empty($_CONF['debug_image_upload'])) {
            $upload->setLogFile($_CONF['path'] . 'logs/error.log');
            $upload->setDebug(true);
        }

        $upload->setMaxFileUploads($availableSlots);

        if (!empty($_CONF['image_lib'])) {
            if ($_CONF['image_lib'] === 'imagemagick') {
                $upload->setMogrifyPath($_CONF['path_to_mogrify']);
            } elseif ($_CONF['image_lib'] === 'netpbm') {
                $upload->setNetPBM($_CONF['path_to_netpbm']);
            } elseif ($_CONF['image_lib'] === 'gdlib') {
                $upload->setGDLib();
            }

            $upload->setAutomaticResize(true);
            $upload->keepOriginalImage(false);

            if (isset($_CONF['jpeg_quality'])) {
                $upload->setJpegQuality($_CONF['jpeg_quality']);
            }
        }

        $upload->setAllowedMimeTypes(array(
            'image/gif'   => '.gif',
            'image/jpeg'  => '.jpg,.jpeg',
            'image/pjpeg' => '.jpg,.jpeg',
            'image/x-png' => '.png',
            'image/png'   => '.png'
        ));

        if (!$upload->setPath($_CLASSIFIEDS_CONF['path_images'])) {
            COM_errorLog('Classifieds: image upload path is unavailable.');
            return false;
        }

        $upload->setMaxDimensions(
            (int) $_CLASSIFIEDS_CONF['max_image_width'],
            (int) $_CLASSIFIEDS_CONF['max_image_height']
        );
        $upload->setMaxFileSize((int) $_CLASSIFIEDS_CONF['max_image_size']);
        $upload->setPerms('0644');

        $nextNumber = (int) DB_getItem(
            $_TABLES['cl_pic'],
            'MAX(pi_img_num)',
            "pi_pid = '" . $clid . "'"
        ) + 1;

        $filenames = array();
        $imageNumbers = array();

        foreach ($uploadFiles as $file) {
            $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
            $extension = preg_replace('/[^a-z0-9]/', '', $extension);
            if ($extension === '') {
                $extension = 'jpg';
            }

            $filename = $clid . '_' . $nextNumber . '.' . $extension;
            $filenames[] = $filename;
            $imageNumbers[] = $nextNumber;
            $nextNumber++;
        }

        $upload->setFileNames($filenames);
        $upload->uploadFiles();

        if ($upload->areErrors()) {
            foreach ($filenames as $filename) {
                $path = $_CLASSIFIEDS_CONF['path_images'] . basename($filename);
                if (is_file($path)) {
                    @unlink($path);
                }
            }
            COM_errorLog('Classifieds: one or more ad images could not be uploaded.');
            return false;
        }

        foreach ($filenames as $index => $filename) {
            $imageNumber = (int) $imageNumbers[$index];
            DB_query(
                "INSERT INTO {$_TABLES['cl_pic']} "
                . "(pi_pid, pi_img_num, pi_filename) VALUES ('"
                . $clid . "', " . $imageNumber . ", '"
                . DB_escapeString($filename) . "')"
            );

            if (DB_error()) {
                foreach ($uploadedNames as $uploaded) {
                    $path = $_CLASSIFIEDS_CONF['path_images'] . basename($uploaded);
                    if (is_file($path)) {
                        @unlink($path);
                    }
                }
                $path = $_CLASSIFIEDS_CONF['path_images'] . basename($filename);
                if (is_file($path)) {
                    @unlink($path);
                }
                foreach ($insertedNumbers as $insertedNumber) {
                    DB_query(
                        "DELETE FROM {$_TABLES['cl_pic']} WHERE pi_pid = '"
                        . $clid . "' AND pi_img_num = " . (int) $insertedNumber
                    );
                }
                COM_errorLog('Classifieds: unable to persist uploaded image metadata.');
                return false;
            }

            $uploadedNames[] = $filename;
            $insertedNumbers[] = $imageNumber;
        }
    }

    // Delete old images only after all new uploads have succeeded.
    foreach ($deleteNumbers as $imageNumber) {
        $filename = DB_getItem(
            $_TABLES['cl_pic'],
            'pi_filename',
            "pi_pid = '" . $clid . "' AND pi_img_num = " . (int) $imageNumber
        );

        if ($filename !== '') {
            if (!CLASSIFIEDS_deleteImage($filename)) {
                COM_errorLog(
                    'Classifieds: unable to delete image ' . basename($filename)
                );
                return false;
            }
        }

        DB_query(
            "DELETE FROM {$_TABLES['cl_pic']} WHERE pi_pid = '"
            . $clid . "' AND pi_img_num = " . (int) $imageNumber
        );

        if (DB_error()) {
            return false;
        }
    }

    return true;
}

/**
* Delete one image from an ad
*
* @param    string  $image  file name of the image (without the path)
*
*/
function CLASSIFIEDS_deleteImage($image)
{
    global $_CLASSIFIEDS_CONF;

    if (empty($image)) {
        return true;
    }

    $path = $_CLASSIFIEDS_CONF['path_images'] . basename($image);
    if (!is_file($path)) {
        return true;
    }

    return @unlink($path);
}

function CLASSIFIEDS_checkCategory($cat)
{
    global $_TABLES;

    $cat = (int) $cat;
    if ($cat <= 0) {
        return false;
    }

    return DB_count($_TABLES['cl_cat'], 'cid', $cat) > 0;
}

function CLASSIFIEDS_missingFieldCat($field)
{
    global $LANG_CLASSIFIEDS_ADMIN, $_TABLES;

    $fields = array();

    if (empty($field['category'])) {
        $fields[] = $LANG_CLASSIFIEDS_ADMIN['category'];
    }

    $pid = isset($field['pid']) ? (int) $field['pid'] : 0;
    if ($pid !== 0 && DB_count($_TABLES['cl_cat'], 'cid', $pid) == 0) {
        $fields[] = $LANG_CLASSIFIEDS_ADMIN['pid'];
    }

    return $fields;
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
        'catdeleted' => 0
    );
    $catid = is_array($catid) ? array_merge($defaults, $catid) : $defaults;
	
	//Display form
	($catid['cid'] == '') ? $retval = COM_startBlock($LANG_CLASSIFIEDS_ADMIN['insert_new_cat']) :
	$retval = COM_startBlock($LANG_CLASSIFIEDS_ADMIN['edit_label'] . ' ' . $catid['category']);

    $template = new Template($_CONF['path'] . 'plugins/classifieds/templates');
    $template->set_file(array('cat' => 'cat_form.thtml'));
    $template->set_var('site_admin_url', $_CONF['site_admin_url']);
	$template->set_var('xhtml', XHTML);
    $template->set_var('gltoken_name', CSRF_TOKEN);
    $template->set_var('gltoken', SEC_createToken());
	
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
        $categories .= CLASSIFIEDS_catOptionList($_TABLES['cl_cat'], 'cid,category,pid', $catid['pid'], 'catorder', "cid <> {$catid['cid']}" );
    } else {
        $categories .= CLASSIFIEDS_catOptionList($_TABLES['cl_cat'], 'cid,category,pid', $catid['pid'], 'catorder');
    }
	$template->set_var('categories', $categories);
	
	//category
    $template->set_var('category_label', $LANG_CLASSIFIEDS_ADMIN['category']);
	$template->set_var('category', $catid['category']);

    //catorder
    $template->set_var('catorder_label', $LANG_CLASSIFIEDS_ADMIN['catorder']);
	$template->set_var('catorder', $catid['catorder']);
	
	$res = DB_query("SELECT catorder, category, pid 
	                 FROM {$_TABLES['cl_cat']}
					 WHERE 1 = 1 
					 ORDER by catorder
					 ");
	$categories_order = '<blockquote>';

	while ($A = DB_fetchArray($res)) {
	    if ($A['pid'] == 0) {
	         $categories_order .= '<p><strong>' . $A['catorder'] .  '. ' . $A['category'] . '</strong></p>';
	    } else {
	        $categories_order .=  '&nbsp;&nbsp;  ' . $A['catorder'] .  '. ' . $A['category'];
	    }
	}
	$categories_order .= '<br' . XHTML . '>&nbsp;</blockquote>';
	$template->set_var('categories_order', $categories_order);

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
	
	//Admin options
	$options = '<select name="op"><option value="save" selected="selected">' . $LANG_CLASSIFIEDS_2['save_button'] . '</option>';
    if ($catid['cid'] != '') $options .= '<option value="delete">' . $LANG_CLASSIFIEDS_2['delete_button'] . '</option></select>';
	$template->set_var('admin_options', $options);
	
    $retval .= $template->parse('output', 'cat');

    $retval .= COM_endBlock();
    return $retval;
}

/**
* Re-orders all categories in increments of 10
*
*/
function reorderCategories()
{
    global $_TABLES;

    $sql = "SELECT * FROM {$_TABLES['cl_cat']} ORDER BY catorder ASC;";
    $result = DB_query($sql);
    $nrows = DB_numRows($result);


    $catOrd = 10;
    $stepNumber = 10;

    for ($i = 0; $i < $nrows; $i++) {
        $A = DB_fetchArray($result);

        if ($A['catorder'] != $catOrd) {  // only update incorrect ones
            $q = "UPDATE " . $_TABLES['cl_cat'] . " SET catorder = '" .
                  $catOrd . "' WHERE cid = '" . $A['cid'] ."'";
            DB_query($q);
        }
        $catOrd += $stepNumber;
    }
}
?>