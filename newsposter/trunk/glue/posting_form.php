<?php
/* $Id$ */
//
// Authors: Frank Thomas <frank@thomas-alfeld.de>

// include all required files
require_once('include/misc.php');
require_once('include/constants.php');
require_once('config.php');

// check auth
$_SESSION['NP']['auth_inst']->check_auth();
$_SESSION['NP']['auth_inst']->check_perm(P_WRITE);

$select_opts   = $_SESSION['NP']['output_inst']->get_selection_topic();
$emoticon_opts = $_SESSION['NP']['output_inst']->get_selection_emots();
$form          = $_SESSION['NP']['output_inst']->get_values_perform();

print_header();
require_once(create_theme_path('posting_form.inc'));
print_footer();

?>
