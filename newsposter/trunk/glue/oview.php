<?php
/* $Id$ */
//
// Authors: Frank Thomas <frank@thomas-alfeld.de>

// include all required files
require_once('include/misc.php');

$entries = '';
$posts   = $_SESSION['NP']['store_inst']->get_all_news();
foreach($posts as $posting)
    $entries .= $_SESSION['NP']['output_inst']->render_oview($posting);

print_header();
require_once(create_theme_path('oview.inc'));
print_footer();

?>
