<?php
/* $Id$ */
//
// Authors: Frank Thomas <frank@thomas-alfeld.de>

// include all required files
require_once('include/misc.php');
require_once('conf/config.php');

// if $_POST is not set, this function also checks
// session vars for authentication
if ($_SESSION['NP']['auth_inst']->check_post() == FALSE)
{
    $sess_id = create_sess_param();
    if (isset($_POST))
	$_SESSION['NP']['_POST'] = $_POST;

    header("Location: {$_SESSION['NP']['auth_inst']->error_page}&auth&$sess_id");     
    exit(0);
}

$radio_buttons = $_SESSION['NP']['output_inst']->get_radio_buttons(
    $_SESSION['NP']['auth_inst']);

print_header();
require_once(create_theme_path('chact.inc'));
print_footer();
    
?>
