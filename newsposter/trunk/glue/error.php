<?php
/* $Id$ */
//
// Authors: Frank Thomas <frank@thomas-alfeld.de>

// include all required files
require_once('include/misc.php');
require_once('include/mail.php');
require_once('config.php');

if ($cfg['SendMailOnError'] == TRUE)
{
    $mail_inst = &new NP_Mail;
    $mail_inst->send_mail_error();
}

if (isset($_GET['auth']))
{
    $url        = $cfg['IndexURL'] . '?np_act=login';
    $error_link = $lang['error_auth_link'];
    $error_text = $lang['error_auth_text'];
    $link       = sprintf("<a href=\"%s\">%s</a>", $url, $url);

}
else if (isset($_GET['perm']))
{
    $sess_id    = create_sess_param();
    $url        = $cfg['IndexURL'] . '?np_act=chact';
    $error_link = $lang['error_perm_link'];
    $error_text = $lang['error_perm_text'];
    $link       = sprintf("<a href=\"%s&%s\">%s</a>", $url, $sess_id, $url);

}

print_header();
require_once(create_theme_path('error.inc'));
print_footer();

?>
