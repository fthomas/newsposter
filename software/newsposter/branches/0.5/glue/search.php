<?php
/* $Id: search.php 51 2003-02-02 13:14:37Z anonymous $ */
//
// Authors: Frank Thomas <frank@thomas-alfeld.de>

// include all required files
require_once('include/misc.php');

$output = '';
if (isset($_POST['search_str']) && !empty($_POST['search_str']))
{    
    switch($_POST['search_index'])
    {
	case 'all':
	    $posts = $_SESSION['NP']['store_inst']->get_all_postings();
	    break;
	
	case 'news':
	    $posts = $_SESSION['NP']['store_inst']->get_all_news();
	    break;
	
	case 'comments':
	    $posts = $_SESSION['NP']['store_inst']->get_all_comments();
	    break;
    }
    
    foreach($posts as $posting)
    {
	// find out if search string is in posting
	$cond1 = stristr($posting['name'],    $_POST['search_str']);
	$cond2 = stristr($posting['mail'],    $_POST['search_str']);
	$cond3 = stristr($posting['subject'], $_POST['search_str']);
	$cond4 = stristr($posting['body'],    $_POST['search_str']);
	
	// if one condition is true, save the posting
	if ($cond1 || $cond2 || $cond3 || $cond4)
	{
	    if(empty($posting['refs']))
		$output .= $_SESSION['NP']['output_inst']->render_posting(
					$posting, TRUE, $_POST['search_str']);
	    else
		$output .= $_SESSION['NP']['output_inst']->render_comment(
					$posting, NULL, $_POST['search_str']);
	}
    }
}

print_header();
require_once(create_theme_path('search.inc'));
print($output);
print_footer();

?>
