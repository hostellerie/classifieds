<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Classifieds Plugin 1.4.0                                                  |
// +---------------------------------------------------------------------------+
// | german_utf-8.php                                                               |
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
    'plugin_name'             => 'Kleinanzeigen',
    'home'                    => 'Startseite',
	'place_an_ad'             => 'Anzeige aufgeben',
	'offer'                   => 'Angebot',
	'demand'                  => 'Gesuch',
	'offers'                  => 'Angebote',
	'demands'                 => 'Gesuche',
	'offers_demands'          => 'Angebote und Gesuche',
	'my_ads'                  => 'Meine Anzeigen',
	'user_ads'                => 'Anzeigen des Benutzers',
	'help'                    => 'Hilfe',
	'admin'                   => 'Administration',
	'access_reserved'         => 'Zugriff beschränkt',
    'you_must_sign_in'        => 'Sie müssen sich anmelden, um auf diese Anzeige zuzugreifen.',
	'posted_by'               => 'Veröffentlicht von',
	'on'                      => 'am',
	'at'                      => 'um',
	'contact_advertiser'      => 'Inserenten kontaktieren',
	'send_email'              => 'E-Mail senden',
	'double_point'            => ':',
	'manage_ad'               => 'Anzeige verwalten',
	'modify_ad'               => 'Anzeige bearbeiten',
	'delete_ad'               => 'Anzeige löschen',
	'price'                   => 'Preis',
	'category'                => 'Kategorie',
	'postcode'                => 'Postleitzahl',
	'enlarge_picture'         => 'Bild vergrößern',
    'previous_picture'        => 'Vorheriges Bild',
    'next_picture'            => 'Nächstes Bild',
    'close_picture'           => 'Bildanzeige schließen',
	'hits'                    => 'Aufrufe',
	'no_ad'                   => 'Kein Ergebnis',
	'no_ad_message'           => 'Es wurde keine Anzeige gefunden. Um eine Anzeige aufzugeben, klicken Sie auf „Anzeige aufgeben“.',
	'report'                  => 'Anzeige oder Missbrauch melden',
	'deleted'                 => 'GELÖSCHT',
	'view_all'                => 'Alle Anzeigen dieses Inserenten anzeigen',
	'all_ads_from'            => 'Alle Anzeigen von',
	'search_button'           => 'Suchen',
	'choose_category'         => '-- Kategorie auswählen --',
	'all_categories'          => 'Alle Kategorien',
	'profile'                 => 'Benutzerprofil',
	'classifieds_list'        => 'Anzeigen',
	'categories_list'         => 'Kategorien',
	'view_all_ads'            => 'Alle Anzeigen anzeigen',
	'under_construction'      => 'Im Aufbau',
    'image_not_writable'      => 'Der Bilderordner für Kleinanzeigen fehlt oder ist nicht beschreibbar. Beheben Sie dieses Problem, bevor Sie das Plugin verwenden.<br' . XHTML . '><br' . XHTML . '>Erstellen Sie im Ordner images einen Unterordner classifieds.',
	'ad-list-active'          => 'Aktive Anzeige',
	'ad-list-delete'          => 'Gelöschte Anzeige',
	'ad-list-old'             => 'Abgelaufene Anzeige',
	'label-hits'              => 'Aufrufe',
	'deleted_ad'              => 'Diese Anzeige ist nicht mehr verfügbar',
	'last_ads'                => 'Neueste Anzeigen auf der Website',
	'ads_not_available'       => 'Diese Anzeige ist nicht verfügbar',
	'all_ads'                 => 'Alle Anzeigen',
    'profile_no_ad'           => 'Keine aktiven Anzeigen',
);

//Ad form create, edit ,delete
$LANG_CLASSIFIEDS_2 = array(
    'deletion_succes'         => 'Die Anzeige wurde erfolgreich gelöscht.',
    'deletion_fail'           => 'Hoppla! Die Anzeige konnte nicht gelöscht werden.',
	'error'                   => 'Hoppla, es ist ein Fehler aufgetreten!',
	'missing_field'           => 'Einige Pflichtfelder fehlen:',
    'check_it'                => 'Bitte prüfen Sie die Angaben, bevor Sie die Anzeige absenden.',
	'save_fail'               => 'Hoppla! Speichern fehlgeschlagen.',
	'save_success'            => 'Ihre Anzeige wurde erfolgreich gespeichert.',
	'message'                 => 'Systemmeldung',
	'insert_new_ad'           => 'Neue Anzeige erstellen',
	'edit_label'              => 'Anzeige bearbeiten:',
	'your_ad'                 => 'Ihre Anzeige',
	'category'                => 'Kategorie',
	'title'                   => 'Anzeigentitel',
	'type'                    => 'Typ',
	'offer'                   => 'Angebot',
	'demand'                  => 'Gesuch',
	'choose_category'         => '-- Kategorie auswählen --',
	'choose_type'             => '-- Anzeigentyp auswählen --',
	'text'                    => 'Anzeigentext',
	'price'                   => 'Preis',
	'images'                  => 'Ihre Bilder',
    'image_upload_label'      => 'Bilder hinzufügen',
    'image_upload_help'       => 'Wählen Sie bis zu %d Bilder gleichzeitig aus (maximal %d pro Anzeige).',
    'image_upload_failed'     => 'Das Bild konnte nicht hochgeladen oder skaliert werden.',
    'image_too_large_no_resizer' => 'Das Bild überschreitet %d × %d Pixel und es ist keine Bibliothek zur Bildskalierung verfügbar.',
	'your_details'            => 'Ihre Angaben',
	'status'                     => 'Status',
	'choose_status'           => '-- Status auswählen --',
	'private'                 => 'Privat',
	'professional'            => 'Gewerblich',
	'siren'                   => 'Gewerbe-ID',
	'tel'                     => 'Tel.',
	'hide_tel'                 => 'Meine Telefonnummer in der Anzeige ausblenden',
	'postcode'                => 'Postleitzahl',
	'city'                    => 'Ort',
	'save_button'             => 'Speichern',
	'delete_button'           => 'Löschen',
	'required_field'          => 'Kennzeichnet ein Pflichtfeld',
	'validate_button'         => 'Bestätigen',
    'copy_button'             => 'Diese Anzeige erneut veröffentlichen',
	'access_reserved'         => 'Zugriff beschränkt. Für diese Funktion müssen Sie Mitglied folgender Gruppe sein:',
);

$LANG_CLASSIFIEDS_ADMIN = array(
    'administration'          => 'Kleinanzeigen-Verwaltung',
    'configuration'           => 'Konfiguration',
    'getting_started_title'    => 'Erste Schritte',
    'getting_started_intro'    => 'Konfigurieren Sie die wichtigsten Einstellungen, erstellen oder importieren Sie Kategorien und prüfen Sie anschließend die öffentliche Kleinanzeigen-Seite.',
    'getting_started_configure'=> 'Kleinanzeigen-Konfiguration prüfen',
    'getting_started_categories'=> 'Kategorien erstellen oder importieren',
    'getting_started_public'   => 'Öffentliche Kleinanzeigen-Seite öffnen',
    'category_in_use'         => 'Diese Kategorie kann nicht gelöscht werden, solange sie Anzeigen oder Unterkategorien enthält.',
    'dashboard_active'         => 'Aktive Anzeigen',
    'dashboard_expired'        => 'Abgelaufene Anzeigen',
    'dashboard_deleted'        => 'Gelöschte Anzeigen',
    'dashboard_categories'     => 'Aktive Kategorien',
    'dashboard_manage'         => 'Kleinanzeigen verwalten',
    'dashboard_storage_warning'=> 'Das Bildverzeichnis der Kleinanzeigen fehlt oder ist nicht beschreibbar.',
    'clid'                    => 'Anzeigen-ID',
	'title'                   => 'Anzeigentitel',
	'owner_id'                => 'Besitzer-ID',
	'created'                 => 'Erstellt',
	'cid'                     => 'Kat.-ID',
	'pid'                     => 'Übergeordnete Kategorie',
	'category'                => 'Kategorie',
	'catorder'                => 'Reihenfolge',
	'catdeleted'              => 'Status',
	'root'                    => 'Stammkategorie',
    'root_category_help'      => 'Stammkategorien dienen nur zur Organisation von Unterkategorien und können keine Anzeigen direkt aufnehmen. Anzeigen müssen in einer Unterkategorie veröffentlicht werden.',
	'deletion_succes'         => 'Das Löschen war erfolgreich.',
    'deletion_fail'           => 'Hoppla! Das Löschen ist fehlgeschlagen.',
	'cat_informations'        => 'Kategorieinformationen',
	'parent_category'         => 'Übergeordnete Kategorie',
	'enable'                  => 'Aktivieren',
	'disable'                 => 'Deaktivieren',
	'edit_label'              => 'Bearbeiten',
	'create_new_cat'          => 'Neue Kategorie erstellen',
    'insert_new_cat'          => 'Neue Kategorie erstellen',
    'save_fail'               => 'Hoppla! Speichern fehlgeschlagen.',
    'save_success'            => 'Die Kategorie wurde erfolgreich gespeichert.',
    'seo_metadata'            => 'SEO-Metadaten',
    'meta_title'              => 'Meta-Titel',
    'meta_description'        => 'Meta-Beschreibung',
    'meta_keywords'           => 'Meta-Schlüsselwörter',
    'modified'                => 'Geändert',
	'online'                  => 'online',
	'plugin_conf'             => 'Die Konfiguration des Kleinanzeigen-Plugins ist ebenfalls',
	'plugin_doc'              => 'Die Dokumentation zur Installation, Aktualisierung und Nutzung des Kleinanzeigen-Plugins ist',
    'publish_all_logged_in'      => 'Alle registrierten Benutzer können Anzeigen veröffentlichen. Derzeit ist keine bestimmte Gruppe erforderlich.',
    'publish_restricted_group'   => 'Die Veröffentlichung ist auf folgende Gruppe beschränkt:',
    'publish_restricted_groups'  => 'Die Veröffentlichung ist auf folgende %d Gruppen beschränkt:',
    'child_position'          => 'Position',
    'position_first'          => 'Erste',
    'position_after'          => 'Nach %s',
    'position_last'           => 'Letzte',
    'csv_import'              => 'Kategorien aus CSV importieren',
    'csv_documentation'       => 'Dokumentation zum CSV-Import',
    'csv_documentation_link'  => 'So bereiten Sie die CSV-Datei für Kategorien vor',
    'csv_doc_intro'           => 'Mit dem CSV-Importer können vollständige Kategoriestrukturen ohne Datenbank-IDs erstellt werden. Bereiten Sie die Datei mit stabilen Schlüsseln vor, prüfen Sie die Vorschau und bestätigen Sie anschließend den Import.',
    'csv_doc_format_title'    => 'Dateiformat',
    'csv_doc_format_text'     => 'Verwenden Sie eine UTF-8-CSV-Datei mit genau vier Spalten in dieser Reihenfolge. Kommas und Semikolons werden als Trennzeichen akzeptiert.',
    'csv_doc_columns_title'   => 'Spalten',
    'csv_doc_key'             => 'Stabiler Bezeichner, der nur beim Import verwendet wird. Er muss in der Datei eindeutig sein und darf Kleinbuchstaben, Ziffern, Punkte, Unterstriche und Bindestriche enthalten.',
    'csv_doc_category'        => 'Bezeichnung der Kategorie für Benutzer. Sie darf nicht leer sein und höchstens 32 Zeichen enthalten.',
    'csv_doc_parent'          => 'Schlüssel der übergeordneten Kategorie. Für eine Stammkategorie leer lassen. Eine übergeordnete Kategorie kann vor oder nach ihren Unterkategorien in der Datei stehen.',
    'csv_doc_order'           => 'Anzeigereihenfolge für Kategorien mit derselben übergeordneten Kategorie. Verwenden Sie eine Ganzzahl von 0 bis 65535.',
    'csv_doc_hierarchy_title' => 'Kategorien und Unterkategorien',
    'csv_doc_hierarchy_text'  => 'Um mehrere Ebenen zu erstellen, verweisen Sie parent_key auf den key einer anderen Zeile. Der Importer löst die Hierarchie automatisch auf; cid/pid-Werte der Datenbank gehören daher nicht in die CSV-Datei.',
    'csv_doc_rules_title'     => 'Wichtige Regeln',
    'csv_doc_rule_utf8'       => 'Speichern Sie die Datei als UTF-8. Ein UTF-8-BOM wird akzeptiert.',
    'csv_doc_rule_header'     => 'Die erste Zeile muss genau lauten: key,category,parent_key,order.',
    'csv_doc_rule_key'        => 'Jeder key muss eindeutig sein. Verwenden Sie denselben key nicht für zwei Kategorien.',
    'csv_doc_rule_parent'     => 'Jeder nicht leere parent_key muss auf einen key in derselben CSV-Datei verweisen. Selbstbezüge und Zyklen werden abgelehnt.',
    'csv_doc_rule_order'      => 'Zeilen dürfen in beliebiger Reihenfolge erscheinen; die Spalte order steuert die Anzeigereihenfolge, nicht die Importreihenfolge.',
    'csv_doc_rule_existing'   => 'Wenn unter derselben übergeordneten Kategorie bereits eine Kategorie mit demselben Namen existiert, wird sie übersprungen statt dupliziert.',
    'csv_doc_rule_preview'    => 'Während der Vorschau wird nichts geschrieben. Vor dem bestätigten Import wird die vollständige Datei erneut geprüft.',
    'csv_doc_workflow_title'  => 'Empfohlener Ablauf',
    'csv_doc_step_template'   => 'CSV-Vorlage herunterladen.',
    'csv_doc_step_edit'       => 'Bearbeiten Sie die Zeilen in einer Tabellenkalkulation oder einem Texteditor und behalten Sie die vier Spalten der Kopfzeile bei.',
    'csv_doc_step_preview'    => 'Laden Sie die Datei hoch und prüfen Sie die Validierungsvorschau, insbesondere Eltern-Kind-Beziehungen und den Status Erstellen/Überspringen.',
    'csv_doc_step_confirm'    => 'Bestätigen Sie nur, wenn die Vorschau korrekt ist. Der Datenbankschreibvorgang ist transaktional.',
    'csv_template'            => 'CSV-Vorlage herunterladen',
    'csv_help'                => 'Importieren Sie Kategorien und Unterkategorien aus einer UTF-8-CSV-Datei. Verwenden Sie key zur Identifizierung jeder Zeile und parent_key für die übergeordnete Kategorie. Lassen Sie parent_key für Stammkategorien leer. Komma und Semikolon werden als Trennzeichen akzeptiert.',
    'csv_file'                => 'CSV-Datei',
    'csv_preview'             => 'Prüfen und Vorschau anzeigen',
    'csv_preview_title'       => 'Importvorschau',
    'csv_preview_summary'     => '%d Kategorien werden erstellt; %d vorhandene Kategorien werden übersprungen.',
    'csv_confirm'             => 'Diese Kategorien importieren',
    'csv_key'                 => 'Schlüssel',
    'csv_parent_key'          => 'Übergeordneter Schlüssel',
    'csv_status'              => 'Importstatus',
    'csv_status_create'       => 'Erstellen',
    'csv_status_skip'         => 'Bereits vorhanden — überspringen',
    'csv_import_success'      => '%d Kategorien erstellt; %d vorhandene Kategorien übersprungen.',
    'csv_errors_title'        => 'Die CSV-Datei kann nicht importiert werden:',
    'csv_error_empty'         => 'Die CSV-Datei ist leer.',
    'csv_error_too_large'     => 'Die CSV-Datei ist zu groß (maximal 256 KB).',
    'csv_error_read_failed'   => 'Die CSV-Datei konnte nicht gelesen werden.',
    'csv_error_upload'        => 'Das Hochladen der CSV-Datei ist fehlgeschlagen.',
    'csv_error_header'        => 'Die erste Zeile muss genau lauten: key,category,parent_key,order.',
    'csv_error_columns'       => 'Zeile %d: Es werden genau vier Spalten erwartet.',
    'csv_error_key'           => 'Zeile %d: Ungültiger Schlüssel "%s". Verwenden Sie Buchstaben, Ziffern, Punkte, Unterstriche oder Bindestriche.',
    'csv_error_duplicate_key' => 'Zeile %d: Doppelter Schlüssel "%s".',
    'csv_error_category'      => 'Zeile %d: Kategorie "%s" ist leer oder länger als 32 Zeichen.',
    'csv_error_self_parent'   => 'Zeile %d: Schlüssel "%s" kann nicht sein eigener übergeordneter Schlüssel sein.',
    'csv_error_order'         => 'Zeile %d: Ungültige Reihenfolge "%s". Verwenden Sie eine Ganzzahl zwischen 0 und 65535.',
    'csv_error_missing_parent'=> 'Zeile %d: Übergeordneter Schlüssel "%s" ist in der CSV-Datei nicht vorhanden.',
    'csv_error_cycle'         => 'Zeile %d: Schlüssel "%s" ist Teil eines Hierarchiezyklus.',
    'csv_error_database'      => 'Die Datenbank hat den Import abgelehnt. Es wurde kein Teilimport übernommen.',
    'csv_error_dependency'    => 'Die Kategoriehierarchie konnte nicht aufgelöst werden. Es wurde kein Teilimport übernommen.',
    'csv_error_payload'       => 'Die validierten CSV-Daten fehlen oder sind ungültig.',
    'csv_error_token'         => 'Das Sicherheitstoken ist abgelaufen. Bitte wiederholen Sie den Import.',
    'csv_error_invalid'       => 'Die CSV-Importanfrage ist ungültig.',
	
);

$LANG_CLASSIFIEDS_EMAIL = array(
    'hello'                   => 'Hallo',
    'new_ad'                  => 'Ihre neue Anzeige wurde veröffentlicht.',
    'edit_ad'                 => 'Ihre Anzeige wurde aktualisiert.',
    'delete_ad'               => 'Ihre Anzeige wurde entfernt.',
    'expire_ad'               => 'Ihre Anzeige ist abgelaufen.',
    'online_for'              => 'Sie bleibt online für',
    'days'                    => 'Tage.',
    'price'                   => 'Preis:',
    'view_ad'                 => 'Anzeige ansehen',
    'manage_ad'               => 'Meine Anzeige verwalten',
    'my_ads'                  => 'Meine Anzeigen',
    'post_new_button'         => 'Neue Anzeige aufgeben',
    'publisher'               => 'Inserent',
    'automatic_notice'        => 'Dies ist eine automatische Nachricht. Bitte antworten Sie nicht auf diese E-Mail.',
    'admin_manage'            => 'Kleinanzeigen verwalten',
    'subject_create'          => 'Neue Anzeige',
    'subject_edit'            => 'Anzeige aktualisiert',
    'subject_delete'          => 'Anzeige entfernt',
    'subject_expire'          => 'Anzeige abgelaufen',

);


// Messages for the plugin upgrade
$PLG_classifieds_MESSAGE3002 = $LANG32[9]; // "requires a newer version of Geeklog"
$PLG_classifieds_MESSAGE1    = 'Hello world :)';

/**
*   Localization of the Admin Configuration UI
*   @global array $LANG_configsections['classifieds']
*/
$LANG_configsections['classifieds'] = array(
    'label' => 'Kleinanzeigen',
    'title' => 'Kleinanzeigen-Konfiguration'
);

/**
*   Configuration system subgroup strings
*   @global array $LANG_configsubgroups['classifieds']
*/
$LANG_configsubgroups['classifieds'] = array(
    'sg_main' => 'Haupteinstellungen'
);

$LANG_tab['classifieds'] = array(
    'tab_main' => 'Kleinanzeigen'
);

/**
*   Configuration system fieldset names
*   @global array $LANG_fs['classifieds']
*/
$LANG_fs['classifieds'] = array(
    'fs_main'            => 'Allgemeine Einstellungen',
    'fs_images'          => 'Bildeinstellungen',
	'fs_display'         => 'Anzeigeeinstellungen',
	'fs_email'           => 'E-Mail-Einstellungen',
    'fs_permissions'     => 'Standardberechtigungen'
 );
 
/**
*   Configuration system prompt strings
*   @global array $LANG_confignames['classifieds']
*/
$LANG_confignames['classifieds'] = array(
    // Main settings
    'active_days' => 'Aktive Tage',
    
	//Images settings
    'max_image_width'  => 'Maximale Bildbreite',
	'max_image_height'  => 'Maximale Bildhöhe',
    'max_image_size'  => 'Maximale Bildgröße',
    'max_images_per_ad'  => 'Maximale Bilder pro Anzeige',

     //Display settings
    'menulabel'  => 'Menübezeichnung',
    'hide_classifieds_menu'  => 'Kleinanzeigen-Menü ausblenden',
    'classifieds_main_header'  => 'Hauptkopfzeile',
    'classifieds_main_footer'  => 'Hauptfußzeile',
    'classifieds_edit_header'  => 'Editor-Kopfzeile',
    'help_page'  => 'Hilfeseite',
    'currency'  => 'Währung',
    'maxPerPage'  => 'Maximum pro Seite',
	'allow_republish' => 'Erneutes Veröffentlichen von Anzeigen erlauben',

    // Email settings
    'create_ad_email_user'  => 'Benutzer bei Anzeigenerstellung per E-Mail informieren',
    'mod_ad_email_user'  => 'Benutzer bei Anzeigenänderung per E-Mail informieren',
    'delete_ad_email_user'  => 'Benutzer bei Anzeigenlöschung per E-Mail informieren',
    'expire_ad_email_user'  => 'Benutzer bei Ablauf der Anzeige per E-Mail informieren',
	'create_ad_email_admin'  => 'Administrator bei Anzeigenerstellung per E-Mail informieren',
    'mod_ad_email_admin'  => 'Administrator bei Anzeigenänderung per E-Mail informieren',
    'delete_ad_email_admin'  => 'Administrator bei Anzeigenlöschung per E-Mail informieren',
    'expire_ad_email_admin'  => 'Administrator bei Ablauf der Anzeige per E-Mail informieren',

    //Permissions settings
    'classifieds_login_required'  => 'Anmeldung für den Zugriff auf Kleinanzeigen erforderlich',
    'default_permissions'  => 'Standardberechtigungen'
);

/**
*   Configuration system selection strings
*   Note: entries 0, 1, and 12 are the same as in 
*   $LANG_configselects['Core']
*
*   @global array $LANG_configselects['classifieds']
*/
$LANG_configselects['classifieds'] = array(
    3 => array('Ja' => 1, 'Nein' => 0),
    12 => array('Kein Zugriff' => 0, 'Nur Lesen' => 2, 'Lesen und Schreiben' => 3)
);

$LANG_configtooltips['classifieds'] = array(    'active_days' => 'Anzahl der Tage, die eine Anzeige aktiv bleibt, bevor sie für Ablaufbenachrichtigung und erneute Veröffentlichung infrage kommt.',
    'max_image_size' => 'Maximale Upload-Größe in Byte für ein Anzeigenbild.',
    'max_images_per_ad' => 'Maximale Anzahl von Bildern, die einer Anzeige zugeordnet werden können.',
    'allow_republish' => 'Ermöglicht das Kopieren geeigneter abgelaufener Anzeigen in eine neue aktive Anzeige, wobei das historische Original erhalten bleibt.',
    'classifieds_login_required' => 'Wenn aktiviert, müssen sich Besucher anmelden, bevor sie auf Kleinanzeigen zugreifen.',
    'default_permissions' => 'Geeklog-ACL-Berechtigungen für neu erstellte Kleinanzeigen-Inhalte.'
);
?>
