<?php
/* $Id: output_all.php 47 2003-01-19 19:10:30Z anonymous $ */
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