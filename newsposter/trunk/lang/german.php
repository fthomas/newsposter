<?php
/* $Id$ */
//
// Translators: Frank Thomas <frank@thomas-alfeld.de>

$lang = array (

    /**
     * login.php
     */
    'login_user'   => 'Username',
    'login_pass'   => 'Passwort',
    'login_submit' => 'Login',
    'login_reset'  => 'Reset',
    'login_anonym' => 'anonym',
    
    /**
     * chact.php
     */
    'radio_text'   => 'Wähle eine der folgenden Aktionen...',
    'radio_write'  => 'Posting <b>schreiben</b>',
    'radio_edit'   => 'Posting <b>editieren</b>',
    'radio_delete' => 'Postings <b>löschen</b>',
    'radio_submit' => 'weiter',

    /**
     * error.php
     */
    'error'           => 'F E H L E R',
    'error_perm_text' => 'Du hast zu wenig Rechte!',
    'error_perm_link' => 'Versuche eine andere Aktion auszuf�hren:',
    'error_auth_text' => 'Authentifizierung war nicht erfolgreich!',
    'error_auth_link' => 'Versuche dich erneut einzuloggen:',
    
    /**
     * misc
     */
    'misc_name'    => 'Name',
    'misc_mail'    => 'E-Mail',
    'misc_subject' => 'Überschrift',
    'misc_article' => 'Artikel',
    'misc_comment' => 'Kommentar',
    'misc_unknown' => 'unbekannt',

    /**
     * NP_Mail
     */
    'mail_intro_error'   => 'Ein Zugangsversuch wurde aufgezeichnet',
    // %s = $lang['misc_article'] or $lang['misc_comment']
    'mail_intro_success' => 'Folgender %s wurde soeben gepostet',
    'mail_subj_error'    => 'Fehler Protokoll - ' . $cfg['PageTitle'],
    'mail_subj_new'      => 'Neues Posting auf '  . $cfg['PageTitle'],
    'mail_ip'            => 'IP Adresse',
    'mail_hostname'      => 'Hostname'
    
);

/* vim:set encoding=utf-8: */
?>
