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

$val = $_SESSION['NP']['output_inst']->get_error_text();

print_header();
require_once(create_theme_path('error.inc'));
print_footer();

?>
