<?php
/* $Id$ */
//
// Authors: Frank Thomas <frank@thomas-alfeld.de>

// include all required files
require_once('include/constants.php');

// check_auth
$_SESSION['NP']['auth_inst']->check_auth();
$_SESSION['NP']['auth_inst']->check_perm(array(P_DEL,
					P_DEL_NEWS, P_DEL_COMMENTS));

if (isset($_POST['cb']))
{
    foreach($_POST['cb'] as $msgid)
    {
	// create cancel before removing
	if ($cfg['PostNNTP'])
	{
	    $int_post = $_SESSION['NP']['store_inst']->get_posting($msgid);
	    $cancel   = $_SESSION['NP']['post_inst']->create_cancel($int_post); 
	    
	    $_SESSION['NP']['nntp_inst']->post($cancel);
	}
	
	$_SESSION['NP']['store_inst']->remove_posting($msgid, TRUE);
    }
    
    if ($cfg['RDFCreation'])
	$_SESSION['NP']['rdf_inst']->create_rdf_file();
}

// send back to default page
header("Location: {$cfg['IndexURL']}?np_act=output_news");

?>