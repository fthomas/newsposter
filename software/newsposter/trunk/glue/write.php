<?php
/* $Id$ */
//
// Authors: Frank Thomas <frank@thomas-alfeld.de>

// include all required files
require_once('include/constants.php');

// check auth
$_SESSION['NP']['auth_inst']->check_auth();
$_SESSION['NP']['auth_inst']->check_perm(P_WRITE);

// if internal_posting exists, store, send, post it!
if (isset($_SESSION['NP']['internal_posting']))
{
    $int_post = $_SESSION['NP']['internal_posting'];
    $ext_post = $_SESSION['NP']['post_inst']->int2ext($int_post);
    
    if (isset($_SESSION['NP']['replace_msgid']))
    {
	$supersede = $_SESSION['NP']['post_inst']->create_supersede(
		$int_post, $_SESSION['NP']['replace_msgid']);
	
	$_SESSION['NP']['store_inst']->replace_posting(
		$int_post, $_SESSION['NP']['replace_msgid']);
	
	if ($cfg['CreateFeeds'])
	    $_SESSION['NP']['feeds_inst']->create_all();

	if ($cfg['PostNNTP'])
	    $_SESSION['NP']['nntp_inst']->post($supersede);

	if ($cfg['SendMailOnSuccess'])
    	    $_SESSION['NP']['mail_inst']->send_mail_success($int_post);
    }
    
    else
    {
	$_SESSION['NP']['store_inst']->store_posting($int_post);

	if ($cfg['CreateFeeds'])
	    $_SESSION['NP']['feeds_inst']->create_all();

	if ($cfg['PostNNTP'])
	    $_SESSION['NP']['nntp_inst']->post($ext_post);

	if ($cfg['SendMailOnSuccess'])
    	    $_SESSION['NP']['mail_inst']->send_mail_success($int_post);

	if ($cfg['SendNewsletter'])
    	    $_SESSION['NP']['mail_inst']->send_newsletter($int_post);
    }
}

// send back to default page
header("Location: {$cfg['IndexURL']}?np_act=output_news");

?>
