<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Classifieds Plugin 1.4.0-dev                                                    |
// +---------------------------------------------------------------------------+
// | install_defaults.php                                                      |
// |                                                                           |
// | Initial Installation Defaults used when loading the online configuration  |
// | records. These settings are only used during the initial installation     |
// | and not referenced any more once the plugin is installed.                 |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2010 by the following authors:                              |
// |                                                                           |
// | Authors: Ben        - cordiste AT free DOT fr                             |
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
//

if (strpos(strtolower($_SERVER['PHP_SELF']), 'install_defaults.php') !== false) {
    die('This file can not be used on its own!');
}

/*
 * classifieds default settings
 *
 * Initial Installation Defaults used when loading the online configuration
 * records. These settings are only used during the initial installation
 * and not referenced any more once the plugin is installed
 *
 */
 
/**
*   Default values to be used during plugin installation/upgrade
*   @global array $_CLASSIFIEDS_DEFAULT
*/
global $_CONF, $_DB_table_prefix, $_CLASSIFIEDS_DEFAULT;
global $LANG_CLASSIFIEDS_1, $LANG_CLASSIFIEDS_2;
global $LANG_CLASSIFIEDS_ADMIN, $LANG_CLASSIFIEDS_EMAIL;

/**
 * Language file include
 *
 * This file can be included from Geeklog's plugin autoinstall functions.
 * Declare language arrays global so their values survive that function scope.
 */
$plugin_path = $_CONF['path'] . 'plugins/classifieds/';
$langfile = $plugin_path . 'language/' . $_CONF['language'] . '.php';

if (!isset($LANG_CLASSIFIEDS_1) || !is_array($LANG_CLASSIFIEDS_1)) {
    if (file_exists($langfile)) {
        require $langfile;
    } else {
        require $plugin_path . 'language/english.php';
    }
}

$_CLASSIFIEDS_DEFAULT = array();

/**
*   Main settings
*/
$_CLASSIFIEDS_DEFAULT['classifieds_folder']    = 'classifieds'; //Allow to move the directory where the users's classifieds program is store
$_CLASSIFIEDS_DEFAULT['active_days'] = 60;

 /**
 * Images settings
 */
$_CLASSIFIEDS_DEFAULT['max_image_width'] = 800;
$_CLASSIFIEDS_DEFAULT['max_image_height'] = 800;
$_CLASSIFIEDS_DEFAULT['max_image_size'] = 4194304; // size in bytes, 1048576 = 1MB
$_CLASSIFIEDS_DEFAULT['max_images_per_ad'] = 3;

 /**
 * Display settings
 */
$_CLASSIFIEDS_DEFAULT['menulabel']    = $LANG_CLASSIFIEDS_1['plugin_name'];
$_CLASSIFIEDS_DEFAULT['hide_classifieds_menu'] = 0;
$_CLASSIFIEDS_DEFAULT['classifieds_main_header'] = 'Customise this header in the config. Autotag welcome.';
$_CLASSIFIEDS_DEFAULT['classifieds_main_footer'] = 'Customise this footer in the config. Autotag welcome too.';
$_CLASSIFIEDS_DEFAULT['classifieds_edit_header'] = '';
$_CLASSIFIEDS_DEFAULT['help_page'] = $LANG_CLASSIFIEDS_1['under_construction']; // Static page ID
$_CLASSIFIEDS_DEFAULT['currency'] = '$';
$_CLASSIFIEDS_DEFAULT['maxPerPage'] = 50;

 /**
 * Email settings
 */
$_CLASSIFIEDS_DEFAULT['create_ad_email_user']        = true;
$_CLASSIFIEDS_DEFAULT['mod_ad_email_user']           = true;
$_CLASSIFIEDS_DEFAULT['delete_ad_email_user']        = true;
$_CLASSIFIEDS_DEFAULT['expire_ad_email_user']        = true;
$_CLASSIFIEDS_DEFAULT['create_ad_email_admin']        = true;
$_CLASSIFIEDS_DEFAULT['mod_ad_email_admin']           = true;
$_CLASSIFIEDS_DEFAULT['delete_ad_email_admin']        = true;
$_CLASSIFIEDS_DEFAULT['expire_ad_email_admin']        = true;

 /**
 * Permissions settings
 */
$_CLASSIFIEDS_DEFAULT['classifieds_login_required'] = 0;
$_CLASSIFIEDS_DEFAULT['default_permissions'] =  array (3, 3, 2, 2);

/**
* Initialize classifieds plugin configuration
*
* Creates the database entries for the configuation if they don't already
* exist. 
*
* @return   boolean     true: success; false: an error occurred
*
*/
function plugin_initconfig_classifieds()
{
    global $_CONF, $_CLASSIFIEDS_DEFAULT;
	
    $c = config::get_instance();
    if (!$c->group_exists('classifieds')) {

        // Main subgroup and explicit tab.
        $c->add('sg_main', NULL, 'subgroup', 0, 0, NULL, 0, true, 'classifieds', 0);
        $c->add('tab_main', NULL, 'tab', 0, 0, NULL, 0, true, 'classifieds', 0);

		//Main settings   
		$c->add('fs_main', NULL, 'fieldset', 0, 0, NULL, 0, true, 'classifieds', 0);
        $c->add('classifieds_folder', $_CLASSIFIEDS_DEFAULT['classifieds_folder'],
                'text', 0, 0, NULL, 10, true, 'classifieds', 0);
		$c->add('active_days', $_CLASSIFIEDS_DEFAULT['active_days'],
                'text', 0, 0, NULL, 20, true, 'classifieds', 0);

		//images
        $c->add('fs_images', NULL, 'fieldset', 0, 1, NULL, 0, true, 'classifieds', 0);
		$c->add('max_image_width', $_CLASSIFIEDS_DEFAULT['max_image_width'],
                'text', 0, 1, NULL, 101, true, 'classifieds', 0);
		$c->add('max_image_height', $_CLASSIFIEDS_DEFAULT['max_image_height'],
                'text', 0, 1, NULL, 102, true, 'classifieds', 0);
		$c->add('max_image_size', $_CLASSIFIEDS_DEFAULT['max_image_size'],
                'text', 0, 1, NULL, 103, true, 'classifieds', 0);
		$c->add('max_images_per_ad', $_CLASSIFIEDS_DEFAULT['max_images_per_ad'],
                'text', 0, 1, NULL, 107, true, 'classifieds', 0);
		
				
        //display
		$c->add('fs_display', NULL, 'fieldset', 0, 2, NULL, 0, true, 'classifieds', 0);
		$c->add('menulabel', $_CLASSIFIEDS_DEFAULT['menulabel'],
                'text', 0, 2, NULL, 201, true, 'classifieds', 0);
		$c->add('hide_classifieds_menu', $_CLASSIFIEDS_DEFAULT['hide_classifieds_menu'],
                'select', 0, 2, 3, 202, true, 'classifieds', 0);
		$c->add('classifieds_main_header', $_CLASSIFIEDS_DEFAULT['classifieds_main_header'],
                'text', 0, 2, NULL, 203, true, 'classifieds', 0);
		$c->add('classifieds_main_footer', $_CLASSIFIEDS_DEFAULT['classifieds_main_footer'],
                'text', 0, 2, NULL, 204, true, 'classifieds', 0);
		$c->add('classifieds_edit_header', $_CLASSIFIEDS_DEFAULT['classifieds_edit_header'],
                'text', 0, 2, NULL, 205, true, 'classifieds', 0);
		$c->add('help_page', $_CLASSIFIEDS_DEFAULT['help_page'],
                'text', 0, 2, NULL, 206, true, 'classifieds', 0);
		$c->add('currency', $_CLASSIFIEDS_DEFAULT['currency'],
                'text', 0, 2, NULL, 207, true, 'classifieds', 0);
		$c->add('maxPerPage', $_CLASSIFIEDS_DEFAULT['maxPerPage'],
                'text', 0, 2, NULL, 210, true, 'classifieds', 0);
		$c->add('allow_republish', 0,
                'select', 0, 2, 3, 220, true, 'classifieds', 0);
				
		//email
		$c->add('fs_email', NULL, 'fieldset', 0, 3, NULL, 0, true, 'classifieds', 0);
		$c->add('create_ad_email_user', $_CLASSIFIEDS_DEFAULT['create_ad_email_user'],
                'select', 0, 3, 3, 301, true, 'classifieds', 0);
		$c->add('mod_ad_email_user', $_CLASSIFIEDS_DEFAULT['mod_ad_email_user'],
                'select', 0, 3, 3, 302, true, 'classifieds', 0);
		$c->add('delete_ad_email_user', $_CLASSIFIEDS_DEFAULT['delete_ad_email_user'],
                'select', 0, 3, 3, 303, true, 'classifieds', 0);
		$c->add('expire_ad_email_user', $_CLASSIFIEDS_DEFAULT['expire_ad_email_user'],
                'select', 0, 3, 3, 304, true, 'classifieds', 0);

		$c->add('create_ad_email_admin', $_CLASSIFIEDS_DEFAULT['create_ad_email_admin'],
                'select', 0, 3, 3, 305, true, 'classifieds', 0);
		$c->add('mod_ad_email_admin', $_CLASSIFIEDS_DEFAULT['mod_ad_email_admin'],
                'select', 0, 3, 3, 306, true, 'classifieds', 0);
		$c->add('delete_ad_email_admin', $_CLASSIFIEDS_DEFAULT['delete_ad_email_admin'],
                'select', 0, 3, 3, 307, true, 'classifieds', 0);
		$c->add('expire_ad_email_admin', $_CLASSIFIEDS_DEFAULT['expire_ad_email_admin'],
                'select', 0, 3, 3, 308, true, 'classifieds', 0);
		
		//permissions
		$c->add('fs_permissions', NULL, 'fieldset', 0, 4, NULL, 0, true, 'classifieds', 0);
		$c->add('classifieds_login_required', $_CLASSIFIEDS_DEFAULT['classifieds_login_required'],
                'select', 0, 4, 3, 401, true, 'classifieds', 0);
		$c->add('default_permissions', $_CLASSIFIEDS_DEFAULT['default_permissions'],
                '@select', 0, 4, 12, 402, true, 'classifieds', 0);

    }				

    return true;
}

?>