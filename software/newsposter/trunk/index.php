<?php
/* $Id$ */
//
// Authors: Frank Thomas <frank@thomas-alfeld.de>

require_once('include/misc.php');

require_once('include/auth.php');
require_once('include/blacklist.php');
require_once('include/i18n.php');
require_once('include/mail.php');
require_once('include/news_feeds.php');
require_once('include/nntp.php');
require_once('include/output.php');
require_once('include/posting.php');
require_once('include/store_fs.php');
require_once('include/ubb_code.php');

if (!isset($_SESSION))
    session_start();

// create global instances of some classes
$_SESSION['NP']['i18n_inst']   = &new NP_I18N;
$_SESSION['NP']['output_inst'] = &new NP_Output;
$_SESSION['NP']['auth_inst']   = &new NP_Auth;
$_SESSION['NP']['post_inst']   = &new NP_Posting;
$_SESSION['NP']['store_inst']  = &new NP_Storing;
$_SESSION['NP']['nntp_inst']   = &new NP_NNTP;
$_SESSION['NP']['mail_inst']   = &new NP_Mail;
$_SESSION['NP']['ubb_inst']    = &new NP_UBB;
$_SESSION['NP']['feeds_inst']  = &new NP_NewsFeeds;
$_SESSION['NP']['bl_inst']     = &new NP_Blacklist;

// if no np_action is specified we want to show
// postings
$action = (empty($_GET['np_act'])) ? ('output_news') : ($_GET['np_act']);

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

    case 'write':
	$inc = 'write.php';
	break;
    
    case 'output_news':
	$inc = 'output_news.php';
	break;
	
    case 'output_all':
	$inc = 'output_all.php';
	break;

    case 'expanded':
	$inc = 'expanded.php';
	break;
    
    case 'oview':
	$inc = 'oview.php';
	break;

    case 'search':
	$inc = 'search.php';
	break;

    case 'posting_sel':
	$inc = 'posting_sel.php';
	break;
    
    case 'delete':
	$inc = 'delete.php';
	break;
	
    default:
	$inc = 'output_news.php';
}

// now include selected file
require_once($np_dir . '/event/' . $inc);

?>
