<?php
// +---------------------------------------------------------------------------+
// | Classifieds Plugin 1.4.0                                              |
// +---------------------------------------------------------------------------+
// | Ad persistence and lifecycle helpers.                                     |
// +---------------------------------------------------------------------------+

if (!defined('VERSION')) {
    die('This file can not be used on its own.');
}

/**
 * Normalize and persist one ad.
 *
 * @param array $data
 * @param array $files
 * @return array
 */
function CLASSIFIEDS_saveAd($data, $files)
{
    global $_CLASSIFIEDS_CONF, $_TABLES, $_USER;
    global $LANG_CLASSIFIEDS_2;

    $result = array(
        'ok' => false,
        'id' => 0,
        'message' => $LANG_CLASSIFIEDS_2['save_fail'],
        'errors' => array()
    );

    if (!SEC_checkToken()) {
        return $result;
    }

    $data = is_array($data) ? $data : array();
    $files = is_array($files) ? $files : array();

    $missing = CLASSIFIEDS_missingField($data);
    if (!empty($missing)) {
        $result['errors'] = $missing;
        return $result;
    }

    $uid = isset($_USER['uid']) ? (int) $_USER['uid'] : 1;
    if ($uid < 2) {
        return $result;
    }

    $clid = isset($data['clid']) ? (int) $data['clid'] : 0;
    $isEdit = ($clid > 0);
    $existing = array();

    if ($isEdit) {
        $query = DB_query(
            "SELECT owner_id, group_id, perm_owner, perm_group, perm_members, perm_anon "
            . "FROM {$_TABLES['cl']} WHERE clid = " . $clid . " LIMIT 1"
        );
        $existing = DB_fetchArray($query);

        if (!is_array($existing)
            || (!SEC_hasRights('classifieds.admin') && SEC_hasAccess2($existing) < 3)) {
            return $result;
        }
    }

    $rawTitle = COM_getTextContent(isset($data['title']) ? $data['title'] : '');
    $rawText = CLASSIFIEDS_getTextContent(isset($data['text']) ? $data['text'] : '');
    $rawCity = COM_getTextContent(isset($data['city']) ? $data['city'] : '');
    $rawSiren = COM_getTextContent(isset($data['siren']) ? $data['siren'] : '');

    $title = DB_escapeString($rawTitle);
    $text = DB_escapeString($rawText);
    $city = DB_escapeString($rawCity);
    $postcode = DB_escapeString(isset($data['postcode']) ? $data['postcode'] : '');
    $siren = DB_escapeString($rawSiren);

    $catid = isset($data['catid']) ? (int) $data['catid'] : 0;
    $type = (isset($data['type']) && (int) $data['type'] === 1) ? 1 : 0;
    $status = !empty($data['status']) ? 1 : 0;
    $hideTel = !empty($data['hide_tel']) ? 1 : 0;

    $removeFromTel = array(' ', '.', '|', ',', '/', ':', '-', '_');
    $cleanTel = DB_escapeString(str_replace(
        $removeFromTel,
        '',
        isset($data['tel']) ? $data['tel'] : ''
    ));

    $priceInput = isset($data['price']) ? str_replace(',', '', $data['price']) : '';
    $priceInput = preg_replace('/[^\d.]/', '', $priceInput);
    $price = ($priceInput === '') ? 0 : (float) $priceInput;

    $now = date('YmdHis');

    $newAcl = array();
    $defaultPermissions = isset($_CLASSIFIEDS_CONF['default_permissions'])
        && is_array($_CLASSIFIEDS_CONF['default_permissions'])
        ? $_CLASSIFIEDS_CONF['default_permissions']
        : array(3, 3, 2, 2);
    SEC_setDefaultPermissions($newAcl, $defaultPermissions);

    $groupId = (int) SEC_getFeatureGroup('classifieds.publish');
    if ($groupId <= 0) {
        $groupId = 1;
    }

    DB_query('START TRANSACTION');

    if ($isEdit) {
        $sql = "UPDATE {$_TABLES['cl']} SET "
            . "catid = '" . $catid . "', "
            . "status = '" . $status . "', "
            . "type = '" . $type . "', "
            . "tel = '" . $cleanTel . "', "
            . "hide_tel = '" . $hideTel . "', "
            . "title = '" . $title . "', "
            . "text = '" . $text . "', "
            . "price = '" . $price . "', "
            . "postcode = '" . $postcode . "', "
            . "city = '" . $city . "', "
            . "siren = '" . $siren . "', "
            . "modified = '" . $now . "' "
            . "WHERE clid = " . $clid;
        DB_query($sql);
    } else {
        $sql = "INSERT INTO {$_TABLES['cl']} SET "
            . "catid = '" . $catid . "', "
            . "status = '" . $status . "', "
            . "type = '" . $type . "', "
            . "tel = '" . $cleanTel . "', "
            . "hide_tel = '" . $hideTel . "', "
            . "title = '" . $title . "', "
            . "text = '" . $text . "', "
            . "price = '" . $price . "', "
            . "postcode = '" . $postcode . "', "
            . "city = '" . $city . "', "
            . "siren = '" . $siren . "', "
            . "created = '" . $now . "', "
            . "modified = '" . $now . "', "
            . "owner_id = '" . $uid . "', "
            . "group_id = '" . $groupId . "', "
            . "perm_owner = '" . (int) $newAcl['perm_owner'] . "', "
            . "perm_group = '" . (int) $newAcl['perm_group'] . "', "
            . "perm_members = '" . (int) $newAcl['perm_members'] . "', "
            . "perm_anon = '" . (int) $newAcl['perm_anon'] . "'";
        DB_query($sql);
        $clid = (int) DB_insertId();
    }

    if (DB_error() || $clid <= 0) {
        DB_query('ROLLBACK');
        return $result;
    }

    $imageResult = CLASSIFIEDS_saveImage($data, $files, $clid);
    if (empty($imageResult['ok'])) {
        DB_query('ROLLBACK');
        if (!empty($imageResult['uploaded_files'])) {
            CLASSIFIEDS_cleanupImageFiles($imageResult['uploaded_files']);
        }
        return $result;
    }

    DB_query('COMMIT');
    if (DB_error()) {
        if (!empty($imageResult['uploaded_files'])) {
            CLASSIFIEDS_cleanupImageFiles($imageResult['uploaded_files']);
        }
        COM_errorLog(
            'Classifieds: ad transaction commit failed for ad #' . $clid . '.'
        );
        return $result;
    }

    if (!empty($imageResult['delete_files'])) {
        foreach ($imageResult['delete_files'] as $deleteFile) {
            if (!CLASSIFIEDS_deleteImage($deleteFile)) {
                COM_errorLog(
                    'Classifieds: database update committed but old image '
                    . basename($deleteFile) . ' could not be removed.'
                );
            }
        }
    }

    $result['ok'] = true;
    $result['id'] = $clid;
    $result['message'] = $LANG_CLASSIFIEDS_2['save_success'];

    CLASSIFIEDS_updateUserAdProfile(
        $uid,
        $cleanTel,
        $postcode,
        $city,
        $status,
        $siren
    );

    if ($isEdit) {
        CLASSIFIEDS_emailEditAd($rawTitle, $rawText, $clid, $uid, $price);
        modifAd($clid);
    } else {
        CLASSIFIEDS_addPublisherGroup($uid);
        CLASSIFIEDS_emailNewAd($rawTitle, $rawText, $clid, $uid, $price);
    }

    PLG_itemSaved((string) $clid, 'classifieds');

    return $result;
}

/**
 * Keep the user's reusable ad contact fields in sync.
 */
function CLASSIFIEDS_updateUserAdProfile(
    $uid,
    $tel,
    $postcode,
    $city,
    $status,
    $siren
) {
    global $_TABLES;

    $uid = (int) $uid;
    if ($uid <= 1) {
        return;
    }

    if (DB_count($_TABLES['cl_users'], 'user_id', $uid) > 0) {
        DB_query(
            "UPDATE {$_TABLES['cl_users']} SET "
            . "tel = '" . $tel . "', "
            . "postcode = '" . $postcode . "', "
            . "city = '" . $city . "', "
            . "status = '" . (int) $status . "', "
            . "siren = '" . $siren . "' "
            . "WHERE user_id = " . $uid
        );
    } else {
        DB_query(
            "INSERT INTO {$_TABLES['cl_users']} SET "
            . "user_id = " . $uid . ", "
            . "tel = '" . $tel . "', "
            . "postcode = '" . $postcode . "', "
            . "city = '" . $city . "', "
            . "status = '" . (int) $status . "', "
            . "siren = '" . $siren . "'"
        );
    }
}

/**
 * Add a first-time publisher to the historical Classifieds Users group.
 */
function CLASSIFIEDS_addPublisherGroup($uid)
{
    global $_CONF, $_TABLES;

    $uid = (int) $uid;
    if ($uid <= 1) {
        return;
    }

    $groupId = (int) DB_getItem(
        $_TABLES['groups'],
        'grp_id',
        "grp_name = 'Classifieds Users'"
    );

    if ($groupId <= 0) {
        return;
    }

    require_once $_CONF['path_system'] . 'lib-user.php';
    USER_addGroup($groupId, $uid);
}


/**
 * Delete an ad.
 *
 * Soft deletion keeps the historical ad and its media for normal user flows.
 * Hard deletion is restricted to Classifieds administrators and removes media
 * and comments as well as the ad record.
 *
 * @param int  $clid
 * @param bool $hard
 * @return bool
 */
function CLASSIFIEDS_deleteAd($clid, $hard = false)
{
    global $_CONF, $_TABLES, $_USER;

    $clid = (int) $clid;
    if ($clid <= 0) {
        return false;
    }

    $query = DB_query(
        "SELECT title, price, owner_id, group_id, perm_owner, perm_group, perm_members, perm_anon "
        . "FROM {$_TABLES['cl']} WHERE clid = " . $clid . " LIMIT 1"
    );
    $ad = DB_fetchArray($query);
    if (!is_array($ad)) {
        return false;
    }

    if ($hard) {
        if (!SEC_hasRights('classifieds.admin')) {
            return false;
        }

        $filesToDelete = array();
        $pictures = DB_query(
            "SELECT pi_filename FROM {$_TABLES['cl_pic']} "
            . "WHERE pi_pid = '" . $clid . "'"
        );
        while ($picture = DB_fetchArray($pictures)) {
            if (!empty($picture['pi_filename'])) {
                $filesToDelete[] = basename($picture['pi_filename']);
            }
        }

        DB_query('START TRANSACTION');
        DB_query(
            "DELETE FROM {$_TABLES['cl_pic']} WHERE pi_pid = '" . $clid . "'"
        );
        DB_query(
            "DELETE FROM {$_TABLES['cl']} WHERE clid = " . $clid
        );

        if (DB_error()) {
            DB_query('ROLLBACK');
            return false;
        }

        DB_query('COMMIT');
        if (DB_error()) {
            return false;
        }

        foreach ($filesToDelete as $fileToDelete) {
            if (!CLASSIFIEDS_deleteImage($fileToDelete)) {
                COM_errorLog(
                    'Classifieds: hard delete committed but image '
                    . $fileToDelete . ' could not be removed.'
                );
            }
        }

        require_once $_CONF['path_system'] . 'lib-comment.php';
        CMT_deleteComment('', (string) $clid, 'classifieds', false);

        PLG_itemDeleted((string) $clid, 'classifieds');
        return true;
    }

    if (!SEC_hasRights('classifieds.admin') && SEC_hasAccess2($ad) < 3) {
        return false;
    }

    DB_change($_TABLES['cl'], 'deleted', 1, 'clid', $clid);
    if (DB_error()) {
        return false;
    }

    $uid = isset($_USER['uid']) ? (int) $_USER['uid'] : (int) $ad['owner_id'];
    CLASSIFIEDS_emailDeleteAd(
        $ad['title'],
        '',
        $clid,
        $uid,
        $ad['price']
    );

    PLG_itemDeleted((string) $clid, 'classifieds');

    return true;
}
