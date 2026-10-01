<?php
// +---------------------------------------------------------------------------+
// | Classifieds Plugin 1.4.0                                              |
// +---------------------------------------------------------------------------+
// | Local image persistence helpers.                                          |
// +---------------------------------------------------------------------------+

if (!defined('VERSION')) {
    die('This file can not be used on its own.');
}

function CLASSIFIEDS_saveImage($ad, $FILES, $clid)
{
    global $_CONF, $_CLASSIFIEDS_CONF, $_TABLES;

    $result = array(
        'ok' => false,
        'uploaded_files' => array(),
        'delete_files' => array()
    );

    $clid = (int) $clid;
    if ($clid <= 0) {
        return $result;
    }

    $args = is_array($ad) ? $ad : array();
    $FILES = is_array($FILES) ? $FILES : array();

    $deleteNumbers = array();
    if (isset($args['delete']) && is_array($args['delete'])) {
        foreach (array_keys($args['delete']) as $imageNumber) {
            $imageNumber = (int) $imageNumber;
            if ($imageNumber > 0) {
                $deleteNumbers[$imageNumber] = $imageNumber;
            }
        }
    }

    $existingCount = (int) DB_count($_TABLES['cl_pic'], 'pi_pid', $clid);
    $remainingCount = max(0, $existingCount - count($deleteNumbers));
    $maxImages = max(0, (int) $_CLASSIFIEDS_CONF['max_images_per_ad']);
    $availableSlots = max(0, $maxImages - $remainingCount);

    $uploadFiles = array();
    foreach ($FILES as $file) {
        if (!is_array($file) || empty($file['name'])) {
            continue;
        }

        $uploadFiles[] = $file;
        if (count($uploadFiles) >= $availableSlots) {
            break;
        }
    }

    if (!empty($uploadFiles) && $availableSlots > 0) {
        require_once $_CONF['path_system'] . 'classes/upload.class.php';

        $upload = new upload();

        if (!empty($_CONF['debug_image_upload'])) {
            $upload->setLogFile($_CONF['path'] . 'logs/error.log');
            $upload->setDebug(true);
        }

        $upload->setMaxFileUploads($availableSlots);

        if (!empty($_CONF['image_lib'])) {
            if ($_CONF['image_lib'] === 'imagemagick') {
                $upload->setMogrifyPath($_CONF['path_to_mogrify']);
            } elseif ($_CONF['image_lib'] === 'netpbm') {
                $upload->setNetPBM($_CONF['path_to_netpbm']);
            } elseif ($_CONF['image_lib'] === 'gdlib') {
                $upload->setGDLib();
            }

            $upload->setAutomaticResize(true);
            $upload->keepOriginalImage(false);

            if (isset($_CONF['jpeg_quality'])) {
                $upload->setJpegQuality($_CONF['jpeg_quality']);
            }
        }

        $upload->setAllowedMimeTypes(array(
            'image/gif'   => '.gif',
            'image/jpeg'  => '.jpg,.jpeg',
            'image/pjpeg' => '.jpg,.jpeg',
            'image/x-png' => '.png',
            'image/png'   => '.png'
        ));

        if (!$upload->setPath($_CLASSIFIEDS_CONF['path_images'])) {
            COM_errorLog('Classifieds: image upload path is unavailable.');
            return $result;
        }

        $upload->setMaxDimensions(
            (int) $_CLASSIFIEDS_CONF['max_image_width'],
            (int) $_CLASSIFIEDS_CONF['max_image_height']
        );
        $upload->setMaxFileSize((int) $_CLASSIFIEDS_CONF['max_image_size']);
        $upload->setPerms('0644');

        $nextNumber = (int) DB_getItem(
            $_TABLES['cl_pic'],
            'MAX(pi_img_num)',
            "pi_pid = '" . $clid . "'"
        ) + 1;

        $filenames = array();
        $imageNumbers = array();

        foreach ($uploadFiles as $file) {
            $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
            if ($extension === 'jpeg') {
                $extension = 'jpg';
            }

            if (!in_array($extension, array('jpg', 'png', 'gif'), true)) {
                COM_errorLog(
                    'Classifieds: rejected image with unsupported filename extension.'
                );
                CLASSIFIEDS_cleanupImageFiles($filenames);
                return $result;
            }

            $filename = $clid . '_' . $nextNumber . '.' . $extension;
            $filenames[] = $filename;
            $imageNumbers[] = $nextNumber;
            $nextNumber++;
        }

        $upload->setFileNames($filenames);
        $upload->uploadFiles();

        if ($upload->areErrors()) {
            CLASSIFIEDS_cleanupImageFiles($filenames);
            COM_errorLog('Classifieds: one or more ad images could not be uploaded.');
            return $result;
        }

        foreach ($filenames as $index => $filename) {
            DB_query(
                "INSERT INTO {$_TABLES['cl_pic']} "
                . "(pi_pid, pi_img_num, pi_filename) VALUES ('"
                . $clid . "', " . (int) $imageNumbers[$index] . ", '"
                . DB_escapeString($filename) . "')"
            );

            if (DB_error()) {
                CLASSIFIEDS_cleanupImageFiles($filenames);
                COM_errorLog('Classifieds: unable to persist uploaded image metadata.');
                return $result;
            }

            $result['uploaded_files'][] = $filename;
        }
    }

    // Stage old image deletions in SQL only. Physical files are removed after
    // the outer ad transaction commits successfully.
    foreach ($deleteNumbers as $imageNumber) {
        $filename = DB_getItem(
            $_TABLES['cl_pic'],
            'pi_filename',
            "pi_pid = '" . $clid . "' AND pi_img_num = " . (int) $imageNumber
        );

        if ($filename !== '') {
            $result['delete_files'][] = basename($filename);
        }

        DB_query(
            "DELETE FROM {$_TABLES['cl_pic']} WHERE pi_pid = '"
            . $clid . "' AND pi_img_num = " . (int) $imageNumber
        );

        if (DB_error()) {
            CLASSIFIEDS_cleanupImageFiles($result['uploaded_files']);
            return $result;
        }
    }

    $result['ok'] = true;

    return $result;
}

/**
 * Remove local image files by filename.
 *
 * @param array $files
 * @return void
 */
function CLASSIFIEDS_cleanupImageFiles($files)
{
    if (!is_array($files)) {
        return;
    }

    foreach ($files as $file) {
        CLASSIFIEDS_deleteImage($file);
    }
}

/**
* Delete one image from an ad
*
* @param    string  $image  file name of the image (without the path)
*
*/
function CLASSIFIEDS_deleteImage($image)
{
    global $_CLASSIFIEDS_CONF;

    if (empty($image)) {
        return true;
    }

    $path = $_CLASSIFIEDS_CONF['path_images'] . basename($image);
    if (!is_file($path)) {
        return true;
    }

    return unlink($path);
}


