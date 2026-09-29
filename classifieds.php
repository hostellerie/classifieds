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
$classifiedsFolder = isset($_CLASSIFIEDS_CONF['classifieds_folder'])
    ? trim((string) $_CLASSIFIEDS_CONF['classifieds_folder'], '/\\')
    : 'classifieds';
$classifiedsFolder = preg_replace('/[^A-Za-z0-9_-]/', '', $classifiedsFolder);
if ($classifiedsFolder === '') {
    $classifiedsFolder = 'classifieds';
}

$_CLASSIFIEDS_CONF['classifieds_folder'] = $classifiedsFolder;
$_CLASSIFIEDS_CONF['path_html'] = rtrim($_CONF['path_html'], '/\\')
    . '/' . $classifiedsFolder . '/';
$_CLASSIFIEDS_CONF['site_url'] = rtrim($_CONF['site_url'], '/')
    . '/' . $classifiedsFolder;
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