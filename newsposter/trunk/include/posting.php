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
 *	X-NP-User: mrfrost {login username}	
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
require_once($np_dir . '/config.php');
require_once($cfg['StoreTypeFile']);


class NP_Posting {

    /**
     * @param	string	$ext_post
     * @access	public
     * @returns	array
     */    
    function ext2int($ext_post)
    {
	global $cfg;
	
	$ext_post  = str_replace("\r", '', $ext_post);
	$lines     = explode("\n", $ext_post);
	$int_array = array();
	
	foreach($lines as $key => $line)
	{
	    // make sure that we only get header fields,
	    // no unfolded lines or the message itself 
	    if (empty($line))
	    {
		$body_line = $key;
		break;
	    }
	    
	    $header_len = strpos($line, ':');
	    
	    if ($header_len == FALSE || $line[0] == ' ')
		continue;
		
	    $header_field = substr($line, 0, $header_len); 
	    $header_value = trim( substr($line, $header_len + 1) );
	    
	    // fill up the array 
	    if ($header_field == 'X-NP-User')
		$int_array['user'] = $header_value;
	
	    else if ($header_field == 'X-NP-Name')
		$int_array['name'] = $header_value;
	
	    else if ($header_field == 'X-NP-Mail')
		$int_array['mail'] = $header_value;
		
	    else if ($header_field == 'Subject')
		$int_array['subject'] = $header_value;
	
	    else if ($header_field == 'Message-ID')
		$int_array['msgid'] = $header_value;

	    else if ($header_field == 'Newsgroups')
		$int_array['ngs'] = $header_value;
	
	    else if ($header_field == 'X-NP-Stamp')
		$int_array['stamp'] = $header_value;
	
	    else if ($header_field == 'X-Complaints-To')
		$int_array['c_to'] = $header_value;
		
	    else if ($header_field == 'X-NP-Topic')
		$int_array['topic'] = $header_value;
	
	    else if ($header_field == 'X-NP-Emoticon')
		$int_array['emoticon'] = $header_value;	
	    
	    else if ($header_field == 'References')
	    {
		$int_array['refs'] = $header_value;
		$refs_line = $key;
	    }
	}
	
	// now collect all unfolded references
	while( $lines[++$refs_line]['0'] == ' ')
	{
	    $msgid = trim($lines[$refs_line]);
	    $int_array['refs'] .= " " . $msgid;
	}
	
	$int_array['date'] = stamp2string($int_array['stamp'], $cfg['DateFormat']);
	$int_array['body'] = implode("\r\n", array_slice($lines, $body_line + 1));
	
	return $int_array;
    }

    /**
     * @param	array	$int_post
     * @access	public
     * @returns	string
     */
    function int2ext($int_post)
    {
	// remove all ASCII control characters from
	// these headers
	$name    = remove_cchars($int_post['name']);
	$mail    = remove_cchars($int_post['mail']);
	$subject = remove_cchars($int_post['subject']);
    
	// now we fill up $ext
        $ext  = "From: \"$name\" <$mail>\r\n";
	$ext .= "Newsgroups: {$int_post['ngs']}\r\n";
	$ext .= "Subject: $subject\r\n";
	$ext .= "Message-ID: {$int_post['msgid']}\r\n";
	
	if(!empty($int_post['refs']))
	{
	    $refs = explode(" ",$int_post['refs']);
	    $ext .= "References: $refs[0]\r\n";
	    
	    $n = count($refs);
	    for($i=1; $i < $n; $i++)
		$ext .= " $refs[$i]\r\n";
	}
	
	$ext .= 'Date: ' .stamp2string($int_post['stamp'], 8)."\r\n"; 
	
	$lines = substr_count("\n", $int_post['body']) + 1; 
	$ext  .= "Lines: $lines\r\n";
	
	$ext .= 'User-Agent: Newsposter/'.VERSION."\r\n";
	$ext .= "Content-Type: text/plain; encoding=utf-8\r\n";
	$ext .= "Content-Transfer-Encoding: 8bit\r\n";
	$ext .= "X-Complaints-To: {$int_post['c_to']}\r\n";
	$ext .= "X-NP-Name: $name\r\n";
	$ext .= "X-NP-Mail: $mail\r\n";
	$ext .= "X-NP-User: {$int_post['user']}\r\n";
	$ext .= "X-NP-Stamp: {$int_post['stamp']}\r\n";
	$ext .= "X-NP-Topic: {$int_post['topic']}\r\n";
	$ext .= "X-NP-Emoticon: {$int_post['emoticon']}\r\n";
	$ext .= "\r\n";

	// get internal encoding and encode $body to utf-8
	$int_enc = iconv_get_encoding('internal_encoding');	
	$body    = iconv($int_enc, 'UTF-8', $int_post['body']);
	$ext    .= $body;
	
	return $ext;
    }
    
    /**
     * @access	private
     * @returns	string
     */
     function _create_msgid()
     {
        $store_inst = new NP_Storing;
     
        do
	{
	    $msgid    = $this->_suggest_msgid();
	    $is_valid = $store_inst->validate_msgid($msgid);
	} while ($is_valid == FALSE);
	
	return $msgid;
     }
     
    /**
     * @access	private
     * @returns	string
     */
    function _suggest_msgid()
    {
	if (empty($cfg['FQDN']))
	    $dn = 'newsposter';
	else
	    $dn = $cfg['FQDN']; 
	
	$uniqid = md5(uniqid(rand(), TRUE));

	// date component
	$dc = my_date(11);

	$msgid = sprintf('%s_%s@%s', $uniqid, $dc, $dn);
	$msgid = str_replace(array('<', '>'), '', $msgid);
	
	return $msgid;
    }
    
}

?>