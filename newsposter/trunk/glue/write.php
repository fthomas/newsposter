<?php
/* $Id$ */
//
// Authors: Frank Thomas <frank@thomas-alfeld.de>

// include all required files
require_once('include/constants.php');

// check auth
$_SESSION['NP']['auth_inst']->check_auth();
$_SESSION['NP']['auth_inst']->check_perm(P_WRITE);

// If internal_posting exists, store, send, post it!
if (isset($_SESSION['NP']['internal_posting']))
{
    $int_post = $_SESSION['NP']['internal_posting'];
    $ext_post = $_SESSION['NP']['post_inst']->int2ext($int_post);

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

// send back to default page
header("Location: {$cfg['IndexURL']}?np_act=output_all");

?>
