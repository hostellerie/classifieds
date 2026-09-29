<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Classifieds Plugin 1.4.0-dev                                                  |
// +---------------------------------------------------------------------------+
// | index.php                                                                 |
// |                                                                           |
// | Public plugin page                                                        |
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

require_once '../lib-common.php';
require_once ($_CONF['path_system']  . 'lib-security.php');

// take user back to the homepage if the plugin is not active
if (!in_array('classifieds', $_PLUGINS)) {
    echo COM_refresh($_CONF['site_url'] . '/index.php');
    exit;
}

$vars = array(
    'mode'        => 'alpha',
    'page'        => 'number',
    'catid'       => 'number',
    'ad'          => 'number',
    'op'          => 'alpha',
    'clid'        => 'number',
    'msg'         => 'text',
    'type'        => 'number',
    'title'       => 'text',
    'text'        => 'text',
    'price'       => 'text',
    'tel'         => 'text',
    'hide_tel'    => 'number',
    'status'      => 'number',
    'siren'       => 'text',
    'author'      => 'text',
    'authoremail' => 'text',
    'message'     => 'text',
    'cc'          => 'number',
    'postcode'    => 'text',
    'city'        => 'text',
    'u'           => 'number'
);
			  
CLASSIFIEDS_filterVars($vars, $_REQUEST);

$display = '';

// MAIN

(isset($_REQUEST['catid'] )) ? SEC_setCookie('ads_cat', $_REQUEST['catid']) : 0;

switch ($_REQUEST['mode']) {

	//Edit
	case 'e':
	    /*
		* Include specific classifieds config file
		*/
		require_once ($_CONF['path'] . 'plugins/classifieds/lib-edit.php');
		
		$display = COM_siteHeader('menu', $LANG_CLASSIFIEDS_1['plugin_name']);
		$display .= CLASSIFIEDS_user_menu();

        switch ($_REQUEST['op']) {
            case 'del':
                if (!SEC_checkToken()) {
                    echo COM_refresh($_CLASSIFIEDS_CONF['site_url'] . '/index.php');
                    exit;
                }

                $adId = (int) $_REQUEST['ad'];
                $deleted = CLASSIFIEDS_deleteAd($adId, false);
                $msg = $deleted
                    ? $LANG_CLASSIFIEDS_2['deletion_succes']
                    : $LANG_CLASSIFIEDS_2['deletion_fail'];

                echo COM_refresh(
                    $_CLASSIFIEDS_CONF['site_url']
                    . '/index.php?mode=my&amp;msg=' . urlencode($msg)
                );
                exit;

            case 'delete':
                if (!SEC_checkToken() || !SEC_hasRights('classifieds.admin')) {
                    echo COM_refresh($_CONF['site_admin_url'] . '/plugins/classifieds/index.php');
                    exit;
                }

                $adId = (int) $_REQUEST['clid'];
                $deleted = CLASSIFIEDS_deleteAd($adId, true);
                $msg = $deleted
                    ? $LANG_CLASSIFIEDS_2['deletion_succes']
                    : $LANG_CLASSIFIEDS_2['deletion_fail'];

                echo COM_refresh(
                    $_CONF['site_admin_url']
                    . '/plugins/classifieds/index.php?msg=' . urlencode($msg)
                );
                exit;

            case 'save':
                $saveResult = CLASSIFIEDS_saveAd($_REQUEST, $_FILES);

                if (!$saveResult['ok']) {
                    if (!empty($saveResult['errors'])) {
                        $display .= COM_startBlock($LANG_CLASSIFIEDS_2['error']);
                        $display .= $LANG_CLASSIFIEDS_2['missing_field'];
                        $display .= '<ul>';
                        foreach ($saveResult['errors'] as $error) {
                            $display .= '<li>' . $error . '</li>';
                        }
                        $display .= '</ul>';
                        $display .= $LANG_CLASSIFIEDS_2['check_it'];
                        $display .= COM_endBlock();
                    } else {
                        $display .= COM_showMessageText(
                            $LANG_CLASSIFIEDS_2['save_fail'],
                            $LANG_CLASSIFIEDS_2['error']
                        );
                    }

                    $display .= CLASSIFIEDS_getAdForm($_REQUEST);
                    break;
                }

                echo COM_refresh(
                    $_CLASSIFIEDS_CONF['site_url']
                    . '/index.php?msg=' . urlencode($saveResult['message'])
                    . '&amp;mode=v&amp;ad=' . (int) $saveResult['id']
                );
                exit;

            case 'edit':
                $adId = (int) $_REQUEST['ad'];
                if ($adId <= 0 || !CLASSIFIEDS_checkAdAccess($adId)) {
                    echo COM_refresh($_CLASSIFIEDS_CONF['site_url'] . '/index.php');
                    exit;
                }

                $res = DB_query(
                    "SELECT clid, catid, status, type, tel, hide_tel, title, text, price, "
                    . "postcode, city, siren, enable, created, modified, notification, deleted, "
                    . "hits, modif, owner_id, group_id, perm_owner, perm_group, perm_members, perm_anon "
                    . "FROM {$_TABLES['cl']} WHERE clid = " . $adId . " LIMIT 1"
                );
                $A = DB_fetchArray($res);
                if (!is_array($A)
                    || (!SEC_hasRights('classifieds.admin') && SEC_hasAccess2($A) < 3)) {
                    echo COM_refresh($_CLASSIFIEDS_CONF['site_url'] . '/index.php');
                    exit;
                }

                $display .= CLASSIFIEDS_getAdForm($A);
                break;

            case 'repost':
                if (!SEC_checkToken()) {
                    echo COM_refresh($_CLASSIFIEDS_CONF['site_url']);
                    exit;
                }

                $repost = CLASSIFIEDS_repost((int) $_REQUEST['ad']);
                if (!empty($repost['ok'])) {
                    echo COM_refresh(
                        $_CLASSIFIEDS_CONF['site_url']
                        . '/index.php?mode=v&ad=' . (int) $repost['new_id']
                    );
                } else {
                    echo COM_refresh(
                        $_CLASSIFIEDS_CONF['site_url']
                        . '/index.php?mode=v&ad=' . (int) $_REQUEST['ad']
                    );
                }
                exit;

            case 'new':
            default:
                $display .= CLASSIFIEDS_getAdForm();
                break;

        }
		$display .= COM_siteFooter(1);
		break;
	//My ads
	case 'my':
	    $display = COM_siteHeader('menu', $LANG_CLASSIFIEDS_1['my_ads'] . ' - '. $LANG_CLASSIFIEDS_1['plugin_name']);
		$display .= CLASSIFIEDS_user_menu();
		if (COM_isAnonUser()) {
            $uid = 1;
        } else {
            $uid = $_USER['uid'];
        }
		// If any message
        $display .= CLASSIFIEDS_message($_REQUEST['msg']);
		$display .= CLASSIFIEDS_displayAds($uid,1);
	    $display .= COM_siteFooter(1);
		break;
	//Help
	case 'h':
	    $display = COM_siteHeader('menu', $LANG_CLASSIFIEDS_1['plugin_name']);
		$display .= CLASSIFIEDS_user_menu();
		$display .= PLG_replaceTags($_CLASSIFIEDS_CONF['help_page']);
	    $display .= COM_siteFooter(1);
		break;
	//View ad
	case 'v':
	    $display .= CLASSIFIEDS_viewAd($_REQUEST['ad']);
		break;
	//see all
	case 'va':
        $profileUid = (int) $_REQUEST['u'];
	    $user = DB_getItem($_TABLES['users'], 'username', 'uid=' . $profileUid);
	    $display = COM_siteHeader('menu', $LANG_CLASSIFIEDS_1['all_ads_from'] . ' ' . $user);
		$display .= CLASSIFIEDS_user_menu();
	    $display .= CLASSIFIEDS_displayAds($profileUid, 0, $user);
		$display .= COM_siteFooter(1);
	    break;
    // Contact advertiser
    case 'c':
        $ad = (int) $_REQUEST['ad'];
        $display = COM_siteHeader('menu', $LANG_CLASSIFIEDS_1['contact_advertiser']);

        if (!CLASSIFIEDS_checkAdAccess($ad)) {
            echo COM_refresh($_CLASSIFIEDS_CONF['site_url'] . '/index.php');
            exit;
        }

        if ($_REQUEST['op'] === 'send') {
            $sent = CLASSIFIEDS_sendContact(
                $ad,
                $_REQUEST['author'],
                $_REQUEST['authoremail'],
                $_REQUEST['message'],
                'contact',
                !empty($_REQUEST['cc'])
            );

            if ($sent) {
                echo COM_refresh(
                    $_CLASSIFIEDS_CONF['site_url'] . '/index.php?mode=v&ad=' . $ad
                );
                exit;
            }

            $display .= COM_showMessageText(
                $LANG_CLASSIFIEDS_2['save_fail'],
                $LANG_CLASSIFIEDS_2['error']
            );
        }

        $display .= CLASSIFIEDS_contactForm(
            $ad,
            'contact',
            $_REQUEST['message']
        );
        $display .= COM_siteFooter(1);
        break;

    // Report ad / abuse
    case 'r':
        $ad = (int) $_REQUEST['ad'];
        $display = COM_siteHeader('menu', $LANG_CLASSIFIEDS_1['report']);

        if (!CLASSIFIEDS_checkAdAccess($ad)) {
            echo COM_refresh($_CLASSIFIEDS_CONF['site_url'] . '/index.php');
            exit;
        }

        if ($_REQUEST['op'] === 'send') {
            $sent = CLASSIFIEDS_sendContact(
                $ad,
                $_REQUEST['author'],
                $_REQUEST['authoremail'],
                $_REQUEST['message'],
                'report',
                !empty($_REQUEST['cc'])
            );

            if ($sent) {
                echo COM_refresh(
                    $_CLASSIFIEDS_CONF['site_url'] . '/index.php?mode=v&ad=' . $ad
                );
                exit;
            }

            $display .= COM_showMessageText(
                $LANG_CLASSIFIEDS_2['save_fail'],
                $LANG_CLASSIFIEDS_2['error']
            );
        }

        $display .= CLASSIFIEDS_contactForm(
            $ad,
            'report',
            $_REQUEST['message']
        );
        $display .= COM_siteFooter(1);
        break;

	//profile
	case 'p' :
	    require_once ($_CONF['path_system']  . 'lib-user.php');
	    $display = COM_siteHeader('menu', $LANG_CLASSIFIEDS_1['profile']);
		$display .= CLASSIFIEDS_user_menu();
		$profileUid = (int) $_REQUEST['u'];
        $display .= USER_showProfile($profileUid, true);
		$display .= COM_siteFooter(1);
		break;
	//Offert
	case 'o':
	//Demand
	case 'd':	
	//Ads list
	default :
	    $display = COM_siteHeader('menu', $LANG_CLASSIFIEDS_1['plugin_name']);
		$display .= CLASSIFIEDS_user_menu();
        if (!empty($_CLASSIFIEDS_CONF['classifieds_main_header'])) {
            $display .= '<div>'
                . PLG_replaceTags($_CLASSIFIEDS_CONF['classifieds_main_header'])
                . '</div>';
        }

        $display .= CLASSIFIEDS_displayAds(1);

        if (!empty($_CLASSIFIEDS_CONF['classifieds_main_footer'])) {
            $display .= '<div>'
                . PLG_replaceTags($_CLASSIFIEDS_CONF['classifieds_main_footer'])
                . '</div>';
        }
        $display .= COM_siteFooter(1);
}

COM_output($display);

?>