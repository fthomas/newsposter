<?php
/* $Id$ */
//
// Authors: Frank Thomas <frank@thomas-alfeld.de>

/**
 * The NP_Posting class can create postings and comments.
 * It also transforms the internal to the external posting
 * format and the other way round.
 *
 * The internal posting format (associative array):
 *
 *	array (
 *		'user'    => 'mrfrost {login username}',
 *		'name'    => 'Frank Thomas',
 *		'mail'    => 'frank@thomas-alfeld.de',
 *		'subject' => 'Announcing Newsposter 0.5.0!',
 *		'msgid'   => '<{unique ID}@{FQDN}>',
 *		'refs'    => '<{msgid}> <{msgid}>',
 *		'ngs'     => 'de.alt.test',
 *		'date'    => '17.11.2002 14:34',
 *		'stamp'   => '{unix time stamp}',
 *		'c_to'    => 'postmaster@thomas-alfeld.de',
 *		'topic'   => 'default',
 *		'emoticon'=> 'happy',
 *		'body'    => 'hello.<br /> this is the content of the posting'
 *	);
 *
 * The external posting format (text only):  
 *
 *	From: "Frank Thomas" <frank@thomas-alfeld.de>
 *	Newsgroups: de.alt.test
 *	Subject: Announcing Newsposter 0.5.0!
 *	Message-ID: <{unique ID}@{FQDN}>
 *	References: <{msgid}>
 *	 <{msgid}>
 *	Date: Sun, 17 Nov 2002 14:34:23 +0100
 *	Lines: 1
 *	User-Agent: Newsposter/{version}
 *	Content-Type: text/plain; charset=utf-8
 *	Content-Transfer-Encoding: 8bit
 *	X-Complaints-To: postmaster@thomas-alfeld.de
 *	X-NP-Name: Frank Thomas
 *	X-NP-Mail: frank@thomas-alfeld.de
 *	X-NP-User: mrfrost (login username)	
 *	X-NP-Stamp: {unix time stamp}
 *	X-NP-Topic: default
 *	X-NP-Emoticon: happy
 *	
 *	hello.<br /> this is the content of the posting
 *
 */

// include all required files
require_once('date.php');
require_once('misc.php');
require_once('constants.php');

class NP_Posting {
    
    function ext2int()
    {
    }

    /**
     * @param	array	$int_posting
     * @access	public
     * @returns	string
     */
    function int2ext($int_posting)
    {
	// remove all ASCII control characters from
	// these headers
	$name    = remove_cchars($int_posting['name']);
	$mail    = remove_cchars($int_posting['mail']);
	$subject = remove_cchars($int_posting['subject']);
    
	// now we fill up $ext
        $ext  = "From: \"$name\" <$mail>\r\n";
	$ext .= "Newsgroups: {$int_posting['ngs']}\r\n";
	$ext .= "Subject: $subject\r\n";
	$ext .= "Message-ID: {$int_posting['msgid']}\r\n";
	
	if(!empty($int_posting['refs']))
	{
	    $refs = explode(" ",$int_posting['refs']);
	    $ext .= "References: $refs[0]\r\n";
	    
	    $n = count($refs);
	    for($i=1; $i < $n; $i++)
		$ext .= " $refs[$i]\r\n";
	}
	
	$ext .= 'Date: ' .stamp2string($int_posting['stamp'], 8)."\r\n"; 
	
	$lines = substr_count("\n", $int_posting['body']) + 1; 
	$ext  .= "Lines: $lines\r\n";
	
	$ext .= 'User-Agent: Newsposter/'.VERSION."\r\n";
	$ext .= "Content-Type: text/plain; encoding=utf-8\r\n";
	$ext .= "Content-Transfer-Encoding: 8bit\r\n";
	$ext .= "X-Complaints-To: {$int_posting['c_to']}\r\n";
	$ext .= "X-NP-Name: $name\r\n";
	$ext .= "X-NP-Mail: $mail\r\n";
	$ext .= "X-NP-User: {$int_posting['user']}\r\n";
	$ext .= "X-NP-Stamp: {$int_posting['stamp']}\r\n";
	$ext .= "X-NP-Topic: {$int_posting['topic']}\r\n";
	$ext .= "X-NP-Emoticon: {$int_posting['emoticon']}\r\n";
	$ext .= "\r\n";

	// get internal encding and encode $body to utf-8
	$int_enc = iconv_get_encoding('internal_encoding');	
	$body    = iconv($int_enc, 'UTF-8', $int_posting['body']);
	$ext    .= "$body\r\n\r\n";
	
	return $ext;
    }
    

}

?>