<?php
/* $Id$ */
//
// Authors: Frank Thomas <frank@thomas-alfeld.de>

// include all required files
require_once('include/misc.php');
require_once($np_dir . '/config.php');

if ($cfg['SendMailOnError'] == TRUE)
{
    $mail_inst = &new NP_Mail;
}

?>
