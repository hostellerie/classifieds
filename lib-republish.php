<?php
// +---------------------------------------------------------------------------+
// | Classifieds Plugin                                                       |
// +---------------------------------------------------------------------------+
// | Integrated republish functionality from the historical Pro edition.       |
// +---------------------------------------------------------------------------+

if (!defined('VERSION')) {
    die('This file can not be used on its own.');
}

function CLASSIFIEDS_repost($clid)
{
    global $_TABLES, $_CLASSIFIEDS_CONF;

    $result = array(
        'ok' => false,
        'source_id' => (int) $clid,
        'new_id' => 0
    );

    $clid = (int) $clid;
    if ($clid <= 0
        || empty($_CLASSIFIEDS_CONF['allow_republish'])
        || !SEC_hasRights('classifieds.publish')) {
        return $result;
    }

    if (!CLASSIFIEDS_checkAdAccess($clid)) {
        return $result;
    }

    $query = DB_query(
        "SELECT * FROM {$_TABLES['cl']} WHERE clid = " . $clid . " LIMIT 1"
    );
    $ad = DB_fetchArray($query);

    if (!is_array($ad) || SEC_hasAccess2($ad) < 3) {
        return $result;
    }

    $created = COM_getUserDateTimeFormat($ad['created']);
    $createdTs = isset($created[1]) ? (int) $created[1] : 0;
    $ageDays = $createdTs > 0 ? (time() - $createdTs) / 86400 : 0;

    if (!empty($ad['deleted'])
        || $ageDays <= (int) $_CLASSIFIEDS_CONF['active_days']) {
        return $result;
    }

    $newClid = CLASSIFIEDS_adCopy($ad);
    if ($newClid <= 0) {
        COM_errorLog(
            'Classifieds: republish failed for ad #' . $clid
            . '; original ad was preserved.'
        );
        return $result;
    }

    DB_change($_TABLES['cl'], 'deleted', 1, 'clid', $clid);
    if (DB_error()) {
        CLASSIFIEDS_discardRepublishedAd($newClid);
        COM_errorLog(
            'Classifieds: republish aborted because source ad #' . $clid
            . ' could not be retired. The new copy was removed.'
        );
        return $result;
    }

    CLASSIFIEDS_emailNewAd(
        $ad['title'],
        $ad['text'],
        $newClid,
        (int) $ad['owner_id'],
        $ad['price']
    );
    PLG_itemSaved((string) $newClid, 'classifieds');
    PLG_itemDeleted((string) $clid, 'classifieds');

    $result['ok'] = true;
    $result['new_id'] = $newClid;

    return $result;
}

/**
 * Copy an expired ad and return the new ad id, or 0 on failure.
 */
function CLASSIFIEDS_adCopy($ad)
{
    global $_CLASSIFIEDS_CONF, $_TABLES;

    if (!is_array($ad) || empty($ad['clid'])) {
        return 0;
    }

    $sourceClid = (int) $ad['clid'];
    if ($sourceClid <= 0 || !CLASSIFIEDS_checkAdAccess($sourceClid)) {
        return 0;
    }

    $missingfields = CLASSIFIEDS_missingField($ad);
    if (!empty($missingfields)) {
        return 0;
    }

    $title = DB_escapeString(COM_getTextContent($ad['title']));
    $text = DB_escapeString(CLASSIFIEDS_getTextContent($ad['text']));
    $city = DB_escapeString(COM_getTextContent($ad['city']));
    $postcode = DB_escapeString(isset($ad['postcode']) ? $ad['postcode'] : '');
    $siren = DB_escapeString(isset($ad['siren']) ? $ad['siren'] : '');
    $catid = DB_escapeString(isset($ad['catid']) ? $ad['catid'] : '');
    $type = isset($ad['type']) ? (int) $ad['type'] : 0;
    $hideTel = !empty($ad['hide_tel']) ? 1 : 0;
    $status = !empty($ad['status']) ? 1 : 0;
    $removeFromTel = array(' ', '.', '|', ',', '/', ':', '-', '_');
    $cleanTel = DB_escapeString(str_replace($removeFromTel, '', isset($ad['tel']) ? $ad['tel'] : ''));
    $price = isset($ad['price']) ? (float) str_replace(',', '', $ad['price']) : 0;
    $ownerId = (int) DB_getItem($_TABLES['cl'], 'owner_id', 'clid = ' . $sourceClid);
    $created = date('YmdHis');
    $modified = $created;

    $sql = "INSERT INTO {$_TABLES['cl']} SET "
        . "catid = '{$catid}', "
        . "status = {$status}, "
        . "type = {$type}, "
        . "tel = '{$cleanTel}', "
        . "hide_tel = {$hideTel}, "
        . "title = '{$title}', "
        . "text = '{$text}', "
        . "price = '" . $price . "', "
        . "postcode = '{$postcode}', "
        . "city = '{$city}', "
        . "siren = '{$siren}', "
        . "created = '{$created}', "
        . "modified = '{$modified}', "
        . "owner_id = {$ownerId}";

    DB_query($sql);
    if (DB_error()) {
        COM_errorLog('Classifieds: unable to create republished copy of ad #' . $sourceClid);
        return 0;
    }

    $newClid = (int) DB_insertId();
    if ($newClid <= 0) {
        COM_errorLog('Classifieds: invalid new ad id while republishing #' . $sourceClid);
        return 0;
    }

    if (!CLASSIFIEDS_copyImages($ad, $newClid)) {
        DB_query("DELETE FROM {$_TABLES['cl_pic']} WHERE pi_pid = '" . $newClid . "'");
        DB_query("DELETE FROM {$_TABLES['cl']} WHERE clid = " . $newClid);
        COM_errorLog('Classifieds: image copy failed while republishing #' . $sourceClid . '; new copy rolled back.');
        return 0;
    }

    return $newClid;
}

/**
 * Remove a provisional republished ad and its copied files.
 *
 * @param int $clid
 * @return void
 */
function CLASSIFIEDS_discardRepublishedAd($clid)
{
    global $_CLASSIFIEDS_CONF, $_TABLES;

    $clid = (int) $clid;
    if ($clid <= 0) {
        return;
    }

    $result = DB_query(
        "SELECT pi_filename FROM {$_TABLES['cl_pic']} "
        . "WHERE pi_pid = '" . $clid . "'"
    );

    while ($image = DB_fetchArray($result)) {
        $path = $_CLASSIFIEDS_CONF['path_images'] . basename($image['pi_filename']);
        if (is_file($path)) {
            @unlink($path);
        }
    }

    DB_query("DELETE FROM {$_TABLES['cl_pic']} WHERE pi_pid = '" . $clid . "'");
    DB_query("DELETE FROM {$_TABLES['cl']} WHERE clid = " . $clid);
}

function CLASSIFIEDS_copyImages($ad, $clid)
{
    global $_CLASSIFIEDS_CONF, $_TABLES;

    $clid = (int) $clid;
    $sourceClid = isset($ad['clid']) ? (int) $ad['clid'] : 0;
    if ($clid <= 0 || $sourceClid <= 0) {
        return false;
    }

    $copiedFiles = array();
    $result = DB_query("SELECT pi_img_num, pi_filename FROM {$_TABLES['cl_pic']} WHERE pi_pid = '"
        . $sourceClid . "' ORDER BY pi_img_num");

    while ($A = DB_fetchArray($result)) {
        $filename = basename($A['pi_filename']);
        $pos = strpos($filename, '_');
        $suffix = ($pos === false) ? $filename : substr($filename, $pos + 1);
        $newFilename = $clid . '_' . $suffix;

        if (!CLASSIFIEDS_copyImage($filename, $newFilename)) {
            foreach ($copiedFiles as $copied) {
                @unlink($_CLASSIFIEDS_CONF['path_images'] . $copied);
            }
            return false;
        }

        $copiedFiles[] = $newFilename;
        DB_query("INSERT INTO {$_TABLES['cl_pic']} (pi_pid, pi_img_num, pi_filename) VALUES ('"
            . $clid . "', " . (int) $A['pi_img_num'] . ", '" . DB_escapeString($newFilename) . "')");
        if (DB_error()) {
            foreach ($copiedFiles as $copied) {
                @unlink($_CLASSIFIEDS_CONF['path_images'] . $copied);
            }
            DB_query("DELETE FROM {$_TABLES['cl_pic']} WHERE pi_pid = '" . $clid . "'");
            return false;
        }
    }

    return true;
}

function CLASSIFIEDS_copyImage($file, $newfile)
{
    global $_CLASSIFIEDS_CONF;

    if ($file === '' || $newfile === '') {
        return false;
    }

    $source = $_CLASSIFIEDS_CONF['path_images'] . basename($file);
    $target = $_CLASSIFIEDS_CONF['path_images'] . basename($newfile);

    if (!is_file($source)) {
        COM_errorLog('Classifieds: source image missing during republish: ' . basename($file));
        return false;
    }

    if (!@copy($source, $target)) {
        COM_errorLog('Classifieds: unable to copy image ' . basename($file) . ' to ' . basename($newfile));
        return false;
    }

    return true;
}
