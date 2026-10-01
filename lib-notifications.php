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
    global $_CONF, $_CLASSIFIEDS_CONF, $_TABLES;
    global $LANG_CLASSIFIEDS_1, $LANG_CLASSIFIEDS_EMAIL;

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
    $title = trim((string) $title);
    $ad = trim((string) $ad);
    $price = trim((string) $price);
    $author = COM_getDisplayName($uid);

    $adUrl = $_CLASSIFIEDS_CONF['site_url'] . '/index.php?mode=v&ad=' . $adnumber;
    $manageUrl = $_CLASSIFIEDS_CONF['site_url'] . '/index.php?mode=e&op=edit&ad=' . $adnumber;
    $placeUrl = $_CLASSIFIEDS_CONF['site_url'] . '/index.php?mode=e';
    $myAdsUrl = $_CLASSIFIEDS_CONF['site_url'] . '/index.php?mode=my';

    $imageUrl = '';
    $imageFilename = DB_getItem(
        $_TABLES['cl_pic'],
        'pi_filename',
        "pi_pid = '" . $adnumber . "' ORDER BY pi_img_num ASC LIMIT 1"
    );
    if ($imageFilename !== '') {
        $imageUrl = $_CLASSIFIEDS_CONF['url_images']
            . rawurlencode(basename($imageFilename));
    }

    $subject = '[' . $_CONF['site_name'] . '] ' . $LANG_CLASSIFIEDS_1['plugin_name']
        . ' #' . $adnumber . ' - ' . $title;

    $eventLabel = $LANG_CLASSIFIEDS_EMAIL[$map[$event][2]];
    $statusText = $eventLabel;
    if ($event === 'create') {
        $statusText .= ' ' . $LANG_CLASSIFIEDS_EMAIL['online_for'] . ' '
            . (int) $_CLASSIFIEDS_CONF['active_days'] . ' '
            . $LANG_CLASSIFIEDS_EMAIL['days'];
    }

    $safeTitle = htmlspecialchars($title, ENT_QUOTES, $_CONF['default_charset']);
    $safeAd = nl2br(
        htmlspecialchars($ad, ENT_QUOTES, $_CONF['default_charset'])
    );
    $safeAuthor = htmlspecialchars(
        $author,
        ENT_QUOTES,
        $_CONF['default_charset']
    );
    $safeStatus = htmlspecialchars(
        $statusText,
        ENT_QUOTES,
        $_CONF['default_charset']
    );
    $safePrice = htmlspecialchars(
        $price . ' ' . $_CLASSIFIEDS_CONF['currency'],
        ENT_QUOTES,
        $_CONF['default_charset']
    );
    $safeSiteName = htmlspecialchars(
        $_CONF['site_name'],
        ENT_QUOTES,
        $_CONF['default_charset']
    );

    $imageHtml = '';
    if ($imageUrl !== '') {
        $imageHtml = '<a href="' . htmlspecialchars($adUrl, ENT_QUOTES, $_CONF['default_charset'])
            . '" style="display:block;text-decoration:none;">'
            . '<img src="' . htmlspecialchars($imageUrl, ENT_QUOTES, $_CONF['default_charset'])
            . '" alt="' . $safeTitle . '" '
            . 'style="display:block;width:100%;max-height:420px;object-fit:cover;border:0;border-radius:12px 12px 0 0;">'
            . '</a>';
    }

    $descriptionHtml = '';
    if ($event !== 'delete' && $safeAd !== '') {
        $descriptionHtml = '<div style="padding:0 24px 20px;color:#444;font-size:15px;line-height:1.6;">'
            . $safeAd . '</div>';
    }

    $priceHtml = '';
    if ($event !== 'delete' && $price !== '') {
        $priceHtml = '<div style="padding:0 24px 18px;font-size:22px;font-weight:700;color:#111;">'
            . $safePrice . '</div>';
    }

    $publicActionHtml = '';
    if ($event === 'create' || $event === 'edit') {
        $publicActionHtml = '<a href="' . htmlspecialchars($adUrl, ENT_QUOTES, $_CONF['default_charset'])
            . '" style="display:inline-block;margin:0 8px 8px 0;padding:11px 18px;'
            . 'border-radius:7px;background:#222;color:#fff;text-decoration:none;font-weight:600;">'
            . htmlspecialchars($LANG_CLASSIFIEDS_EMAIL['view_ad'], ENT_QUOTES, $_CONF['default_charset'])
            . '</a>';
    }

    $htmlStart = '<!doctype html><html><body style="margin:0;padding:0;background:#f4f4f4;'
        . 'font-family:Arial,Helvetica,sans-serif;color:#222;">'
        . '<div style="max-width:680px;margin:0 auto;padding:28px 14px;">'
        . '<div style="margin:0 0 14px;font-size:13px;color:#777;">'
        . $safeSiteName . ' · ' . htmlspecialchars($LANG_CLASSIFIEDS_1['plugin_name'], ENT_QUOTES, $_CONF['default_charset'])
        . '</div>'
        . '<div style="background:#fff;border:1px solid #e6e6e6;border-radius:14px;overflow:hidden;">'
        . $imageHtml
        . '<div style="padding:24px 24px 10px;">'
        . '<div style="margin-bottom:8px;font-size:14px;color:#666;">' . $safeStatus . '</div>'
        . '<h1 style="margin:0;font-size:25px;line-height:1.25;color:#111;">' . $safeTitle . '</h1>'
        . '</div>'
        . $priceHtml
        . $descriptionHtml;

    $htmlEnd = '</div></div></body></html>';

    $plainBase = $LANG_CLASSIFIEDS_EMAIL['hello'] . ' ' . $author . ",\n\n"
        . $statusText . "\n\n"
        . $title . "\n";

    if ($event !== 'delete' && $price !== '') {
        $plainBase .= $LANG_CLASSIFIEDS_EMAIL['price'] . ' ' . $price . ' '
            . $_CLASSIFIEDS_CONF['currency'] . "\n";
    }
    if ($event !== 'delete' && $ad !== '') {
        $plainBase .= "\n" . $ad . "\n";
    }

    $ok = true;

    if ($userEnabled) {
        $email = CLASSIFIEDS_getUserEmail($uid);
        if ($email !== '') {
            $userActions = '';
            $plainUser = $plainBase;

            if ($event === 'create' || $event === 'edit') {
                $userActions .= $publicActionHtml
                    . '<a href="' . htmlspecialchars($manageUrl, ENT_QUOTES, $_CONF['default_charset'])
                    . '" style="display:inline-block;margin:0 8px 8px 0;padding:10px 17px;'
                    . 'border:1px solid #bbb;border-radius:7px;color:#222;text-decoration:none;font-weight:600;">'
                    . htmlspecialchars($LANG_CLASSIFIEDS_EMAIL['manage_ad'], ENT_QUOTES, $_CONF['default_charset'])
                    . '</a>';

                $plainUser .= "\n" . $LANG_CLASSIFIEDS_EMAIL['view_ad'] . ': ' . $adUrl
                    . "\n" . $LANG_CLASSIFIEDS_EMAIL['manage_ad'] . ': ' . $manageUrl . "\n";
            } elseif ($event === 'expire') {
                $userActions .= '<a href="' . htmlspecialchars($myAdsUrl, ENT_QUOTES, $_CONF['default_charset'])
                    . '" style="display:inline-block;margin:0 8px 8px 0;padding:11px 18px;'
                    . 'border-radius:7px;background:#222;color:#fff;text-decoration:none;font-weight:600;">'
                    . htmlspecialchars($LANG_CLASSIFIEDS_EMAIL['my_ads'], ENT_QUOTES, $_CONF['default_charset'])
                    . '</a>'
                    . '<a href="' . htmlspecialchars($placeUrl, ENT_QUOTES, $_CONF['default_charset'])
                    . '" style="display:inline-block;margin:0 8px 8px 0;padding:10px 17px;'
                    . 'border:1px solid #bbb;border-radius:7px;color:#222;text-decoration:none;font-weight:600;">'
                    . htmlspecialchars($LANG_CLASSIFIEDS_EMAIL['post_new_button'], ENT_QUOTES, $_CONF['default_charset'])
                    . '</a>';

                $plainUser .= "\n" . $LANG_CLASSIFIEDS_EMAIL['my_ads'] . ': ' . $myAdsUrl
                    . "\n" . $LANG_CLASSIFIEDS_EMAIL['post_new_button'] . ': ' . $placeUrl . "\n";
            } elseif ($event === 'delete') {
                $userActions .= '<a href="' . htmlspecialchars($placeUrl, ENT_QUOTES, $_CONF['default_charset'])
                    . '" style="display:inline-block;margin:0 8px 8px 0;padding:11px 18px;'
                    . 'border-radius:7px;background:#222;color:#fff;text-decoration:none;font-weight:600;">'
                    . htmlspecialchars($LANG_CLASSIFIEDS_EMAIL['post_new_button'], ENT_QUOTES, $_CONF['default_charset'])
                    . '</a>';

                $plainUser .= "\n" . $LANG_CLASSIFIEDS_EMAIL['post_new_button'] . ': ' . $placeUrl . "\n";
            }

            $userHtml = $htmlStart
                . '<div style="padding:4px 24px 24px;">' . $userActions . '</div>'
                . '<div style="padding:0 24px 24px;color:#666;font-size:13px;line-height:1.5;">'
                . htmlspecialchars($LANG_CLASSIFIEDS_EMAIL['automatic_notice'], ENT_QUOTES, $_CONF['default_charset'])
                . '</div>'
                . $htmlEnd;

            $ok = (bool) COM_mail(
                $email,
                $subject,
                array($userHtml, $plainUser),
                $_CONF['noreply_mail'],
                true
            ) && $ok;
        } else {
            COM_errorLog('Classifieds: unable to send lifecycle notification; no email for uid ' . $uid);
            $ok = false;
        }
    }

    if ($adminEnabled) {
        $adminActions = '';
        $plainAdmin = $plainBase;

        if ($event === 'create' || $event === 'edit') {
            $adminActions = $publicActionHtml;
            $plainAdmin .= "\n" . $LANG_CLASSIFIEDS_EMAIL['view_ad'] . ': ' . $adUrl . "\n";
        } elseif ($event === 'expire') {
            $adminActions = '<a href="' . htmlspecialchars($myAdsUrl, ENT_QUOTES, $_CONF['default_charset'])
                . '" style="display:inline-block;margin:0 8px 8px 0;padding:11px 18px;'
                . 'border-radius:7px;background:#222;color:#fff;text-decoration:none;font-weight:600;">'
                . htmlspecialchars($LANG_CLASSIFIEDS_EMAIL['my_ads'], ENT_QUOTES, $_CONF['default_charset'])
                . '</a>';
            $plainAdmin .= "\n" . $LANG_CLASSIFIEDS_EMAIL['my_ads'] . ': ' . $myAdsUrl . "\n";
        }

        $adminHtml = $htmlStart
            . '<div style="padding:4px 24px 24px;">' . $adminActions . '</div>'
            . '<div style="padding:0 24px 24px;color:#666;font-size:13px;line-height:1.5;">'
            . htmlspecialchars($LANG_CLASSIFIEDS_EMAIL['publisher'], ENT_QUOTES, $_CONF['default_charset'])
            . ': ' . $safeAuthor
            . '</div>'
            . $htmlEnd;

        $ok = (bool) COM_mail(
            $_CONF['site_mail'],
            $subject,
            array($adminHtml, $plainAdmin),
            $_CONF['noreply_mail'],
            true
        ) && $ok;
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

        $sent = CLASSIFIEDS_emailAdExpire(
            $A['title'],
            $A['text'],
            $clid,
            $A['owner_id'],
            $A['price']
        );

        if (!$sent) {
            COM_errorLog(
                'Classifieds: one or more expiration notification recipients '
                . 'could not be reached for ad #' . $clid
                . '. The expiration event is marked handled to avoid duplicate mail.'
            );
        }

        DB_query(
            "UPDATE {$_TABLES['cl']} SET notification = 2 WHERE clid = " . $clid
        );
    }
}
