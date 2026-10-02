<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Classifieds Plugin 1.4.0                                                  |
// +---------------------------------------------------------------------------+
// | french_canada_utf-8.php                                                   |
// |                                                                           |
// | French Canadian language file                                                      |
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
    'plugin_name'             => 'Les annonces',
    'home'                    => 'Accueil',
	'place_an_ad'             => 'Publier une annonce',
	'offer'                   => 'Offre',
	'demand'                  => 'Recherche',
	'offers'                  => 'Offres',
	'demands'                 => 'Recherches',
	'offers_demands'          => 'Offres et recherches',
	'my_ads'                  => 'Mes annonces',
	'user_ads'                => 'Les annonces',
	'help'                    => 'Aide',
	'admin'                   => 'Admin',
	'access_reserved'         => 'Accès réservé aux membres',
    'you_must_sign_in'        => 'Vous devez vous connecter à l\'espace membre pour voir cette annonce.',
	'posted_by'               => 'Publiée par',
	'on'                      => 'le',
	'at'                      => 'à',
	'contact_advertiser'      => 'Contactez l\'annonceur',
	'send_email'              => 'Envoyez un email',
	'double_point'            => ' :',
	'manage_ad'               => 'Gérer l\'annonce',
	'modify_ad'               => 'Modifier l\'annonce',
	'delete_ad'               => 'Effacer l\'annonce',
	'price'                   => 'Prix',
	'category'                => 'Rubrique',
	'postcode'                => 'Code postal',
	'enlarge_picture'         => 'Agrandir l\'image',
    'previous_picture'        => 'Image précédente',
    'next_picture'            => 'Image suivante',
    'close_picture'           => 'Fermer la visionneuse',
	'hits'                    => 'visites',
	'no_ad'                   => 'Aucun résultat',
	'no_ad_message'           => 'Désolé, aucune annonce n\'a été trouvée. Pour en publier une, cliquez sur "Publier une annonce".',
	'report'                  => 'Signaler cette annonce ou un abus',
	'deleted'                 => 'SUPPRIMÉE',
	'view_all'                => 'Voir toutes les annonces de ce membre',
	'all_ads_from'            => 'Toutes les annonces publiées par',
	'search_button'           => 'Chercher',
	'choose_category'         => '-- Choisir une rubrique --',
	'all_categories'          => 'Toutes les rubriques',
	'profile'                 => 'Profil du membre',
	'classifieds_list'        => 'Les annonces',
	'categories_list'         => 'Les rubriques',
	'view_all_ads'            => 'Voir toutes les annonces',
	'under_construction'      => 'En construction',
    'image_not_writable'      => 'Le dossier de stockage des images du plugin classifieds n\'existe pas ou n\'est pas accessible en écriture. Vous devez vérifier ce problème avant d\'utiliser le plugin classifieds.<br' . XHTML . '><br' . XHTML . '>Pour des raisons de compatibilité avec le plugin multi, le nom de dossier qui contient le dossier "classifieds" est paramétrable et doit être un sous dossier du dossier images. D\'autres plugins ayant recours au stockage d\'images utiliseront cette classification.<br' . XHTML . '><br' . XHTML . '>Vous pouvez modifier le nom du dossier dans la configuration du plugin.',
	'ad-list-active'          => 'Annonce active',
	'ad-list-delete'          => 'Annonce effacée',
	'ad-list-old'             => 'Annonce périmée',
	'label-hits'              => 'Visites',
	'deleted_ad'              => 'Désolé, cette annonce n\'est plus disponible.',
	'last_ads'                => 'Les dernières annonces sur le site',
	'ads_not_available'       => 'Cette annonce n\'est plus disponible.',
	'all_ads'                 => 'Toutes les annonces',
    'profile_no_ad'           => 'Aucune petite annonce en cours',

);

//Ad form create, edit ,delete
$LANG_CLASSIFIEDS_2 = array(
    'deletion_succes'         => 'L\'annonce a bien été supprimée.',
    'deletion_fail'           => 'Oups! La suppression a échoué.',
	'error'                   => 'Oups il y a une erreur !',
	'missing_field'           => 'Des champs nécessaires sont manquants :',
    'check_it'                => 'Merci de vérifier tous les champs marqués d\'un astérisque rouge avant de soumettre à nouveau votre annonce.',
	'save_fail'               => 'Oups! La sauvegarde a échoué.',
	'save_success'            => 'Votre annonce a bien été sauvegardée.',
	'message'                 => 'Message',
	'insert_new_ad'           => 'Insérer une nouvelle annonce',
	'edit_label'              => 'Edition de l\'annonce :',
	'your_ad'                 => 'Votre annonce',
	'category'                => 'Rubrique',
	'title'                   => 'Titre de l\'annonce',
	'type'                    => 'Type',
	'offer'                   => 'Offre',
	'demand'                  => 'Recherche',
	'choose_category'         => '-- Choisir une rubrique --',
	'choose_type'             => '-- Choisir un type --',
	'text'                    => 'Texte de l\'annonce',
	'price'                   => 'Prix',
	'images'                  => 'Vos photos',
    'image_upload_label'      => 'Ajouter des images',
    'image_upload_help'       => 'Sélectionnez jusqu’à %d images en une seule fois (%d maximum par annonce).',
    'image_upload_failed'     => 'L’image n’a pas pu être envoyée ou redimensionnée.',
    'image_too_large_no_resizer' => 'L’image dépasse %d × %d pixels et aucune bibliothèque de redimensionnement n’est disponible.',
	'your_details'            => 'Vos coordonnées',
	'status'                  => 'Statut',
	'choose_status'           => '-- Choisir votre statut --',
	'private'                 => 'Particulier',
	'professional'            => 'Professionnel',
	'siren'                   => 'SIREN',
	'tel'                     => 'Tél',
	'hide_tel'                => 'Cacher mon numéro de téléphone dans l\'annonce.',
	'postcode'                => 'Code postal',
	'city'                    => 'Ville',
	'save_button'             => 'Enregistrer',
	'delete_button'           => 'Effacer',
	'required_field'          => 'Indique des champs requis.',
	'validate_button'         => 'Valider',
    'copy_button'             => 'Republier cette annonce',
	'access_reserved'         => 'Accès réservé. Pour accéder à cette fonction vous devez faire partie du groupe',
);

$LANG_CLASSIFIEDS_ADMIN = array(
    'administration'          => 'Administration des petites annonces',
    'configuration'           => 'Configuration',
    'getting_started_title'    => 'Bien démarrer',
    'getting_started_intro'    => 'Vérifiez les réglages essentiels, créez ou importez les rubriques, puis contrôlez la page publique des petites annonces.',
    'getting_started_configure'=> 'Vérifier la configuration de Classifieds',
    'getting_started_categories'=> 'Créer ou importer des rubriques',
    'getting_started_public'   => 'Ouvrir la page publique de Classifieds',
    'category_in_use'         => 'Cette rubrique ne peut pas être supprimée car elle contient encore des annonces ou des sous-rubriques.',
    'dashboard_active'         => 'Annonces actives',
    'dashboard_expired'        => 'Annonces expirées',
    'dashboard_deleted'        => 'Annonces supprimées',
    'dashboard_categories'     => 'Rubriques actives',
    'dashboard_manage'         => 'Gérer les annonces',
    'dashboard_storage_warning'=> 'Le dossier des images Classifieds est absent ou non accessible en écriture.',
    'clid'                    => 'ID de l’annonce',
	'title'                   => 'Titre de l’annonce',
	'owner_id'                => 'ID du propriétaire',
	'created'                 => 'Création',
	'cid'                     => 'Cat. ID',
	'pid'                     => 'Rubrique parente',
	'category'                => 'Rubrique',
	'catorder'                => 'Ordre',
	'catdeleted'              => 'Statut',
	'root'                    => 'Rubrique racine',
    'root_category_help'      => 'Les rubriques racines servent uniquement à organiser les sous-rubriques et ne peuvent pas recevoir directement d’annonces. Les annonces doivent être publiées dans une sous-rubrique.',
	'deletion_succes'         => 'La suppression a réussi.',
    'deletion_fail'           => 'Oups ! La suppression a échoué.',
	'cat_informations'        => 'Informations de la rubrique',
	'parent_category'         => 'Rubrique parente',
	'enable'                  => 'Activer',
	'disable'                 => 'Désactiver',
	'edit_label'              => 'Modification',
	'create_new_cat'          => 'Créer une nouvelle rubrique',
    'insert_new_cat'          => 'Créer une nouvelle rubrique',
    'save_fail'               => 'Oups! La sauvegarde a échoué.',
    'save_success'            => 'La rubrique a bien été sauvegardée.',
    'seo_metadata'            => 'Métadonnées SEO',
    'meta_title'              => 'Méta-titre',
    'meta_description'        => 'Méta-description',
    'meta_keywords'           => 'Mots-clés méta',
    'modified'                => 'Modification',
	'online'                  => 'en ligne',
	'plugin_conf'             => 'La configuration du plugin Classifieds est également disponible',
	'plugin_doc'              => 'La documentation d\'installation, de mise à jour et d\'utilisation du plugin Classifieds est disponible',
    'publish_all_logged_in'      => 'Tous les utilisateurs enregistrés peuvent publier des annonces. Aucun groupe spécifique n’est actuellement requis.',
    'publish_restricted_group'   => 'La publication est réservée au groupe suivant :',
    'publish_restricted_groups'  => 'La publication est réservée aux %d groupes suivants :',
    'child_position'          => 'Position',
    'position_first'          => 'Première',
    'position_after'          => 'Après %s',
    'position_last'           => 'Dernière',
    'csv_import'              => 'Importer des rubriques depuis un CSV',
    'csv_documentation'       => 'Documentation de l’import CSV',
    'csv_documentation_link'  => 'Comment préparer le fichier CSV des rubriques',
    'csv_doc_intro'           => 'L’import CSV permet de créer une arborescence complète de rubriques sans manipuler les identifiants de la base de données. Préparez le fichier avec des clés stables, vérifiez la prévisualisation, puis confirmez l’import.',
    'csv_doc_format_title'    => 'Format du fichier',
    'csv_doc_format_text'     => 'Utilisez un fichier CSV UTF-8 comportant exactement quatre colonnes dans cet ordre. Les séparateurs virgule et point-virgule sont acceptés.',
    'csv_doc_columns_title'   => 'Colonnes',
    'csv_doc_key'             => 'Identifiant stable utilisé uniquement pendant l’import. Il doit être unique dans le fichier et peut contenir des lettres minuscules, chiffres, points, tirets bas et tirets.',
    'csv_doc_category'        => 'Nom de la rubrique affiché aux utilisateurs. Il ne doit pas être vide et peut contenir jusqu’à 32 caractères.',
    'csv_doc_parent'          => 'Clé de la rubrique parente. Laissez ce champ vide pour une rubrique racine. Un parent peut apparaître avant ou après ses enfants dans le fichier.',
    'csv_doc_order'           => 'Ordre d’affichage parmi les rubriques ayant le même parent. Utilisez un entier de 0 à 65535.',
    'csv_doc_hierarchy_title' => 'Rubriques et sous-rubriques',
    'csv_doc_hierarchy_text'  => 'Pour créer plusieurs niveaux, indiquez dans parent_key la key d’une autre ligne. L’importeur reconstruit automatiquement la hiérarchie : les valeurs cid/pid de la base ne doivent jamais figurer dans le CSV.',
    'csv_doc_rules_title'     => 'Règles importantes',
    'csv_doc_rule_utf8'       => 'Enregistrez le fichier en UTF-8. La présence d’un BOM UTF-8 est acceptée.',
    'csv_doc_rule_header'     => 'La première ligne doit être exactement : key,category,parent_key,order.',
    'csv_doc_rule_key'        => 'Chaque key doit être unique. Ne réutilisez pas la même clé pour deux rubriques.',
    'csv_doc_rule_parent'     => 'Chaque parent_key non vide doit correspondre à une key présente dans le même CSV. Les auto-parentés et les boucles sont refusées.',
    'csv_doc_rule_order'      => 'Les lignes peuvent être placées dans n’importe quel ordre ; la colonne order détermine l’ordre d’affichage et non l’ordre d’import.',
    'csv_doc_rule_existing'   => 'Si une rubrique portant le même nom existe déjà sous le même parent, elle est ignorée au lieu d’être dupliquée.',
    'csv_doc_rule_preview'    => 'Aucune écriture n’est effectuée pendant la prévisualisation. Le fichier complet est de nouveau validé avant l’import confirmé.',
    'csv_doc_workflow_title'  => 'Procédure conseillée',
    'csv_doc_step_template'   => 'Téléchargez le modèle CSV.',
    'csv_doc_step_edit'       => 'Modifiez les lignes dans un tableur ou un éditeur de texte en conservant l’en-tête à quatre colonnes.',
    'csv_doc_step_preview'    => 'Envoyez le fichier et vérifiez la prévisualisation, notamment les relations parent/enfant et le statut créer/ignorer.',
    'csv_doc_step_confirm'    => 'Confirmez uniquement lorsque la prévisualisation est correcte. L’écriture en base est transactionnelle.',
    'csv_template'            => 'Télécharger le modèle CSV',
    'csv_help'                => 'Importez des rubriques et sous-rubriques depuis un fichier CSV UTF-8. La colonne key identifie chaque ligne et parent_key référence sa rubrique parente. Laissez parent_key vide pour une rubrique racine. Les séparateurs virgule et point-virgule sont acceptés.',
    'csv_file'                => 'Fichier CSV',
    'csv_preview'             => 'Valider et prévisualiser',
    'csv_preview_title'       => 'Prévisualisation de l’import',
    'csv_preview_summary'     => '%d rubriques seront créées ; %d rubriques existantes seront ignorées.',
    'csv_confirm'             => 'Importer ces rubriques',
    'csv_key'                 => 'Clé',
    'csv_parent_key'          => 'Clé parente',
    'csv_status'              => 'Statut de l’import',
    'csv_status_create'       => 'Créer',
    'csv_status_skip'         => 'Existe déjà — ignorer',
    'csv_import_success'      => '%d rubriques créées ; %d rubriques existantes ignorées.',
    'csv_errors_title'        => 'Le fichier CSV ne peut pas être importé :',
    'csv_error_empty'         => 'Le fichier CSV est vide.',
    'csv_error_too_large'     => 'Le fichier CSV est trop volumineux (maximum 256 Ko).',
    'csv_error_read_failed'   => 'Le fichier CSV ne peut pas être lu.',
    'csv_error_upload'        => 'L’envoi du fichier CSV a échoué.',
    'csv_error_header'        => 'La première ligne doit être exactement : key,category,parent_key,order.',
    'csv_error_columns'       => 'Ligne %d : quatre colonnes sont attendues.',
    'csv_error_key'           => 'Ligne %d : clé « %s » invalide. Utilisez lettres, chiffres, points, tirets bas ou tirets.',
    'csv_error_duplicate_key' => 'Ligne %d : la clé « %s » est utilisée plusieurs fois.',
    'csv_error_category'      => 'Ligne %d : la rubrique « %s » est vide ou dépasse 32 caractères.',
    'csv_error_self_parent'   => 'Ligne %d : la clé « %s » ne peut pas être son propre parent.',
    'csv_error_order'         => 'Ligne %d : ordre « %s » invalide. Utilisez un entier entre 0 et 65535.',
    'csv_error_missing_parent'=> 'Ligne %d : la clé parente « %s » n’existe pas dans le fichier CSV.',
    'csv_error_cycle'         => 'Ligne %d : la clé « %s » appartient à une boucle de parenté.',
    'csv_error_database'      => 'La base de données a refusé l’import. Aucun import partiel n’a été conservé.',
    'csv_error_dependency'    => 'La hiérarchie des rubriques ne peut pas être résolue. Aucun import partiel n’a été conservé.',
    'csv_error_payload'       => 'Le contenu CSV validé est absent ou invalide.',
    'csv_error_token'         => 'Le jeton de sécurité a expiré. Relancez l’import.',
    'csv_error_invalid'       => 'La demande d’import CSV est invalide.',
	
);

$LANG_CLASSIFIEDS_EMAIL = array(
    'hello'                   => 'Bonjour',
    'new_ad'                  => 'Votre nouvelle annonce a été publiée.',
    'edit_ad'                 => 'Votre annonce a été mise à jour.',
    'delete_ad'               => 'Votre annonce a été retirée.',
    'expire_ad'               => 'Votre annonce est arrivée à expiration.',
    'online_for'              => 'Elle restera en ligne pendant',
    'days'                    => 'jours.',
    'price'                   => 'Prix :',
    'view_ad'                 => 'Voir l’annonce',
    'manage_ad'               => 'Gérer mon annonce',
    'my_ads'                  => 'Mes annonces',
    'post_new_button'         => 'Publier une nouvelle annonce',
    'publisher'               => 'Annonceur',
    'automatic_notice'        => 'Ceci est un message automatique. Merci de ne pas répondre à cet email.',
    'admin_manage'            => 'Gérer Classifieds',
    'subject_create'          => 'Nouvelle annonce',
    'subject_edit'            => 'Annonce mise à jour',
    'subject_delete'          => 'Annonce retirée',
    'subject_expire'          => 'Annonce expirée',

);


// Messages for the plugin upgrade
$PLG_classifieds_MESSAGE3002 = $LANG32[9]; // "requires a newer version of Geeklog"
$PLG_classifieds_MESSAGE1    = 'Hello world :)';

/**
*   Localization of the Admin Configuration UI
*   @global array $LANG_configsections['classifieds']
*/
$LANG_configsections['classifieds'] = array(
    'label' => 'Petites annonces',
    'title' => 'Configuration des petites annonces'
);

/**
*   Configuration system subgroup strings
*   @global array $LANG_configsubgroups['classifieds']
*/
$LANG_configsubgroups['classifieds'] = array(
    'sg_main' => 'Paramètres principaux'
);

$LANG_tab['classifieds'] = array(
    'tab_main' => 'Petites annonces'
);

/**
*   Configuration system fieldset names
*   @global array $LANG_fs['classifieds']
*/
$LANG_fs['classifieds'] = array(
    'fs_main'            => 'Paramètres généraux',
    'fs_images'          => 'Images',
	'fs_display'         => 'Affichage',
	'fs_email'           => 'Paramètres des emails',
    'fs_permissions'     => 'Permissions par défaut'
 );
 
/**
*   Configuration system prompt strings
*   @global array $LANG_confignames['classifieds']
*/
$LANG_confignames['classifieds'] = array(
    // Paramètres généraux
    'active_days' => 'Durée de validité des annonces',
    
	//Images settings
    'max_image_width'  => 'Largeur maximale des images',
	'max_image_height'  => 'Hauteur maximale des images',
    'max_image_size'  => 'Taille maximale d’une image',
    'max_images_per_ad'  => 'Nombre maximal d’images par annonce',

     //Display settings
    'menulabel'  => 'Libellé du menu',
    'hide_classifieds_menu'  => 'Masquer le menu des annonces',
    'classifieds_main_header'  => 'En-tête principal',
    'classifieds_main_footer'  => 'Pied de page principal',
    'classifieds_edit_header'  => 'En-tête du formulaire',
    'help_page'  => 'Page d’aide',
    'currency'  => 'Devise',
    'maxPerPage'  => 'Annonces par page',
	'allow_republish' => 'Permettre la republication des annonces',

    // Email settings
    'create_ad_email_user'  => 'Envoyer un email à l’utilisateur lors de la création',
    'mod_ad_email_user'  => 'Envoyer un email à l’utilisateur lors d’une modification',
    'delete_ad_email_user'  => 'Envoyer un email à l’utilisateur lors de la suppression',
    'expire_ad_email_user'  => 'Envoyer un email à l’utilisateur à l’expiration',
	'create_ad_email_admin'  => 'Envoyer un email à l’administrateur lors de la création',
    'mod_ad_email_admin'  => 'Envoyer un email à l’administrateur lors d’une modification',
    'delete_ad_email_admin'  => 'Envoyer un email à l’administrateur lors de la suppression',
    'expire_ad_email_admin'  => 'Envoyer un email à l’administrateur à l’expiration',
	
    //Permissions settings
    'classifieds_login_required'  => 'Connexion requise pour accéder aux annonces',
    'default_permissions'  => 'Permissions par défaut'
);

/**
*   Configuration system selection strings
*   Note: entries 0, 1, and 12 are the same as in 
*   $LANG_configselects['Core']
*
*   @global array $LANG_configselects['classifieds']
*/
$LANG_configselects['classifieds'] = array(
    3 => array('Oui' => 1, 'Non' => 0),
    12 => array('Aucun accès' => 0, 'Lecture seule' => 2, 'Lecture-écriture' => 3)
);

$LANG_configtooltips['classifieds'] = array(    'active_days' => 'Nombre de jours pendant lesquels une annonce reste active avant de pouvoir être notifiée comme expirée et republiée.',
    'max_image_size' => 'Taille maximale, en octets, pour une image envoyée avec une annonce.',
    'max_images_per_ad' => 'Nombre maximal d’images pouvant être associées à une annonce.',
    'allow_republish' => 'Permet de copier une annonce expirée vers une nouvelle annonce active tout en conservant l’ancienne dans l’historique.',
    'classifieds_login_required' => 'Lorsque cette option est activée, les visiteurs doivent se connecter pour accéder aux petites annonces.',
    'default_permissions' => 'Permissions ACL Geeklog appliquées aux nouveaux contenus Classifieds.'
);

?>
