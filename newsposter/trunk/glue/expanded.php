<?php
/* $Id$ */
//
// Authors: Frank Thomas <frank@thomas-alfeld.de>

// include all required files
require_once('include/misc.php');

// write comment, if $_POST is set
if (isset($_POST['body']) && !empty($_POST['body']) && $cfg['UseComments'])
{
    $_SESSION['NP']['name']     = $_POST['name'];
    $_SESSION['NP']['mail']     = $_POST['mail'];
    $_SESSION['NP']['subject']  = $_POST['subject'];
    $_SESSION['NP']['emoticon'] = $_POST['emoticon'];
    $_SESSION['NP']['body']     = $_POST['body'];
    $_SESSION['NP']['topic']    = 'comment';
    
    if (!isset($_SESSION['NP']['username']))
	$_SESSION['NP']['username'] = 'commentator';
    
    $reference = $_SESSION['NP']['store_inst']->get_posting($_POST['ref']);
    $int_post  = $_SESSION['NP']['post_inst']->create_post($reference);
    $ext_post  = $_SESSION['NP']['post_inst']->int2ext($int_post);
    
    $_SESSION['NP']['store_inst']->store_posting($int_post);
    
    if ($cfg['RDFCreation'])
	$_SESSION['NP']['rdf_inst']->create_rdf_file();
    
    if ($cfg['PostNNTP'])
	$_SESSION['NP']['nntp_inst']->post($ext_post);
    
    if ($cfg['SendMailOnSuccess'])
	$_SESSION['NP']['mail_inst']->send_mail_success($int_post);

    if ($cfg['SendNewsletter'])
	$_SESSION['NP']['mail_inst']->send_newsletter($int_post);
}

// get parent and children
$parent = $_SESSION['NP']['store_inst']->get_posting($_GET['msg_id']);
$posts  = $_SESSION['NP']['store_inst']->get_thread($_GET['msg_id'], FALSE);

// exit if parent posting does not exist
if (empty($parent))
    exit(0);

// render parent and children
$output = $_SESSION['NP']['output_inst']->render_posting($parent, FALSE);

if ($cfg['UseComments'] && $cfg['ShowOverview'])
    $output .= $_SESSION['NP']['output_inst']->render_oview($posts);

foreach($posts as $comment)
    $output .= $_SESSION['NP']['output_inst']->render_comment(
		$comment, $parent['msgid']);

print_header();
print($output);

if ($cfg['UseComments'])
{
    $val = $_SESSION['NP']['output_inst']->get_values_comment();
    require_once(create_theme_path('comment_form.inc'));
}

print_footer();

?>
