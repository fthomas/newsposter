<?php
/* $Id$ */
//
// Authors: Frank Thomas <frank@thomas-alfeld.de>

// include all required files
require_once('include/misc.php');
require_once('include/constants.php');

// check_auth
$_SESSION['NP']['auth_inst']->check_auth();
$_SESSION['NP']['auth_inst']->check_perm(array(P_WRITE, P_EDIT, P_EDIT_NEWS));

// move all $_POST vars to the current session
$_SESSION['NP']['name']     = $_POST['name'];
$_SESSION['NP']['mail']     = $_POST['mail'];
$_SESSION['NP']['subject']  = $_POST['subject'];
$_SESSION['NP']['topic']    = $_POST['topic'];
$_SESSION['NP']['emoticon'] = $_POST['emoticon'];
$_SESSION['NP']['body']     = $_POST['body'];
$_SESSION['NP']['nl2br']    = FALSE;

if (isset($_POST['nl2br']))
{
    $_SESSION['NP']['nl2br'] = TRUE;
    $_SESSION['NP']['body']  = str_replace("\n", "<br />\n",
				    $_SESSION['NP']['body']);
}

// create internal formatted posting from session variables
$preview_post = $_SESSION['NP']['post_inst']->create_post();

print_header();
require_once(create_theme_path('preview.inc'));
print($_SESSION['NP']['output_inst']->render_posting($preview_post));
print_footer();

?>
