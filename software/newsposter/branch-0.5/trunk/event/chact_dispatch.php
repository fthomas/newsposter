<?php
/* $Id$ */
//
// Authors: Frank Thomas <frank@thomas-alfeld.de>

require_once('include/misc.php');
require_once('conf/config.php');

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
        unset_posting_session_vars();
	header("Location: {$cfg['IndexURL']}?np_act=posting_form&$sess_id");
	exit(0);

    case 'edit':
	header("Location: {$cfg['IndexURL']}?np_act=posting_selection&edit&$sess_id");
	exit(0);
	
    case 'delete':
	header("Location: {$cfg['IndexURL']}?np_act=posting_selection&del&$sess_id");
	exit(0);

    default:
	header("Location: {$cfg['IndexURL']}?np_act=chact&$sess_id");
	exit(0);
}

function unset_posting_session_vars()
{
    unset($_SESSION['NP']['name']);    
    unset($_SESSION['NP']['mail']);
    unset($_SESSION['NP']['subject']); 
    unset($_SESSION['NP']['topic']);
    unset($_SESSION['NP']['emoticon']);
    unset($_SESSION['NP']['body']);
    unset($_SESSION['NP']['stamp']);
    unset($_SESSION['NP']['refs']);
}

?>
