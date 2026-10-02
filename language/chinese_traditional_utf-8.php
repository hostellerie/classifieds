<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Classifieds Plugin 1.4.0                                                  |
// +---------------------------------------------------------------------------+
// | chinese_traditional_utf-8.php                                                               |
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
    'plugin_name'             => '分類廣告',
    'home'                    => '首頁',
	'place_an_ad'             => '發布廣告',
	'offer'                   => '提供',
	'demand'                  => '求購',
	'offers'                  => '提供',
	'demands'                 => '求購',
	'offers_demands'          => '提供與求購',
	'my_ads'                  => '我的廣告',
	'user_ads'                => '用戶廣告',
	'help'                    => '幫助',
	'admin'                   => '管理',
	'access_reserved'         => '存取受限',
    'you_must_sign_in'        => '您必须登入才能檢視此廣告。',
	'posted_by'               => '發布者',
	'on'                      => '日期',
	'at'                      => '時間',
	'contact_advertiser'      => '聯絡廣告主',
	'send_email'              => '發送電子郵件',
	'double_point'            => ':',
	'manage_ad'               => '管理廣告',
	'modify_ad'               => '修改廣告',
	'delete_ad'               => '刪除廣告',
	'price'                   => '价格',
	'category'                => '分類',
	'postcode'                => '郵遞區號',
	'enlarge_picture'         => '放大圖片',
    'previous_picture'        => '上一張圖片',
    'next_picture'            => '下一張圖片',
    'close_picture'           => '關閉圖片檢視器',
	'hits'                    => '存取',
	'no_ad'                   => '沒有結果',
	'no_ad_message'           => '未找到廣告。要發布廣告，請点击“發布廣告”按鈕。',
	'report'                  => '舉報廣告或濫用行為',
	'deleted'                 => '已删除',
	'view_all'                => '檢視此廣告主的全部廣告',
	'all_ads_from'            => '全部廣告，發布者',
	'search_button'           => '搜尋',
	'choose_category'         => '-- 選择分類 --',
	'all_categories'          => '所有分類',
	'profile'                 => '用戶資料',
	'classifieds_list'        => '廣告',
	'categories_list'         => '分類',
	'view_all_ads'            => '檢視所有廣告',
	'under_construction'      => '建設中',
    'image_not_writable'      => '分類廣告圖片資料夾不存在或不可寫入。使用外掛前請先解決此問題。<br' . XHTML . '><br' . XHTML . '>請在 images 資料夾中建立 classifieds 子資料夾。',
	'ad-list-active'          => '有效廣告',
	'ad-list-delete'          => '已刪除廣告',
	'ad-list-old'             => '過期廣告',
	'label-hits'              => '瀏覽次數',
	'deleted_ad'              => '此廣告已不可用',
	'last_ads'                => '網站最新廣告',
	'ads_not_available'       => '此廣告不可用',
	'all_ads'                 => '所有廣告',
    'profile_no_ad'           => '沒有有效廣告',
);

//Ad form create, edit ,delete
$LANG_CLASSIFIEDS_2 = array(
    'deletion_succes'         => '廣告已成功删除。',
    'deletion_fail'           => '廣告删除失败。',
	'error'                   => '發生錯誤！',
	'missing_field'           => '缺少必填字段：',
    'check_it'                => '提交廣告前請檢查相關內容。',
	'save_fail'               => '保存失败。',
	'save_success'            => '您的廣告已成功保存。',
	'message'                 => '係統訊息',
	'insert_new_ad'           => '發布新廣告',
	'edit_label'              => '編輯廣告：',
	'your_ad'                 => '您的廣告',
	'category'                => '分類',
	'title'                   => '廣告標題',
	'type'                    => '類型',
	'offer'                   => '提供',
	'demand'                  => '求購',
	'choose_category'         => '-- 選择分類 --',
	'choose_type'             => '-- 選择廣告類型 --',
	'text'                    => '廣告內容',
	'price'                   => '价格',
	'images'                  => '您的圖片',
    'image_upload_label'      => '添加圖片',
    'image_upload_help'       => '一次最多選择 %d 張圖片（每個廣告最多 %d 張）。',
    'image_upload_failed'     => '圖片無法上傳或調整大小。',
    'image_too_large_no_resizer' => '圖片超過 %d × %d 像素，且沒有可用的圖片缩放庫。',
	'your_details'            => '您的資訊',
	'status'                     => '狀態',
	'choose_status'           => '-- 選择狀態 --',
	'private'                 => '個人',
	'professional'            => '專業用戶',
	'siren'                   => '專业 ID',
	'tel'                     => '電话',
	'hide_tel'                 => '在廣告中隱藏我的電話號碼',
	'postcode'                => '郵遞區號',
	'city'                    => '城市',
	'save_button'             => '保存',
	'delete_button'           => '删除',
	'required_field'          => '表示必填字段',
	'validate_button'         => '驗證',
    'copy_button'             => '重新發布此廣告',
	'access_reserved'         => '存取受限。要使用此功能，您必须屬于以下組：',
);

$LANG_CLASSIFIEDS_ADMIN = array(
    'administration'          => '分類廣告管理',
    'configuration'           => '設定',
    'getting_started_title'    => '開始使用',
    'getting_started_intro'    => '設定基本設置，建立或匯入分類，然後檢查公開的分類廣告頁面。',
    'getting_started_configure'=> '檢查分類廣告設定',
    'getting_started_categories'=> '建立或匯入分類',
    'getting_started_public'   => '打開公開分類廣告頁面',
    'category_in_use'         => '此分類仍包含廣告或子分類，因此無法删除。',
    'dashboard_active'         => '有效廣告',
    'dashboard_expired'        => '過期廣告',
    'dashboard_deleted'        => '已刪除廣告',
    'dashboard_categories'     => '有效分類',
    'dashboard_manage'         => '管理分類廣告',
    'dashboard_storage_warning'=> '分類廣告圖片目錄不存在或不可寫。',
    'clid'                    => '廣告 ID',
	'title'                   => '廣告標題',
	'owner_id'                => '擁有者 ID',
	'created'                 => '建立時間',
	'cid'                     => '分類 ID',
	'pid'                     => '父分類',
	'category'                => '分類',
	'catorder'                => '順序',
	'catdeleted'              => '狀態',
	'root'                    => '根分類',
    'root_category_help'      => '根分類僅用于組織子分類，不能直接接收廣告。廣告必须發布在子分類中。',
	'deletion_succes'         => '删除成功。',
    'deletion_fail'           => '删除失败。',
	'cat_informations'        => '分類資訊',
	'parent_category'         => '父分類',
	'enable'                  => '啟用',
	'disable'                 => '停用',
	'edit_label'              => '編輯',
	'create_new_cat'          => '建立新分類',
    'insert_new_cat'          => '建立新分類',
    'save_fail'               => '保存失败。',
    'save_success'            => '分類已成功保存。',
    'seo_metadata'            => 'SEO 中繼資料',
    'meta_title'              => '中繼標題',
    'meta_description'        => '中繼描述',
    'meta_keywords'           => '中繼關鍵字',
    'modified'                => '修改時間',
	'online'                  => '線上',
	'plugin_conf'             => '分類廣告插件設定也位于',
	'plugin_doc'              => '分類廣告插件的安装、升級和使用文檔位于',
    'publish_all_logged_in'      => '所有註冊用戶都可以發布廣告。目前不要求特定用戶組。',
    'publish_restricted_group'   => '發布僅限以下用戶組：',
    'publish_restricted_groups'  => '發布僅限以下 %d 個用戶組：',
    'child_position'          => '位置',
    'position_first'          => '第一',
    'position_after'          => '在 %s 之後',
    'position_last'           => '最後',
    'csv_import'              => '从 CSV 匯入分類',
    'csv_documentation'       => 'CSV 匯入檔案',
    'csv_documentation_link'  => '如何準備分類 CSV 檔案',
    'csv_doc_intro'           => 'CSV 匯入器可在不使用資料庫 ID 的情况下建立完整分類樹。請使用穩定鍵准备檔案，驗證預覽後再確認匯入。',
    'csv_doc_format_title'    => '檔案格式',
    'csv_doc_format_text'     => '使用 UTF-8 CSV 檔案，并按此順序准確包含四列。逗號和分號均可作為分隔符號。',
    'csv_doc_columns_title'   => '列',
    'csv_doc_key'             => '僅在導入時使用的穩定識別碼。它在檔案中必须唯一，可包含小寫字母、數字、点、底線和連字號。',
    'csv_doc_category'        => '向用戶顯示的分類名稱。不能為空，最多 32 個字元。',
    'csv_doc_parent'          => '父分類的鍵。根分類請留空。父分類可出现在其子分類之前或之後。',
    'csv_doc_order'           => '同一父分類下各分類的顯示順序。使用 0 到 65535 的整數。',
    'csv_doc_hierarchy_title' => '分類和子分類',
    'csv_doc_hierarchy_text'  => '要建立多級結構，請让 parent_key 指向另一行的 key。導入器会自動解析階層，因此資料庫 cid/pid 值不應出现在 CSV 檔案中。',
    'csv_doc_rules_title'     => '重要規則',
    'csv_doc_rule_utf8'       => '請将檔案儲存為 UTF-8。允許 UTF-8 BOM。',
    'csv_doc_rule_header'     => '第一列必须准確為：key,category,parent_key,order。',
    'csv_doc_rule_key'        => '每個 key 必须唯一。不要对两個分類重複使用同一 key。',
    'csv_doc_rule_parent'     => '每個非空 parent_key 必须參照同一 CSV 檔案中存在的 key。自參照和循環会被拒绝。',
    'csv_doc_rule_order'      => '行可按任意順序出现；order 列控制顯示順序，而不是導入順序。',
    'csv_doc_rule_existing'   => '如果同一父分類下已有同名分類，将略過而不是建立重複項。',
    'csv_doc_rule_preview'    => '預覽期间不会寫入任何內容。確認匯入前会再次驗證完整檔案。',
    'csv_doc_workflow_title'  => '建議流程',
    'csv_doc_step_template'   => '下載 CSV 範本。',
    'csv_doc_step_edit'       => '在試算表或文本編輯器中編輯各行，同時保留四列標頭。',
    'csv_doc_step_preview'    => '上傳檔案并檢查驗證預覽，尤其是父子關係以及建立/略過狀態。',
    'csv_doc_step_confirm'    => '僅在預覽正確時確認。資料庫寫入采用交易處理。',
    'csv_template'            => '下載 CSV 範本',
    'csv_help'                => '从 UTF-8 CSV 檔案匯入分類和子分類。使用 key 標識每一行，使用 parent_key 參照父分類。根分類的 parent_key 留空。可使用逗號或分號作為分隔符號。',
    'csv_file'                => 'CSV 檔案',
    'csv_preview'             => '驗證并預覽',
    'csv_preview_title'       => '導入預覽',
    'csv_preview_summary'     => '将建立 %d 個分類；将略過 %d 個现有分類。',
    'csv_confirm'             => '導入這些分類',
    'csv_key'                 => '鍵',
    'csv_parent_key'          => '父鍵',
    'csv_status'              => '導入狀態',
    'csv_status_create'       => '建立',
    'csv_status_skip'         => '已存在 — 略過',
    'csv_import_success'      => '已建立 %d 個分類；已略過 %d 個现有分類。',
    'csv_errors_title'        => '無法匯入 CSV 檔案：',
    'csv_error_empty'         => 'CSV 檔案為空。',
    'csv_error_too_large'     => 'CSV 檔案過大（最大 256 KB）。',
    'csv_error_read_failed'   => '無法讀取 CSV 檔案。',
    'csv_error_upload'        => 'CSV 檔案上傳失败。',
    'csv_error_header'        => '第一列必须准確為：key,category,parent_key,order。',
    'csv_error_columns'       => '第 %d 行：必须恰好有四列。',
    'csv_error_key'           => '第 %d 行：鍵“%s”無效。請使用字母、數字、点、底線或連字號。',
    'csv_error_duplicate_key' => '第 %d 行：重複鍵“%s”。',
    'csv_error_category'      => '第 %d 行：分類“%s”為空或超過 32 個字元。',
    'csv_error_self_parent'   => '第 %d 行：鍵“%s”不能将自身作為父層。',
    'csv_error_order'         => '第 %d 行：順序“%s”無效。請使用 0 到 65535 的整數。',
    'csv_error_missing_parent'=> '第 %d 行：父鍵“%s”在 CSV 檔案中不存在。',
    'csv_error_cycle'         => '第 %d 行：鍵“%s”屬于父級循環。',
    'csv_error_database'      => '資料庫拒绝了導入。未保留任何部分導入。',
    'csv_error_dependency'    => '無法解析分類階層。未保留任何部分導入。',
    'csv_error_payload'       => '已驗證的 CSV 數據缺失或無效。',
    'csv_error_token'         => '安全權杖已過期。請重新执行導入。',
    'csv_error_invalid'       => 'CSV 導入要求無效。',
	
);

$LANG_CLASSIFIEDS_EMAIL = array(
    'hello'                   => '您好',
    'new_ad'                  => '您的新廣告已發布。',
    'edit_ad'                 => '您的廣告已更新。',
    'delete_ad'               => '您的廣告已移除。',
    'expire_ad'               => '您的廣告已過期。',
    'online_for'              => '它将保持線上',
    'days'                    => '天。',
    'price'                   => '价格：',
    'view_ad'                 => '檢視廣告',
    'manage_ad'               => '管理我的廣告',
    'my_ads'                  => '我的廣告',
    'post_new_button'         => '發布新廣告',
    'publisher'               => '發布者',
    'automatic_notice'        => '這是一封自動消息，請勿回複。',
    'admin_manage'            => '管理分類廣告',
    'subject_create'          => '新廣告',
    'subject_edit'            => '廣告已更新',
    'subject_delete'          => '廣告已移除',
    'subject_expire'          => '廣告已過期',

);


// Messages for the plugin upgrade
$PLG_classifieds_MESSAGE3002 = $LANG32[9]; // "requires a newer version of Geeklog"
$PLG_classifieds_MESSAGE1    = 'Hello world :)';

/**
*   Localization of the Admin Configuration UI
*   @global array $LANG_configsections['classifieds']
*/
$LANG_configsections['classifieds'] = array(
    'label' => '分類廣告',
    'title' => '分類廣告設定'
);

/**
*   Configuration system subgroup strings
*   @global array $LANG_configsubgroups['classifieds']
*/
$LANG_configsubgroups['classifieds'] = array(
    'sg_main' => '主要設定'
);

$LANG_tab['classifieds'] = array(
    'tab_main' => '分類廣告'
);

/**
*   Configuration system fieldset names
*   @global array $LANG_fs['classifieds']
*/
$LANG_fs['classifieds'] = array(
    'fs_main'            => '一般設定',
    'fs_images'          => '圖片設置',
	'fs_display'         => '顯示設定',
	'fs_email'           => '電子郵件設置',
    'fs_permissions'     => '預設權限'
 );
 
/**
*   Configuration system prompt strings
*   @global array $LANG_confignames['classifieds']
*/
$LANG_confignames['classifieds'] = array(
    // Main settings
    'active_days' => '有效天數',
    
	//Images settings
    'max_image_width'  => '最大圖片寬度',
	'max_image_height'  => '最大圖片高度',
    'max_image_size'  => '最大圖片大小',
    'max_images_per_ad'  => '每個廣告最大圖片數',

     //Display settings
    'menulabel'  => '選單標籤',
    'hide_classifieds_menu'  => '隱藏分類廣告菜单',
    'classifieds_main_header'  => '主標頭',
    'classifieds_main_footer'  => '主頁尾',
    'classifieds_edit_header'  => '編輯器標頭',
    'help_page'  => '說明頁面',
    'currency'  => '貨幣',
    'maxPerPage'  => '每頁最大數量',
	'allow_republish' => '允許重新發布廣告',

    // Email settings
    'create_ad_email_user'  => '建立廣告時向用戶發送郵件',
    'mod_ad_email_user'  => '修改廣告時向用戶發送郵件',
    'delete_ad_email_user'  => '刪除廣告時向用戶發送郵件',
    'expire_ad_email_user'  => '廣告過期時向用戶發送郵件',
	'create_ad_email_admin'  => '建立廣告時向管理員發送郵件',
    'mod_ad_email_admin'  => '修改廣告時向管理員發送郵件',
    'delete_ad_email_admin'  => '刪除廣告時向管理員發送郵件',
    'expire_ad_email_admin'  => '廣告過期時向管理員發送郵件',

    //Permissions settings
    'classifieds_login_required'  => '存取分類廣告需要登入',
    'default_permissions'  => '預設權限'
);

/**
*   Configuration system selection strings
*   Note: entries 0, 1, and 12 are the same as in 
*   $LANG_configselects['Core']
*
*   @global array $LANG_configselects['classifieds']
*/
$LANG_configselects['classifieds'] = array(
    3 => array('是' => 1, '否' => 0),
    12 => array('無存取權限' => 0, '唯讀' => 2, '讀寫' => 3)
);

$LANG_configtooltips['classifieds'] = array(    'active_days' => '廣告保持有效的天數，之後可进行過期通知并重新發布。',
    'max_image_size' => '单張廣告圖片允許上傳的最大字节數。',
    'max_images_per_ad' => '单個廣告可附加的最大圖片數量。',
    'allow_republish' => '允許将符合条件的過期廣告複制為新的有效廣告，同時保留歷史原始項目。',
    'classifieds_login_required' => '啟用後，訪客必须登入才能存取分類廣告。',
    'default_permissions' => '應用于新建分類廣告內容的 Geeklog ACL 權限。'
);
?>
