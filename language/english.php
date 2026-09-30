<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Classifieds Plugin 1.4.0                                                  |
// +---------------------------------------------------------------------------+
// | english.php                                                               |
// |                                                                           |
// | English language file                                                     |
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

/**
* Import Geeklog plugin messages for reuse
*
* @global array $LANG32
*/
global $LANG32;

// +---------------------------------------------------------------------------+
// | Array Format:                                                             |
// | $LANGXX[YY]:  $LANG - variable name                                       |
// |               XX    - specific array name                                 |
// |               YY    - phrase id or number                                 |
// +---------------------------------------------------------------------------+

//Ad list, ad detail
$LANG_CLASSIFIEDS_1 = array(
    'plugin_name'             => 'Classifieds',
    'home'                    => 'Home',
	'place_an_ad'             => 'Place an ad',
	'offer'                   => 'Offer',
	'demand'                  => 'Demand',
	'offers'                  => 'Offers',
	'demands'                 => 'Demands',
	'offers_demands'          => 'Offers and demands',
	'my_ads'                  => 'My ads',
	'user_ads'                => 'User ads',
	'help'                    => 'Help',
	'admin'                   => 'Admin',
	'access_reserved'         => 'Access reserved',
    'you_must_sign_in'        => 'You must sign in to access this ad.',
	'posted_by'               => 'Posted by',
	'on'                      => 'on',
	'at'                      => 'at',
	'contact_advertiser'      => 'Contact advertiser',
	'send_email'              => 'Send an email',
	'double_point'            => ':',
	'manage_ad'               => 'Manage Ad',
	'modify_ad'               => 'Modify Ad',
	'delete_ad'               => 'Delete Ad',
	'price'                   => 'Price',
	'category'                => 'Category',
	'postcode'                => 'Postal code',
	'enlarge_picture'         => 'Enlarge picture',
	'hits'                    => 'visits',
	'no_ad'                   => 'No result',
	'no_ad_message'           => 'Sorry but no ad was found. To post one you can press the "Place an Ad" button.',
	'report'                  => 'Report Ad or signale abuse',
	'deleted'                 => 'DELETED',
	'view_all'                => 'View all Ads from this advertiser',
	'all_ads_from'            => 'All Ads posted by',
	'search_button'           => 'Search',
	'choose_category'         => '-- Select a category --',
	'all_categories'          => 'All categories',
	'profile'                 => 'Profile user',
	'classifieds_list'        => 'Ads',
	'categories_list'         => 'Categories',
	'view_all_ads'            => 'View all ads',
	'under_construction'      => 'Under construction',
    'image_not_writable'      => 'The classifieds images folder does not exists or is not writable. You must check this issue before using the classifieds plugin.<br' . XHTML . '><br' . XHTML . '>Please create a classifieds sub folder within the images folder.',
	'ad-list-active'          => 'Active ad',
	'ad-list-delete'          => 'Deleted ad',
	'ad-list-old'             => 'Old ad',
	'label-hits'              => 'Hits',
	'deleted_ad'              => 'Sorry, this ad is no more available',
	'last_ads'                => 'Last ads on the site',
	'ads_not_available'       => 'This ads is not available',
	'all_ads'                 => 'All ads',
    'profile_no_ad'           => 'No active ads',
);

//Ad form create, edit ,delete
$LANG_CLASSIFIEDS_2 = array(
    'deletion_succes'         => 'The deletion of the ad was successful.',
    'deletion_fail'           => 'Oups! The deletion of the ad failed.',
	'error'                   => 'Oups there is an error!',
	'missing_field'           => 'Some required fields are missing:',
    'check_it'                => 'Please can you check it before submitting your ad.',
	'save_fail'               => 'Oups! Save failed.',
	'save_success'            => 'Your ad has been saved successfully.',
	'message'                 => 'Message from the system',
	'insert_new_ad'           => 'Insert a new Ad',
	'edit_label'              => 'Editing Ad:',
	'your_ad'                 => 'Your Ad',
	'category'                => 'Category',
	'title'                   => 'Ad title',
	'type'                    => 'Type',
	'offer'                   => 'Offer',
	'demand'                  => 'Demand',
	'choose_category'         => '-- Choose a category --',
	'choose_type'             => '-- Choose ad type --',
	'text'                    => 'Ad text',
	'price'                   => 'Price',
	'images'                  => 'Your pictures',
	'your_details'            => 'Your details',
	'status'                     => 'Status',
	'choose_status'           => '-- Choose your status --',
	'private'                 => 'Private',
	'professional'            => 'Professional',
	'siren'                   => 'Pro ID',
	'tel'                     => 'Tel',
	'hide_tel'                 => 'Hide my telephone in the ad',
	'postcode'                => 'Postal code',
	'city'                    => 'City',
	'save_button'             => 'Save',
	'delete_button'           => 'Delete',
	'required_field'          => 'Indicates required field',
	'validate_button'         => 'Validate',
    'copy_button'             => 'Republish this ad',
	'access_reserved'         => 'Access reserved. To access this feature you must belong to group:',
);

$LANG_CLASSIFIEDS_ADMIN = array(
    'administration'          => 'Classifieds administration',
    'configuration'           => 'Configuration',
    'category_in_use'         => 'This category cannot be deleted while it still contains ads or child categories.',
    'dashboard_active'         => 'Active ads',
    'dashboard_expired'        => 'Expired ads',
    'dashboard_deleted'        => 'Deleted ads',
    'dashboard_categories'     => 'Active categories',
    'dashboard_manage'         => 'Manage Classifieds',
    'dashboard_storage_warning'=> 'The Classifieds image directory is missing or not writable.',
    'clid'                    => 'Ad ID',
	'title'                   => 'Ad title',
	'owner_id'                => 'Owner ID',
	'created'                 => 'Created',
	'cid'                     => 'Cat. ID',
	'pid'                     => 'Parent cat.',
	'category'                => 'Category',
	'catorder'                => 'Order',
	'catdeleted'              => 'Status',
	'root'                    => 'Root category',
	'deletion_succes'         => 'The deletion was successful.',
    'deletion_fail'           => 'Oups! The deletion failed.',
	'cat_informations'        => 'Category informations',
	'parent_category'         => 'Parent category',
	'enable'                  => 'Enable',
	'disable'                 => 'Disable',
	'edit_label'              => 'Editing',
	'create_new_cat'          => 'Create a new category',
    'modified'                => 'Modified',
	'online'                  => 'online',
	'plugin_conf'             => 'The classifieds plugin configuration is also',
	'plugin_doc'              => 'Install, upgrade and usage documentation for classifieds plugin are',
	'no_group_access'         => 'Warning: No group has the right to publish ads. To allow all users to publish ads, create a new group in the admin area. For this new group check "Default group", check Apply "Default Group" change to existing user accounts to make this a default group for new users, and check classifieds.publish rights.', 
	'group_access'            => 'group has right to publish ads:', 
	'groups_access'           => 'groups have right to publish ads:', 
	
);

$LANG_CLASSIFIEDS_EMAIL = array(
    'hello'                   => 'Hello',
    'new_ad'                  => 'Your new ad has been posted on',
	'edit_ad'                 => 'Your ad has been edited on',
	'delete_ad'               => 'Your ad has been deleted on',
	'expire_ad'               => 'Your ad has expired on',
	'online_for'              => 'and it will be online for',
	'days'                    => 'days.',
	'post_new'                => 'You can post a new one on',
	'you_can_see'             => 'You can see it on',
	'thanks'                  => 'Thanks,',
	'sign'                    => 'The admin',
	'no_reply'                => 'PS: This is an automated mail, thank you not to respond.',
	'your_ad'                 => 'Your ad:',
	'price'                   => 'Price:',
);


// Messages for the plugin upgrade
$PLG_classifieds_MESSAGE3002 = $LANG32[9]; // "requires a newer version of Geeklog"
$PLG_classifieds_MESSAGE1    = 'Hello world :)';

/**
*   Localization of the Admin Configuration UI
*   @global array $LANG_configsections['classifieds']
*/
$LANG_configsections['classifieds'] = array(
    'label' => 'Classifieds',
    'title' => 'Classifieds Configuration'
);

/**
*   Configuration system subgroup strings
*   @global array $LANG_configsubgroups['classifieds']
*/
$LANG_configsubgroups['classifieds'] = array(
    'sg_main' => 'Main Settings'
);

$LANG_tab['classifieds'] = array(
    'tab_main' => 'Classifieds'
);

/**
*   Configuration system fieldset names
*   @global array $LANG_fs['classifieds']
*/
$LANG_fs['classifieds'] = array(
    'fs_main'            => 'General Settings',
    'fs_images'          => 'Images settings',
	'fs_display'         => 'Display settings',
	'fs_email'           => 'Email settings',
    'fs_permissions'     => 'Default Permissions'
 );
 
/**
*   Configuration system prompt strings
*   @global array $LANG_confignames['classifieds']
*/
$LANG_confignames['classifieds'] = array(
    //Main settings	'active_days'  => 'Active days',
    
	//Images settings
    'max_image_width'  => 'Max image width',
	'max_image_height'  => 'Max image height',
    'max_image_size'  => 'Max image size',
    'max_images_per_ad'  => 'Max images per ad',

     //Display settings
    'menulabel'  => 'Menulabel',
    'hide_classifieds_menu'  => 'Hide classifieds menu',
    'classifieds_main_header'  => 'Main header',
    'classifieds_main_footer'  => 'Main footer',
    'classifieds_edit_header'  => 'Editor header',
    'help_page'  => 'Help page',
    'currency'  => 'Currency',
    'maxPerPage'  => 'Max per page',
	'allow_republish' => 'Allow republishing ad',

    // Email settings
    'create_ad_email_user'  => 'Email user on ad creation',
    'mod_ad_email_user'  => 'Email user on ad modification',
    'delete_ad_email_user'  => 'Email user on ad delete',
    'expire_ad_email_user'  => 'Email user on ad expire',
	'create_ad_email_admin'  => 'Email admin on ad creation',
    'mod_ad_email_admin'  => 'Email admin on ad modification',
    'delete_ad_email_admin'  => 'Email admin on ad delete',
    'expire_ad_email_admin'  => 'Email admin on ad expire',

    //Permissions settings
    'classifieds_login_required'  => 'Login required to access classifieds',
    'default_permissions'  => 'Default permissions'
);

/**
*   Configuration system selection strings
*   Note: entries 0, 1, and 12 are the same as in 
*   $LANG_configselects['Core']
*
*   @global array $LANG_configselects['classifieds']
*/
$LANG_configselects['classifieds'] = array(
    3 => array('Yes' => 1, 'No' => 0),
    12 => array('No access' => 0, 'Read-Only' => 2, 'Read-Write' => 3)
);

$LANG_configtooltips['classifieds'] = array(    'active_days' => 'Number of days an ad remains active before it becomes eligible for expiration notification and republishing.',
    'max_image_size' => 'Maximum upload size in bytes for one ad image.',
    'max_images_per_ad' => 'Maximum number of images that can be attached to one ad.',
    'allow_republish' => 'Allows eligible expired ads to be copied into a new active ad while preserving the historical original.',
    'classifieds_login_required' => 'When enabled, visitors must sign in before accessing Classifieds.',
    'default_permissions' => 'Geeklog ACL permissions applied to newly created Classifieds content.'
);
?>
