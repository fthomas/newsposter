<?php
/* $Id$ */
//
// Authors: Frank Thomas <frank@thomas-alfeld.de>

// include all required files
require_once('include/misc.php');

$output = '';
$posts  = $_SESSION['NP']['store_inst']->get_all_news();
foreach($posts as $posting)
    $output .= $_SESSION['NP']['output_inst']->render_posting($posting);

print_header();
print($output);
print_footer();

?>