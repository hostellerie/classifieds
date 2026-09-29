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
    if ($isAdmin) {
        return !empty($prefs['emailfromadmin']);
    }

    return !empty($prefs['emailfromuser']);
}

/**
 * Build the contact/report form.
 *
 * @param int    $uid
 * @param int    $ad
 * @param string $subject
 * @param string $mode contact|report
 * @param string $message
 * @return string
 */
function CLASSIFIEDS_contactForm($uid, $ad, $subject, $mode = 'contact', $message = '')
{
    global $_CONF, $_CLASSIFIEDS_CONF, $_USER, $LANG08;

    $uid = (int) $uid;
    $ad = (int) $ad;
    $mode = ($mode === 'report') ? 'report' : 'contact';

    if ($ad <= 0 || !CLASSIFIEDS_checkAdAccess($ad)) {
        return COM_showMessageText($LANG08[35], $LANG08[10]);
    }

    if ($mode === 'contact' && !CLASSIFIEDS_canContactUser($uid)) {
        return COM_showMessageText($LANG08[35], $LANG08[10]);
    }

    if (COM_isAnonUser()
        && (!empty($_CONF['loginrequired']) || !empty($_CONF['emailuserloginrequired']))) {
        return CLASSIFIEDS_loginRequiredForm();
    }

    $author = '';
    $authoremail = '';

    if (!COM_isAnonUser()) {
        $author = COM_getDisplayName($_USER['uid'], $_USER['username'], $_USER['fullname']);
        $authoremail = isset($_USER['email']) ? $_USER['email'] : '';
    }

    $template = new Template($_CONF['path'] . 'plugins/classifieds/templates/contact');
    $template->set_file('form', 'contactuserform.thtml');

    $template->set_var('xhtml', XHTML);
    $template->set_var('action_url', $_CLASSIFIEDS_CONF['site_url'] . '/index.php');
    $template->set_var('lang_description', $LANG08[26]);
    $template->set_var('lang_username', $LANG08[11]);
    $template->set_var('lang_useremail', $LANG08[12]);
    $template->set_var('lang_subject', $LANG08[13]);
    $template->set_var('lang_message', $LANG08[14]);
    $template->set_var('lang_cc', $LANG08[36]);
    $template->set_var('lang_cc_description', $LANG08[37]);
    $template->set_var('lang_submit', $LANG08[16]);

    $template->set_var('username', htmlspecialchars($author, ENT_QUOTES, $_CONF['default_charset']));
    $template->set_var('useremail', htmlspecialchars($authoremail, ENT_QUOTES, $_CONF['default_charset']));
    $template->set_var('subject', htmlspecialchars($subject, ENT_QUOTES, $_CONF['default_charset']));
    $template->set_var('message', htmlspecialchars($message, ENT_QUOTES, $_CONF['default_charset']));

    $template->set_var('uid', $uid);
    $template->set_var('ad', $ad);
    $template->set_var('contact_mode', $mode);
    $template->set_var('gltoken_name', CSRF_TOKEN);
    $template->set_var('gltoken', SEC_createToken());

    PLG_templateSetVars('contact', $template);

    $template->parse('output', 'form');

    return $template->finish($template->get_var('output'));
}

/**
 * Send a contact or abuse-report message.
 *
 * @param int    $uid
 * @param int    $ad
 * @param string $subject
 * @param string $author
 * @param string $authoremail
 * @param string $message
 * @param string $mode contact|report
 * @param bool   $copySender
 * @return bool
 */
function CLASSIFIEDS_sendContact(
    $uid,
    $ad,
    $subject,
    $author,
    $authoremail,
    $message,
    $mode = 'contact',
    $copySender = false
) {
    global $_CONF, $_TABLES;

    $uid = (int) $uid;
    $ad = (int) $ad;
    $mode = ($mode === 'report') ? 'report' : 'contact';

    if (!SEC_checkToken() || $ad <= 0 || !CLASSIFIEDS_checkAdAccess($ad)) {
        return false;
    }

    if (COM_isAnonUser()
        && (!empty($_CONF['loginrequired']) || !empty($_CONF['emailuserloginrequired']))) {
        return false;
    }

    $author = trim(strip_tags((string) $author));
    $authoremail = trim((string) $authoremail);
    $subject = trim(strip_tags((string) $subject));
    $message = trim(strip_tags((string) $message));

    $author = substr($author, 0, strcspn($author, "\r\n"));
    $authoremail = substr($authoremail, 0, strcspn($authoremail, "\r\n"));
    $subject = substr($subject, 0, strcspn($subject, "\r\n"));

    if ($author === '' || $subject === '' || $message === '' || !COM_isemail($authoremail)) {
        return false;
    }

    COM_clearSpeedlimit($_CONF['speedlimit'], 'mail');
    if (COM_checkSpeedlimit('mail') > 0) {
        return false;
    }

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
        if (!CLASSIFIEDS_canContactUser($uid)) {
            return false;
        }

        $result = DB_query(
            "SELECT username, fullname, email FROM {$_TABLES['users']} WHERE uid = " . $uid
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
    $mailSubject = '[' . $_CONF['site_name'] . '] Classifieds #' . $ad . ' - ' . $subject;
    $mailBody = $message . "\n\n"
        . 'Classified ad: #' . $ad . "\n"
        . $_CONF['site_url'] . '/classifieds/index.php?mode=v&ad=' . $ad . "\n";

    $sent = COM_mail($to, $mailSubject, $mailBody, $from);

    if ($sent && $copySender) {
        COM_mail($from, $mailSubject, $mailBody, $_CONF['noreply_mail']);
    }

    COM_updateSpeedlimit('mail');

    return (bool) $sent;
}
