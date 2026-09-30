<?php
// +--------------------------------------------------------------------------+
// | Classifieds Plugin - geeklog CMS                                         |
// +--------------------------------------------------------------------------+
// | Copyright (C) 2010 by the following authors:                             |
// |                                                                          |
// | Authors: ::Ben - cordiste AT free DOT fr                                 |
// +--------------------------------------------------------------------------+
// |                                                                          |
// | This program is free software; you can redistribute it and/or            |
// | modify it under the terms of the GNU General Public License              |
// | as published by the Free Software Foundation; either version 2           |
// | of the License, or (at your option) any later version.                   |
// |                                                                          |
// | This program is distributed in the hope that it will be useful,          |
// | but WITHOUT ANY WARRANTY; without even the implied warranty of           |
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            |
// | GNU General Public License for more details.                             |
// |                                                                          |
// | You should have received a copy of the GNU General Public License        |
// | along with this program; if not, write to the Free Software Foundation,  |
// | Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.          |
// |                                                                          |
// +--------------------------------------------------------------------------+

if (!defined ('VERSION')) {
    die ('This file can not be used on its own.');
}

/**
 * Classifieds plugin table(s)
 */
$_TABLES['cl'] = $_DB_table_prefix . 'cl';
$_TABLES['cl_cat'] = $_DB_table_prefix . 'cl_cat';
$_TABLES['cl_pic'] = $_DB_table_prefix . 'cl_pic';
$_TABLES['cl_users'] = $_DB_table_prefix . 'cl_users';

/**
* Classifieds Configuration.
 */
/*
 * Public plugin location.
 *
 * New installations always use /classifieds. Older installations may still
 * carry the historical classifieds_folder setting. It is no longer exposed in
 * Geeklog Configuration, but a genuinely existing custom public directory is
 * honored so an in-place upgrade cannot break an installation that physically
 * moved the public files.
 */
$classifiedsFolder = 'classifieds';
if (isset($_CLASSIFIEDS_CONF['classifieds_folder'])) {
    $legacyFolder = trim((string) $_CLASSIFIEDS_CONF['classifieds_folder'], '/\\');
    $legacyFolder = preg_replace('/[^A-Za-z0-9_-]/', '', $legacyFolder);

    if ($legacyFolder !== ''
        && $legacyFolder !== 'classifieds'
        && is_dir(rtrim($_CONF['path_html'], '/\\') . '/' . $legacyFolder)) {
        $classifiedsFolder = $legacyFolder;
    }
}

if (!defined('CLASSIFIEDS_PUBLIC_FOLDER')) {
    define('CLASSIFIEDS_PUBLIC_FOLDER', $classifiedsFolder);
}

$_CLASSIFIEDS_CONF['path_html'] = rtrim($_CONF['path_html'], '/\\')
    . '/' . CLASSIFIEDS_PUBLIC_FOLDER . '/';
$_CLASSIFIEDS_CONF['site_url'] = rtrim($_CONF['site_url'], '/')
    . '/' . CLASSIFIEDS_PUBLIC_FOLDER;
$_CLASSIFIEDS_CONF['debug'] = false;
$_CLASSIFIEDS_CONF['path_images'] = rtrim($_CONF['path_images'], '/\\')
    . '/classifieds/';

$imagesRelativePath = substr(
    rtrim($_CONF['path_images'], '/\\'),
    strlen(rtrim($_CONF['path_html'], '/\\'))
);
$imagesRelativePath = trim(str_replace('\\', '/', $imagesRelativePath), '/');

$_CLASSIFIEDS_CONF['url_images'] = rtrim($_CONF['site_url'], '/')
    . ($imagesRelativePath !== '' ? '/' . $imagesRelativePath : '')
    . '/classifieds/';

?>