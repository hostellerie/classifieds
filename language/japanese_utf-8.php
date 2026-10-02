<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Classifieds Plugin 1.4.0                                                  |
// +---------------------------------------------------------------------------+
// | japanese_utf-8.php                                                               |
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
    'plugin_name'             => 'クラシファイド',
    'home'                    => 'ホーム',
	'place_an_ad'             => '広告を掲載',
	'offer'                   => '提供',
	'demand'                  => '募集',
	'offers'                  => '提供',
	'demands'                 => '募集',
	'offers_demands'          => '提供と募集',
	'my_ads'                  => '自分の広告',
	'user_ads'                => 'ユーザーの広告',
	'help'                    => 'ヘルプ',
	'admin'                   => '管理',
	'access_reserved'         => 'アクセス制限',
    'you_must_sign_in'        => 'この広告を見るにはログインしてください。',
	'posted_by'               => '投稿者',
	'日付'                      => '日付',
	'時刻'                      => '時刻',
	'contact_advertiser'      => '広告主に連絡',
	'send_email'              => 'メールを送信',
	'double_point'            => ':',
	'manage_ad'               => '広告を管理',
	'modify_ad'               => '広告を編集',
	'delete_ad'               => '広告を削除',
	'price'                   => '価格',
	'category'                => 'カテゴリー',
	'postcode'                => '郵便番号',
	'enlarge_picture'         => '画像を拡大',
    'previous_picture'        => '前の画像',
    'next_picture'            => '次の画像',
    'close_picture'           => '画像ビューアを閉じる',
	'hits'                    => '閲覧',
	'no_ad'                   => '結果なし',
	'no_ad_message'           => '広告が見つかりませんでした。掲載するには「広告を掲載」ボタンを押してください。',
	'report'                  => '広告または不正利用を報告',
	'deleted'                 => '削除済み',
	'view_all'                => 'この広告主のすべての広告を表示',
	'all_ads_from'            => '投稿者のすべての広告',
	'search_button'           => '検索',
	'choose_category'         => '-- カテゴリーを選択 --',
	'all_categories'          => 'すべてのカテゴリー',
	'profile'                 => 'ユーザープロフィール',
	'classifieds_list'        => '広告',
	'categories_list'         => 'カテゴリー',
	'view_all_ads'            => 'すべての広告を表示',
	'under_construction'      => '準備中',
    'image_not_writable'      => 'The classifieds images folder does not exists or is not writable. You must check this issue before using the classifieds plugin.<br' . XHTML . '><br' . XHTML . '>Please create a classifieds sub folder within the images folder.',
	'ad-list-active'          => '有効な広告',
	'ad-list-delete'          => '削除済み広告',
	'ad-list-old'             => '期限切れ広告',
	'label-hits'              => '閲覧数',
	'deleted_ad'              => 'この広告は現在利用できません',
	'last_ads'                => 'サイトの最新広告',
	'ads_not_available'       => 'この広告は利用できません',
	'all_ads'                 => 'すべての広告',
    'profile_no_ad'           => '有効な広告はありません',
);

//Ad form create, edit ,delete
$LANG_CLASSIFIEDS_2 = array(
    'deletion_succes'         => '広告を削除しました。',
    'deletion_fail'           => '広告を削除できませんでした。',
	'error'                   => 'エラーが発生しました。',
	'missing_field'           => '必須項目が不足しています:',
    'check_it'                => '広告を送信する前に内容を確認してください。',
	'save_fail'               => '保存できませんでした。',
	'save_success'            => '広告を保存しました。',
	'message'                 => 'システムメッセージ',
	'insert_new_ad'           => '新しい広告を作成',
	'edit_label'              => '広告を編集:',
	'your_ad'                 => 'あなたの広告',
	'category'                => 'カテゴリー',
	'title'                   => '広告タイトル',
	'type'                    => '種類',
	'offer'                   => '提供',
	'demand'                  => '募集',
	'choose_category'         => '-- カテゴリーを選択 --',
	'choose_type'             => '-- 広告の種類を選択 --',
	'text'                    => '広告本文',
	'price'                   => '価格',
	'images'                  => '画像',
    'image_upload_label'      => '画像を追加',
    'image_upload_help'       => '一度に最大%d枚の画像を選択できます（広告1件につき最大%d枚）。',
    'image_upload_failed'     => '画像をアップロードまたはリサイズできませんでした。',
    'image_too_large_no_resizer' => '画像が%d × %dピクセルを超えており、利用可能な画像リサイズライブラリがありません。',
	'your_details'            => '連絡先情報',
	'status'                     => 'ステータス',
	'choose_status'           => '-- ステータスを選択 --',
	'private'                 => '個人',
	'professional'            => '事業者',
	'siren'                   => '事業者ID',
	'tel'                     => '電話',
	'hide_tel'                 => '広告に電話番号を表示しない',
	'postcode'                => '郵便番号',
	'city'                    => '市区町村',
	'save_button'             => '保存',
	'delete_button'           => '削除',
	'required_field'          => '必須項目を示します',
	'validate_button'         => '確認',
    'copy_button'             => 'この広告を再掲載',
	'access_reserved'         => 'アクセス制限。この機能を利用するには次のグループに所属する必要があります:',
);

$LANG_CLASSIFIEDS_ADMIN = array(
    'administration'          => 'クラシファイド管理',
    'configuration'           => '設定',
    'getting_started_title'    => 'はじめに',
    'getting_started_intro'    => '基本設定を行い、カテゴリーを作成またはインポートしてから、公開クラシファイドページを確認してください。',
    'getting_started_configure'=> 'クラシファイド設定を確認',
    'getting_started_categories'=> 'カテゴリーを作成またはインポート',
    'getting_started_public'   => '公開クラシファイドページを開く',
    'category_in_use'         => '広告または子カテゴリーが残っているため、このカテゴリーは削除できません。',
    'dashboard_active'         => '有効な広告',
    'dashboard_expired'        => '期限切れ広告',
    'dashboard_deleted'        => '削除済み広告',
    'dashboard_categories'     => '有効なカテゴリー',
    'dashboard_manage'         => 'クラシファイドを管理',
    'dashboard_storage_warning'=> 'クラシファイド画像ディレクトリが存在しないか、書き込みできません。',
    'clid'                    => '広告ID',
	'title'                   => '広告タイトル',
	'owner_id'                => '所有者ID',
	'created'                 => '作成日',
	'cid'                     => 'カテゴリーID',
	'pid'                     => '親カテゴリー',
	'category'                => 'カテゴリー',
	'catorder'                => '表示順',
	'catdeleted'              => 'ステータス',
	'root'                    => 'ルートカテゴリー',
    'root_category_help'      => 'ルートカテゴリーは子カテゴリーの整理専用で、広告を直接掲載できません。広告は子カテゴリーに掲載してください。',
	'deletion_succes'         => '削除しました。',
    'deletion_fail'           => '削除できませんでした。',
	'cat_informations'        => 'カテゴリー情報',
	'parent_category'         => '親カテゴリー',
	'enable'                  => '有効化',
	'disable'                 => '無効化',
	'edit_label'              => '編集中',
	'create_new_cat'          => '新しいカテゴリーを作成',
    'insert_new_cat'          => '新しいカテゴリーを作成',
    'save_fail'               => '保存できませんでした。',
    'save_success'            => 'カテゴリーを保存しました。',
    'seo_metadata'            => 'SEOメタデータ',
    'meta_title'              => 'メタタイトル',
    'meta_description'        => 'メタディスクリプション',
    'meta_keywords'           => 'メタキーワード',
    'modified'                => '更新日',
	'オンライン'                  => 'オンライン',
	'plugin_conf'             => 'クラシファイドプラグインの設定はこちらにもあります',
	'plugin_doc'              => 'クラシファイドプラグインのインストール、更新、使用方法のドキュメントはこちらです',
    'publish_all_logged_in'      => '登録ユーザーはすべて広告を掲載できます。現在、特定のグループ所属は不要です。',
    'publish_restricted_group'   => '掲載は次のグループに制限されています:',
    'publish_restricted_groups'  => '掲載は次の%dグループに制限されています:',
    'child_position'          => '位置',
    'position_first'          => '最初',
    'position_after'          => '%sの後',
    'position_last'           => '最後',
    'csv_import'              => 'CSVからカテゴリーをインポート',
    'csv_documentation'       => 'CSVインポートのドキュメント',
    'csv_documentation_link'  => 'カテゴリーCSVファイルの作成方法',
    'csv_doc_intro'           => 'CSVインポーターでは、データベースIDを使わずに完全なカテゴリーツリーを作成できます。安定したキーでファイルを準備し、プレビューを検証してからインポートを確定してください。',
    'csv_doc_format_title'    => 'ファイル形式',
    'csv_doc_format_text'     => 'UTF-8のCSVファイルを使用し、次の順序で正確に4列にしてください。区切り文字にはカンマまたはセミコロンを使用できます。',
    'csv_doc_columns_title'   => '列',
    'csv_doc_key'             => 'インポート時のみ使用する固定識別子です。ファイル内で一意である必要があり、小文字、数字、ピリオド、アンダースコア、ハイフンを使用できます。',
    'csv_doc_category'        => 'ユーザーに表示するカテゴリー名です。空欄にはできず、最大32文字です。',
    'csv_doc_parent'          => '親カテゴリーのキーです。ルートカテゴリーの場合は空欄にします。親はファイル内で子より前でも後でも構いません。',
    'csv_doc_order'           => '同じ親を持つカテゴリー間の表示順です。0から65535の整数を使用します。',
    'csv_doc_hierarchy_title' => 'カテゴリーとサブカテゴリー',
    'csv_doc_hierarchy_text'  => '複数階層を作成するには、parent_keyから別行のkeyを参照します。インポーターが階層を自動解決するため、データベースのcid/pid値をCSVに入れないでください。',
    'csv_doc_rules_title'     => '重要なルール',
    'csv_doc_rule_utf8'       => 'ファイルはUTF-8で保存してください。UTF-8 BOMも使用できます。',
    'csv_doc_rule_header'     => '1行目は正確に key,category,parent_key,order としてください。',
    'csv_doc_rule_key'        => '各keyは一意でなければなりません。2つのカテゴリーで同じkeyを再利用しないでください。',
    'csv_doc_rule_parent'     => '空でないparent_keyは、同じCSVファイル内に存在するkeyを参照する必要があります。自己参照や循環参照は拒否されます。',
    'csv_doc_rule_order'      => '行の順序は任意です。order列は表示順を制御し、インポート順ではありません。',
    'csv_doc_rule_existing'   => '同じ親の下に同名カテゴリーがすでに存在する場合、重複作成せずスキップします。',
    'csv_doc_rule_preview'    => 'プレビュー中は何も書き込まれません。確定インポート前にファイル全体を再検証します。',
    'csv_doc_workflow_title'  => '推奨手順',
    'csv_doc_step_template'   => 'CSVテンプレートをダウンロードします。',
    'csv_doc_step_edit'       => '4列のヘッダーを維持したまま、表計算ソフトまたはテキストエディターで行を編集します。',
    'csv_doc_step_preview'    => 'ファイルをアップロードし、親子関係と作成/スキップ状態を中心に検証プレビューを確認します。',
    'csv_doc_step_confirm'    => 'プレビューが正しい場合のみ確定してください。データベースへの書き込みはトランザクションで処理されます。',
    'csv_template'            => 'CSVテンプレートをダウンロード',
    'csv_help'                => 'UTF-8 CSVファイルからカテゴリーとサブカテゴリーをインポートします。各行はkeyで識別し、親はparent_keyで参照します。ルートカテゴリーではparent_keyを空欄にします。区切り文字にはカンマとセミコロンを使用できます。',
    'csv_file'                => 'CSVファイル',
    'csv_preview'             => '検証してプレビュー',
    'csv_preview_title'       => 'インポートプレビュー',
    'csv_preview_summary'     => '%d件のカテゴリーを作成し、既存の%d件をスキップします。',
    'csv_confirm'             => 'これらのカテゴリーをインポート',
    'csv_key'                 => 'キー',
    'csv_parent_key'          => '親キー',
    'csv_status'              => 'インポート状態',
    'csv_status_create'       => '作成',
    'csv_status_skip'         => '既に存在 — スキップ',
    'csv_import_success'      => '%d件のカテゴリーを作成し、既存の%d件をスキップしました。',
    'csv_errors_title'        => 'CSVファイルをインポートできません:',
    'csv_error_empty'         => 'CSVファイルが空です。',
    'csv_error_too_large'     => 'CSVファイルが大きすぎます（最大256 KB）。',
    'csv_error_read_failed'   => 'CSVファイルを読み込めませんでした。',
    'csv_error_upload'        => 'CSVファイルのアップロードに失敗しました。',
    'csv_error_header'        => '1行目は正確に key,category,parent_key,order としてください。',
    'csv_error_columns'       => '%d行目: 4列である必要があります。',
    'csv_error_key'           => '%d行目: キー「%s」が無効です。英字、数字、ピリオド、アンダースコア、ハイフンを使用してください。',
    'csv_error_duplicate_key' => '%d行目: キー「%s」が重複しています。',
    'csv_error_category'      => '%d行目: カテゴリー「%s」が空欄か、32文字を超えています。',
    'csv_error_self_parent'   => '%d行目: キー「%s」は自身を親にできません。',
    'csv_error_order'         => '%d行目: 順序「%s」が無効です。0から65535の整数を使用してください。',
    'csv_error_missing_parent'=> '%d行目: 親キー「%s」がCSVファイルに存在しません。',
    'csv_error_cycle'         => '%d行目: キー「%s」が親子関係の循環に含まれています。',
    'csv_error_database'      => 'データベースがインポートを拒否しました。部分的なインポートは保存されていません。',
    'csv_error_dependency'    => 'カテゴリー階層を解決できませんでした。部分的なインポートは保存されていません。',
    'csv_error_payload'       => '検証済みCSVデータがないか無効です。',
    'csv_error_token'         => 'セキュリティトークンの有効期限が切れました。インポートをやり直してください。',
    'csv_error_invalid'       => 'CSVインポート要求が無効です。',
	
);

$LANG_CLASSIFIEDS_EMAIL = array(
    'hello'                   => 'こんにちは',
    'new_ad'                  => '新しい広告が公開されました。',
    'edit_ad'                 => '広告が更新されました。',
    'delete_ad'               => '広告が削除されました。',
    'expire_ad'               => '広告の掲載期限が切れました。',
    'online_for'              => '掲載期間',
    'days'                    => '日間です。',
    'price'                   => '価格:',
    'view_ad'                 => '広告を見る',
    'manage_ad'               => '自分の広告を管理',
    'my_ads'                  => '自分の広告',
    'post_new_button'         => '新しい広告を掲載',
    'publisher'               => '投稿者',
    'automatic_notice'        => 'これは自動送信メールです。このメールには返信しないでください。',
    'admin_manage'            => 'クラシファイドを管理',
    'subject_create'          => '新しい広告',
    'subject_edit'            => '広告を更新しました',
    'subject_delete'          => '広告を削除しました',
    'subject_expire'          => '広告の期限切れ',

);


// Messages for the plugin upgrade
$PLG_classifieds_MESSAGE3002 = $LANG32[9]; // "requires a newer version of Geeklog"
$PLG_classifieds_MESSAGE1    = 'Hello world :)';

/**
*   Localization of the Admin Configuration UI
*   @global array $LANG_configsections['classifieds']
*/
$LANG_configsections['classifieds'] = array(
    'label' => 'クラシファイド',
    'title' => 'クラシファイド設定'
);

/**
*   Configuration system subgroup strings
*   @global array $LANG_configsubgroups['classifieds']
*/
$LANG_configsubgroups['classifieds'] = array(
    'sg_main' => '基本設定'
);

$LANG_tab['classifieds'] = array(
    'tab_main' => 'クラシファイド'
);

/**
*   Configuration system fieldset names
*   @global array $LANG_fs['classifieds']
*/
$LANG_fs['classifieds'] = array(
    'fs_main'            => '一般設定',
    'fs_images'          => '画像設定',
	'fs_display'         => '表示設定',
	'fs_email'           => 'メール設定',
    'fs_permissions'     => '既定の権限'
 );
 
/**
*   Configuration system prompt strings
*   @global array $LANG_confignames['classifieds']
*/
$LANG_confignames['classifieds'] = array(
    // Main settings
    'active_days' => '有効日数',
    
	//Images settings
    'max_image_width'  => '画像の最大幅',
	'max_image_height'  => '画像の最大高さ',
    'max_image_size'  => '画像の最大サイズ',
    'max_images_per_ad'  => '広告ごとの最大画像数',

     //Display settings
    'menulabel'  => 'メニューラベル',
    'hide_classifieds_menu'  => 'クラシファイドメニューを非表示',
    'classifieds_main_header'  => 'メインヘッダー',
    'classifieds_main_footer'  => 'メインフッター',
    'classifieds_edit_header'  => '編集ヘッダー',
    'help_page'  => 'ヘルプページ',
    'currency'  => '通貨',
    'maxPerPage'  => '1ページの最大件数',
	'allow_republish' => '広告の再掲載を許可',

    // Email settings
    'create_ad_email_user'  => '広告作成時にユーザーへメール',
    'mod_ad_email_user'  => '広告変更時にユーザーへメール',
    'delete_ad_email_user'  => '広告削除時にユーザーへメール',
    'expire_ad_email_user'  => '広告期限切れ時にユーザーへメール',
	'create_ad_email_admin'  => '広告作成時に管理者へメール',
    'mod_ad_email_admin'  => '広告変更時に管理者へメール',
    'delete_ad_email_admin'  => '広告削除時に管理者へメール',
    'expire_ad_email_admin'  => '広告期限切れ時に管理者へメール',

    //Permissions settings
    'classifieds_login_required'  => 'クラシファイドへのアクセスにログインを要求',
    'default_permissions'  => '既定の権限'
);

/**
*   Configuration system selection strings
*   Note: entries 0, 1, and 12 are the same as in 
*   $LANG_configselects['Core']
*
*   @global array $LANG_configselects['classifieds']
*/
$LANG_configselects['classifieds'] = array(
    3 => array('はい' => 1, 'いいえ' => 0),
    12 => array('アクセス不可' => 0, '読み取り専用' => 2, '読み書き可能' => 3)
);

$LANG_configtooltips['classifieds'] = array(    'active_days' => '広告が有効なまま保持され、期限通知と再掲載の対象になるまでの日数です。',
    'max_image_size' => '広告画像1枚あたりの最大アップロードサイズ（バイト）です。',
    'max_images_per_ad' => '1件の広告に添付できる画像の最大数です。',
    'allow_republish' => '対象となる期限切れ広告を新しい有効な広告としてコピーし、元の広告を履歴として保持します。',
    'classifieds_login_required' => '有効にすると、訪問者はクラシファイドにアクセスする前にログインする必要があります。',
    'default_permissions' => '新しく作成されたクラシファイドコンテンツに適用するGeeklog ACL権限です。'
);
?>
