<?php
/* $Id$ */
//
// Authors: Frank Thomas <frank@thomas-alfeld.de>

// include all required files
require_once('include/misc.php');
require_once($np_dir . '/config.php');

// if $_POST is not set, this function also checks
// session vars for authentication
if ($_SESSION['NP']['auth_inst']->check_post() == FALSE)
    header("Location: {$_SESSION['NP']['auth_inst']->error_page}"); 

?>
