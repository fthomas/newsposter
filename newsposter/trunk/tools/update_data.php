<?php
/* $Id$ */
//
// Authors: Frank Thomas <frank@thomas-alfeld.de>

// adjust this to your separator string used in your old data.txt
$separator = '<-separator->';

// change to Newsposter's main dir for including some files 
chdir('..');

// include all required files
require_once('config.php');
require_once('include/posting.php');
require_once('include/' . $cfg['StoreTypeFile']);

// change back to tools directory
chdir('tools');

// we have to use session variables, because
// NP_Posting::create_post() needs them
session_start();

// prevent PHP from appending session_id to all URLs 
ini_set('session.use_trans_sid', 0);

$post_inst  = &new NP_Posting;
$store_inst = &new NP_Storing;

if (!file_exists('data.txt'))
{
    trigger_error('Old data file (data.txt) does not exist');
    exit(0);
}

// read entire file
$data_lines = file('data.txt');

// pop last item of array. it is empty
array_pop($data_lines);

foreach($data_lines as $key => $line)
{
    $post =  explode($separator, $line);

    $_SESSION['NP']['msgid']    = $post[0];
    $_SESSION['NP']['subject']  = $post[1];
    $_SESSION['NP']['name']     = $post[2];
    $_SESSION['NP']['mail']     = $post[3];
    $_SESSION['NP']['stamp']    = $post[4];
    $_SESSION['NP']['body']     = $post[5];
    $_SESSION['NP']['username'] = 'update';
    $_SESSION['NP']['topic']    = 'default';
    $_SESSION['NP']['emoticon'] = 'none';

    $store_inst->store_posting($post_inst->create_post());
}

?>
