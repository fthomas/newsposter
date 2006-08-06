<?php
/* $Id$ */
//
// Authors: Frank Thomas <frank@thomas-alfeld.de>

require_once('include/constants.php');
require_once('include/misc.php');
require_once('include/auth.php');
require_once('include/i18n.php');
require_once('include/output.php');
require_once('include/posting.php');
require_once('include/storing.php');

if (!isset($_SESSION))
    session_start();

// create global instances of some classes
$_SESSION['NP']['i18n_inst']   = &new NP_I18N;
$_SESSION['NP']['output_inst'] = &new NP_Output;
$_SESSION['NP']['auth_inst']   = &new NP_Auth;
$_SESSION['NP']['post_inst']   = &new NP_Posting;
$_SESSION['NP']['store_inst']  = &new NP_Storing;

print "<pre>";
print_r($GLOBALS);
print "</pre>";

?>
