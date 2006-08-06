#!/usr/bin/php4 -q
<?php
/* $Id$ */
//
// Authors: Frank S. Thomas <frank@thomas-alfeld.de>

// Go to Newsposter's main directory and include some mandatory files.
chdir('..');
require_once('config.php');
require_once('include/' . $cfg['StoreTypeFile']);
chdir('tools');

// Create directory to store converted entries.
@mkdir('../spool/blosxom/'); 
@mkdir('../spool/blosxom/writeback/');

$store_inst = &new NP_Storing;

foreach($store_inst->get_all_news() as $news_item)
{
    $thread = $store_inst->get_thread($news_item['msgid']);
    convert_to_blosxom($thread);
}

function convert_to_blosxom($thread)
{
    $replace = array(' ',':',';','[',']','-','?','/','!','(',')',"'",'"','@','¤');
    $fn = str_replace($replace, '', $thread[0]['subject']);
    $fn = strtolower($fn);
    
    // Create entry file.
    $rfc_date = stamp2string($thread[0]['stamp'], 8);
    $file_cont  = $thread[0]['subject']."\n";
    $file_cont .= "<!--\nmeta-creatio_date: $rfc_date\n-->\n";
    $file_cont .= $thread[0]['body']."\n";

    $fp = fopen('../spool/blosxom/'.$fn.'.blog.txt', 'w+');
    fwrite($fp, $file_cont);
    fclose($fp);
    
    // Create writeback file.
    unset($thread[0]);
    $wbp = fopen('../spool/blosxom/writeback/'.$fn.'.wb', 'w');
    foreach($thread as $comment)
    {	
	$body = str_replace(array("\n","\t"), ' ', $comment['body']);
	$url = "";
	if (!empty($comment['mail']))
	    $url = "mailto:".$comment['mail'];
	
	$wb_cont  = "name: ".$comment['name']."\n";
	$wb_cont .= "url: ".$url."\n";
	$wb_cont .= "title: ".$comment['subject']."\n";
	$wb_cont .= "comment: ".$body."\n";
	$wb_cont .= "excerpt: \n";
	$wb_cont .= "blog name: \n";
	$wb_cont .= "-----\n";
	
	fwrite($wbp, $wb_cont);
    }
    fclose($wbp);
}

?>
