<?php
/* $Id$ */
//
// Authors: Frank Thomas <frank@thomas-alfeld.de>

// include all required files
require_once('include/misc.php');
require_once('conf/config.php');

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