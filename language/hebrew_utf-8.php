<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Classifieds Plugin 1.4.0                                                  |
// +---------------------------------------------------------------------------+
// | hebrew_utf-8.php                                                               |
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
    'plugin_name'             => 'מודעות',
    'home'                    => 'ראשי',
	'place_an_ad'             => 'פרסום מודעה',
	'offer'                   => 'הצעה',
	'demand'                  => 'בקשה',
	'offers'                  => 'הצעות',
	'demands'                 => 'בקשות',
	'offers_demands'          => 'הצעות ובקשות',
	'my_ads'                  => 'המודעות שלי',
	'user_ads'                => 'מודעות המשתמש',
	'help'                    => 'עזרה',
	'admin'                   => 'ניהול',
	'access_reserved'         => 'הגישה מוגבלת',
    'you_must_sign_in'        => 'יש להתחבר כדי לגשת למודעה זו.',
	'posted_by'               => 'פורסם על ידי',
	'on'                      => 'בתאריך',
	'at'                      => 'בשעה',
	'contact_advertiser'      => 'יצירת קשר עם המפרסם',
	'send_email'              => 'שליחת דוא"ל',
	'double_point'            => ':',
	'manage_ad'               => 'ניהול המודעה',
	'modify_ad'               => 'עריכת המודעה',
	'delete_ad'               => 'מחיקת המודעה',
	'price'                   => 'מחיר',
	'category'                => 'קטגוריה',
	'postcode'                => 'מיקוד',
	'enlarge_picture'         => 'הגדלת התמונה',
    'previous_picture'        => 'התמונה הקודמת',
    'next_picture'            => 'התמונה הבאה',
    'close_picture'           => 'סגירת מציג התמונות',
	'hits'                    => 'צפיות',
	'no_ad'                   => 'אין תוצאות',
	'no_ad_message'           => 'לא נמצאה מודעה. כדי לפרסם מודעה, לחצו על הכפתור "פרסום מודעה".',
	'report'                  => 'דיווח על מודעה או שימוש לרעה',
	'deleted'                 => 'נמחק',
	'view_all'                => 'הצגת כל המודעות של מפרסם זה',
	'all_ads_from'            => 'כל המודעות שפורסמו על ידי',
	'search_button'           => 'חיפוש',
	'choose_category'         => '-- בחירת קטגוריה --',
	'all_categories'          => 'כל הקטגוריות',
	'profile'                 => 'פרופיל משתמש',
	'classifieds_list'        => 'מודעות',
	'categories_list'         => 'קטגוריות',
	'view_all_ads'            => 'הצגת כל המודעות',
	'under_construction'      => 'בבנייה',
    'image_not_writable'      => 'תיקיית התמונות של המודעות אינה קיימת או אינה ניתנת לכתיבה. יש לתקן זאת לפני השימוש בתוסף.<br' . XHTML . '><br' . XHTML . '>יש ליצור תיקיית משנה classifieds בתוך התיקייה images.',
	'ad-list-active'          => 'מודעה פעילה',
	'ad-list-delete'          => 'מודעה שנמחקה',
	'ad-list-old'             => 'מודעה שפג תוקפה',
	'label-hits'              => 'צפיות',
	'deleted_ad'              => 'מודעה זו אינה זמינה עוד',
	'last_ads'                => 'המודעות האחרונות באתר',
	'ads_not_available'       => 'מודעה זו אינה זמינה',
	'all_ads'                 => 'כל המודעות',
    'profile_no_ad'           => 'אין מודעות פעילות',
);

//Ad form create, edit ,delete
$LANG_CLASSIFIEDS_2 = array(
    'deletion_succes'         => 'המודעה נמחקה בהצלחה.',
    'deletion_fail'           => 'מחיקת המודעה נכשלה.',
	'error'                   => 'אירעה שגיאה!',
	'missing_field'           => 'חסרים שדות חובה:',
    'check_it'                => 'נא לבדוק את הפרטים לפני שליחת המודעה.',
	'save_fail'               => 'השמירה נכשלה.',
	'save_success'            => 'המודעה נשמרה בהצלחה.',
	'message'                 => 'הודעת מערכת',
	'insert_new_ad'           => 'יצירת מודעה חדשה',
	'edit_label'              => 'עריכת מודעה:',
	'your_ad'                 => 'המודעה שלך',
	'category'                => 'קטגוריה',
	'title'                   => 'כותרת המודעה',
	'type'                    => 'סוג',
	'offer'                   => 'הצעה',
	'demand'                  => 'בקשה',
	'choose_category'         => '-- בחירת קטגוריה --',
	'choose_type'             => '-- בחירת סוג מודעה --',
	'text'                    => 'טקסט המודעה',
	'price'                   => 'מחיר',
	'images'                  => 'התמונות שלך',
    'image_upload_label'      => 'הוספת תמונות',
    'image_upload_help'       => 'ניתן לבחור עד %d תמונות בכל פעם (עד %d למודעה).',
    'image_upload_failed'     => 'לא ניתן להעלות או לשנות את גודל התמונה.',
    'image_too_large_no_resizer' => 'התמונה חורגת מ-%d × %d פיקסלים ואין ספריית שינוי גודל זמינה.',
	'your_details'            => 'הפרטים שלך',
	'status'                     => 'סטטוס',
	'choose_status'           => '-- בחירת סטטוס --',
	'private'                 => 'פרטי',
	'professional'            => 'מקצועי',
	'siren'                   => 'מזהה מקצועי',
	'tel'                     => 'טלפון',
	'hide_tel'                 => 'הסתרת מספר הטלפון שלי במודעה',
	'postcode'                => 'מיקוד',
	'city'                    => 'עיר',
	'save_button'             => 'שמירה',
	'delete_button'           => 'מחיקה',
	'required_field'          => 'מציין שדה חובה',
	'validate_button'         => 'אישור',
    'copy_button'             => 'פרסום מחדש של מודעה זו',
	'access_reserved'         => 'הגישה מוגבלת. כדי להשתמש בתכונה זו יש להשתייך לקבוצה:',
);

$LANG_CLASSIFIEDS_ADMIN = array(
    'administration'          => 'ניהול מודעות',
    'configuration'           => 'הגדרות',
    'getting_started_title'    => 'תחילת עבודה',
    'getting_started_intro'    => 'הגדירו את ההגדרות החיוניות, צרו או ייבאו קטגוריות ולאחר מכן בדקו את עמוד המודעות הציבורי.',
    'getting_started_configure'=> 'בדיקת הגדרות המודעות',
    'getting_started_categories'=> 'יצירה או ייבוא של קטגוריות',
    'getting_started_public'   => 'פתיחת עמוד המודעות הציבורי',
    'category_in_use'         => 'לא ניתן למחוק קטגוריה זו כל עוד יש בה מודעות או תתי-קטגוריות.',
    'dashboard_active'         => 'מודעות פעילות',
    'dashboard_expired'        => 'מודעות שפג תוקפן',
    'dashboard_deleted'        => 'מודעות שנמחקו',
    'dashboard_categories'     => 'קטגוריות פעילות',
    'dashboard_manage'         => 'ניהול מודעות',
    'dashboard_storage_warning'=> 'תיקיית התמונות של המודעות חסרה או אינה ניתנת לכתיבה.',
    'clid'                    => 'מזהה מודעה',
	'title'                   => 'כותרת המודעה',
	'owner_id'                => 'מזהה בעלים',
	'created'                 => 'נוצר',
	'cid'                     => 'מזהה קטגוריה',
	'pid'                     => 'קטגוריית אב',
	'category'                => 'קטגוריה',
	'catorder'                => 'סדר',
	'catdeleted'              => 'סטטוס',
	'root'                    => 'קטגוריית שורש',
    'root_category_help'      => 'קטגוריות שורש משמשות רק לארגון תתי-קטגוריות ואינן מקבלות מודעות ישירות. יש לפרסם מודעות בתת-קטגוריה.',
	'deletion_succes'         => 'המחיקה בוצעה בהצלחה.',
    'deletion_fail'           => 'המחיקה נכשלה.',
	'cat_informations'        => 'פרטי קטגוריה',
	'parent_category'         => 'קטגוריית אב',
	'enable'                  => 'הפעלה',
	'disable'                 => 'השבתה',
	'edit_label'              => 'עריכה',
	'create_new_cat'          => 'יצירת קטגוריה חדשה',
    'insert_new_cat'          => 'יצירת קטגוריה חדשה',
    'save_fail'               => 'השמירה נכשלה.',
    'save_success'            => 'הקטגוריה נשמרה בהצלחה.',
    'seo_metadata'            => 'מטא-נתוני SEO',
    'meta_title'              => 'כותרת מטא',
    'meta_description'        => 'תיאור מטא',
    'meta_keywords'           => 'מילות מפתח מטא',
    'modified'                => 'שונה',
	'online'                  => 'מקוון',
	'plugin_conf'             => 'הגדרות תוסף המודעות זמינות גם',
	'plugin_doc'              => 'תיעוד ההתקנה, השדרוג והשימוש בתוסף המודעות זמין',
    'publish_all_logged_in'      => 'כל המשתמשים הרשומים יכולים לפרסם מודעות. כרגע אין צורך בקבוצה מסוימת.',
    'publish_restricted_group'   => 'הפרסום מוגבל לקבוצה הבאה:',
    'publish_restricted_groups'  => 'הפרסום מוגבל ל-%d הקבוצות הבאות:',
    'child_position'          => 'מיקום',
    'position_first'          => 'ראשון',
    'position_after'          => 'אחרי %s',
    'position_last'           => 'אחרון',
    'csv_import'              => 'ייבוא קטגוריות מ-CSV',
    'csv_documentation'       => 'תיעוד ייבוא CSV',
    'csv_documentation_link'  => 'כיצד להכין קובץ CSV של קטגוריות',
    'csv_doc_intro'           => 'מייבא ה-CSV מאפשר ליצור עצי קטגוריות מלאים ללא מזהי מסד נתונים. הכינו את הקובץ עם מפתחות יציבים, בדקו את התצוגה המקדימה ואז אשרו את הייבוא.',
    'csv_doc_format_title'    => 'פורמט קובץ',
    'csv_doc_format_text'     => 'השתמשו בקובץ CSV בקידוד UTF-8 עם ארבע עמודות בדיוק ובסדר זה. פסיקים ונקודה-פסיק מתקבלים כמפרידים.',
    'csv_doc_columns_title'   => 'עמודות',
    'csv_doc_key'             => 'מזהה יציב המשמש רק במהלך הייבוא. עליו להיות ייחודי בקובץ והוא יכול להכיל אותיות קטנות, ספרות, נקודות, קווים תחתונים ומקפים.',
    'csv_doc_category'        => 'שם הקטגוריה המוצג למשתמשים. הוא אינו יכול להיות ריק ויכול להכיל עד 32 תווים.',
    'csv_doc_parent'          => 'המפתח של קטגוריית האב. השאירו ריק עבור קטגוריית שורש. האב יכול להופיע לפני או אחרי ילדיו בקובץ.',
    'csv_doc_order'           => 'סדר התצוגה בין קטגוריות בעלות אותו אב. השתמשו במספר שלם בין 0 ל-65535.',
    'csv_doc_hierarchy_title' => 'קטגוריות ותתי-קטגוריות',
    'csv_doc_hierarchy_text'  => 'כדי ליצור מספר רמות, הפנו את parent_key אל key של שורה אחרת. המייבא פותר את ההיררכיה אוטומטית, לכן ערכי cid/pid של מסד הנתונים אינם צריכים להופיע בקובץ CSV.',
    'csv_doc_rules_title'     => 'כללים חשובים',
    'csv_doc_rule_utf8'       => 'שמרו את הקובץ כ-UTF-8. מתקבל גם BOM של UTF-8.',
    'csv_doc_rule_header'     => 'השורה הראשונה חייבת להיות בדיוק: key,category,parent_key,order.',
    'csv_doc_rule_key'        => 'כל key חייב להיות ייחודי. אין להשתמש שוב באותו key עבור שתי קטגוריות.',
    'csv_doc_rule_parent'     => 'כל parent_key שאינו ריק חייב להפנות ל-key הקיים באותו קובץ CSV. הפניה עצמית ומחזורים נדחים.',
    'csv_doc_rule_order'      => 'השורות יכולות להופיע בכל סדר; העמודה order קובעת את סדר התצוגה ולא את סדר הייבוא.',
    'csv_doc_rule_existing'   => 'אם כבר קיימת קטגוריה בעלת אותו שם תחת אותו אב, היא תידלג במקום להיווצר שוב.',
    'csv_doc_rule_preview'    => 'לא נכתב דבר במהלך התצוגה המקדימה. הקובץ המלא נבדק שוב לפני הייבוא המאושר.',
    'csv_doc_workflow_title'  => 'תהליך עבודה מומלץ',
    'csv_doc_step_template'   => 'הורידו את תבנית ה-CSV.',
    'csv_doc_step_edit'       => 'ערכו את השורות בגיליון אלקטרוני או בעורך טקסט תוך שמירה על כותרת ארבע העמודות.',
    'csv_doc_step_preview'    => 'העלו את הקובץ ובדקו את תצוגת האימות, במיוחד יחסי אב-ילד ומצב יצירה/דילוג.',
    'csv_doc_step_confirm'    => 'אשרו רק כאשר התצוגה המקדימה תקינה. הכתיבה למסד הנתונים מתבצעת כעסקה.',
    'csv_template'            => 'הורדת תבנית CSV',
    'csv_help'                => 'ייבאו קטגוריות ותתי-קטגוריות מקובץ CSV בקידוד UTF-8. השתמשו ב-key לזיהוי כל שורה וב-parent_key להפניה לאב שלה. השאירו parent_key ריק עבור קטגוריות שורש. פסיק ונקודה-פסיק מתקבלים כמפרידים.',
    'csv_file'                => 'קובץ CSV',
    'csv_preview'             => 'אימות ותצוגה מקדימה',
    'csv_preview_title'       => 'תצוגת ייבוא מקדימה',
    'csv_preview_summary'     => '%d קטגוריות ייווצרו; %d קטגוריות קיימות ידולגו.',
    'csv_confirm'             => 'ייבוא הקטגוריות האלה',
    'csv_key'                 => 'מפתח',
    'csv_parent_key'          => 'מפתח אב',
    'csv_status'              => 'מצב ייבוא',
    'csv_status_create'       => 'יצירה',
    'csv_status_skip'         => 'כבר קיים — דילוג',
    'csv_import_success'      => 'נוצרו %d קטגוריות; דולגו %d קטגוריות קיימות.',
    'csv_errors_title'        => 'לא ניתן לייבא את קובץ ה-CSV:',
    'csv_error_empty'         => 'קובץ ה-CSV ריק.',
    'csv_error_too_large'     => 'קובץ ה-CSV גדול מדי (מקסימום 256 KB).',
    'csv_error_read_failed'   => 'לא ניתן לקרוא את קובץ ה-CSV.',
    'csv_error_upload'        => 'העלאת קובץ ה-CSV נכשלה.',
    'csv_error_header'        => 'השורה הראשונה חייבת להיות בדיוק: key,category,parent_key,order.',
    'csv_error_columns'       => 'שורה %d: נדרשות בדיוק ארבע עמודות.',
    'csv_error_key'           => 'שורה %d: המפתח "%s" אינו תקין. השתמשו באותיות, ספרות, נקודות, קווים תחתונים או מקפים.',
    'csv_error_duplicate_key' => 'שורה %d: המפתח "%s" מופיע יותר מפעם אחת.',
    'csv_error_category'      => 'שורה %d: הקטגוריה "%s" ריקה או ארוכה מ-32 תווים.',
    'csv_error_self_parent'   => 'שורה %d: המפתח "%s" אינו יכול להיות האב של עצמו.',
    'csv_error_order'         => 'שורה %d: הסדר "%s" אינו תקין. השתמשו במספר שלם בין 0 ל-65535.',
    'csv_error_missing_parent'=> 'שורה %d: מפתח האב "%s" אינו קיים בקובץ ה-CSV.',
    'csv_error_cycle'         => 'שורה %d: המפתח "%s" הוא חלק ממחזור בהיררכיה.',
    'csv_error_database'      => 'מסד הנתונים דחה את הייבוא. לא נשמר ייבוא חלקי.',
    'csv_error_dependency'    => 'לא ניתן לפתור את היררכיית הקטגוריות. לא נשמר ייבוא חלקי.',
    'csv_error_payload'       => 'נתוני ה-CSV המאומתים חסרים או אינם תקינים.',
    'csv_error_token'         => 'תוקף אסימון האבטחה פג. נסו לבצע את הייבוא שוב.',
    'csv_error_invalid'       => 'בקשת ייבוא ה-CSV אינה תקינה.',
	
);

$LANG_CLASSIFIEDS_EMAIL = array(
    'hello'                   => 'שלום',
    'new_ad'                  => 'המודעה החדשה שלך פורסמה.',
    'edit_ad'                 => 'המודעה שלך עודכנה.',
    'delete_ad'               => 'המודעה שלך הוסרה.',
    'expire_ad'               => 'תוקף המודעה שלך פג.',
    'online_for'              => 'היא תישאר מקוונת למשך',
    'days'                    => 'ימים.',
    'price'                   => 'מחיר:',
    'view_ad'                 => 'צפייה במודעה',
    'manage_ad'               => 'ניהול המודעה שלי',
    'my_ads'                  => 'המודעות שלי',
    'post_new_button'         => 'פרסום מודעה חדשה',
    'publisher'               => 'מפרסם',
    'automatic_notice'        => 'זוהי הודעה אוטומטית. אין להשיב לדוא"ל זה.',
    'admin_manage'            => 'ניהול מודעות',
    'subject_create'          => 'מודעה חדשה',
    'subject_edit'            => 'המודעה עודכנה',
    'subject_delete'          => 'המודעה הוסרה',
    'subject_expire'          => 'תוקף המודעה פג',

);


// Messages for the plugin upgrade
$PLG_classifieds_MESSAGE3002 = $LANG32[9]; // "requires a newer version of Geeklog"
$PLG_classifieds_MESSAGE1    = 'Hello world :)';

/**
*   Localization of the Admin Configuration UI
*   @global array $LANG_configsections['classifieds']
*/
$LANG_configsections['classifieds'] = array(
    'label' => 'מודעות',
    'title' => 'הגדרות מודעות'
);

/**
*   Configuration system subgroup strings
*   @global array $LANG_configsubgroups['classifieds']
*/
$LANG_configsubgroups['classifieds'] = array(
    'sg_main' => 'הגדרות ראשיות'
);

$LANG_tab['classifieds'] = array(
    'tab_main' => 'מודעות'
);

/**
*   Configuration system fieldset names
*   @global array $LANG_fs['classifieds']
*/
$LANG_fs['classifieds'] = array(
    'fs_main'            => 'הגדרות כלליות',
    'fs_images'          => 'הגדרות תמונות',
	'fs_display'         => 'הגדרות תצוגה',
	'fs_email'           => 'הגדרות דוא"ל',
    'fs_permissions'     => 'הרשאות ברירת מחדל'
 );
 
/**
*   Configuration system prompt strings
*   @global array $LANG_confignames['classifieds']
*/
$LANG_confignames['classifieds'] = array(
    // Main settings
    'active_days' => 'ימי פעילות',
    
	//Images settings
    'max_image_width'  => 'רוחב תמונה מרבי',
	'max_image_height'  => 'גובה תמונה מרבי',
    'max_image_size'  => 'גודל תמונה מרבי',
    'max_images_per_ad'  => 'מספר תמונות מרבי למודעה',

     //Display settings
    'menulabel'  => 'תווית תפריט',
    'hide_classifieds_menu'  => 'הסתרת תפריט המודעות',
    'classifieds_main_header'  => 'כותרת ראשית',
    'classifieds_main_footer'  => 'כותרת תחתונה ראשית',
    'classifieds_edit_header'  => 'כותרת עורך',
    'help_page'  => 'עמוד עזרה',
    'currency'  => 'מטבע',
    'maxPerPage'  => 'מקסימום לעמוד',
	'allow_republish' => 'אפשר פרסום מחדש של מודעות',

    // Email settings
    'create_ad_email_user'  => 'שליחת דוא"ל למשתמש בעת יצירת מודעה',
    'mod_ad_email_user'  => 'שליחת דוא"ל למשתמש בעת שינוי מודעה',
    'delete_ad_email_user'  => 'שליחת דוא"ל למשתמש בעת מחיקת מודעה',
    'expire_ad_email_user'  => 'שליחת דוא"ל למשתמש בעת פקיעת מודעה',
	'create_ad_email_admin'  => 'שליחת דוא"ל למנהל בעת יצירת מודעה',
    'mod_ad_email_admin'  => 'שליחת דוא"ל למנהל בעת שינוי מודעה',
    'delete_ad_email_admin'  => 'שליחת דוא"ל למנהל בעת מחיקת מודעה',
    'expire_ad_email_admin'  => 'שליחת דוא"ל למנהל בעת פקיעת מודעה',

    //Permissions settings
    'classifieds_login_required'  => 'נדרשת התחברות כדי לגשת למודעות',
    'default_permissions'  => 'הרשאות ברירת מחדל'
);

/**
*   Configuration system selection strings
*   Note: entries 0, 1, and 12 are the same as in 
*   $LANG_configselects['Core']
*
*   @global array $LANG_configselects['classifieds']
*/
$LANG_configselects['classifieds'] = array(
    3 => array('כן' => 1, 'לא' => 0),
    12 => array('אין גישה' => 0, 'קריאה בלבד' => 2, 'קריאה וכתיבה' => 3)
);

$LANG_configtooltips['classifieds'] = array(    'active_days' => 'מספר הימים שבהם מודעה נשארת פעילה לפני שניתן להודיע על פקיעתה ולפרסם אותה מחדש.',
    'max_image_size' => 'גודל ההעלאה המרבי בבתים לתמונת מודעה אחת.',
    'max_images_per_ad' => 'מספר התמונות המרבי שניתן לצרף למודעה אחת.',
    'allow_republish' => 'מאפשר להעתיק מודעות שפג תוקפן למודעה פעילה חדשה תוך שמירת המקור בהיסטוריה.',
    'classifieds_login_required' => 'כאשר האפשרות מופעלת, מבקרים חייבים להתחבר לפני גישה למודעות.',
    'default_permissions' => 'הרשאות ACL של Geeklog המוחלות על תוכן מודעות חדש.'
);
?>
