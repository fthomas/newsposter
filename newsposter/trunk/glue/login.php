<?php
/* $Id$ */
//
// Authors: Frank Thomas <frank@thomas-alfeld.de>

// include all required files
require_once('include/misc.php');
require_once($np_dir . '/config.php');

// retrieve additional informations for login page
$login_add = $_SESSION['NP']['output_inst']->login();

print_header();
require_once(c_theme_path('login.inc'));
print_footer();

?>
