<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Classifieds Plugin 1.4.0                                                  |
// +---------------------------------------------------------------------------+
// | chinese_simplified_utf-8.php                                                               |
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
    'plugin_name'             => '分类广告',
    'home'                    => '首页',
	'place_an_ad'             => '发布广告',
	'offer'                   => '提供',
	'demand'                  => '求购',
	'offers'                  => '提供',
	'demands'                 => '求购',
	'offers_demands'          => '提供与求购',
	'my_ads'                  => '我的广告',
	'user_ads'                => '用户广告',
	'help'                    => '帮助',
	'admin'                   => '管理',
	'access_reserved'         => '访问受限',
    'you_must_sign_in'        => '您必须登录才能查看此广告。',
	'posted_by'               => '发布者',
	'on'                      => '日期',
	'at'                      => '时间',
	'contact_advertiser'      => '联系广告主',
	'send_email'              => '发送电子邮件',
	'double_point'            => ':',
	'manage_ad'               => '管理广告',
	'modify_ad'               => '修改广告',
	'delete_ad'               => '删除广告',
	'price'                   => '价格',
	'category'                => '分类',
	'postcode'                => '邮政编码',
	'enlarge_picture'         => '放大图片',
    'previous_picture'        => '上一张图片',
    'next_picture'            => '下一张图片',
    'close_picture'           => '关闭图片查看器',
	'hits'                    => '访问',
	'no_ad'                   => '没有结果',
	'no_ad_message'           => '未找到广告。要发布广告，请点击“发布广告”按钮。',
	'report'                  => '举报广告或滥用行为',
	'deleted'                 => '已删除',
	'view_all'                => '查看此广告主的全部广告',
	'all_ads_from'            => '全部广告，发布者',
	'search_button'           => '搜索',
	'choose_category'         => '-- 选择分类 --',
	'all_categories'          => '所有分类',
	'profile'                 => '用户资料',
	'classifieds_list'        => '广告',
	'categories_list'         => '分类',
	'view_all_ads'            => '查看所有广告',
	'under_construction'      => '建设中',
    'image_not_writable'      => '分类广告图片文件夹不存在或不可写。使用插件前请先解决此问题。<br' . XHTML . '><br' . XHTML . '>请在 images 文件夹中创建 classifieds 子文件夹。',
	'ad-list-active'          => '有效广告',
	'ad-list-delete'          => '已删除广告',
	'ad-list-old'             => '过期广告',
	'label-hits'              => '浏览次数',
	'deleted_ad'              => '此广告已不可用',
	'last_ads'                => '网站最新广告',
	'ads_not_available'       => '此广告不可用',
	'all_ads'                 => '所有广告',
    'profile_no_ad'           => '没有有效广告',
);

//Ad form create, edit ,delete
$LANG_CLASSIFIEDS_2 = array(
    'deletion_succes'         => '广告已成功删除。',
    'deletion_fail'           => '广告删除失败。',
	'error'                   => '发生错误！',
	'missing_field'           => '缺少必填字段：',
    'check_it'                => '提交广告前请检查相关内容。',
	'save_fail'               => '保存失败。',
	'save_success'            => '您的广告已成功保存。',
	'message'                 => '系统消息',
	'insert_new_ad'           => '发布新广告',
	'edit_label'              => '编辑广告：',
	'your_ad'                 => '您的广告',
	'category'                => '分类',
	'title'                   => '广告标题',
	'type'                    => '类型',
	'offer'                   => '提供',
	'demand'                  => '求购',
	'choose_category'         => '-- 选择分类 --',
	'choose_type'             => '-- 选择广告类型 --',
	'text'                    => '广告内容',
	'price'                   => '价格',
	'images'                  => '您的图片',
    'image_upload_label'      => '添加图片',
    'image_upload_help'       => '一次最多选择 %d 张图片（每个广告最多 %d 张）。',
    'image_upload_failed'     => '图片无法上传或调整大小。',
    'image_too_large_no_resizer' => '图片超过 %d × %d 像素，且没有可用的图片缩放库。',
	'your_details'            => '您的信息',
	'status'                     => '状态',
	'choose_status'           => '-- 选择状态 --',
	'private'                 => '个人',
	'professional'            => '专业用户',
	'siren'                   => '专业 ID',
	'tel'                     => '电话',
	'hide_tel'                 => '在广告中隐藏我的电话号码',
	'postcode'                => '邮政编码',
	'city'                    => '城市',
	'save_button'             => '保存',
	'delete_button'           => '删除',
	'required_field'          => '表示必填字段',
	'validate_button'         => '验证',
    'copy_button'             => '重新发布此广告',
	'access_reserved'         => '访问受限。要使用此功能，您必须属于以下组：',
);

$LANG_CLASSIFIEDS_ADMIN = array(
    'administration'          => '分类广告管理',
    'configuration'           => '配置',
    'getting_started_title'    => '开始使用',
    'getting_started_intro'    => '配置基本设置，创建或导入分类，然后检查公开的分类广告页面。',
    'getting_started_configure'=> '检查分类广告配置',
    'getting_started_categories'=> '创建或导入分类',
    'getting_started_public'   => '打开公开分类广告页面',
    'category_in_use'         => '此分类仍包含广告或子分类，因此无法删除。',
    'dashboard_active'         => '有效广告',
    'dashboard_expired'        => '过期广告',
    'dashboard_deleted'        => '已删除广告',
    'dashboard_categories'     => '有效分类',
    'dashboard_manage'         => '管理分类广告',
    'dashboard_storage_warning'=> '分类广告图片目录不存在或不可写。',
    'clid'                    => '广告 ID',
	'title'                   => '广告标题',
	'owner_id'                => '所有者 ID',
	'created'                 => '创建时间',
	'cid'                     => '分类 ID',
	'pid'                     => '父分类',
	'category'                => '分类',
	'catorder'                => '顺序',
	'catdeleted'              => '状态',
	'root'                    => '根分类',
    'root_category_help'      => '根分类仅用于组织子分类，不能直接接收广告。广告必须发布在子分类中。',
	'deletion_succes'         => '删除成功。',
    'deletion_fail'           => '删除失败。',
	'cat_informations'        => '分类信息',
	'parent_category'         => '父分类',
	'enable'                  => '启用',
	'disable'                 => '禁用',
	'edit_label'              => '编辑',
	'create_new_cat'          => '创建新分类',
    'insert_new_cat'          => '创建新分类',
    'save_fail'               => '保存失败。',
    'save_success'            => '分类已成功保存。',
    'seo_metadata'            => 'SEO 元数据',
    'meta_title'              => '元标题',
    'meta_description'        => '元描述',
    'meta_keywords'           => '元关键词',
    'modified'                => '修改时间',
	'online'                  => '在线',
	'plugin_conf'             => '分类广告插件配置也位于',
	'plugin_doc'              => '分类广告插件的安装、升级和使用文档位于',
    'publish_all_logged_in'      => '所有注册用户都可以发布广告。目前不要求特定用户组。',
    'publish_restricted_group'   => '发布仅限以下用户组：',
    'publish_restricted_groups'  => '发布仅限以下 %d 个用户组：',
    'child_position'          => '位置',
    'position_first'          => '第一',
    'position_after'          => '在 %s 之后',
    'position_last'           => '最后',
    'csv_import'              => '从 CSV 导入分类',
    'csv_documentation'       => 'CSV 导入文档',
    'csv_documentation_link'  => '如何准备分类 CSV 文件',
    'csv_doc_intro'           => 'CSV 导入器可在不使用数据库 ID 的情况下创建完整分类树。请使用稳定键准备文件，验证预览后再确认导入。',
    'csv_doc_format_title'    => '文件格式',
    'csv_doc_format_text'     => '使用 UTF-8 CSV 文件，并按此顺序准确包含四列。逗号和分号均可作为分隔符。',
    'csv_doc_columns_title'   => '列',
    'csv_doc_key'             => '仅在导入时使用的稳定标识符。它在文件中必须唯一，可包含小写字母、数字、点、下划线和连字符。',
    'csv_doc_category'        => '向用户显示的分类名称。不能为空，最多 32 个字符。',
    'csv_doc_parent'          => '父分类的键。根分类请留空。父分类可出现在其子分类之前或之后。',
    'csv_doc_order'           => '同一父分类下各分类的显示顺序。使用 0 到 65535 的整数。',
    'csv_doc_hierarchy_title' => '分类和子分类',
    'csv_doc_hierarchy_text'  => '要创建多级结构，请让 parent_key 指向另一行的 key。导入器会自动解析层级，因此数据库 cid/pid 值不应出现在 CSV 文件中。',
    'csv_doc_rules_title'     => '重要规则',
    'csv_doc_rule_utf8'       => '请将文件保存为 UTF-8。允许 UTF-8 BOM。',
    'csv_doc_rule_header'     => '第一行必须准确为：key,category,parent_key,order。',
    'csv_doc_rule_key'        => '每个 key 必须唯一。不要对两个分类重复使用同一 key。',
    'csv_doc_rule_parent'     => '每个非空 parent_key 必须引用同一 CSV 文件中存在的 key。自引用和循环会被拒绝。',
    'csv_doc_rule_order'      => '行可按任意顺序出现；order 列控制显示顺序，而不是导入顺序。',
    'csv_doc_rule_existing'   => '如果同一父分类下已有同名分类，将跳过而不是创建重复项。',
    'csv_doc_rule_preview'    => '预览期间不会写入任何内容。确认导入前会再次验证完整文件。',
    'csv_doc_workflow_title'  => '推荐流程',
    'csv_doc_step_template'   => '下载 CSV 模板。',
    'csv_doc_step_edit'       => '在电子表格或文本编辑器中编辑各行，同时保留四列标题。',
    'csv_doc_step_preview'    => '上传文件并检查验证预览，尤其是父子关系以及创建/跳过状态。',
    'csv_doc_step_confirm'    => '仅在预览正确时确认。数据库写入采用事务处理。',
    'csv_template'            => '下载 CSV 模板',
    'csv_help'                => '从 UTF-8 CSV 文件导入分类和子分类。使用 key 标识每一行，使用 parent_key 引用父分类。根分类的 parent_key 留空。可使用逗号或分号作为分隔符。',
    'csv_file'                => 'CSV 文件',
    'csv_preview'             => '验证并预览',
    'csv_preview_title'       => '导入预览',
    'csv_preview_summary'     => '将创建 %d 个分类；将跳过 %d 个现有分类。',
    'csv_confirm'             => '导入这些分类',
    'csv_key'                 => '键',
    'csv_parent_key'          => '父键',
    'csv_status'              => '导入状态',
    'csv_status_create'       => '创建',
    'csv_status_skip'         => '已存在 — 跳过',
    'csv_import_success'      => '已创建 %d 个分类；已跳过 %d 个现有分类。',
    'csv_errors_title'        => '无法导入 CSV 文件：',
    'csv_error_empty'         => 'CSV 文件为空。',
    'csv_error_too_large'     => 'CSV 文件过大（最大 256 KB）。',
    'csv_error_read_failed'   => '无法读取 CSV 文件。',
    'csv_error_upload'        => 'CSV 文件上传失败。',
    'csv_error_header'        => '第一行必须准确为：key,category,parent_key,order。',
    'csv_error_columns'       => '第 %d 行：必须恰好有四列。',
    'csv_error_key'           => '第 %d 行：键“%s”无效。请使用字母、数字、点、下划线或连字符。',
    'csv_error_duplicate_key' => '第 %d 行：重复键“%s”。',
    'csv_error_category'      => '第 %d 行：分类“%s”为空或超过 32 个字符。',
    'csv_error_self_parent'   => '第 %d 行：键“%s”不能将自身作为父级。',
    'csv_error_order'         => '第 %d 行：顺序“%s”无效。请使用 0 到 65535 的整数。',
    'csv_error_missing_parent'=> '第 %d 行：父键“%s”在 CSV 文件中不存在。',
    'csv_error_cycle'         => '第 %d 行：键“%s”属于父级循环。',
    'csv_error_database'      => '数据库拒绝了导入。未保留任何部分导入。',
    'csv_error_dependency'    => '无法解析分类层级。未保留任何部分导入。',
    'csv_error_payload'       => '已验证的 CSV 数据缺失或无效。',
    'csv_error_token'         => '安全令牌已过期。请重新执行导入。',
    'csv_error_invalid'       => 'CSV 导入请求无效。',
	
);

$LANG_CLASSIFIEDS_EMAIL = array(
    'hello'                   => '您好',
    'new_ad'                  => '您的新广告已发布。',
    'edit_ad'                 => '您的广告已更新。',
    'delete_ad'               => '您的广告已移除。',
    'expire_ad'               => '您的广告已过期。',
    'online_for'              => '它将保持在线',
    'days'                    => '天。',
    'price'                   => '价格：',
    'view_ad'                 => '查看广告',
    'manage_ad'               => '管理我的广告',
    'my_ads'                  => '我的广告',
    'post_new_button'         => '发布新广告',
    'publisher'               => '发布者',
    'automatic_notice'        => '这是一封自动消息，请勿回复。',
    'admin_manage'            => '管理分类广告',
    'subject_create'          => '新广告',
    'subject_edit'            => '广告已更新',
    'subject_delete'          => '广告已移除',
    'subject_expire'          => '广告已过期',

);


// Messages for the plugin upgrade
$PLG_classifieds_MESSAGE3002 = $LANG32[9]; // "requires a newer version of Geeklog"
$PLG_classifieds_MESSAGE1    = 'Hello world :)';

/**
*   Localization of the Admin Configuration UI
*   @global array $LANG_configsections['classifieds']
*/
$LANG_configsections['classifieds'] = array(
    'label' => '分类广告',
    'title' => '分类广告配置'
);

/**
*   Configuration system subgroup strings
*   @global array $LANG_configsubgroups['classifieds']
*/
$LANG_configsubgroups['classifieds'] = array(
    'sg_main' => '主要设置'
);

$LANG_tab['classifieds'] = array(
    'tab_main' => '分类广告'
);

/**
*   Configuration system fieldset names
*   @global array $LANG_fs['classifieds']
*/
$LANG_fs['classifieds'] = array(
    'fs_main'            => '常规设置',
    'fs_images'          => '图片设置',
	'fs_display'         => '显示设置',
	'fs_email'           => '电子邮件设置',
    'fs_permissions'     => '默认权限'
 );
 
/**
*   Configuration system prompt strings
*   @global array $LANG_confignames['classifieds']
*/
$LANG_confignames['classifieds'] = array(
    // Main settings
    'active_days' => '有效天数',
    
	//Images settings
    'max_image_width'  => '最大图片宽度',
	'max_image_height'  => '最大图片高度',
    'max_image_size'  => '最大图片大小',
    'max_images_per_ad'  => '每个广告最大图片数',

     //Display settings
    'menulabel'  => '菜单标签',
    'hide_classifieds_menu'  => '隐藏分类广告菜单',
    'classifieds_main_header'  => '主标题',
    'classifieds_main_footer'  => '主页脚',
    'classifieds_edit_header'  => '编辑器标题',
    'help_page'  => '帮助页面',
    'currency'  => '货币',
    'maxPerPage'  => '每页最大数量',
	'allow_republish' => '允许重新发布广告',

    // Email settings
    'create_ad_email_user'  => '创建广告时向用户发送邮件',
    'mod_ad_email_user'  => '修改广告时向用户发送邮件',
    'delete_ad_email_user'  => '删除广告时向用户发送邮件',
    'expire_ad_email_user'  => '广告过期时向用户发送邮件',
	'create_ad_email_admin'  => '创建广告时向管理员发送邮件',
    'mod_ad_email_admin'  => '修改广告时向管理员发送邮件',
    'delete_ad_email_admin'  => '删除广告时向管理员发送邮件',
    'expire_ad_email_admin'  => '广告过期时向管理员发送邮件',

    //Permissions settings
    'classifieds_login_required'  => '访问分类广告需要登录',
    'default_permissions'  => '默认权限'
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
    12 => array('无访问权限' => 0, '只读' => 2, '读写' => 3)
);

$LANG_configtooltips['classifieds'] = array(    'active_days' => '广告保持有效的天数，之后可进行过期通知并重新发布。',
    'max_image_size' => '单张广告图片允许上传的最大字节数。',
    'max_images_per_ad' => '单个广告可附加的最大图片数量。',
    'allow_republish' => '允许将符合条件的过期广告复制为新的有效广告，同时保留历史原件。',
    'classifieds_login_required' => '启用后，访客必须登录才能访问分类广告。',
    'default_permissions' => '应用于新建分类广告内容的 Geeklog ACL 权限。'
);
?>
