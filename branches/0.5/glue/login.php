<?php
/* $Id: login.php 44 2003-01-12 16:50:14Z anonymous $ */
//
// Authors: Frank Thomas <frank@thomas-alfeld.de>

// include all required files
require_once('include/misc.php');
require_once('config.php');

// retrieve additional informations for login page
$login_add = $_SESSION['NP']['output_inst']->get_values_login();

print_header();
require_once(create_theme_path('login.inc'));
print_footer();

?>
