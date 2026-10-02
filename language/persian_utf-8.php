<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Classifieds Plugin 1.4.0                                                  |
// +---------------------------------------------------------------------------+
// | persian_utf-8.php                                                               |
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
    'plugin_name'             => 'نیازمندی‌ها',
    'home'                    => 'خانه',
	'place_an_ad'             => 'ثبت آگهی',
	'offer'                   => 'عرضه',
	'demand'                  => 'تقاضا',
	'offers'                  => 'عرضه‌ها',
	'demands'                 => 'تقاضاها',
	'offers_demands'          => 'عرضه‌ها و تقاضاها',
	'my_ads'                  => 'آگهی‌های من',
	'user_ads'                => 'آگهی‌های کاربر',
	'help'                    => 'راهنما',
	'admin'                   => 'مدیریت',
	'access_reserved'         => 'دسترسی محدود',
    'you_must_sign_in'        => 'برای مشاهده این آگهی باید وارد شوید.',
	'posted_by'               => 'منتشرشده توسط',
	'on'                      => 'در تاریخ',
	'at'                      => 'ساعت',
	'contact_advertiser'      => 'تماس با آگهی‌دهنده',
	'send_email'              => 'ارسال ایمیل',
	'double_point'            => ':',
	'manage_ad'               => 'مدیریت آگهی',
	'modify_ad'               => 'ویرایش آگهی',
	'delete_ad'               => 'حذف آگهی',
	'price'                   => 'قیمت',
	'category'                => 'دسته‌بندی',
	'postcode'                => 'کد پستی',
	'enlarge_picture'         => 'بزرگ‌نمایی تصویر',
    'previous_picture'        => 'تصویر قبلی',
    'next_picture'            => 'تصویر بعدی',
    'close_picture'           => 'بستن نمایشگر تصویر',
	'hits'                    => 'بازدید',
	'no_ad'                   => 'بدون نتیجه',
	'no_ad_message'           => 'هیچ آگهی‌ای پیدا نشد. برای ثبت آگهی روی دکمه «ثبت آگهی» کلیک کنید.',
	'report'                  => 'گزارش آگهی یا سوءاستفاده',
	'deleted'                 => 'حذف‌شده',
	'view_all'                => 'مشاهده همه آگهی‌های این آگهی‌دهنده',
	'all_ads_from'            => 'همه آگهی‌های منتشرشده توسط',
	'search_button'           => 'جستجو',
	'choose_category'         => '-- انتخاب دسته‌بندی --',
	'all_categories'          => 'همه دسته‌بندی‌ها',
	'profile'                 => 'پروفایل کاربر',
	'classifieds_list'        => 'آگهی‌ها',
	'categories_list'         => 'دسته‌بندی‌ها',
	'view_all_ads'            => 'مشاهده همه آگهی‌ها',
	'under_construction'      => 'در حال ساخت',
    'image_not_writable'      => 'پوشه تصاویر نیازمندی‌ها وجود ندارد یا قابل نوشتن نیست. پیش از استفاده از افزونه این مشکل را برطرف کنید.<br' . XHTML . '><br' . XHTML . '>در پوشه images یک زیرپوشه classifieds ایجاد کنید.',
	'ad-list-active'          => 'آگهی فعال',
	'ad-list-delete'          => 'آگهی حذف‌شده',
	'ad-list-old'             => 'آگهی منقضی',
	'label-hits'              => 'بازدیدها',
	'deleted_ad'              => 'این آگهی دیگر در دسترس نیست',
	'last_ads'                => 'آخرین آگهی‌های سایت',
	'ads_not_available'       => 'این آگهی در دسترس نیست',
	'all_ads'                 => 'همه آگهی‌ها',
    'profile_no_ad'           => 'آگهی فعالی وجود ندارد',
);

//Ad form create, edit ,delete
$LANG_CLASSIFIEDS_2 = array(
    'deletion_succes'         => 'آگهی با موفقیت حذف شد.',
    'deletion_fail'           => 'حذف آگهی ناموفق بود.',
	'error'                   => 'خطایی رخ داده است!',
	'missing_field'           => 'برخی فیلدهای الزامی تکمیل نشده‌اند:',
    'check_it'                => 'لطفاً پیش از ارسال آگهی اطلاعات را بررسی کنید.',
	'save_fail'               => 'ذخیره‌سازی ناموفق بود.',
	'save_success'            => 'آگهی شما با موفقیت ذخیره شد.',
	'message'                 => 'پیام سیستم',
	'insert_new_ad'           => 'ثبت آگهی جدید',
	'edit_label'              => 'ویرایش آگهی:',
	'your_ad'                 => 'آگهی شما',
	'category'                => 'دسته‌بندی',
	'title'                   => 'عنوان آگهی',
	'type'                    => 'نوع',
	'offer'                   => 'عرضه',
	'demand'                  => 'تقاضا',
	'choose_category'         => '-- انتخاب دسته‌بندی --',
	'choose_type'             => '-- انتخاب نوع آگهی --',
	'text'                    => 'متن آگهی',
	'price'                   => 'قیمت',
	'images'                  => 'تصاویر شما',
    'image_upload_label'      => 'افزودن تصاویر',
    'image_upload_help'       => 'حداکثر %d تصویر را هم‌زمان انتخاب کنید (حداکثر %d تصویر برای هر آگهی).',
    'image_upload_failed'     => 'تصویر قابل بارگذاری یا تغییر اندازه نبود.',
    'image_too_large_no_resizer' => 'ابعاد تصویر از %d × %d پیکسل بیشتر است و کتابخانه‌ای برای تغییر اندازه تصویر در دسترس نیست.',
	'your_details'            => 'اطلاعات شما',
	'status'                     => 'وضعیت',
	'choose_status'           => '-- انتخاب وضعیت --',
	'private'                 => 'شخصی',
	'professional'            => 'حرفه‌ای',
	'siren'                   => 'شناسه حرفه‌ای',
	'tel'                     => 'تلفن',
	'hide_tel'                 => 'شماره تلفن من در آگهی نمایش داده نشود',
	'postcode'                => 'کد پستی',
	'city'                    => 'شهر',
	'save_button'             => 'ذخیره',
	'delete_button'           => 'حذف',
	'required_field'          => 'نشان‌دهنده فیلد الزامی',
	'validate_button'         => 'تأیید',
    'copy_button'             => 'انتشار دوباره این آگهی',
	'access_reserved'         => 'دسترسی محدود است. برای استفاده از این قابلیت باید عضو گروه زیر باشید:',
);

$LANG_CLASSIFIEDS_ADMIN = array(
    'administration'          => 'مدیریت نیازمندی‌ها',
    'configuration'           => 'پیکربندی',
    'getting_started_title'    => 'شروع کار',
    'getting_started_intro'    => 'تنظیمات اصلی را پیکربندی کنید، دسته‌بندی‌ها را بسازید یا وارد کنید و سپس صفحه عمومی نیازمندی‌ها را بررسی کنید.',
    'getting_started_configure'=> 'بررسی پیکربندی نیازمندی‌ها',
    'getting_started_categories'=> 'ساخت یا ورود دسته‌بندی‌ها',
    'getting_started_public'   => 'باز کردن صفحه عمومی نیازمندی‌ها',
    'category_in_use'         => 'تا زمانی که این دسته‌بندی دارای آگهی یا زیردسته باشد، نمی‌توان آن را حذف کرد.',
    'dashboard_active'         => 'آگهی‌های فعال',
    'dashboard_expired'        => 'آگهی‌های منقضی',
    'dashboard_deleted'        => 'آگهی‌های حذف‌شده',
    'dashboard_categories'     => 'دسته‌بندی‌های فعال',
    'dashboard_manage'         => 'مدیریت نیازمندی‌ها',
    'dashboard_storage_warning'=> 'پوشه تصاویر نیازمندی‌ها وجود ندارد یا قابل نوشتن نیست.',
    'clid'                    => 'شناسه آگهی',
	'title'                   => 'عنوان آگهی',
	'owner_id'                => 'شناسه مالک',
	'created'                 => 'ایجادشده',
	'cid'                     => 'شناسه دسته',
	'pid'                     => 'دسته والد',
	'category'                => 'دسته‌بندی',
	'catorder'                => 'ترتیب',
	'catdeleted'              => 'وضعیت',
	'root'                    => 'دسته ریشه',
    'root_category_help'      => 'دسته‌های ریشه فقط برای سازمان‌دهی زیردسته‌ها استفاده می‌شوند و نمی‌توان مستقیماً در آن‌ها آگهی ثبت کرد. آگهی باید در یک زیردسته منتشر شود.',
	'deletion_succes'         => 'حذف با موفقیت انجام شد.',
    'deletion_fail'           => 'حذف ناموفق بود.',
	'cat_informations'        => 'اطلاعات دسته‌بندی',
	'parent_category'         => 'دسته والد',
	'enable'                  => 'فعال‌سازی',
	'disable'                 => 'غیرفعال‌سازی',
	'edit_label'              => 'ویرایش',
	'create_new_cat'          => 'ساخت دسته‌بندی جدید',
    'insert_new_cat'          => 'ساخت دسته‌بندی جدید',
    'save_fail'               => 'ذخیره‌سازی ناموفق بود.',
    'save_success'            => 'دسته‌بندی با موفقیت ذخیره شد.',
    'seo_metadata'            => 'فراداده SEO',
    'meta_title'              => 'عنوان متا',
    'meta_description'        => 'توضیحات متا',
    'meta_keywords'           => 'کلیدواژه‌های متا',
    'modified'                => 'ویرایش‌شده',
	'online'                  => 'آنلاین',
	'plugin_conf'             => 'پیکربندی افزونه نیازمندی‌ها همچنین در',
	'plugin_doc'              => 'مستندات نصب، ارتقا و استفاده از افزونه نیازمندی‌ها در',
    'publish_all_logged_in'      => 'همه کاربران ثبت‌نام‌شده می‌توانند آگهی منتشر کنند. در حال حاضر عضویت در گروه خاصی لازم نیست.',
    'publish_restricted_group'   => 'انتشار فقط برای گروه زیر مجاز است:',
    'publish_restricted_groups'  => 'انتشار فقط برای %d گروه زیر مجاز است:',
    'child_position'          => 'موقعیت',
    'position_first'          => 'اول',
    'position_after'          => 'بعد از %s',
    'position_last'           => 'آخر',
    'csv_import'              => 'ورود دسته‌بندی‌ها از CSV',
    'csv_documentation'       => 'مستندات ورود CSV',
    'csv_documentation_link'  => 'نحوه آماده‌سازی فایل CSV دسته‌بندی‌ها',
    'csv_doc_intro'           => 'ابزار ورود CSV امکان ساخت درخت کامل دسته‌بندی‌ها را بدون استفاده از شناسه‌های پایگاه داده فراهم می‌کند. فایل را با کلیدهای پایدار آماده کنید، پیش‌نمایش را بررسی کنید و سپس ورود را تأیید کنید.',
    'csv_doc_format_title'    => 'قالب فایل',
    'csv_doc_format_text'     => 'از فایل CSV با کدگذاری UTF-8 و دقیقاً چهار ستون به این ترتیب استفاده کنید. ویرگول و نقطه‌ویرگول به‌عنوان جداکننده پذیرفته می‌شوند.',
    'csv_doc_columns_title'   => 'ستون‌ها',
    'csv_doc_key'             => 'شناسه‌ای پایدار که فقط هنگام ورود استفاده می‌شود. باید در فایل یکتا باشد و می‌تواند شامل حروف کوچک، ارقام، نقطه، زیرخط و خط تیره باشد.',
    'csv_doc_category'        => 'عنوان دسته‌بندی که به کاربران نمایش داده می‌شود. نباید خالی باشد و حداکثر می‌تواند 32 نویسه داشته باشد.',
    'csv_doc_parent'          => 'کلید دسته والد. برای دسته ریشه خالی بگذارید. دسته والد می‌تواند قبل یا بعد از فرزندانش در فایل قرار گیرد.',
    'csv_doc_order'           => 'ترتیب نمایش میان دسته‌هایی که والد مشترک دارند. از عدد صحیح 0 تا 65535 استفاده کنید.',
    'csv_doc_hierarchy_title' => 'دسته‌بندی‌ها و زیردسته‌ها',
    'csv_doc_hierarchy_text'  => 'برای ساخت چند سطح، parent_key را به key ردیف دیگری ارجاع دهید. ابزار ورود ساختار سلسله‌مراتبی را خودکار حل می‌کند، بنابراین مقادیر cid/pid پایگاه داده نباید در فایل CSV باشند.',
    'csv_doc_rules_title'     => 'قواعد مهم',
    'csv_doc_rule_utf8'       => 'فایل را با کدگذاری UTF-8 ذخیره کنید. UTF-8 BOM نیز پذیرفته می‌شود.',
    'csv_doc_rule_header'     => 'ردیف اول باید دقیقاً این باشد: key,category,parent_key,order.',
    'csv_doc_rule_key'        => 'هر key باید یکتا باشد. از یک key برای دو دسته‌بندی استفاده نکنید.',
    'csv_doc_rule_parent'     => 'هر parent_key غیرخالی باید به key موجود در همان فایل CSV ارجاع دهد. خودارجاعی و چرخه‌ها پذیرفته نمی‌شوند.',
    'csv_doc_rule_order'      => 'ردیف‌ها می‌توانند با هر ترتیبی باشند؛ ستون order ترتیب نمایش را تعیین می‌کند، نه ترتیب ورود را.',
    'csv_doc_rule_existing'   => 'اگر دسته‌ای با همان نام زیر همان والد وجود داشته باشد، به‌جای ساخت نسخه تکراری از آن صرف‌نظر می‌شود.',
    'csv_doc_rule_preview'    => 'در مرحله پیش‌نمایش چیزی نوشته نمی‌شود. پیش از ورود تأییدشده، کل فایل دوباره اعتبارسنجی می‌شود.',
    'csv_doc_workflow_title'  => 'روند پیشنهادی',
    'csv_doc_step_template'   => 'الگوی CSV را دانلود کنید.',
    'csv_doc_step_edit'       => 'ردیف‌ها را در صفحه‌گسترده یا ویرایشگر متن ویرایش کنید و سربرگ چهارستونی را حفظ کنید.',
    'csv_doc_step_preview'    => 'فایل را بارگذاری کرده و پیش‌نمایش اعتبارسنجی را بررسی کنید، به‌ویژه رابطه والد/فرزند و وضعیت ساخت/صرف‌نظر.',
    'csv_doc_step_confirm'    => 'فقط زمانی تأیید کنید که پیش‌نمایش درست است. نوشتن در پایگاه داده به‌صورت تراکنشی انجام می‌شود.',
    'csv_template'            => 'دانلود الگوی CSV',
    'csv_help'                => 'دسته‌بندی‌ها و زیردسته‌ها را از فایل CSV با کدگذاری UTF-8 وارد کنید. از key برای شناسایی هر ردیف و از parent_key برای اشاره به والد آن استفاده کنید. parent_key را برای دسته‌های ریشه خالی بگذارید. ویرگول و نقطه‌ویرگول پذیرفته می‌شوند.',
    'csv_file'                => 'فایل CSV',
    'csv_preview'             => 'اعتبارسنجی و پیش‌نمایش',
    'csv_preview_title'       => 'پیش‌نمایش ورود',
    'csv_preview_summary'     => '%d دسته‌بندی ساخته می‌شود؛ از %d دسته‌بندی موجود صرف‌نظر می‌شود.',
    'csv_confirm'             => 'ورود این دسته‌بندی‌ها',
    'csv_key'                 => 'کلید',
    'csv_parent_key'          => 'کلید والد',
    'csv_status'              => 'وضعیت ورود',
    'csv_status_create'       => 'ساخت',
    'csv_status_skip'         => 'از قبل وجود دارد — صرف‌نظر',
    'csv_import_success'      => '%d دسته‌بندی ساخته شد؛ از %d دسته‌بندی موجود صرف‌نظر شد.',
    'csv_errors_title'        => 'فایل CSV قابل ورود نیست:',
    'csv_error_empty'         => 'فایل CSV خالی است.',
    'csv_error_too_large'     => 'فایل CSV بیش از حد بزرگ است (حداکثر 256 KB).',
    'csv_error_read_failed'   => 'فایل CSV قابل خواندن نیست.',
    'csv_error_upload'        => 'بارگذاری فایل CSV ناموفق بود.',
    'csv_error_header'        => 'ردیف اول باید دقیقاً این باشد: key,category,parent_key,order.',
    'csv_error_columns'       => 'خط %d: دقیقاً چهار ستون لازم است.',
    'csv_error_key'           => 'خط %d: کلید "%s" نامعتبر است. از حروف، ارقام، نقطه، زیرخط یا خط تیره استفاده کنید.',
    'csv_error_duplicate_key' => 'خط %d: کلید "%s" تکراری است.',
    'csv_error_category'      => 'خط %d: دسته‌بندی "%s" خالی است یا بیش از 32 نویسه دارد.',
    'csv_error_self_parent'   => 'خط %d: کلید "%s" نمی‌تواند والد خودش باشد.',
    'csv_error_order'         => 'خط %d: ترتیب "%s" نامعتبر است. از عدد صحیح بین 0 و 65535 استفاده کنید.',
    'csv_error_missing_parent'=> 'خط %d: کلید والد "%s" در فایل CSV وجود ندارد.',
    'csv_error_cycle'         => 'خط %d: کلید "%s" بخشی از یک چرخه والد است.',
    'csv_error_database'      => 'پایگاه داده ورود را رد کرد. هیچ ورود ناقصی نگهداری نشد.',
    'csv_error_dependency'    => 'ساختار سلسله‌مراتبی دسته‌بندی‌ها قابل حل نبود. هیچ ورود ناقصی نگهداری نشد.',
    'csv_error_payload'       => 'داده CSV اعتبارسنجی‌شده وجود ندارد یا نامعتبر است.',
    'csv_error_token'         => 'توکن امنیتی منقضی شده است. ورود را دوباره انجام دهید.',
    'csv_error_invalid'       => 'درخواست ورود CSV نامعتبر است.',
	
);

$LANG_CLASSIFIEDS_EMAIL = array(
    'hello'                   => 'سلام',
    'new_ad'                  => 'آگهی جدید شما منتشر شد.',
    'edit_ad'                 => 'آگهی شما به‌روزرسانی شد.',
    'delete_ad'               => 'آگهی شما حذف شد.',
    'expire_ad'               => 'آگهی شما منقضی شده است.',
    'online_for'              => 'مدت نمایش آنلاین',
    'days'                    => 'روز.',
    'price'                   => 'قیمت:',
    'view_ad'                 => 'مشاهده آگهی',
    'manage_ad'               => 'مدیریت آگهی من',
    'my_ads'                  => 'آگهی‌های من',
    'post_new_button'         => 'ثبت آگهی جدید',
    'publisher'               => 'آگهی‌دهنده',
    'automatic_notice'        => 'این پیام به‌صورت خودکار ارسال شده است. لطفاً به این ایمیل پاسخ ندهید.',
    'admin_manage'            => 'مدیریت نیازمندی‌ها',
    'subject_create'          => 'آگهی جدید',
    'subject_edit'            => 'آگهی به‌روزرسانی شد',
    'subject_delete'          => 'آگهی حذف شد',
    'subject_expire'          => 'آگهی منقضی شد',

);


// Messages for the plugin upgrade
$PLG_classifieds_MESSAGE3002 = $LANG32[9]; // "requires a newer version of Geeklog"
$PLG_classifieds_MESSAGE1    = 'Hello world :)';

/**
*   Localization of the Admin Configuration UI
*   @global array $LANG_configsections['classifieds']
*/
$LANG_configsections['classifieds'] = array(
    'label' => 'نیازمندی‌ها',
    'title' => 'پیکربندی نیازمندی‌ها'
);

/**
*   Configuration system subgroup strings
*   @global array $LANG_configsubgroups['classifieds']
*/
$LANG_configsubgroups['classifieds'] = array(
    'sg_main' => 'تنظیمات اصلی'
);

$LANG_tab['classifieds'] = array(
    'tab_main' => 'نیازمندی‌ها'
);

/**
*   Configuration system fieldset names
*   @global array $LANG_fs['classifieds']
*/
$LANG_fs['classifieds'] = array(
    'fs_main'            => 'تنظیمات عمومی',
    'fs_images'          => 'تنظیمات تصاویر',
	'fs_display'         => 'تنظیمات نمایش',
	'fs_email'           => 'تنظیمات ایمیل',
    'fs_permissions'     => 'مجوزهای پیش‌فرض'
 );
 
/**
*   Configuration system prompt strings
*   @global array $LANG_confignames['classifieds']
*/
$LANG_confignames['classifieds'] = array(
    // Main settings
    'active_days' => 'روزهای فعال',
    
	//Images settings
    'max_image_width'  => 'حداکثر عرض تصویر',
	'max_image_height'  => 'حداکثر ارتفاع تصویر',
    'max_image_size'  => 'حداکثر اندازه تصویر',
    'max_images_per_ad'  => 'حداکثر تعداد تصویر برای هر آگهی',

     //Display settings
    'menulabel'  => 'برچسب منو',
    'hide_classifieds_menu'  => 'پنهان کردن منوی نیازمندی‌ها',
    'classifieds_main_header'  => 'سربرگ اصلی',
    'classifieds_main_footer'  => 'پابرگ اصلی',
    'classifieds_edit_header'  => 'سربرگ ویرایشگر',
    'help_page'  => 'صفحه راهنما',
    'currency'  => 'واحد پول',
    'maxPerPage'  => 'حداکثر در هر صفحه',
	'allow_republish' => 'اجازه انتشار دوباره آگهی',

    // Email settings
    'create_ad_email_user'  => 'ارسال ایمیل به کاربر هنگام ساخت آگهی',
    'mod_ad_email_user'  => 'ارسال ایمیل به کاربر هنگام ویرایش آگهی',
    'delete_ad_email_user'  => 'ارسال ایمیل به کاربر هنگام حذف آگهی',
    'expire_ad_email_user'  => 'ارسال ایمیل به کاربر هنگام انقضای آگهی',
	'create_ad_email_admin'  => 'ارسال ایمیل به مدیر هنگام ساخت آگهی',
    'mod_ad_email_admin'  => 'ارسال ایمیل به مدیر هنگام ویرایش آگهی',
    'delete_ad_email_admin'  => 'ارسال ایمیل به مدیر هنگام حذف آگهی',
    'expire_ad_email_admin'  => 'ارسال ایمیل به مدیر هنگام انقضای آگهی',

    //Permissions settings
    'classifieds_login_required'  => 'برای دسترسی به نیازمندی‌ها ورود الزامی است',
    'default_permissions'  => 'مجوزهای پیش‌فرض'
);

/**
*   Configuration system selection strings
*   Note: entries 0, 1, and 12 are the same as in 
*   $LANG_configselects['Core']
*
*   @global array $LANG_configselects['classifieds']
*/
$LANG_configselects['classifieds'] = array(
    3 => array('بله' => 1, 'خیر' => 0),
    12 => array('بدون دسترسی' => 0, 'فقط خواندنی' => 2, 'خواندن و نوشتن' => 3)
);

$LANG_configtooltips['classifieds'] = array(    'active_days' => 'تعداد روزهایی که آگهی فعال می‌ماند تا واجد شرایط اعلان انقضا و انتشار دوباره شود.',
    'max_image_size' => 'حداکثر حجم بارگذاری بر حسب بایت برای یک تصویر آگهی.',
    'max_images_per_ad' => 'حداکثر تعداد تصاویری که می‌توان به یک آگهی پیوست کرد.',
    'allow_republish' => 'اجازه می‌دهد آگهی‌های منقضی واجد شرایط به آگهی فعال جدید کپی شوند و نسخه اصلی در تاریخچه حفظ شود.',
    'classifieds_login_required' => 'در صورت فعال بودن، بازدیدکنندگان باید پیش از دسترسی به نیازمندی‌ها وارد شوند.',
    'default_permissions' => 'مجوزهای ACL گیک‌لاگ که روی محتوای جدید نیازمندی‌ها اعمال می‌شوند.'
);
?>
