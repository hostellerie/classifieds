<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Classifieds Plugin 1.4.0                                                  |
// +---------------------------------------------------------------------------+
// | italian_utf-8.php                                                               |
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
    'plugin_name'             => 'Annunci',
    'home'                    => 'Pagina iniziale',
	'place_an_ad'             => 'Pubblica un annuncio',
	'offer'                   => 'Offerta',
	'demand'                  => 'Richiesta',
	'offers'                  => 'Offerte',
	'demands'                 => 'Richieste',
	'offers_demands'          => 'Offerte e richieste',
	'my_ads'                  => 'I miei annunci',
	'user_ads'                => 'Annunci utente',
	'help'                    => 'Aiuto',
	'admin'                   => 'Amministrazione',
	'access_reserved'         => 'Accesso riservato',
    'you_must_sign_in'        => 'Devi accedere per visualizzare questo annuncio.',
	'posted_by'               => 'Pubblicato da',
	'on'                      => 'il',
	'at'                      => 'alle',
	'contact_advertiser'      => 'Contatta l\'inserzionista',
	'send_email'              => 'Invia un\'email',
	'double_point'            => ':',
	'manage_ad'               => 'Gestisci annuncio',
	'modify_ad'               => 'Modifica annuncio',
	'delete_ad'               => 'Elimina annuncio',
	'price'                   => 'Prezzo',
	'category'                => 'Categoria',
	'postcode'                => 'Codice postale',
	'enlarge_picture'         => 'Ingrandisci immagine',
    'previous_picture'        => 'Immagine precedente',
    'next_picture'            => 'Immagine successiva',
    'close_picture'           => 'Chiudi visualizzatore immagini',
	'hits'                    => 'visite',
	'no_ad'                   => 'Nessun risultato',
	'no_ad_message'           => 'Nessun annuncio trovato. Per pubblicarne uno, premi il pulsante "Pubblica un annuncio".',
	'report'                  => 'Segnala annuncio o abuso',
	'deleted'                 => 'ELIMINATO',
	'view_all'                => 'Visualizza tutti gli annunci di questo inserzionista',
	'all_ads_from'            => 'Tutti gli annunci pubblicati da',
	'search_button'           => 'Cerca',
	'choose_category'         => '-- Seleziona una categoria --',
	'all_categories'          => 'Tutte le categorie',
	'profile'                 => 'Profilo utente',
	'classifieds_list'        => 'Annunci',
	'categories_list'         => 'Categorie',
	'view_all_ads'            => 'Visualizza tutti gli annunci',
	'under_construction'      => 'In costruzione',
    'image_not_writable'      => 'La cartella delle immagini degli annunci non esiste o non è scrivibile. Correggi il problema prima di usare il plugin.<br' . XHTML . '><br' . XHTML . '>Crea una sottocartella classifieds nella cartella images.',
	'ad-list-active'          => 'Annuncio attivo',
	'ad-list-delete'          => 'Annuncio eliminato',
	'ad-list-old'             => 'Annuncio scaduto',
	'label-hits'              => 'Visite',
	'deleted_ad'              => 'Questo annuncio non è più disponibile',
	'last_ads'                => 'Ultimi annunci sul sito',
	'ads_not_available'       => 'Questo annuncio non è disponibile',
	'all_ads'                 => 'Tutti gli annunci',
    'profile_no_ad'           => 'Nessun annuncio attivo',
);

//Ad form create, edit ,delete
$LANG_CLASSIFIEDS_2 = array(
    'deletion_succes'         => 'L\'annuncio è stato eliminato correttamente.',
    'deletion_fail'           => 'Ops! Eliminazione dell\'annuncio non riuscita.',
	'error'                   => 'Ops, si è verificato un errore!',
	'missing_field'           => 'Mancano alcuni campi obbligatori:',
    'check_it'                => 'Controlla i campi prima di inviare l\'annuncio.',
	'save_fail'               => 'Ops! Salvataggio non riuscito.',
	'save_success'            => 'L\'annuncio è stato salvato correttamente.',
	'message'                 => 'Messaggio di sistema',
	'insert_new_ad'           => 'Inserisci un nuovo annuncio',
	'edit_label'              => 'Modifica annuncio:',
	'your_ad'                 => 'Il tuo annuncio',
	'category'                => 'Categoria',
	'title'                   => 'Titolo dell\'annuncio',
	'type'                    => 'Tipo',
	'offer'                   => 'Offerta',
	'demand'                  => 'Richiesta',
	'choose_category'         => '-- Scegli una categoria --',
	'choose_type'             => '-- Scegli il tipo di annuncio --',
	'text'                    => 'Testo dell\'annuncio',
	'price'                   => 'Prezzo',
	'images'                  => 'Le tue immagini',
    'image_upload_label'      => 'Aggiungi immagini',
    'image_upload_help'       => 'Seleziona fino a %d immagini alla volta (%d massimo per annuncio).',
    'image_upload_failed'     => 'Impossibile caricare o ridimensionare l\'immagine.',
    'image_too_large_no_resizer' => 'L\'immagine supera %d × %d pixel e non è disponibile alcuna libreria di ridimensionamento.',
	'your_details'            => 'I tuoi dati',
	'status'                     => 'Stato',
	'choose_status'           => '-- Scegli il tuo stato --',
	'private'                 => 'Privato',
	'professional'            => 'Professionista',
	'siren'                   => 'ID professionale',
	'tel'                     => 'Tel',
	'hide_tel'                 => 'Nascondi il mio telefono nell\'annuncio',
	'postcode'                => 'Codice postale',
	'city'                    => 'Città',
	'save_button'             => 'Salva',
	'delete_button'           => 'Elimina',
	'required_field'          => 'Indica un campo obbligatorio',
	'validate_button'         => 'Convalida',
    'copy_button'             => 'Ripubblica questo annuncio',
	'access_reserved'         => 'Accesso riservato. Per usare questa funzione devi appartenere al gruppo:',
);

$LANG_CLASSIFIEDS_ADMIN = array(
    'administration'          => 'Amministrazione annunci',
    'configuration'           => 'Configurazione',
    'getting_started_title'    => 'Per iniziare',
    'getting_started_intro'    => 'Configura le impostazioni essenziali, crea o importa le categorie, quindi verifica la pagina pubblica degli annunci.',
    'getting_started_configure'=> 'Verifica la configurazione degli annunci',
    'getting_started_categories'=> 'Crea o importa categorie',
    'getting_started_public'   => 'Apri la pagina pubblica degli annunci',
    'category_in_use'         => 'Questa categoria non può essere eliminata finché contiene annunci o sottocategorie.',
    'dashboard_active'         => 'Annunci attivi',
    'dashboard_expired'        => 'Annunci scaduti',
    'dashboard_deleted'        => 'Annunci eliminati',
    'dashboard_categories'     => 'Categorie attive',
    'dashboard_manage'         => 'Gestisci annunci',
    'dashboard_storage_warning'=> 'La directory delle immagini degli annunci non esiste o non è scrivibile.',
    'clid'                    => 'ID annuncio',
	'title'                   => 'Titolo dell\'annuncio',
	'owner_id'                => 'ID proprietario',
	'created'                 => 'Creato',
	'cid'                     => 'ID cat.',
	'pid'                     => 'Categoria padre',
	'category'                => 'Categoria',
	'catorder'                => 'Ordine',
	'catdeleted'              => 'Stato',
	'root'                    => 'Categoria radice',
    'root_category_help'      => 'Le categorie radice servono solo a organizzare le sottocategorie e non possono ricevere annunci direttamente. Gli annunci devono essere pubblicati in una sottocategoria.',
	'deletion_succes'         => 'Eliminazione riuscita.',
    'deletion_fail'           => 'Ops! Eliminazione non riuscita.',
	'cat_informations'        => 'Informazioni categoria',
	'parent_category'         => 'Categoria padre',
	'enable'                  => 'Abilita',
	'disable'                 => 'Disabilita',
	'edit_label'              => 'Modifica',
	'create_new_cat'          => 'Crea una nuova categoria',
    'insert_new_cat'          => 'Crea una nuova categoria',
    'save_fail'               => 'Ops! Salvataggio non riuscito.',
    'save_success'            => 'La categoria è stata salvata correttamente.',
    'seo_metadata'            => 'Metadati SEO',
    'meta_title'              => 'Titolo meta',
    'meta_description'        => 'Descrizione meta',
    'meta_keywords'           => 'Parole chiave meta',
    'modified'                => 'Modificato',
	'online'                  => 'online',
	'plugin_conf'             => 'La configurazione del plugin annunci è anche',
	'plugin_doc'              => 'La documentazione per installazione, aggiornamento e uso del plugin annunci è',
    'publish_all_logged_in'      => 'Tutti gli utenti registrati possono pubblicare annunci. Al momento non è richiesto alcun gruppo specifico.',
    'publish_restricted_group'   => 'La pubblicazione è riservata al seguente gruppo:',
    'publish_restricted_groups'  => 'La pubblicazione è riservata ai seguenti %d gruppi:',
    'child_position'          => 'Posizione',
    'position_first'          => 'Prima',
    'position_after'          => 'Dopo %s',
    'position_last'           => 'Ultima',
    'csv_import'              => 'Importa categorie da CSV',
    'csv_documentation'       => 'Documentazione importazione CSV',
    'csv_documentation_link'  => 'Come preparare il file CSV delle categorie',
    'csv_doc_intro'           => 'L\'importatore CSV consente di creare alberi completi di categorie senza usare ID del database. Prepara il file con chiavi stabili, convalida l\'anteprima e conferma l\'importazione.',
    'csv_doc_format_title'    => 'Formato file',
    'csv_doc_format_text'     => 'Usa un file CSV UTF-8 con esattamente quattro colonne in questo ordine. Virgole e punti e virgola sono accettati come separatori.',
    'csv_doc_columns_title'   => 'Colonne',
    'csv_doc_key'             => 'Identificatore stabile usato solo durante l\'importazione. Deve essere univoco nel file e può contenere lettere minuscole, cifre, punti, trattini bassi e trattini.',
    'csv_doc_category'        => 'Etichetta della categoria mostrata agli utenti. Non può essere vuota e può contenere fino a 32 caratteri.',
    'csv_doc_parent'          => 'Chiave della categoria padre. Lasciala vuota per una categoria radice. Un padre può comparire prima o dopo i figli nel file.',
    'csv_doc_order'           => 'Ordine di visualizzazione tra categorie con lo stesso padre. Usa un intero da 0 a 65535.',
    'csv_doc_hierarchy_title' => 'Categorie e sottocategorie',
    'csv_doc_hierarchy_text'  => 'Per creare più livelli, fai puntare parent_key alla key di un\'altra riga. L\'importatore risolve automaticamente la gerarchia, quindi i valori cid/pid del database non devono comparire nel CSV.',
    'csv_doc_rules_title'     => 'Regole importanti',
    'csv_doc_rule_utf8'       => 'Salva il file come UTF-8. È accettato un BOM UTF-8.',
    'csv_doc_rule_header'     => 'La prima riga deve essere esattamente: key,category,parent_key,order.',
    'csv_doc_rule_key'        => 'Ogni key deve essere univoca. Non riutilizzare una key per due categorie.',
    'csv_doc_rule_parent'     => 'Ogni parent_key non vuota deve fare riferimento a una key presente nello stesso CSV. Autoriferimenti e cicli vengono rifiutati.',
    'csv_doc_rule_order'      => 'Le righe possono apparire in qualsiasi ordine; la colonna order controlla l\'ordine di visualizzazione, non quello di importazione.',
    'csv_doc_rule_existing'   => 'Se esiste già una categoria con lo stesso nome sotto lo stesso padre, viene ignorata invece di essere duplicata.',
    'csv_doc_rule_preview'    => 'Durante l\'anteprima non viene scritto nulla. Il file completo viene convalidato di nuovo prima dell\'importazione confermata.',
    'csv_doc_workflow_title'  => 'Procedura consigliata',
    'csv_doc_step_template'   => 'Scarica il modello CSV.',
    'csv_doc_step_edit'       => 'Modifica le righe in un foglio di calcolo o editor di testo mantenendo l\'intestazione a quattro colonne.',
    'csv_doc_step_preview'    => 'Carica il file e controlla l\'anteprima di convalida, in particolare le relazioni padre/figlio e lo stato crea/ignora.',
    'csv_doc_step_confirm'    => 'Conferma solo quando l\'anteprima è corretta. La scrittura nel database è transazionale.',
    'csv_template'            => 'Scarica modello CSV',
    'csv_help'                => 'Importa categorie e sottocategorie da un file CSV UTF-8. Usa key per identificare ogni riga e parent_key per riferirne il padre. Lascia parent_key vuoto per le categorie radice. Sono accettati virgola e punto e virgola come separatori.',
    'csv_file'                => 'File CSV',
    'csv_preview'             => 'Convalida e anteprima',
    'csv_preview_title'       => 'Anteprima importazione',
    'csv_preview_summary'     => 'Verranno create %d categorie; %d categorie esistenti verranno ignorate.',
    'csv_confirm'             => 'Importa queste categorie',
    'csv_key'                 => 'Chiave',
    'csv_parent_key'          => 'Chiave padre',
    'csv_status'              => 'Stato importazione',
    'csv_status_create'       => 'Crea',
    'csv_status_skip'         => 'Esiste già — ignora',
    'csv_import_success'      => '%d categorie create; %d categorie esistenti ignorate.',
    'csv_errors_title'        => 'Il file CSV non può essere importato:',
    'csv_error_empty'         => 'Il file CSV è vuoto.',
    'csv_error_too_large'     => 'Il file CSV è troppo grande (massimo 256 KB).',
    'csv_error_read_failed'   => 'Impossibile leggere il file CSV.',
    'csv_error_upload'        => 'Caricamento del file CSV non riuscito.',
    'csv_error_header'        => 'La prima riga deve essere esattamente: key,category,parent_key,order.',
    'csv_error_columns'       => 'Riga %d: sono richieste esattamente quattro colonne.',
    'csv_error_key'           => 'Riga %d: chiave "%s" non valida. Usa lettere, cifre, punti, trattini bassi o trattini.',
    'csv_error_duplicate_key' => 'Riga %d: chiave duplicata "%s".',
    'csv_error_category'      => 'Riga %d: la categoria "%s" è vuota o supera 32 caratteri.',
    'csv_error_self_parent'   => 'Riga %d: la chiave "%s" non può essere il proprio padre.',
    'csv_error_order'         => 'Riga %d: ordine "%s" non valido. Usa un intero tra 0 e 65535.',
    'csv_error_missing_parent'=> 'Riga %d: la chiave padre "%s" non esiste nel file CSV.',
    'csv_error_cycle'         => 'Riga %d: la chiave "%s" fa parte di un ciclo nella gerarchia.',
    'csv_error_database'      => 'Il database ha rifiutato l\'importazione. Nessuna importazione parziale è stata mantenuta.',
    'csv_error_dependency'    => 'Impossibile risolvere la gerarchia delle categorie. Nessuna importazione parziale è stata mantenuta.',
    'csv_error_payload'       => 'I dati CSV convalidati mancano o non sono validi.',
    'csv_error_token'         => 'Il token di sicurezza è scaduto. Riprova l\'importazione.',
    'csv_error_invalid'       => 'La richiesta di importazione CSV non è valida.',
	
);

$LANG_CLASSIFIEDS_EMAIL = array(
    'hello'                   => 'Ciao',
    'new_ad'                  => 'Il tuo nuovo annuncio è stato pubblicato.',
    'edit_ad'                 => 'Il tuo annuncio è stato aggiornato.',
    'delete_ad'               => 'Il tuo annuncio è stato rimosso.',
    'expire_ad'               => 'Il tuo annuncio è scaduto.',
    'online_for'              => 'Rimarrà online per',
    'days'                    => 'giorni.',
    'price'                   => 'Prezzo:',
    'view_ad'                 => 'Visualizza annuncio',
    'manage_ad'               => 'Gestisci il mio annuncio',
    'my_ads'                  => 'I miei annunci',
    'post_new_button'         => 'Pubblica un nuovo annuncio',
    'publisher'               => 'Inserzionista',
    'automatic_notice'        => 'Questo è un messaggio automatico. Non rispondere a questa email.',
    'admin_manage'            => 'Gestisci annunci',
    'subject_create'          => 'Nuovo annuncio',
    'subject_edit'            => 'Annuncio aggiornato',
    'subject_delete'          => 'Annuncio rimosso',
    'subject_expire'          => 'Annuncio scaduto',

);


// Messages for the plugin upgrade
$PLG_classifieds_MESSAGE3002 = $LANG32[9]; // "requires a newer version of Geeklog"
$PLG_classifieds_MESSAGE1    = 'Hello world :)';

/**
*   Localization of the Admin Configuration UI
*   @global array $LANG_configsections['classifieds']
*/
$LANG_configsections['classifieds'] = array(
    'label' => 'Annunci',
    'title' => 'Configurazione annunci'
);

/**
*   Configuration system subgroup strings
*   @global array $LANG_configsubgroups['classifieds']
*/
$LANG_configsubgroups['classifieds'] = array(
    'sg_main' => 'Impostazioni principali'
);

$LANG_tab['classifieds'] = array(
    'tab_main' => 'Annunci'
);

/**
*   Configuration system fieldset names
*   @global array $LANG_fs['classifieds']
*/
$LANG_fs['classifieds'] = array(
    'fs_main'            => 'Impostazioni generali',
    'fs_images'          => 'Impostazioni immagini',
	'fs_display'         => 'Impostazioni visualizzazione',
	'fs_email'           => 'Impostazioni email',
    'fs_permissions'     => 'Permessi predefiniti'
 );
 
/**
*   Configuration system prompt strings
*   @global array $LANG_confignames['classifieds']
*/
$LANG_confignames['classifieds'] = array(
    // Main settings
    'active_days' => 'Giorni attivi',
    
	//Images settings
    'max_image_width'  => 'Larghezza massima immagine',
	'max_image_height'  => 'Altezza massima immagine',
    'max_image_size'  => 'Dimensione massima immagine',
    'max_images_per_ad'  => 'Numero massimo immagini per annuncio',

     //Display settings
    'menulabel'  => 'Etichetta menu',
    'hide_classifieds_menu'  => 'Nascondi menu annunci',
    'classifieds_main_header'  => 'Intestazione principale',
    'classifieds_main_footer'  => 'Piè di pagina principale',
    'classifieds_edit_header'  => 'Intestazione editor',
    'help_page'  => 'Pagina di aiuto',
    'currency'  => 'Valuta',
    'maxPerPage'  => 'Massimo per pagina',
	'allow_republish' => 'Consenti ripubblicazione annunci',

    // Email settings
    'create_ad_email_user'  => 'Invia email all\'utente alla creazione dell\'annuncio',
    'mod_ad_email_user'  => 'Invia email all\'utente alla modifica dell\'annuncio',
    'delete_ad_email_user'  => 'Invia email all\'utente all\'eliminazione dell\'annuncio',
    'expire_ad_email_user'  => 'Invia email all\'utente alla scadenza dell\'annuncio',
	'create_ad_email_admin'  => 'Invia email all\'amministratore alla creazione dell\'annuncio',
    'mod_ad_email_admin'  => 'Invia email all\'amministratore alla modifica dell\'annuncio',
    'delete_ad_email_admin'  => 'Invia email all\'amministratore all\'eliminazione dell\'annuncio',
    'expire_ad_email_admin'  => 'Invia email all\'amministratore alla scadenza dell\'annuncio',

    //Permissions settings
    'classifieds_login_required'  => 'Accesso richiesto per visualizzare gli annunci',
    'default_permissions'  => 'Permessi predefiniti'
);

/**
*   Configuration system selection strings
*   Note: entries 0, 1, and 12 are the same as in 
*   $LANG_configselects['Core']
*
*   @global array $LANG_configselects['classifieds']
*/
$LANG_configselects['classifieds'] = array(
    3 => array('Sì' => 1, 'No' => 0),
    12 => array('Nessun accesso' => 0, 'Sola lettura' => 2, 'Lettura e scrittura' => 3)
);

$LANG_configtooltips['classifieds'] = array(    'active_days' => 'Numero di giorni in cui un annuncio rimane attivo prima di poter essere notificato come scaduto e ripubblicato.',
    'max_image_size' => 'Dimensione massima di caricamento in byte per una singola immagine dell\'annuncio.',
    'max_images_per_ad' => 'Numero massimo di immagini associabili a un annuncio.',
    'allow_republish' => 'Consente di copiare gli annunci scaduti idonei in un nuovo annuncio attivo mantenendo l\'originale nello storico.',
    'classifieds_login_required' => 'Quando attivo, i visitatori devono accedere prima di visualizzare gli annunci.',
    'default_permissions' => 'Permessi ACL di Geeklog applicati ai nuovi contenuti degli annunci.'
);
?>
