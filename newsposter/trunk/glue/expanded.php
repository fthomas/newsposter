<?php
/* $Id$ */
//
// Authors: Frank Thomas <frank@thomas-alfeld.de>

// include all required files
require_once('include/misc.php');

// get parent and children
$parent = $_SESSION['NP']['store_inst']->get_posting($_GET['msg_id']);
$posts  = $_SESSION['NP']['store_inst']->get_thread($_GET['msg_id'], FALSE);

// render parent and children
$output = $_SESSION['NP']['output_inst']->render_posting($parent, FALSE);

print_header();
print($output);

if ($cfg['UseComments'])
{
    // comment a comment or a news entry?
    $msgid = (isset($_GET['child_of'])) ? ($_GET['child_of'])
		: ($_GET['msg_id']);

    $emots_opts = $_SESSION['NP']['output_inst']->get_selection_emots();
    require_once(create_theme_path('comments.inc'));
}

print_footer();

?>