<?php
/* $Id: oview.php 49 2003-01-28 19:35:02Z mrfrost $ */
//
// Authors: Frank Thomas <frank@thomas-alfeld.de>

// include all required files
require_once('include/misc.php');

$threaded_posts = array();
$posts = $_SESSION['NP']['store_inst']->get_all_news();
foreach($posts as $posting)
    $threaded_posts = array_merge($threaded_posts,
	    $_SESSION['NP']['store_inst']->get_thread($posting['msgid'])); 

$oview = $_SESSION['NP']['output_inst']->render_oview($threaded_posts);

print_header();
print($oview);
print_footer();

?>
