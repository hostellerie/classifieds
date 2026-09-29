<?php
// +---------------------------------------------------------------------------+
// | Classifieds Plugin                                                       |
// +---------------------------------------------------------------------------+
// | Integrated notification and scheduled expiration functions.              |
// +---------------------------------------------------------------------------+

if (!defined('VERSION')) {
    die('This file can not be used on its own.');
}

/**
 * Return the email address for a Geeklog user.
 *
 * @param int $uid User id
 * @return string
 */
function CLASSIFIEDS_getUserEmail($uid)
{
    global $_TABLES;

    $uid = (int) $uid;
    if ($uid <= 0) {
        return '';
    }

    return (string) DB_getItem($_TABLES['users'], 'email', 'uid=' . $uid);
}

/**
 * Send a Classifieds lifecycle notification.
 *
 * @return bool True when every enabled recipient was handled successfully.
 */
function CLASSIFIEDS_sendLifecycleEmail($event, $title, $ad, $adnumber, $uid, $price = '')
{
    global $_CONF, $_CLASSIFIEDS_CONF, $LANG_CLASSIFIEDS_1, $LANG_CLASSIFIEDS_EMAIL;

    $map = array(
        'create' => array('create_ad_email_user', 'create_ad_email_admin', 'new_ad'),
        'edit'   => array('mod_ad_email_user', 'mod_ad_email_admin', 'edit_ad'),
        'delete' => array('delete_ad_email_user', 'delete_ad_email_admin', 'delete_ad'),
        'expire' => array('expire_ad_email_user', 'expire_ad_email_admin', 'expire_ad'),
    );

    if (!isset($map[$event])) {
        return false;
    }

    $userEnabled = !empty($_CLASSIFIEDS_CONF[$map[$event][0]]);
    $adminEnabled = !empty($_CLASSIFIEDS_CONF[$map[$event][1]]);

    if (!$userEnabled && !$adminEnabled) {
        return true;
    }

    $adnumber = (int) $adnumber;
    $uid = (int) $uid;
    $title = (string) $title;
    $ad = (string) $ad;
    $price = (string) $price;
    $author = COM_getDisplayName($uid);

    $subject = '[' . $_CONF['site_name'] . '] ' . $LANG_CLASSIFIEDS_1['plugin_name']
        . ' #' . $adnumber . ' - ' . $title;

    $body = $LANG_CLASSIFIEDS_EMAIL['hello'] . ' ' . $author . ",\n\n";
    $body .= $LANG_CLASSIFIEDS_EMAIL[$map[$event][2]] . ' ' . $_CONF['site_url'];

    if ($event === 'create') {
        $body .= ' ' . $LANG_CLASSIFIEDS_EMAIL['online_for'] . ' '
            . (int) $_CLASSIFIEDS_CONF['active_days'] . ' ' . $LANG_CLASSIFIEDS_EMAIL['days'];
    }
    $body .= "\n\n";

    if ($event === 'create' || $event === 'edit') {
        $body .= $LANG_CLASSIFIEDS_EMAIL['you_can_see'] . ' <'
            . $_CLASSIFIEDS_CONF['site_url'] . '/index.php?mode=v&ad=' . $adnumber . ">\n\n";
    }

    if ($event === 'delete' || $event === 'expire') {
        $body .= $LANG_CLASSIFIEDS_EMAIL['post_new'] . ' <'
            . $_CLASSIFIEDS_CONF['site_url'] . "/index.php?mode=e>\n\n";
    }

    if ($event !== 'delete') {
        $body .= strtoupper($title) . "\n\n";
        $body .= $ad . "\n\n";
        $body .= $LANG_CLASSIFIEDS_EMAIL['price'] . ' ' . $price . ' '
            . $_CLASSIFIEDS_CONF['currency'] . "\n\n";
    }

    $body .= $LANG_CLASSIFIEDS_EMAIL['thanks'] . "\n";
    $body .= $LANG_CLASSIFIEDS_EMAIL['sign'] . "\n\n";
    $body .= $LANG_CLASSIFIEDS_EMAIL['no_reply'] . "\n";
    $body .= "\n------------------------------\n" . $_CONF['site_url'] . "\n------------------------------\n";

    $ok = true;

    if ($userEnabled) {
        $email = CLASSIFIEDS_getUserEmail($uid);
        if ($email !== '') {
            $ok = (bool) COM_mail($email, $subject, $body, $_CONF['noreply_mail']) && $ok;
        } else {
            COM_errorLog('Classifieds: unable to send lifecycle notification; no email for uid ' . $uid);
            $ok = false;
        }
    }

    if ($adminEnabled) {
        $ok = (bool) COM_mail($_CONF['site_mail'], $subject, $body, $_CONF['noreply_mail']) && $ok;
    }

    return $ok;
}

function CLASSIFIEDS_emailNewAd($title, $ad, $adnumber, $uid, $price = '')
{
    return CLASSIFIEDS_sendLifecycleEmail('create', $title, $ad, $adnumber, $uid, $price);
}

function CLASSIFIEDS_emailEditAd($title, $ad, $adnumber, $uid, $price = '')
{
    return CLASSIFIEDS_sendLifecycleEmail('edit', $title, $ad, $adnumber, $uid, $price);
}

function CLASSIFIEDS_emailDeleteAd($title, $ad, $adnumber, $uid, $price = '')
{
    return CLASSIFIEDS_sendLifecycleEmail('delete', $title, $ad, $adnumber, $uid, $price);
}

function CLASSIFIEDS_emailAdExpire($title, $ad, $adnumber, $uid, $price = '')
{
    return CLASSIFIEDS_sendLifecycleEmail('expire', $title, $ad, $adnumber, $uid, $price);
}

/**
 * Process expiration notifications for ads once per item.
 */
function plugin_runScheduledTask_classifieds()
{
    global $_TABLES, $_CLASSIFIEDS_CONF;

    $activeDays = isset($_CLASSIFIEDS_CONF['active_days']) ? (int) $_CLASSIFIEDS_CONF['active_days'] : 0;
    if ($activeDays <= 0) {
        return;
    }

    $sql = "SELECT clid, title, text, owner_id, price "
        . "FROM {$_TABLES['cl']} "
        . "WHERE deleted = 0 "
        . "AND enable = 1 "
        . "AND notification <> 2 "
        . "AND TO_DAYS(NOW()) - TO_DAYS(created) > " . $activeDays;

    $result = DB_query($sql);
    if (!$result) {
        COM_errorLog('Classifieds: scheduled expiration query failed.');
        return;
    }

    while ($A = DB_fetchArray($result)) {
        $clid = (int) $A['clid'];
        if ($clid <= 0) {
            continue;
        }

        if (CLASSIFIEDS_emailAdExpire($A['title'], $A['text'], $clid, $A['owner_id'], $A['price'])) {
            DB_query("UPDATE {$_TABLES['cl']} SET notification = 2 WHERE clid = " . $clid);
        } else {
            COM_errorLog('Classifieds: expiration notification failed for ad #' . $clid . '. It will be retried.');
        }
    }
}
