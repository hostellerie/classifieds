<?php
// +---------------------------------------------------------------------------+
// | Classifieds Plugin 1.4.0-dev                                              |
// +---------------------------------------------------------------------------+
// | Simple ad contact/report workflow.                                        |
// +---------------------------------------------------------------------------+

if (!defined('VERSION')) {
    die('This file can not be used on its own.');
}

/**
 * Return the contact data attached to an ad.
 *
 * @param int $ad
 * @return array|false
 */
function CLASSIFIEDS_getContactTarget($ad)
{
    global $_TABLES;

    $ad = (int) $ad;
    if ($ad <= 0 || !CLASSIFIEDS_checkAdAccess($ad)) {
        return false;
    }

    $result = DB_query(
        "SELECT clid, owner_id, title "
        . "FROM {$_TABLES['cl']} "
        . "WHERE clid = " . $ad . " AND deleted = 0 LIMIT 1"
    );
    $row = DB_fetchArray($result);

    return is_array($row) ? $row : false;
}

/**
 * Check whether the current visitor may contact a Classifieds user.
 *
 * @param int $uid
 * @return bool
 */
function CLASSIFIEDS_canContactUser($uid)
{
    global $_CONF, $_TABLES;

    $uid = (int) $uid;
    if ($uid <= 1) {
        return false;
    }

    if (COM_isAnonUser()
        && (!empty($_CONF['loginrequired']) || !empty($_CONF['emailuserloginrequired']))) {
        return false;
    }

    $result = DB_query(
        "SELECT emailfromadmin, emailfromuser "
        . "FROM {$_TABLES['userprefs']} WHERE uid = " . $uid
    );
    $prefs = DB_fetchArray($result);
    if (!is_array($prefs)) {
        return false;
    }

    $isAdmin = SEC_inGroup('Root') || SEC_hasRights('user.mail');

    return $isAdmin
        ? !empty($prefs['emailfromadmin'])
        : !empty($prefs['emailfromuser']);
}

/**
 * Build the contact/report form for an ad.
 *
 * @param int    $ad
 * @param string $mode contact|report
 * @param string $message
 * @return string
 */
function CLASSIFIEDS_contactForm($ad, $mode = 'contact', $message = '')
{
    global $_CONF, $_CLASSIFIEDS_CONF, $_USER, $LANG08, $LANG_CLASSIFIEDS_1;

    $mode = ($mode === 'report') ? 'report' : 'contact';
    $target = CLASSIFIEDS_getContactTarget($ad);
    if ($target === false) {
        return COM_showMessageText($LANG08[35], $LANG08[10]);
    }

    $uid = (int) $target['owner_id'];
    if ($mode === 'contact' && !CLASSIFIEDS_canContactUser($uid)) {
        return COM_showMessageText($LANG08[35], $LANG08[10]);
    }

    if (COM_isAnonUser()
        && (!empty($_CONF['loginrequired']) || !empty($_CONF['emailuserloginrequired']))) {
        return SEC_loginRequiredForm();
    }

    $author = '';
    $authoremail = '';

    if (!COM_isAnonUser()) {
        $author = COM_getDisplayName($_USER['uid'], $_USER['username'], $_USER['fullname']);
        $authoremail = isset($_USER['email']) ? $_USER['email'] : '';
    }

    $subject = ($mode === 'report')
        ? $LANG_CLASSIFIEDS_1['report']
        : $target['title'];

    $template = new Template($_CONF['path'] . 'plugins/classifieds/templates/contact');
    $template->set_file('form', 'contactuserform.thtml');

    $template->set_var('xhtml', XHTML);
    $template->set_var('action_url', $_CLASSIFIEDS_CONF['site_url'] . '/index.php');
    $template->set_var('route_mode', $mode === 'report' ? 'r' : 'c');
    $template->set_var('ad', (int) $target['clid']);

    $template->set_var('lang_description', $LANG08[26]);
    $template->set_var('lang_username', $LANG08[11]);
    $template->set_var('lang_useremail', $LANG08[12]);
    $template->set_var('lang_subject', $LANG08[13]);
    $template->set_var('lang_message', $LANG08[14]);
    $template->set_var('lang_cc', $LANG08[36]);
    $template->set_var('lang_cc_description', $LANG08[37]);
    $template->set_var('lang_submit', $LANG08[16]);

    $template->set_var(
        'username',
        htmlspecialchars($author, ENT_QUOTES, $_CONF['default_charset'])
    );
    $template->set_var(
        'useremail',
        htmlspecialchars($authoremail, ENT_QUOTES, $_CONF['default_charset'])
    );
    $template->set_var(
        'subject',
        htmlspecialchars($subject, ENT_QUOTES, $_CONF['default_charset'])
    );
    $template->set_var(
        'message',
        htmlspecialchars($message, ENT_QUOTES, $_CONF['default_charset'])
    );

    $template->set_var('gltoken_name', CSRF_TOKEN);
    $template->set_var('gltoken', SEC_createToken());

    PLG_templateSetVars('contact', $template);

    $template->parse('output', 'form');

    return $template->finish($template->get_var('output'));
}

/**
 * Send a contact or abuse-report message for an ad.
 *
 * @param int    $ad
 * @param string $author
 * @param string $authoremail
 * @param string $message
 * @param string $mode contact|report
 * @param bool   $copySender
 * @return bool
 */
function CLASSIFIEDS_sendContact(
    $ad,
    $author,
    $authoremail,
    $message,
    $mode = 'contact',
    $copySender = false
) {
    global $_CONF, $_CLASSIFIEDS_CONF, $_TABLES, $LANG_CLASSIFIEDS_1;

    if (!SEC_checkToken()) {
        return false;
    }

    $mode = ($mode === 'report') ? 'report' : 'contact';
    $target = CLASSIFIEDS_getContactTarget($ad);
    if ($target === false) {
        return false;
    }

    if (COM_isAnonUser()
        && (!empty($_CONF['loginrequired']) || !empty($_CONF['emailuserloginrequired']))) {
        return false;
    }

    $author = trim(strip_tags((string) $author));
    $authoremail = trim((string) $authoremail);
    $message = trim(strip_tags((string) $message));

    $author = substr($author, 0, strcspn($author, "\r\n"));
    $authoremail = substr($authoremail, 0, strcspn($authoremail, "\r\n"));

    if ($author === '' || $message === '' || !COM_isemail($authoremail)) {
        return false;
    }

    COM_clearSpeedlimit($_CONF['speedlimit'], 'mail');
    if (COM_checkSpeedlimit('mail') > 0) {
        return false;
    }

    $subject = ($mode === 'report')
        ? $LANG_CLASSIFIEDS_1['report']
        : $target['title'];

    $spam = PLG_checkforSpam($subject . "\n" . $message, $_CONF['spamx']);
    if ($spam > 0) {
        COM_updateSpeedlimit('mail');
        return false;
    }

    $presave = PLG_itemPreSave('contact', $message);
    if (!empty($presave)) {
        return false;
    }

    if ($mode === 'report') {
        $to = $_CONF['site_mail'];
    } else {
        $uid = (int) $target['owner_id'];
        if (!CLASSIFIEDS_canContactUser($uid)) {
            return false;
        }

        $result = DB_query(
            "SELECT username, fullname, email "
            . "FROM {$_TABLES['users']} WHERE uid = " . $uid
        );
        $recipient = DB_fetchArray($result);
        if (!is_array($recipient) || empty($recipient['email'])) {
            return false;
        }

        $recipientName = !empty($recipient['fullname'])
            ? $recipient['fullname']
            : $recipient['username'];

        $to = COM_formatEmailAddress($recipientName, $recipient['email']);
    }

    $from = COM_formatEmailAddress($author, $authoremail);
    $mailSubject = '[' . $_CONF['site_name'] . '] '
        . $LANG_CLASSIFIEDS_1['plugin_name']
        . ' #' . (int) $target['clid']
        . ' - ' . $subject;

    $mailBody = $message . "\n\n"
        . $_CLASSIFIEDS_CONF['site_url']
        . '/index.php?mode=v&ad=' . (int) $target['clid'] . "\n";

    $sent = COM_mail($to, $mailSubject, $mailBody, $from);

    if ($sent && $copySender) {
        COM_mail($from, $mailSubject, $mailBody, $_CONF['noreply_mail']);
    }

    COM_updateSpeedlimit('mail');

    return (bool) $sent;
}
