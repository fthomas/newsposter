<?php
/* $Id: output_news.php 49 2003-01-28 19:35:02Z mrfrost $ */
//
// Authors: Frank Thomas <frank@thomas-alfeld.de>

// include all required files
require_once('include/misc.php');
require_once('config.php');

$output = '';
$posts  = $_SESSION['NP']['store_inst']->get_all_news(0, $cfg['MaxPostings']);
foreach($posts as $posting)
{
    $diff = time() - $posting['stamp'];
    if ($cfg['CutOffAge'] != 0 && $diff > $cfg['CutOffAge'])
	break;
	
    $output .= $_SESSION['NP']['output_inst']->render_posting($posting);
}

print_header();
print($output);
print_footer();

?>