<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Classifieds Plugin 1.4.0-dev                                                  |
// +---------------------------------------------------------------------------+
// | french_france_utf-8.php                                                   |
// |                                                                           |
// | French language file                                                      |
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
    'home'                    => 'Home',
	'place_an_ad'             => 'Publier une annonce',
	'offer'                   => 'Offre',
	'demand'                  => 'Recherche',
	'offers'                  => 'Offres',
	'demands'                 => 'Recherches',
	'offers_demands'          => 'Offres et recherches',
	'my_ads'                  => 'Mes annonces',
	'user_ads'                => 'Les annonces',
	'pro'                     => 'Compte Pro',
	'help'                    => 'Aide',
	'admin'                   => 'Admin',
	'access_reserved'         => 'Accés réservé aux membres',
    'you_must_sign_in'        => 'Vous devez vous connecter à l\'espace membre pour vour cette annonce.',
	'posted_by'               => 'Publiée par',
	'on'                      => 'le',
	'at'                      => 'à',
	'contact_advertiser'      => 'Contactez l\'annonceur',
	'send_email'              => 'Envoyez un email',
	'double_point'            => ' :',
	'manage_ad'               => 'Gérer l\'annonce',
	'modify_ad'               => 'Modifier l\'annonce',
	'delete_ad'               => 'Effacer l\'annonce',
	'save_ad'                 => 'Sauvegarder l\'annonce',
	'price'                   => 'Prix',
	'category'                => 'Rubrique',
	'postcode'                => 'Code postal',
	'enlarge_picture'         => 'Agrandir l\'image',
	'hits'                    => 'visites',
	'no_ad'                   => 'Aucun résultat',
	'no_ad_message'           => 'Désolé, aucune annonce n\'a été trouvée. Pour en publier une, cliquez sur "Publier une annonce".',
	'delete_confirm'          => 'Souhaitez vous réellement effacer cette annonce ?',
	'report'                  => 'Signaler cette annonce ou un abus',
	'deleted'                 => 'DELETED',
	'view_all'                => 'Voir toutes les annonces de ce membre',
	'all_ads_from'            => 'Toutes les annonces publiées par',
	'search_button'           => 'Chercher',
	'choose_category'         => '-- Choisir une rubriques --',
	'all_categories'          => 'Toutes les rubriques',
	'profile'                 => 'Profil du membre',
	'classifieds_list'        => 'Les annonces',
	'categories_list'         => 'Les rubriques',
	'view_all_ads'            => 'Voir toutes les annonces',
	'under_construction'      => 'En construction',
    'image_not_writable'      => 'Le dossier de stockage des images du plugin classifieds n\'existe pas ou n\'est pas accessible en écriture. Vous devez vérifier ce problème avant d\'utiliser le plugin classifieds.<br' . XHTML . '><br' . XHTML . '>Pour des raisons de compatibilité avec le plugin multi, le nom de dossier qui contient le dossier "classifieds" est paramétrable et doit être un sous dossier du dossier images. D\'autres plugins ayant recours au stockage d\'images utiliseront cette classification.<br' . XHTML . '><br' . XHTML . '>Vous pouvez modifier le nom du dossier dans la configuration du plugin.',
    'install_jquery'          => 'Pour permettre aux utilisateurs de votre site d\'afficher les images des petites annonces dans une lightbox, vous devez installer le plugin jQuery pour Geeklog.',
	'ad-list-active'          => 'Annonce active',
	'ad-list-delete'          => 'Annonce effacée',
	'ad-list-old'             => 'Annonce périmée',
	'label-hits'              => 'Visites',
	'deleted_ad'              => 'Désolé, cette annonce n\'est plus disponible.',
	'last_ads'                => 'Les dernières annonces sur le site',
	'ads_not_available'       => 'Cette annonce n\'est plus disponible.',
	'relay'                   => 'Relayer cette annonce',
	'all_ads'                 => 'Toutes les annonces',
    'profile_no_ad'           => 'Aucune petite-annonce en cours',

);

//Ad form create, edit ,delete
$LANG_CLASSIFIEDS_2 = array(
    'deletion_succes'         => 'L\'annonce a bien été supprimée.',
    'deletion_fail'           => 'Oups! La suppression a échouée.',
	'error'                   => 'Oups il y a une erreur !',
	'missing_field'           => 'Des champs nécessaires sont manquants :',
    'check_it'                => 'Merci de vérifier tous les champs marqués d\'un astérix rouge avant de soumettre à nouveau votre annonce.',
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
	'your_details'            => 'Vos coordonnées',
	'status'                  => 'Status',
	'choose_status'           => '-- Choisir votre status --',
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
    'clid'                    => 'Ad ID',
	'title'                   => 'Ad title',
	'owner_id'                => 'Owner ID',
	'created'                 => 'Création',
	'cid'                     => 'Cat. ID',
	'pid'                     => 'Parent cat.',
	'category'                => 'Category',
	'catorder'                => 'Order',
	'catdeleted'              => 'Status',
	'root'                    => 'Root category',
	'deletion_succes'         => 'The deletion was successful.',
    'deletion_fail'           => 'Oups! The deletion failed.',
	'cat_informations'        => 'Category informations',
	'parent_category'         => 'Parent category',
	'enable'                  => 'Enable',
	'disable'                 => 'Disable',
	'edit_label'              => 'Editing',
	'create_new_cat'          => 'Créer une nouvelle rubrique',
    'modified'                => 'Modification',
	'online'                  => 'en ligne',
	'plugin_conf'             => 'La configuration du plugin classifieds est aussi',
	'plugin_doc'              => 'La documentation pour l\'installation, la mise à jour et l\'usage du plugin classifieds est',
	'no_group_access'         => 'Warning: No group has the right to publish ads. To allow all users to publish ads, create a new group in the admin area. For this new group check "Default group", check Apply "Default Group" change to existing user accounts to make this a default group for new users, and check classifieds.publish rights.', 
	'group_access'            => 'group has right to publish ads', 
	'groups_access'           => 'groups have right to publish ads', 
	
);

$LANG_CLASSIFIEDS_EMAIL = array(
    'hello'                   => 'Bonjour',
    'new_ad'                  => 'Votre nouvelle annonce a été publiée sur le site',
	'edit_ad'                 => 'Votre annonce a été modifiée sur le site',
	'delete_ad'               => 'Votre annonce a été retirée du site',
	'expire_ad'               => 'Votre annonce est arrivée a expiration sur le site',
	'online_for'              => 'et sera en ligne pendant',
	'days'                    => 'jours.',
	'post_new'                => 'Vous pouvez en publier une nouvelle sur la page',
	'you_can_see'             => 'Vous pouvez la voir sur la page',
	'thanks'                  => 'Merci,',
	'sign'                    => 'L\'administrateur du site.',
	'no_reply'                => 'PS: Ceci est un email automatique, merci de ne pas y répondre.',
	'your_ad'                 => 'Votre annonce :',
	'price'                   => 'Prix :',
);

$LANG_CLASSIFIEDS_LOGIN = array(
    1                         => 'Connexion nécessaire',
    2                         => 'Pour pouvoir utiliser cette fonction vous devez vous connecter à l\'espace membre du site.'
);
// Messages for the plugin upgrade
$PLG_classifieds_MESSAGE3002 = $LANG32[9]; // "requires a newer version of Geeklog"
$PLG_classifieds_MESSAGE1    = 'Hello world :)';

/**
*   Localization of the Admin Configuration UI
*   @global array $LANG_configsections['classifieds']
*/
$LANG_configsections['classifieds'] = array(
    'label' => 'Classifieds',
    'title' => 'Classifieds Configuration'
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
    //Main settings
	'classifieds_folder'  => 'Dossier public des annonces',
	'active_days'  => 'Durée de validité des annonces',
    
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
    'date_format'  => 'Format de date',
    'time_format'  => 'Format de l’heure',
    'maxPerPage'  => 'Annonces par page',
	'allow_republish' => 'Permettre la republication des annonces',

    // Email settings
    'create_ad_email_user'  => 'Email user on ad creation',
    'mod_ad_email_user'  => 'Email user on ad modification',
    'delete_ad_email_user'  => 'Email user on ad delete',
    'expire_ad_email_user'  => 'Email user on ad expire',
	'create_ad_email_admin'  => 'Email admin on ad creation',
    'mod_ad_email_admin'  => 'Email admin on ad modification',
    'delete_ad_email_admin'  => 'Email admin on ad delete',
    'expire_ad_email_admin'  => 'Email admin on ad expire',
	
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

$LANG_configtooltips['classifieds'] = array(
    'classifieds_folder' => 'Dossier public utilisé par les pages des petites annonces. Sur un site existant, sa modification nécessite de conserver la cohérence des fichiers publics et des liens.',
    'active_days' => 'Nombre de jours pendant lesquels une annonce reste active avant de pouvoir être notifiée comme expirée et republiée.',
    'max_image_size' => 'Taille maximale, en octets, pour une image envoyée avec une annonce.',
    'max_images_per_ad' => 'Nombre maximal d’images pouvant être associées à une annonce.',
    'allow_republish' => 'Permet de copier une annonce expirée vers une nouvelle annonce active tout en conservant l’ancienne dans l’historique.',
    'classifieds_login_required' => 'Lorsque cette option est activée, les visiteurs doivent se connecter pour accéder aux petites annonces.',
    'default_permissions' => 'Permissions ACL Geeklog appliquées aux nouveaux contenus Classifieds.'
);

?>
