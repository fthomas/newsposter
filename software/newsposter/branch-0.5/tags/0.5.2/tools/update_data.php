<?php
/* $Id$ */
//
// Authors: Frank Thomas <frank@thomas-alfeld.de>

/**
 * This script converts all postings from the old Newsposter version 0.4.x
 * to the new format. Copy your old 'data.txt' file and the old 'comments/'
 * directory in the this directory (tools/) and run this script. All old
 * postings will then be stored (if nothing fails) in the spool/mbox file. 
 */

// this function convert and stores an old message in the new format
function old2new($line)
{
    global $cfg, $post_inst, $store_inst;
    
    // adjust this to your separator string used in your old data.txt
    $separator = '<-separator->';
    
    $emots = array (
        'angry',
        'dead',
        'discuss',
        'evil',
        'happy',
        'insane',
        'laughing',
        'mean',
        'none',
        'pissed',
        'sad',
        'satisfied',
        'shocked',
        'sleepy',
        'suprised',
        'uplooking'
    );
    
    $values1 = explode($separator, $line);
    $msgid   = "<" . $values1[0] . "@{$cfg['FQDN']}>";    
    
    $_SESSION['NP']['msgid']    = $msgid;
    $_SESSION['NP']['subject']  = utf8_encode($values1[1]);
    $_SESSION['NP']['name']     = utf8_encode($values1[2]);
    $_SESSION['NP']['mail']     = $values1[3];
    $_SESSION['NP']['stamp']    = $values1[4];
    $_SESSION['NP']['body']     = utf8_encode($values1[5]);
    $_SESSION['NP']['username'] = 'update';
    $_SESSION['NP']['topic']    = 'default';
    $_SESSION['NP']['emoticon'] = 'none';
    
    $posting = $post_inst->create_post();
    $store_inst->store_posting($posting);
    
    $filename = 'comments/' . $values1[0];
    
    if (file_exists($filename) && filesize($filename) != 0)
    {
        // reads $filename into array
        $lines = file($filename);

        foreach ($lines as $line)
        {
            $values2 = explode($separator, $line);
            $msgid   = "<" . $values2[0] . "@{$cfg['FQDN']}>";    

            $_SESSION['NP']['msgid']    = $msgid;
            $_SESSION['NP']['subject']  = 'Re: ' . $posting['subject'];
            $_SESSION['NP']['name']     = utf8_encode($values2[1]);
            $_SESSION['NP']['mail']     = $values2[2];
            $_SESSION['NP']['stamp']    = $values2[4];
            $_SESSION['NP']['body']     = utf8_encode($values2[3]);
            $_SESSION['NP']['username'] = 'update';
            $_SESSION['NP']['topic']    = 'comment';
            $_SESSION['NP']['emoticon'] = 'none';

            foreach ($emots as $emot)
            {
                if (isset($values2[5]) && stristr($values2[5], $emot))
                    $_SESSION['NP']['emoticon'] = $emot;
            }

            $comment = $post_inst->create_post($posting);
            $comment['stamp'] = trim($values2[4]);

            $store_inst->store_posting($comment);
        }
        
        $out_comments = " and ". count($lines) ." comments";
    }
    
    $out_posting = "Transferred posting (".strip_tags($posting['subject']).") ";
    print $out_posting . $out_comments . " <br />\n";
}

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

foreach($data_lines as $line)
{
    old2new($line);
}

?>
