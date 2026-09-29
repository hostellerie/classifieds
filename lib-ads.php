<?php
// +---------------------------------------------------------------------------+
// | Classifieds Plugin 1.4.0-dev                                              |
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
            "SELECT * FROM {$_TABLES['cl']} WHERE clid = " . $clid . " LIMIT 1"
        );
        $existing = DB_fetchArray($query);

        if (!is_array($existing) || SEC_hasAccess2($existing) < 3) {
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
            . "owner_id = '" . $uid . "'";
        DB_query($sql);
        $clid = (int) DB_insertId();
    }

    if (DB_error() || $clid <= 0) {
        DB_query('ROLLBACK');
        return $result;
    }

    if (!CLASSIFIEDS_saveImage($data, $files, $clid)) {
        DB_query('ROLLBACK');
        return $result;
    }

    DB_query('COMMIT');

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
