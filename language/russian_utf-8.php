<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Classifieds Plugin 1.4.0                                                  |
// +---------------------------------------------------------------------------+
// | russian_utf-8.php                                                               |
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
    'plugin_name'             => 'Объявления',
    'home'                    => 'Главная',
	'place_an_ad'             => 'Разместить объявление',
	'offer'                   => 'Предложение',
	'demand'                  => 'Спрос',
	'offers'                  => 'Предложения',
	'demands'                 => 'Запросы',
	'offers_demands'          => 'Предложения и запросы',
	'my_ads'                  => 'Мои объявления',
	'user_ads'                => 'Объявления пользователя',
	'help'                    => 'Помощь',
	'admin'                   => 'Администрирование',
	'access_reserved'         => 'Доступ ограничен',
    'you_must_sign_in'        => 'Чтобы открыть это объявление, необходимо войти в систему.',
	'posted_by'               => 'Опубликовано',
	'on'                      => '',
	'at'                      => 'в',
	'contact_advertiser'      => 'Связаться с автором',
	'send_email'              => 'Отправить письмо',
	'double_point'            => ':',
	'manage_ad'               => 'Управление объявлением',
	'modify_ad'               => 'Изменить объявление',
	'delete_ad'               => 'Удалить объявление',
	'price'                   => 'Цена',
	'category'                => 'Категория',
	'postcode'                => 'Почтовый индекс',
	'enlarge_picture'         => 'Увеличить изображение',
    'previous_picture'        => 'Предыдущее изображение',
    'next_picture'            => 'Следующее изображение',
    'close_picture'           => 'Закрыть просмотр изображений',
	'hits'                    => 'просмотров',
	'no_ad'                   => 'Нет результатов',
	'no_ad_message'           => 'Объявления не найдены. Чтобы разместить объявление, нажмите кнопку «Разместить объявление».',
	'report'                  => 'Пожаловаться на объявление или нарушение',
	'deleted'                 => 'УДАЛЕНО',
	'view_all'                => 'Показать все объявления этого автора',
	'all_ads_from'            => 'Все объявления автора',
	'search_button'           => 'Поиск',
	'choose_category'         => '-- Выберите категорию --',
	'all_categories'          => 'Все категории',
	'profile'                 => 'Профиль пользователя',
	'classifieds_list'        => 'Объявления',
	'categories_list'         => 'Категории',
	'view_all_ads'            => 'Показать все объявления',
	'under_construction'      => 'В разработке',
    'image_not_writable'      => 'Папка изображений объявлений отсутствует или недоступна для записи. Исправьте эту проблему перед использованием плагина.<br' . XHTML . '><br' . XHTML . '>Создайте подпапку classifieds в папке images.',
	'ad-list-active'          => 'Активное объявление',
	'ad-list-delete'          => 'Удалённое объявление',
	'ad-list-old'             => 'Просроченное объявление',
	'label-hits'              => 'Просмотры',
	'deleted_ad'              => 'Это объявление больше недоступно',
	'last_ads'                => 'Последние объявления на сайте',
	'ads_not_available'       => 'Это объявление недоступно',
	'all_ads'                 => 'Все объявления',
    'profile_no_ad'           => 'Нет активных объявлений',
);

//Ad form create, edit ,delete
$LANG_CLASSIFIEDS_2 = array(
    'deletion_succes'         => 'Объявление успешно удалено.',
    'deletion_fail'           => 'Не удалось удалить объявление.',
	'error'                   => 'Произошла ошибка!',
	'missing_field'           => 'Не заполнены обязательные поля:',
    'check_it'                => 'Проверьте данные перед отправкой объявления.',
	'save_fail'               => 'Не удалось сохранить.',
	'save_success'            => 'Объявление успешно сохранено.',
	'message'                 => 'Системное сообщение',
	'insert_new_ad'           => 'Создать объявление',
	'edit_label'              => 'Редактирование объявления:',
	'your_ad'                 => 'Ваше объявление',
	'category'                => 'Категория',
	'title'                   => 'Заголовок объявления',
	'type'                    => 'Тип',
	'offer'                   => 'Предложение',
	'demand'                  => 'Спрос',
	'choose_category'         => '-- Выберите категорию --',
	'choose_type'             => '-- Выберите тип объявления --',
	'text'                    => 'Текст объявления',
	'price'                   => 'Цена',
	'images'                  => 'Ваши изображения',
    'image_upload_label'      => 'Добавить изображения',
    'image_upload_help'       => 'Выберите до %d изображений за один раз (не более %d на объявление).',
    'image_upload_failed'     => 'Не удалось загрузить или изменить размер изображения.',
    'image_too_large_no_resizer' => 'Размер изображения превышает %d × %d пикселей, а библиотека изменения размера недоступна.',
	'your_details'            => 'Ваши данные',
	'status'                     => 'Статус',
	'choose_status'           => '-- Выберите статус --',
	'private'                 => 'Частное лицо',
	'professional'            => 'Профессионал',
	'siren'                   => 'ID организации',
	'tel'                     => 'Тел.',
	'hide_tel'                 => 'Скрыть мой телефон в объявлении',
	'postcode'                => 'Почтовый индекс',
	'city'                    => 'Город',
	'save_button'             => 'Сохранить',
	'delete_button'           => 'Удалить',
	'required_field'          => 'Обязательное поле',
	'validate_button'         => 'Подтвердить',
    'copy_button'             => 'Опубликовать объявление повторно',
	'access_reserved'         => 'Доступ ограничен. Для использования этой функции необходимо состоять в группе:',
);

$LANG_CLASSIFIEDS_ADMIN = array(
    'administration'          => 'Администрирование объявлений',
    'configuration'           => 'Настройки',
    'getting_started_title'    => 'Начало работы',
    'getting_started_intro'    => 'Настройте основные параметры, создайте или импортируйте категории, затем проверьте публичную страницу объявлений.',
    'getting_started_configure'=> 'Проверить настройки объявлений',
    'getting_started_categories'=> 'Создать или импортировать категории',
    'getting_started_public'   => 'Открыть публичную страницу объявлений',
    'category_in_use'         => 'Категорию нельзя удалить, пока в ней есть объявления или дочерние категории.',
    'dashboard_active'         => 'Активные объявления',
    'dashboard_expired'        => 'Просроченные объявления',
    'dashboard_deleted'        => 'Удалённые объявления',
    'dashboard_categories'     => 'Активные категории',
    'dashboard_manage'         => 'Управление объявлениями',
    'dashboard_storage_warning'=> 'Каталог изображений объявлений отсутствует или недоступен для записи.',
    'clid'                    => 'ID объявления',
	'title'                   => 'Заголовок объявления',
	'owner_id'                => 'ID владельца',
	'created'                 => 'Создано',
	'cid'                     => 'ID кат.',
	'pid'                     => 'Родительская категория',
	'category'                => 'Категория',
	'catorder'                => 'Порядок',
	'catdeleted'              => 'Статус',
	'root'                    => 'Корневая категория',
    'root_category_help'      => 'Корневые категории используются только для организации дочерних категорий и не принимают объявления напрямую. Объявления нужно публиковать в дочерней категории.',
	'deletion_succes'         => 'Удаление выполнено успешно.',
    'deletion_fail'           => 'Не удалось выполнить удаление.',
	'cat_informations'        => 'Сведения о категории',
	'parent_category'         => 'Родительская категория',
	'enable'                  => 'Включить',
	'disable'                 => 'Отключить',
	'edit_label'              => 'Редактирование',
	'create_new_cat'          => 'Создать новую категорию',
    'insert_new_cat'          => 'Создать новую категорию',
    'save_fail'               => 'Не удалось сохранить.',
    'save_success'            => 'Категория успешно сохранена.',
    'seo_metadata'            => 'SEO-метаданные',
    'meta_title'              => 'Мета-заголовок',
    'meta_description'        => 'Мета-описание',
    'meta_keywords'           => 'Мета-ключевые слова',
    'modified'                => 'Изменено',
	'online'                  => 'онлайн',
	'plugin_conf'             => 'Настройки плагина объявлений также доступны',
	'plugin_doc'              => 'Документация по установке, обновлению и использованию плагина объявлений доступна',
    'publish_all_logged_in'      => 'Все зарегистрированные пользователи могут публиковать объявления. Специальная группа не требуется.',
    'publish_restricted_group'   => 'Публикация разрешена только следующей группе:',
    'publish_restricted_groups'  => 'Публикация разрешена только следующим %d группам:',
    'child_position'          => 'Позиция',
    'position_first'          => 'Первая',
    'position_after'          => 'После %s',
    'position_last'           => 'Последняя',
    'csv_import'              => 'Импорт категорий из CSV',
    'csv_documentation'       => 'Документация по импорту CSV',
    'csv_documentation_link'  => 'Как подготовить CSV-файл категорий',
    'csv_doc_intro'           => 'Импорт CSV позволяет создавать полные деревья категорий без ID базы данных. Подготовьте файл со стабильными ключами, проверьте предварительный просмотр и подтвердите импорт.',
    'csv_doc_format_title'    => 'Формат файла',
    'csv_doc_format_text'     => 'Используйте CSV-файл UTF-8 ровно с четырьмя столбцами в указанном порядке. В качестве разделителей принимаются запятые и точки с запятой.',
    'csv_doc_columns_title'   => 'Столбцы',
    'csv_doc_key'             => 'Стабильный идентификатор, используемый только при импорте. Он должен быть уникальным в файле и может содержать строчные буквы, цифры, точки, подчёркивания и дефисы.',
    'csv_doc_category'        => 'Название категории для пользователей. Не может быть пустым и должно содержать не более 32 символов.',
    'csv_doc_parent'          => 'Ключ родительской категории. Для корневой категории оставьте пустым. Родитель может находиться в файле до или после дочерних элементов.',
    'csv_doc_order'           => 'Порядок отображения категорий с одним родителем. Используйте целое число от 0 до 65535.',
    'csv_doc_hierarchy_title' => 'Категории и подкатегории',
    'csv_doc_hierarchy_text'  => 'Для создания нескольких уровней укажите в parent_key ключ key другой строки. Импортёр автоматически построит иерархию, поэтому значения cid/pid базы данных не должны находиться в CSV.',
    'csv_doc_rules_title'     => 'Важные правила',
    'csv_doc_rule_utf8'       => 'Сохраните файл в UTF-8. Допускается BOM UTF-8.',
    'csv_doc_rule_header'     => 'Первая строка должна быть точно: key,category,parent_key,order.',
    'csv_doc_rule_key'        => 'Каждый key должен быть уникальным. Не используйте один ключ для двух категорий.',
    'csv_doc_rule_parent'     => 'Каждый непустой parent_key должен ссылаться на key в том же CSV-файле. Самоссылки и циклы отклоняются.',
    'csv_doc_rule_order'      => 'Строки могут идти в любом порядке; столбец order задаёт порядок отображения, а не импорта.',
    'csv_doc_rule_existing'   => 'Если категория с таким именем уже существует у того же родителя, она пропускается без создания дубликата.',
    'csv_doc_rule_preview'    => 'Во время предварительного просмотра данные не записываются. Перед подтверждённым импортом файл проверяется повторно.',
    'csv_doc_workflow_title'  => 'Рекомендуемый порядок работы',
    'csv_doc_step_template'   => 'Скачайте шаблон CSV.',
    'csv_doc_step_edit'       => 'Измените строки в таблице или текстовом редакторе, сохранив заголовок из четырёх столбцов.',
    'csv_doc_step_preview'    => 'Загрузите файл и проверьте предварительную валидацию, особенно связи родителей и статусы создания/пропуска.',
    'csv_doc_step_confirm'    => 'Подтверждайте импорт только после проверки предварительного просмотра. Запись в базу данных выполняется транзакционно.',
    'csv_template'            => 'Скачать шаблон CSV',
    'csv_help'                => 'Импортируйте категории и подкатегории из CSV UTF-8. Используйте key для каждой строки и parent_key для ссылки на родителя. Для корневых категорий оставьте parent_key пустым. Разделителями могут быть запятая и точка с запятой.',
    'csv_file'                => 'CSV-файл',
    'csv_preview'             => 'Проверить и показать предварительный просмотр',
    'csv_preview_title'       => 'Предварительный просмотр импорта',
    'csv_preview_summary'     => 'Будет создано %d категорий; %d существующих категорий будет пропущено.',
    'csv_confirm'             => 'Импортировать эти категории',
    'csv_key'                 => 'Ключ',
    'csv_parent_key'          => 'Родительский ключ',
    'csv_status'              => 'Статус импорта',
    'csv_status_create'       => 'Создать',
    'csv_status_skip'         => 'Уже существует — пропустить',
    'csv_import_success'      => 'Создано %d категорий; пропущено %d существующих категорий.',
    'csv_errors_title'        => 'CSV-файл нельзя импортировать:',
    'csv_error_empty'         => 'CSV-файл пуст.',
    'csv_error_too_large'     => 'CSV-файл слишком большой (максимум 256 КБ).',
    'csv_error_read_failed'   => 'Не удалось прочитать CSV-файл.',
    'csv_error_upload'        => 'Не удалось загрузить CSV-файл.',
    'csv_error_header'        => 'Первая строка должна быть точно: key,category,parent_key,order.',
    'csv_error_columns'       => 'Строка %d: требуется ровно четыре столбца.',
    'csv_error_key'           => 'Строка %d: недопустимый ключ "%s". Используйте буквы, цифры, точки, подчёркивания или дефисы.',
    'csv_error_duplicate_key' => 'Строка %d: повторяющийся ключ "%s".',
    'csv_error_category'      => 'Строка %d: категория "%s" пуста или длиннее 32 символов.',
    'csv_error_self_parent'   => 'Строка %d: ключ "%s" не может быть собственным родителем.',
    'csv_error_order'         => 'Строка %d: недопустимый порядок "%s". Используйте целое число от 0 до 65535.',
    'csv_error_missing_parent'=> 'Строка %d: родительский ключ "%s" отсутствует в CSV-файле.',
    'csv_error_cycle'         => 'Строка %d: ключ "%s" входит в цикл иерархии.',
    'csv_error_database'      => 'База данных отклонила импорт. Частичный импорт не сохранён.',
    'csv_error_dependency'    => 'Не удалось построить иерархию категорий. Частичный импорт не сохранён.',
    'csv_error_payload'       => 'Проверенные данные CSV отсутствуют или недействительны.',
    'csv_error_token'         => 'Срок действия токена безопасности истёк. Повторите импорт.',
    'csv_error_invalid'       => 'Запрос на импорт CSV недействителен.',
	
);

$LANG_CLASSIFIEDS_EMAIL = array(
    'hello'                   => 'Здравствуйте',
    'new_ad'                  => 'Ваше новое объявление опубликовано.',
    'edit_ad'                 => 'Ваше объявление обновлено.',
    'delete_ad'               => 'Ваше объявление удалено.',
    'expire_ad'               => 'Срок действия вашего объявления истёк.',
    'online_for'              => 'Оно останется онлайн в течение',
    'days'                    => 'дн.',
    'price'                   => 'Цена:',
    'view_ad'                 => 'Открыть объявление',
    'manage_ad'               => 'Управлять моим объявлением',
    'my_ads'                  => 'Мои объявления',
    'post_new_button'         => 'Разместить новое объявление',
    'publisher'               => 'Автор',
    'automatic_notice'        => 'Это автоматическое сообщение. Не отвечайте на него.',
    'admin_manage'            => 'Управление объявлениями',
    'subject_create'          => 'Новое объявление',
    'subject_edit'            => 'Объявление обновлено',
    'subject_delete'          => 'Объявление удалено',
    'subject_expire'          => 'Объявление просрочено',

);


// Messages for the plugin upgrade
$PLG_classifieds_MESSAGE3002 = $LANG32[9]; // "requires a newer version of Geeklog"
$PLG_classifieds_MESSAGE1    = 'Hello world :)';

/**
*   Localization of the Admin Configuration UI
*   @global array $LANG_configsections['classifieds']
*/
$LANG_configsections['classifieds'] = array(
    'label' => 'Объявления',
    'title' => 'Настройки объявлений'
);

/**
*   Configuration system subgroup strings
*   @global array $LANG_configsubgroups['classifieds']
*/
$LANG_configsubgroups['classifieds'] = array(
    'sg_main' => 'Основные настройки'
);

$LANG_tab['classifieds'] = array(
    'tab_main' => 'Объявления'
);

/**
*   Configuration system fieldset names
*   @global array $LANG_fs['classifieds']
*/
$LANG_fs['classifieds'] = array(
    'fs_main'            => 'Общие настройки',
    'fs_images'          => 'Настройки изображений',
	'fs_display'         => 'Настройки отображения',
	'fs_email'           => 'Настройки электронной почты',
    'fs_permissions'     => 'Права по умолчанию'
 );
 
/**
*   Configuration system prompt strings
*   @global array $LANG_confignames['classifieds']
*/
$LANG_confignames['classifieds'] = array(
    // Main settings
    'active_days' => 'Дни активности',
    
	//Images settings
    'max_image_width'  => 'Максимальная ширина изображения',
	'max_image_height'  => 'Максимальная высота изображения',
    'max_image_size'  => 'Максимальный размер изображения',
    'max_images_per_ad'  => 'Максимум изображений на объявление',

     //Display settings
    'menulabel'  => 'Название меню',
    'hide_classifieds_menu'  => 'Скрыть меню объявлений',
    'classifieds_main_header'  => 'Основной заголовок',
    'classifieds_main_footer'  => 'Основной нижний колонтитул',
    'classifieds_edit_header'  => 'Заголовок редактора',
    'help_page'  => 'Страница помощи',
    'currency'  => 'Валюта',
    'maxPerPage'  => 'Максимум на странице',
	'allow_republish' => 'Разрешить повторную публикацию',

    // Email settings
    'create_ad_email_user'  => 'Письмо пользователю при создании объявления',
    'mod_ad_email_user'  => 'Письмо пользователю при изменении объявления',
    'delete_ad_email_user'  => 'Письмо пользователю при удалении объявления',
    'expire_ad_email_user'  => 'Письмо пользователю при истечении объявления',
	'create_ad_email_admin'  => 'Письмо администратору при создании объявления',
    'mod_ad_email_admin'  => 'Письмо администратору при изменении объявления',
    'delete_ad_email_admin'  => 'Письмо администратору при удалении объявления',
    'expire_ad_email_admin'  => 'Письмо администратору при истечении объявления',

    //Permissions settings
    'classifieds_login_required'  => 'Для доступа к объявлениям требуется вход',
    'default_permissions'  => 'Права по умолчанию'
);

/**
*   Configuration system selection strings
*   Note: entries 0, 1, and 12 are the same as in 
*   $LANG_configselects['Core']
*
*   @global array $LANG_configselects['classifieds']
*/
$LANG_configselects['classifieds'] = array(
    3 => array('Да' => 1, 'Нет' => 0),
    12 => array('Нет доступа' => 0, 'Только чтение' => 2, 'Чтение и запись' => 3)
);

$LANG_configtooltips['classifieds'] = array(    'active_days' => 'Количество дней, в течение которых объявление остаётся активным до уведомления об истечении и возможности повторной публикации.',
    'max_image_size' => 'Максимальный размер загрузки в байтах для одного изображения объявления.',
    'max_images_per_ad' => 'Максимальное количество изображений для одного объявления.',
    'allow_republish' => 'Позволяет копировать подходящие просроченные объявления в новые активные, сохраняя исходную версию в истории.',
    'classifieds_login_required' => 'Если включено, посетители должны войти в систему перед доступом к объявлениям.',
    'default_permissions' => 'Права ACL Geeklog для новых материалов объявлений.'
);
?>
