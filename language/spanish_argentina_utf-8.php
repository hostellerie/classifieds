<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Classifieds Plugin 1.4.0                                                  |
// +---------------------------------------------------------------------------+
// | spanish_argentina_utf-8.php                                                               |
// |                                                                           |
// | Spanish Argentina language file                                                     |
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
    'plugin_name'             => 'Clasificados',
    'home'                    => 'Inicio',
	'place_an_ad'             => 'Publicar un anuncio',
	'offer'                   => 'Oferta',
	'demand'                  => 'Demanda',
	'offers'                  => 'Ofertas',
	'demands'                 => 'Demandas',
	'offers_demands'          => 'Ofertas y demandas',
	'my_ads'                  => 'Mis anuncios',
	'user_ads'                => 'Anuncios del usuario',
	'help'                    => 'Ayuda',
	'admin'                   => 'Administración',
	'access_reserved'         => 'Acceso restringido',
    'you_must_sign_in'        => 'Debe iniciar sesión para acceder a este anuncio.',
	'posted_by'               => 'Publicado por',
	'el'                      => 'el',
	'a las'                      => 'a las',
	'contact_advertiser'      => 'Contactar con el anunciante',
	'send_email'              => 'Enviar un correo electrónico',
	'double_point'            => ':',
	'manage_ad'               => 'Gestionar anuncio',
	'modify_ad'               => 'Modificar anuncio',
	'delete_ad'               => 'Eliminar anuncio',
	'price'                   => 'Precio',
	'category'                => 'Categoría',
	'postcode'                => 'Código postal',
	'enlarge_picture'         => 'Ampliar imagen',
    'previous_picture'        => 'Imagen anterior',
    'next_picture'            => 'Imagen siguiente',
    'close_picture'           => 'Cerrar visor de imágenes',
	'hits'                    => 'visitas',
	'no_ad'                   => 'Sin resultados',
	'no_ad_message'           => 'No se encontró ningún anuncio. Para publicar uno, pulse el botón "Publicar un anuncio".',
	'report'                  => 'Denunciar anuncio o abuso',
	'deleted'                 => 'ELIMINADO',
	'view_all'                => 'Ver todos los anuncios de este anunciante',
	'all_ads_from'            => 'Todos los anuncios publicados por',
	'search_button'           => 'Buscar',
	'choose_category'         => '-- Seleccione una categoría --',
	'all_categories'          => 'Todas las categorías',
	'profile'                 => 'Perfil del usuario',
	'classifieds_list'        => 'Anuncios',
	'categories_list'         => 'Categorías',
	'view_all_ads'            => 'Ver todos los anuncios',
	'under_construction'      => 'En construcción',
    'image_not_writable'      => 'La carpeta de imágenes de Clasificados no existe o no tiene permisos de escritura. Debe corregir este problema antes de usar el plugin.<br' . XHTML . '><br' . XHTML . '>Cree una subcarpeta classifieds dentro de la carpeta images.',
	'ad-list-active'          => 'Anuncio activo',
	'ad-list-delete'          => 'Anuncio eliminado',
	'ad-list-old'             => 'Anuncio caducado',
	'label-hits'              => 'Visitas',
	'deleted_ad'              => 'Este anuncio ya no está disponible',
	'last_ads'                => 'Últimos anuncios del sitio',
	'ads_not_available'       => 'Este anuncio no está disponible',
	'all_ads'                 => 'Todos los anuncios',
    'profile_no_ad'           => 'No hay anuncios activos',
);

//Ad form create, edit ,delete
$LANG_CLASSIFIEDS_2 = array(
    'deletion_succes'         => 'El anuncio se eliminó correctamente.',
    'deletion_fail'           => '¡Ups! No se pudo eliminar el anuncio.',
	'error'                   => '¡Ups! Se produjo un error.',
	'missing_field'           => 'Faltan algunos campos obligatorios:',
    'check_it'                => 'Revise los campos antes de enviar el anuncio.',
	'save_fail'               => '¡Ups! No se pudo guardar.',
	'save_success'            => 'Su anuncio se guardó correctamente.',
	'message'                 => 'Mensaje del sistema',
	'insert_new_ad'           => 'Publicar un nuevo anuncio',
	'edit_label'              => 'Editar anuncio:',
	'your_ad'                 => 'Su anuncio',
	'category'                => 'Categoría',
	'title'                   => 'Título del anuncio',
	'type'                    => 'Tipo',
	'offer'                   => 'Oferta',
	'demand'                  => 'Demanda',
	'choose_category'         => '-- Elija una categoría --',
	'choose_type'             => '-- Elija el tipo de anuncio --',
	'text'                    => 'Texto del anuncio',
	'price'                   => 'Precio',
	'images'                  => 'Sus imágenes',
    'image_upload_label'      => 'Añadir imágenes',
    'image_upload_help'       => 'Seleccione hasta %d imágenes a la vez (%d como máximo por anuncio).',
    'image_upload_failed'     => 'No se pudo subir o redimensionar la imagen.',
    'image_too_large_no_resizer' => 'La imagen supera %d × %d píxeles y no hay ninguna biblioteca de redimensionado disponible.',
	'your_details'            => 'Sus datos',
	'status'                     => 'Estado',
	'choose_status'           => '-- Elija su estado --',
	'private'                 => 'Particular',
	'professional'            => 'Profesional',
	'siren'                   => 'ID profesional',
	'tel'                     => 'Tel.',
	'hide_tel'                 => 'Ocultar mi teléfono en el anuncio',
	'postcode'                => 'Código postal',
	'city'                    => 'Ciudad',
	'save_button'             => 'Guardar',
	'delete_button'           => 'Eliminar',
	'required_field'          => 'Indica un campo obligatorio',
	'validate_button'         => 'Validar',
    'copy_button'             => 'Republicar este anuncio',
	'access_reserved'         => 'Acceso restringido. Para usar esta función debe pertenecer al grupo:',
);

$LANG_CLASSIFIEDS_ADMIN = array(
    'administration'          => 'Administración de Clasificados',
    'configuration'           => 'Configuración',
    'getting_started_title'    => 'Primeros pasos',
    'getting_started_intro'    => 'Configure los ajustes esenciales, cree o importe categorías y compruebe la página pública de Clasificados.',
    'getting_started_configure'=> 'Revisar la configuración de Clasificados',
    'getting_started_categories'=> 'Crear o importar categorías',
    'getting_started_public'   => 'Abrir la página pública de Clasificados',
    'category_in_use'         => 'Esta categoría no puede eliminarse mientras contenga anuncios o subcategorías.',
    'dashboard_active'         => 'Anuncios activos',
    'dashboard_expired'        => 'Anuncios caducados',
    'dashboard_deleted'        => 'Anuncios eliminados',
    'dashboard_categories'     => 'Categorías activas',
    'dashboard_manage'         => 'Gestionar Clasificados',
    'dashboard_storage_warning'=> 'El directorio de imágenes de Clasificados no existe o no tiene permisos de escritura.',
    'clid'                    => 'ID del anuncio',
	'title'                   => 'Título del anuncio',
	'owner_id'                => 'ID del propietario',
	'created'                 => 'Creado',
	'cid'                     => 'ID cat.',
	'pid'                     => 'Categoría superior',
	'category'                => 'Categoría',
	'catorder'                => 'Orden',
	'catdeleted'              => 'Estado',
	'root'                    => 'Categoría raíz',
    'root_category_help'      => 'Las categorías raíz solo organizan subcategorías y no pueden recibir anuncios directamente. Los anuncios deben publicarse en una subcategoría.',
	'deletion_succes'         => 'La eliminación se realizó correctamente.',
    'deletion_fail'           => '¡Ups! La eliminación falló.',
	'cat_informations'        => 'Información de la categoría',
	'parent_category'         => 'Categoría superior',
	'enable'                  => 'Activar',
	'disable'                 => 'Desactivar',
	'edit_label'              => 'Edición',
	'create_new_cat'          => 'Crear una nueva categoría',
    'insert_new_cat'          => 'Crear una nueva categoría',
    'save_fail'               => '¡Ups! No se pudo guardar.',
    'save_success'            => 'La categoría se guardó correctamente.',
    'seo_metadata'            => 'Metadatos SEO',
    'meta_title'              => 'Título meta',
    'meta_description'        => 'Descripción meta',
    'meta_keywords'           => 'Palabras clave meta',
    'modified'                => 'Modificado',
	'en línea'                  => 'en línea',
	'plugin_conf'             => 'La configuración del plugin Clasificados también está',
	'plugin_doc'              => 'La documentación de instalación, actualización y uso del plugin Clasificados está',
    'publish_all_logged_in'      => 'Todos los usuarios registrados pueden publicar anuncios. Actualmente no se requiere ningún grupo específico.',
    'publish_restricted_group'   => 'La publicación está restringida al siguiente grupo:',
    'publish_restricted_groups'  => 'La publicación está restringida a los siguientes %d grupos:',
    'child_position'          => 'Posición',
    'position_first'          => 'Primera',
    'position_after'          => 'Después de %s',
    'position_last'           => 'Última',
    'csv_import'              => 'Importar categorías desde CSV',
    'csv_documentation'       => 'Documentación de importación CSV',
    'csv_documentation_link'  => 'Cómo preparar el archivo CSV de categorías',
    'csv_doc_intro'           => 'El importador CSV permite crear árboles completos de categorías sin usar ID de base de datos. Prepare el archivo con claves estables, valide la vista previa y confirme la importación.',
    'csv_doc_format_title'    => 'Formato de archivo',
    'csv_doc_format_text'     => 'Use un archivo CSV UTF-8 con exactamente cuatro columnas en este orden. Se aceptan comas y puntos y coma como separadores.',
    'csv_doc_columns_title'   => 'Columnas',
    'csv_doc_key'             => 'Identificador estable usado solo durante la importación. Debe ser único en el archivo y puede contener letras minúsculas, dígitos, puntos, guiones bajos y guiones.',
    'csv_doc_category'        => 'Etiqueta de categoría mostrada a los usuarios. No puede estar vacía y puede tener hasta 32 caracteres.',
    'csv_doc_parent'          => 'Clave de la categoría superior. Déjela vacía para una categoría raíz. Una categoría superior puede aparecer antes o después de sus hijas.',
    'csv_doc_order'           => 'Orden de visualización entre categorías con el mismo padre. Use un entero de 0 a 65535.',
    'csv_doc_hierarchy_title' => 'Categorías y subcategorías',
    'csv_doc_hierarchy_text'  => 'Para crear varios niveles, haga que parent_key apunte a la key de otra fila. El importador resuelve la jerarquía automáticamente; los valores cid/pid de la base de datos no deben aparecer en el CSV.',
    'csv_doc_rules_title'     => 'Reglas importantes',
    'csv_doc_rule_utf8'       => 'Guarde el archivo como UTF-8. Se admite un BOM UTF-8.',
    'csv_doc_rule_header'     => 'La primera fila debe ser exactamente: key,category,parent_key,order.',
    'csv_doc_rule_key'        => 'Cada key debe ser única. No reutilice una key para dos categorías.',
    'csv_doc_rule_parent'     => 'Cada parent_key no vacía debe referenciar una key presente en el mismo CSV. Se rechazan autorreferencias y ciclos.',
    'csv_doc_rule_order'      => 'Las filas pueden aparecer en cualquier orden; la columna order controla el orden de visualización, no el de importación.',
    'csv_doc_rule_existing'   => 'Si ya existe una categoría con el mismo nombre bajo el mismo padre, se omite en lugar de duplicarse.',
    'csv_doc_rule_preview'    => 'Durante la vista previa no se escribe nada. El archivo completo se valida de nuevo antes de la importación confirmada.',
    'csv_doc_workflow_title'  => 'Flujo de trabajo recomendado',
    'csv_doc_step_template'   => 'Descargue la plantilla CSV.',
    'csv_doc_step_edit'       => 'Edite las filas en una hoja de cálculo o editor de texto conservando la cabecera de cuatro columnas.',
    'csv_doc_step_preview'    => 'Suba el archivo y revise la vista previa de validación, especialmente las relaciones padre/hijo y el estado crear/omitir.',
    'csv_doc_step_confirm'    => 'Confirme solo cuando la vista previa sea correcta. La escritura en la base de datos es transaccional.',
    'csv_template'            => 'Descargar plantilla CSV',
    'csv_help'                => 'Importe categorías y subcategorías desde un CSV UTF-8. Use key para identificar cada fila y parent_key para referenciar su padre. Deje parent_key vacío para categorías raíz. Se aceptan comas y puntos y coma como separadores.',
    'csv_file'                => 'Archivo CSV',
    'csv_preview'             => 'Validar y previsualizar',
    'csv_preview_title'       => 'Vista previa de importación',
    'csv_preview_summary'     => 'Se crearán %d categorías; se omitirán %d categorías existentes.',
    'csv_confirm'             => 'Importar estas categorías',
    'csv_key'                 => 'Clave',
    'csv_parent_key'          => 'Clave superior',
    'csv_status'              => 'Estado de importación',
    'csv_status_create'       => 'Crear',
    'csv_status_skip'         => 'Ya existe — omitir',
    'csv_import_success'      => '%d categorías creadas; %d categorías existentes omitidas.',
    'csv_errors_title'        => 'El archivo CSV no puede importarse:',
    'csv_error_empty'         => 'El archivo CSV está vacío.',
    'csv_error_too_large'     => 'El archivo CSV es demasiado grande (máximo 256 KB).',
    'csv_error_read_failed'   => 'No se pudo leer el archivo CSV.',
    'csv_error_upload'        => 'Falló la subida del archivo CSV.',
    'csv_error_header'        => 'La primera fila debe ser exactamente: key,category,parent_key,order.',
    'csv_error_columns'       => 'Línea %d: se esperaban exactamente cuatro columnas.',
    'csv_error_key'           => 'Línea %d: clave "%s" no válida. Use letras, dígitos, puntos, guiones bajos o guiones.',
    'csv_error_duplicate_key' => 'Línea %d: clave duplicada "%s".',
    'csv_error_category'      => 'Línea %d: la categoría "%s" está vacía o supera 32 caracteres.',
    'csv_error_self_parent'   => 'Línea %d: la clave "%s" no puede ser su propio padre.',
    'csv_error_order'         => 'Línea %d: orden "%s" no válido. Use un entero entre 0 y 65535.',
    'csv_error_missing_parent'=> 'Línea %d: la clave superior "%s" no existe en el archivo CSV.',
    'csv_error_cycle'         => 'Línea %d: la clave "%s" forma parte de un ciclo de jerarquía.',
    'csv_error_database'      => 'La base de datos rechazó la importación. No se conservó ninguna importación parcial.',
    'csv_error_dependency'    => 'No se pudo resolver la jerarquía de categorías. No se conservó ninguna importación parcial.',
    'csv_error_payload'       => 'Los datos CSV validados faltan o no son válidos.',
    'csv_error_token'         => 'El token de seguridad caducó. Vuelva a intentar la importación.',
    'csv_error_invalid'       => 'La solicitud de importación CSV no es válida.',
	
);

$LANG_CLASSIFIEDS_EMAIL = array(
    'hello'                   => 'Hola',
    'new_ad'                  => 'Su nuevo anuncio se ha publicado.',
    'edit_ad'                 => 'Su anuncio se ha actualizado.',
    'delete_ad'               => 'Su anuncio se ha retirado.',
    'expire_ad'               => 'Su anuncio ha caducado.',
    'online_for'              => 'Permanecerá en línea durante',
    'days'                    => 'días.',
    'price'                   => 'Precio:',
    'view_ad'                 => 'Ver anuncio',
    'manage_ad'               => 'Gestionar mi anuncio',
    'my_ads'                  => 'Mis anuncios',
    'post_new_button'         => 'Publicar un nuevo anuncio',
    'publisher'               => 'Anunciante',
    'automatic_notice'        => 'Este es un mensaje automático. No responda a este correo.',
    'admin_manage'            => 'Gestionar Clasificados',
    'subject_create'          => 'Nuevo anuncio',
    'subject_edit'            => 'Anuncio actualizado',
    'subject_delete'          => 'Anuncio retirado',
    'subject_expire'          => 'Anuncio caducado',

);


// Messages for the plugin upgrade
$PLG_classifieds_MESSAGE3002 = $LANG32[9]; // "requires a newer version of Geeklog"
$PLG_classifieds_MESSAGE1    = 'Hello world :)';

/**
*   Localization of the Admin Configuration UI
*   @global array $LANG_configsections['classifieds']
*/
$LANG_configsections['classifieds'] = array(
    'label' => 'Clasificados',
    'title' => 'Configuración de Clasificados'
);

/**
*   Configuration system subgroup strings
*   @global array $LANG_configsubgroups['classifieds']
*/
$LANG_configsubgroups['classifieds'] = array(
    'sg_main' => 'Configuración principal'
);

$LANG_tab['classifieds'] = array(
    'tab_main' => 'Clasificados'
);

/**
*   Configuration system fieldset names
*   @global array $LANG_fs['classifieds']
*/
$LANG_fs['classifieds'] = array(
    'fs_main'            => 'Configuración general',
    'fs_images'          => 'Configuración de imágenes',
	'fs_display'         => 'Configuración de visualización',
	'fs_email'           => 'Configuración de correo',
    'fs_permissions'     => 'Permisos predeterminados'
 );
 
/**
*   Configuration system prompt strings
*   @global array $LANG_confignames['classifieds']
*/
$LANG_confignames['classifieds'] = array(
    // Main settings
    'active_days' => 'Días activos',
    
	//Images settings
    'max_image_width'  => 'Anchura máxima de imagen',
	'max_image_height'  => 'Altura máxima de imagen',
    'max_image_size'  => 'Tamaño máximo de imagen',
    'max_images_per_ad'  => 'Máximo de imágenes por anuncio',

     //Display settings
    'menulabel'  => 'Etiqueta del menú',
    'hide_classifieds_menu'  => 'Ocultar menú de Clasificados',
    'classifieds_main_header'  => 'Cabecera principal',
    'classifieds_main_footer'  => 'Pie principal',
    'classifieds_edit_header'  => 'Cabecera del editor',
    'help_page'  => 'Página de ayuda',
    'currency'  => 'Moneda',
    'maxPerPage'  => 'Máximo por página',
	'allow_republish' => 'Permitir republicar anuncios',

    // Email settings
    'create_ad_email_user'  => 'Enviar correo al usuario al crear el anuncio',
    'mod_ad_email_user'  => 'Enviar correo al usuario al modificar el anuncio',
    'delete_ad_email_user'  => 'Enviar correo al usuario al eliminar el anuncio',
    'expire_ad_email_user'  => 'Enviar correo al usuario al caducar el anuncio',
	'create_ad_email_admin'  => 'Enviar correo al administrador al crear el anuncio',
    'mod_ad_email_admin'  => 'Enviar correo al administrador al modificar el anuncio',
    'delete_ad_email_admin'  => 'Enviar correo al administrador al eliminar el anuncio',
    'expire_ad_email_admin'  => 'Enviar correo al administrador al caducar el anuncio',

    //Permissions settings
    'classifieds_login_required'  => 'Inicio de sesión obligatorio para acceder a Clasificados',
    'default_permissions'  => 'Permisos predeterminados'
);

/**
*   Configuration system selection strings
*   Note: entries 0, 1, and 12 are the same as in 
*   $LANG_configselects['Core']
*
*   @global array $LANG_configselects['classifieds']
*/
$LANG_configselects['classifieds'] = array(
    3 => array('Sí' => 1, 'No' => 0),
    12 => array('Sin acceso' => 0, 'Solo lectura' => 2, 'Lectura y escritura' => 3)
);

$LANG_configtooltips['classifieds'] = array(    'active_days' => 'Número de días que un anuncio permanece activo antes de poder notificarse como caducado y republicarse.',
    'max_image_size' => 'Tamaño máximo de subida en bytes para una imagen del anuncio.',
    'max_images_per_ad' => 'Número máximo de imágenes que pueden adjuntarse a un anuncio.',
    'allow_republish' => 'Permite copiar anuncios caducados aptos a un nuevo anuncio activo conservando el original en el historial.',
    'classifieds_login_required' => 'Cuando está activado, los visitantes deben iniciar sesión antes de acceder a Clasificados.',
    'default_permissions' => 'Permisos ACL de Geeklog aplicados al nuevo contenido de Clasificados.'
);
?>
