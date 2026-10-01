<?php
// +---------------------------------------------------------------------------+
// | Classifieds Plugin 1.4.0                                              |
// +---------------------------------------------------------------------------+
// | Local image persistence helpers.                                          |
// +---------------------------------------------------------------------------+

if (!defined('VERSION')) {
    die('This file can not be used on its own.');
}

/**
 * Flatten PHP's $_FILES structures into ordinary file arrays.
 *
 * Supports both historical file1/file2 inputs and modern images[] batches.
 *
 * @param array $files
 * @return array
 */
function CLASSIFIEDS_normalizeUploadFiles($files)
{
    $normalized = array();

    foreach ((array) $files as $file) {
        if (!is_array($file) || !isset($file['name'])) {
            continue;
        }

        if (is_array($file['name'])) {
            $count = count($file['name']);
            for ($i = 0; $i < $count; $i++) {
                if (empty($file['name'][$i])) {
                    continue;
                }

                $normalized[] = array(
                    'name' => $file['name'][$i],
                    'type' => isset($file['type'][$i]) ? $file['type'][$i] : '',
                    'tmp_name' => isset($file['tmp_name'][$i]) ? $file['tmp_name'][$i] : '',
                    'error' => isset($file['error'][$i]) ? $file['error'][$i] : UPLOAD_ERR_NO_FILE,
                    'size' => isset($file['size'][$i]) ? $file['size'][$i] : 0
                );
            }
        } elseif (!empty($file['name'])) {
            $normalized[] = array(
                'name' => (string) $file['name'],
                'type' => isset($file['type']) ? (string) $file['type'] : '',
                'tmp_name' => isset($file['tmp_name']) ? (string) $file['tmp_name'] : '',
                'error' => isset($file['error']) ? (int) $file['error'] : UPLOAD_ERR_NO_FILE,
                'size' => isset($file['size']) ? (int) $file['size'] : 0
            );
        }
    }

    return $normalized;
}

function CLASSIFIEDS_saveImage($ad, $FILES, $clid)
{
    global $_CONF, $_CLASSIFIEDS_CONF, $_TABLES, $LANG_CLASSIFIEDS_2;

    $result = array(
        'ok' => false,
        'uploaded_files' => array(),
        'delete_files' => array(),
        'errors' => array()
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
    foreach (CLASSIFIEDS_normalizeUploadFiles($FILES) as $file) {
        if ((int) $file['error'] !== UPLOAD_ERR_OK) {
            continue;
        }

        $uploadFiles[] = $file;
        if (count($uploadFiles) >= $availableSlots) {
            break;
        }
    }

    if (!empty($uploadFiles) && $availableSlots > 0) {
        require_once $_CONF['path_system'] . 'classes/upload.class.php';

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

        // Geeklog 2.1.1's Upload class reads the global $_FILES array directly
        // and expects exactly one scalar file structure per entry. A native
        // multiple input (images[]) therefore cannot be passed to it as-is.
        // Process the already flattened batch one image at a time, keeping the
        // core Upload class responsible for MIME, size, dimensions and resize.
        $originalFiles = $_FILES;

        foreach ($uploadFiles as $index => $file) {
            $upload = new upload();

            if (!empty($_CONF['debug_image_upload'])) {
                $upload->setLogFile($_CONF['path'] . 'logs/error.log');
                $upload->setDebug(true);
            }

            $upload->setMaxFileUploads(1);

            $canResize = false;
            if (!empty($_CONF['image_lib'])) {
                if ($_CONF['image_lib'] === 'imagemagick') {
                    $upload->setMogrifyPath($_CONF['path_to_mogrify']);
                    $canResize = true;
                } elseif ($_CONF['image_lib'] === 'netpbm') {
                    $upload->setNetPBM($_CONF['path_to_netpbm']);
                    $canResize = true;
                } elseif ($_CONF['image_lib'] === 'gdlib') {
                    $upload->setGDLib();
                    $canResize = true;
                }
            } elseif (function_exists('gd_info')) {
                // Geeklog often ships with image_lib unset. Reuse its native
                // Upload resizing path with GD when the extension is available.
                $upload->setGDLib();
                $canResize = true;
            }

            if ($canResize) {
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
                $_FILES = $originalFiles;
                COM_errorLog('Classifieds: image upload path is unavailable.');
                CLASSIFIEDS_cleanupImageFiles($filenames);
                return $result;
            }

            $upload->setMaxDimensions(
                (int) $_CLASSIFIEDS_CONF['max_image_width'],
                (int) $_CLASSIFIEDS_CONF['max_image_height']
            );
            $upload->setMaxFileSize((int) $_CLASSIFIEDS_CONF['max_image_size']);
            $upload->setPerms('0644');
            $upload->setFileNames($filenames[$index]);

            $_FILES = array(
                'classifieds_image' => array(
                    'name' => (string) $file['name'],
                    'type' => (string) $file['type'],
                    'tmp_name' => (string) $file['tmp_name'],
                    'error' => (int) $file['error'],
                    'size' => (int) $file['size']
                )
            );

            $upload->uploadFiles();

            if ($upload->areErrors()) {
                $_FILES = $originalFiles;
                CLASSIFIEDS_cleanupImageFiles($filenames);
                COM_errorLog(
                    'Classifieds: image #' . ($index + 1)
                    . ' could not be uploaded.'
                );
                $result['errors'][] = $canResize
                    ? $LANG_CLASSIFIEDS_2['image_upload_failed']
                    : sprintf(
                        $LANG_CLASSIFIEDS_2['image_too_large_no_resizer'],
                        (int) $_CLASSIFIEDS_CONF['max_image_width'],
                        (int) $_CLASSIFIEDS_CONF['max_image_height']
                    );
                return $result;
            }
        }

        $_FILES = $originalFiles;

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


