<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Classifieds Plugin 1.3.0                                                  |
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

$vars = array('mode'     => 'alpha',
              'page'     => 'number',
              'catid'    => 'alpha',
			  'ad'       => 'number',
			  'op'       => 'alpha',
			  'clid'     => 'number',
			  'catid'    => 'alpha',
			  'msg'      => 'text',
			  'pro'      => 'number',
			  'type'     => 'number',
			  'title'    => 'text',
			  'text'     => 'text',
			  'price'    => 'text',
			  'tel'      => 'alpha',
			  'hide_tel' => 'number',
              'status'   => 'number',
              'siren'    => 'text',
              'deleted'  => 'number',
              'subject'  => 'text',
			  'postcode' => 'alpha',
			  'city'     => 'text',
			  'uid'      => 'number',
			  'u'        => 'number'
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
			    if (is_numeric($_REQUEST['ad'])) {
				    if (CLASSIFIEDS_checkAdAccess($_REQUEST['ad']) == false ) {
                        echo COM_refresh ($_CLASSIFIEDS_CONF['site_url'] . '/index.php');
						exit();
					    break;
                    }
                    $sql = "SELECT * FROM {$_TABLES['cl']} WHERE clid = {$_REQUEST['ad']}";
                    $res = DB_query($sql);
                    $A = DB_fetchArray($res);
					if (SEC_hasAccess2($A) < 3) {
	                    echo COM_refresh($_CLASSIFIEDS_CONF['site_url'] . "/index.php");
		                exit();
					    break;
					}
					
					DB_change($_TABLES['cl'],'deleted',1,'clid',$_REQUEST['ad']);
					
					if (DB_error()) {
                        $msg = $LANG_CLASSIFIEDS_2['save_fail'];
                    } else {
                        $msg = $LANG_CLASSIFIEDS_2['deletion_succes'];
						CLASSIFIEDS_emailDeleteAd($A['title'], '', (int) $_REQUEST['ad'], $_USER['uid'], $A['price']);
                    }
					echo COM_refresh($_CLASSIFIEDS_CONF['site_url'] . "/index.php?mode=my&amp;msg=$msg");
					exit();
				}
			    break;
			case 'delete':
			    if (SEC_hasRights('classifieds.admin')) {
    	            DB_delete($_TABLES['cl'], 'clid', $_REQUEST['clid']);
                    if (DB_affectedRows('') == 1) {
                        $msg = $LANG_CLASSIFIEDS_2['deletion_succes'];
                    } else {
                        $msg = $LANG_CLASSIFIEDS_2['deletion_fail'];
                    }
		            // delete complete, return to ad list
                    echo COM_refresh($_CONF['site_url'] . "/admin/plugins/classifieds/index.php?msg=$msg");
				}
                exit();
                break;
        
            case 'save':
                if (!SEC_checkToken()) {
                    $display .= COM_showMessageText($LANG_CLASSIFIEDS_2['save_fail'], $LANG_CLASSIFIEDS_2['error']);
                    break;
                }
			    $missingfields = CLASSIFIEDS_missingField($_REQUEST);
                if ($missingfields != '') {
                    $display .= COM_startBlock($LANG_CLASSIFIEDS_2['error']);
                    $display .= $LANG_CLASSIFIEDS_2['missing_field'];
					$display .= '<ul>';
					foreach ($missingfields as $i => $value) {
                        $display .= '<li>' . ($missingfields[$i]);
                    }
					$display .= '</ul>';
					$display .= $LANG_CLASSIFIEDS_2['check_it'];
                    $display .= COM_endBlock();
                    $display .= CLASSIFIEDS_getAdForm($_REQUEST);
                    break;
                }
				//test token
                //if(!SEC_checkToken()) break;
                
				// prepare strings for insertion
                $title = addslashes(COM_getTextContent($_REQUEST['title']));
                $text = addslashes(CLASSIFIEDS_getTextContent($_REQUEST['text']));
				$city = addslashes(COM_getTextContent($_REQUEST['city']));
				$remove_from_tel = array(' ', '.', '|', ',', '/', ':', '-', '_');
                $clean_tel = str_replace($remove_from_tel, '', $_REQUEST['tel']);
				($_REQUEST['hide_tel'] == '1') ? $hide_tel = '1' : $hide_tel = '0';
                ($_REQUEST['status'] == '1') ? $status = '1' : $status = '0';
				$created = date("YmdHis");
				$modified = date("YmdHis");

                // price can only contain numbers and a decimal
                $price = str_replace(",","",$_REQUEST['price']);
                $price = preg_replace('/[^\d.]/', '', $price);

                if (!empty($_REQUEST['clid'])) {
				    //Edit mode 
					if (is_numeric($_REQUEST['clid'])) {
                        $sql = "SELECT * FROM {$_TABLES['cl']} WHERE clid = {$_REQUEST['clid']}";
                        $res = DB_query($sql);
                        $A = DB_fetchArray($res);
					    if (SEC_hasAccess2($A) < 3) {
	                        echo COM_refresh($_CLASSIFIEDS_CONF['site_url'] . "/index.php");
		                    exit();
							break;
						}
					} else {
					    echo COM_refresh($_CLASSIFIEDS_CONF['site_url'] . "/index.php");
						exit();
						break;
	                }
					
				    $sql = "catid = '{$catid}', "
                     . "status = '{$status}', "
                     . "type = '{$type}', "
                     . "tel = '{$clean_tel}', "
                     . "hide_tel = '{$hide_tel}', "
			         . "title = '{$title}', "
			         . "text = '{$text}', "
			         . "price = '{$price}', "
					 . "postcode = '{$postcode}', "
					 . "city = '{$city}', "
                     . "siren = '{$siren}', "
			         . "modified = '{$modified}', "
			         . "deleted = '{$deleted}'
			         ";
                    $sql = "UPDATE {$_TABLES['cl']} SET $sql "
                         . "WHERE clid = {$_REQUEST['clid']}";

                    DB_query($sql);
                    $last_pid = $_REQUEST['clid'];
                    if (DB_error()) { 
                        $msg = $LANG_CLASSIFIEDS_2['save_fail'];
                    } else {
                        $msg = $LANG_CLASSIFIEDS_2['save_success'];
						CLASSIFIEDS_emailEditAd($_REQUEST['title'], $_REQUEST['text'],
                            (int) $_REQUEST['clid'], $_USER['uid'], $price);
						modifAd($_REQUEST['clid']);
                    }
                } else {
				    //Create mode
					if ($_USER['uid'] < 2) {
	                    $display .= CLASSIFIEDS_loginRequiredForm();
						break;
	                }
					
				    $sql = "catid = '{$_REQUEST['catid']}', "
                     . "status = '{$status}', "
                     . "type = '{$_REQUEST['type']}', "
                     . "tel = '{$clean_tel}', "
                     . "hide_tel = '{$hide_tel}', "
			         . "title = '{$title}', "
			         . "text = '{$text}', "
			         . "price = '{$price}', "
					 . "postcode = '{$_REQUEST['postcode']}', "
					 . "city = '{$city}', "
                     . "siren = '{$_REQUEST['siren']}', "
			         . "created = '{$created}', "
			         . "modified = '{$modified}', "
					 . "owner_id = '{$_USER['uid']}'
			         ";
                    $sql = "INSERT INTO {$_TABLES['cl']} SET $sql ";
					
					DB_query($sql);
                    $last_pid = DB_insertId();
					if ($last_pid == 0) $last_pid = 1;
                    if (DB_error()) {
                        $msg = $LANG_CLASSIFIEDS_2['save_fail'];
                    } else {
                        $msg = $LANG_CLASSIFIEDS_2['save_success'];
						$adnumber = DB_insertId();
						CLASSIFIEDS_emailNewAd($title, $text, $adnumber, $_USER['uid'], $price);
						//add user to classifieds users group
						require_once $_CONF['path_system'] . 'lib-user.php';
						$ad_users = DB_getItem($_TABLES['groups'], 'grp_id',
                             "grp_name='Classifieds Users'");
                        USER_addGroup ($ad_users, $_USER['uid']);						
						
						// Populate user data
						if (DB_count($_TABLES['cl_users'],'user_id',$_USER['uid']) > 0) {
						    DB_query("UPDATE {$_TABLES['cl_users']} SET tel = '{$clean_tel}', postcode = '{$postcode}',
                            city = '{$city}', status = '{$status}', siren = '{$siren}' WHERE user_id = " . (int) $_USER['uid']);
						} else {
						    DB_query("INSERT INTO {$_TABLES['cl_users']} SET user_id = " . (int) $_USER['uid'] . ",
                            tel = '{$clean_tel}', postcode = '{$postcode}',
                            city = '{$city}', status = '{$status}',
                            siren = '{$siren}'");
						}
                    }
                }
		        
		        //Process images

		        CLASSIFIEDS_saveImage ($_REQUEST, $_FILES, $last_pid);
		        
                // save complete, return to Ad display
                echo COM_refresh($_CLASSIFIEDS_CONF['site_url'] . '/index.php?msg=' . urlencode($msg) . '&amp;mode=v&amp;ad=' . $last_pid);
                exit();
                break;

            /* this case is currently not used... future expansion? */
            case 'preview':
                $display .= CLASSIFIEDS_getAdForm($_REQUEST);
                break;

            case 'edit':
                // Get the ad to edit and display the form
                if (is_numeric($_REQUEST['ad'])) {
				    if (CLASSIFIEDS_checkAdAccess($_REQUEST['ad']) == false ) {
                        $display .= COM_refresh ($_CLASSIFIEDS_CONF['site_url'] . '/index.php');
						exit();
					    break;
                    }
                    $sql = "SELECT * FROM {$_TABLES['cl']} WHERE clid = {$_REQUEST['ad']}";
                    $res = DB_query($sql);
                    $A = DB_fetchArray($res);
                    $display .= CLASSIFIEDS_getAdForm($A);
                } else {
                    echo COM_refresh($_CLASSIFIEDS_CONF['site_url']);
                }
                break;

            case 'copy':
                if (!SEC_checkToken()) {
                    $display .= COM_showMessageText($LANG_CLASSIFIEDS_2['save_fail'], $LANG_CLASSIFIEDS_2['error']);
                    break;
                }
                $copiedId = CLASSIFIEDS_adCopy($_REQUEST, $_FILES);
                if ($copiedId > 0) {
                    echo COM_refresh($_CLASSIFIEDS_CONF['site_url'] . '/index.php?mode=v&ad=' . $copiedId);
                    exit;
                }
                $display .= CLASSIFIEDS_message($LANG_CLASSIFIEDS_2['save_fail']);
                break;

            case 'repost':
                if (!SEC_checkToken()) {
                    echo COM_refresh($_CLASSIFIEDS_CONF['site_url']);
                    exit;
                }
                CLASSIFIEDS_repost($_REQUEST['ad']);
                break;

            case 'new':
            default:
                $display .= CLASSIFIEDS_getAdForm($A = NULL);
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
	    $user = DB_getItem($_TABLES['users'],'username','uid=' . $_GET['u']);
	    $display = COM_siteHeader('menu', $LANG_CLASSIFIEDS_1['all_ads_from'] . ' ' . $user);
		$display .= CLASSIFIEDS_user_menu();
	    $display .= CLASSIFIEDS_displayAds($_GET['u'],0,$user);
		$display .= COM_siteFooter(1);
	    break;
    //contact
	case 'c':
		$uid = $_GET['uid'];
		$ad = $_GET['ad'];
		$subject = $_GET['subject'];
		$display = COM_siteHeader('menu', $LANG_CLASSIFIEDS_1['contact']);
		if (($uid > 1) && CLASSIFIEDS_checkAdAccess($ad) == true ) {
		    ($_USER['uid'] > 1) ? $user = $_USER['uid'] : 0;
            $display .= CLASSIFIEDS_contactemail ($uid, $user, '', $subject, '', $ad);
        } else {
            $display .= COM_refresh ($_CLASSIFIEDS_CONF['site_url'] . '/index.php');
			exit();
        }
		$display .= COM_siteFooter(1);
		break;
	//advise
	case 'a':
	    $display = COM_siteHeader('menu', $LANG_CLASSIFIEDS_1['advisor']);
		$display .= CLASSIFIEDS_user_menu();
		if (($uid > 1) && CLASSIFIEDS_checkAdAccess($ad) == true ) {
		    $display .= 'Hello';
		    //$display .= CLASSIFIEDS_mailAd($_GET['ad'], '', '', '', '', '');
		} else {
            $display .= COM_refresh ($_CLASSIFIEDS_CONF['site_url'] . '/index.php');
			exit();
        }
		$display .= COM_siteFooter(1);
		break;
	//report
	case 'r':
	    $uid = 2;
		$ad = $_GET['ad'];
		$subject = $LANG_CLASSIFIEDS_1['report'];
		$display = COM_siteHeader('menu', $LANG_CLASSIFIEDS_1['contact']);
		if (($uid > 1) && CLASSIFIEDS_checkAdAccess($ad) == true ) {
		    ($_USER['uid'] > 1) ? $user = $_USER['uid'] : 0;
            $display .= CLASSIFIEDS_contactemail ($uid, $user, '', $subject, '', $ad);
        } else {
            $display .= COM_refresh ($_CLASSIFIEDS_CONF['site_url'] . '/index.php');
			exit();
        }
		$display .= COM_siteFooter(1);
		break;
	//save
	case 's':
	    $display = COM_siteHeader('menu', $LANG_CLASSIFIEDS_1['save_ad']);
		$display .= CLASSIFIEDS_user_menu();
		if (CLASSIFIEDS_checkAdAccess($_REQUEST['ad']) == false ) {
            $display .= COM_refresh ($_CLASSIFIEDS_CONF['site_url'] . '/index.php');
			exit();
			break;
        }
		if ( COM_isAnonUser()) {
	        $display .= CLASSIFIEDS_loginRequiredForm();
	    } else {
		}
		$display .= COM_siteFooter(1);
		break;
	//profile
	case 'p' :
	    require_once ($_CONF['path_system']  . 'lib-user.php');
	    $display = COM_siteHeader('menu', $LANG_CLASSIFIEDS_1['profile']);
		$display .= CLASSIFIEDS_user_menu();
		(function_exists('USER_showProfile')) ? $display .= USER_showProfile($_GET['u'], true) : $display .=CLASSIFIEDS_showProfile($_GET['u'], true);
		$display .= COM_siteFooter(1);
		break;
	//Offert
	case 'o':
	    ($_REQUEST['mode'] == 'o') ? SEC_setCookie('ads_type', 'o') : 0;
	//Demand
	case 'd':	
	//Ads list
	    ($_REQUEST['mode'] == 'd') ? SEC_setCookie('ads_type', 'd') : 0;
	default :
	    $display = COM_siteHeader('menu', $LANG_CLASSIFIEDS_1['plugin_name']);
		$display .= CLASSIFIEDS_user_menu();
	    if ($_CLASSIFIEDS_CONF['classifieds_main_header'] != '') $display .= '<div>' . PLG_replaceTags($_CLASSIFIEDS_CONF['classifieds_main_header']) . '</div>';
	    $display .= CLASSIFIEDS_displayAds(1);
		if ($_CLASSIFIEDS_CONF['clasifieds_main_footer'] != '') $display .= '<div>' . PLG_replaceTags($_CLASSIFIEDS_CONF['classifieds_main_footer']) . '</div>';
        $display .= COM_siteFooter(1);
}

COM_output($display);

?>