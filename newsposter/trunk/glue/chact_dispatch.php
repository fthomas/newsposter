<?php
/* $Id$ */
//
// Authors: Frank Thomas <frank@thomas-alfeld.de>

//include all required files
require_once('include/misc.php');
require_once('config.php');

// check auth
$_SESSION['NP']['auth_inst']->check_auth();
$sess_id = create_sess_param();

// if no action is specified we send the user back to chact
if (!isset($_POST['action']) || empty($_POST['action']))
{
    header("Location: {$cfg['IndexURL']}?np_act=chact&$sess_id");
    exit(0);
}

switch($_POST['action'])
{
    case 'write':
	header("Location: {$cfg['IndexURL']}?np_act=posting_form&$sess_id");
	exit(0);

    case 'edit':
	print "EDIT";
	break;
	
    case 'delete':
	print "DELETE";
	break;

    default:
	header("Location: {$cfg['IndexURL']}?np_act=chact&$sess_id");
	exit(0);
}

?>