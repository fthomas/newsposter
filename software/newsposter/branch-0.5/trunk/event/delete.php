<?php
/* $Id$ */
//
// Authors: Frank Thomas <frank@thomas-alfeld.de>

// include all required files
require_once('include/constants.php');

// check_auth
$_SESSION['NP']['auth_inst']->check_auth();
$_SESSION['NP']['auth_inst']->check_perm(
    array(P_DELETE, P_ARTICLES_DELETE, P_COMMENTS_DELETE));

if (isset($_POST['cb']))
{
    foreach($_POST['cb'] as $msgid)
    {
	// prepare msg_id for normal usage
	$msgid = prep_msgid($msgid);
	
	$_SESSION['NP']['store_inst']->remove_posting($msgid, TRUE);
    }
    
    if ($cfg['CreateFeeds'])
	$_SESSION['NP']['feeds_inst']->create_all();
}

// send back to default page
header("Location: {$cfg['IndexURL']}?np_act=output_news");

?>