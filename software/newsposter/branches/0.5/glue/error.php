<?php
/* $Id: error.php 57 2003-02-12 16:33:48Z mrfrost $ */
//
// Authors: Frank Thomas <frank@thomas-alfeld.de>

// include all required files
require_once('include/misc.php');
require_once('include/mail.php');
require_once('config.php');

if ($cfg['SendMailOnError'] == TRUE &&
    $_SESSION['NP']['bl_inst']->validate_user() == TRUE)
{
    $mail_inst = &new NP_Mail;
    $mail_inst->send_mail_error();
}

$val = $_SESSION['NP']['output_inst']->get_error_text();

print_header();
require_once(create_theme_path('error.inc'));
print_footer();

?>
