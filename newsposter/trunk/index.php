<?php
/* $Id$ */
//
// Authors: Frank Thomas <frank@thomas-alfeld.de>

// include all required files
require_once('include/misc.php');
require_once('include/output.php');
require_once('include/auth.php');
require_once('include/posting.php');

session_start();

// create global instances of some classes
$_SESSION['NP']['output_inst'] = &new NP_Output;
$_SESSION['NP']['auth_inst']   = &new NP_Auth;
$_SESSION['NP']['post_inst']   = &new NP_Posting;

// if no np_action is specified we want to show
// postings
if (empty($_GET['np_act']))
    $action = 'login';
else
    $action = $_GET['np_act'];

// look up action var
switch($action)
{
    case 'login':
	$inc = 'login.php';
	break;

    // chact is "choose action"	
    case 'chact':
	$inc = 'chact.php';
	break;

    case 'chact_dispatch':
	$inc = 'chact_dispatch.php';
	break;
    
    case 'error':
	$inc = 'error.php';
	break;

    case 'posting_form':
	$inc = 'posting_form.php';
	break;

    case 'preview':
	$inc = 'preview.php';
	break;

    default:
	$inc = 'login.php';
}

// now include selected file
require_once($np_dir . '/glue/' . $inc);

?>