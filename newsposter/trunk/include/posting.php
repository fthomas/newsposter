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
     * @access	public
     * @param	array	$reference	An internal formatted  posting. 
     * @return	array	The returned array is an internal formatted posting.
     */
    function create_post($reference = NULL)
    {
	global $cfg;
    
	session_start();
    
	// for anonymous posting set name/mail/subject to
	// unknown
	$_SESSION['name']    = trim($_SESSION['name']);
	$_SESSION['mail']    = trim($_SESSION['mail']);
	$_SESSION['subject'] = trim($_SESSION['subject']);
	
	if (!empty($_SESSION['name'])) 
	    $int_post['name'] = $_SESSION['name'];
	else
	    $int_post['name'] = 'unknown';
	
	if (!empty($_SESSION['mail']))
	    $int_post['mail'] = $_SESSION['mail'];
	else
	    $int_post['mail'] = 'unknown';
    
	if (!empty($_SESSION['subject']))
	    $int_post['subject'] = $_SESSION['subject'];
	else
	    $int_post['subject'] = 'unknown';
	
	$int_post['user']     = $_SESSION['username'];
	$int_post['msgid']    = $this->_create_msgid();
	$int_post['ngs']      = $cfg['Newsgroup'];
	$int_post['date']     = my_date();
	$int_post['stamp']    = my_date(10);
	$int_post['c_to']     = $cfg['Complaints'];
	$int_post['topic']    = $_SESSION['topic'];
	$int_post['emoticon'] = $_SESSION['emoticon'];
	$int_post['body']     = $_SESSION['body'];
	
	// determine weather $int_post is a posting or
	// a comment and has references
	if ($reference != NULL && is_array($reference))
	{
	    if (!isset($reference['refs']))
		$int_post['refs'] = $reference['msgid'];
	    else
		$int_post['refs'] = $reference['refs']." ".$reference['msgid'];
	}
	
	return $int_post;
    }

    /**
     * @access	public
     * @param	array	$int_post
     * @return	string
     */
    function create_supersede($int_post)
    {
	$msgid = $int_post['msgid'];
	$int_post['msgid'] = $this->_create_msgid();
    
	$ext_post  = $this->int2ext($int_post);
	$ext_post = "Supersedes: $msgid\n" . $ext_post;
    
	return $ext_post;
    }
    
    /**
     * @access	public
     * @param	array	$int_post
     * @return	string
     */
    function create_cancel($int_post)
    {
	$msgid = $int_post['msgid'];
	$body  = "cancel by original author\n";
	
	$int_post['subject'] = "cancel of " . $int_post['msgid']; 
	// this is necessary for counting lines
	$int_post['body']    = $body;
	$int_post['msgid']   = $this->_suggest_msgid();

	unset($int_post['refs']);
    
	$ext_post  = $this->int2ext($int_post);
	$ext_post  = "Control: cancel $msgid\n" . $ext_post;
	
	// remove all X-NP-* header; the position of
	// these should be fixed 
	$ext_post  = explode("\n", $ext_post);
	$ext_post  = implode("\n", array_slice($ext_post, 0, 10));	
	$ext_post .= "\n\n" . $body;
	
	return $ext_post;
    }

    /**
     * @access	public
     * @param	string	$ext_post
     * @return	array
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
	$int_array['body'] = implode("\n", array_slice($lines, $body_line + 1));
	
	return $int_array;
    }

    /**
     * @access	public
     * @param	array	$int_post
     * @return	string
     */
    function int2ext($int_post)
    {
	// remove all ASCII control characters from
	// these headers
	$name    = remove_cchars($int_post['name']);
	$mail    = remove_cchars($int_post['mail']);
	$subject = remove_cchars($int_post['subject']);
    
	// now we fill up $ext
        $ext  = "From: \"$name\" <$mail>\n";
	$ext .= "Newsgroups: {$int_post['ngs']}\n";
	$ext .= "Subject: $subject\n";
	$ext .= "Message-ID: {$int_post['msgid']}\n";
	
	if(!empty($int_post['refs']))
	{
	    $refs = explode(" ",$int_post['refs']);
	    $ext .= "References: $refs[0]\n";
	    
	    $n = count($refs);
	    for($i=1; $i < $n; $i++)
		$ext .= " $refs[$i]\n";
	}
	
	$ext .= 'Date: ' .stamp2string($int_post['stamp'], 8)."\n"; 
	
	$lines = substr_count($int_post['body'], "\n") + 1;
	$ext  .= "Lines: $lines\n";
	
	$ext .= sprintf('User-Agent: Newsposter/%s ("%s")%s', VERSION, CODENAME, "\n");
	$ext .= "Content-Type: text/plain; charset=utf-8\n";
	$ext .= "Content-Transfer-Encoding: 8bit\n";
	$ext .= "X-Complaints-To: {$int_post['c_to']}\n";
	$ext .= "X-NP-Name: $name\n";
	$ext .= "X-NP-Mail: $mail\n";
	$ext .= "X-NP-User: {$int_post['user']}\n";
	$ext .= "X-NP-Stamp: {$int_post['stamp']}\n";
	$ext .= "X-NP-Topic: {$int_post['topic']}\n";
	$ext .= "X-NP-Emoticon: {$int_post['emoticon']}\n";
	$ext .= "\n";

	// get internal encoding and encode $body to utf-8
	$int_enc = iconv_get_encoding('internal_encoding');	
	$body    = iconv($int_enc, 'UTF-8', $int_post['body']);
	$ext    .= $body;
	
	return $ext;
    }

    /**
     * @access	public
     * @param	mixed	$message
     * @return	string
     */
    function get_msgid($message)
    {
	if (is_array($message) && isset($message['msgid']))
	    return $message['msgid'];
	
	else if(is_string($message))
	{
	    $message = $this->ext2int($message);
	    return $message['msgid'];
	}
    }
    
    /**
     * @access	private
     * @return	string
     */
    function _create_msgid()
    {
        $store_inst = &new NP_Storing;
     
        do
	{
	    $msgid    = $this->_suggest_msgid();
	    $is_valid = $store_inst->validate_msgid($msgid);
	} while ($is_valid == FALSE);
	
	return $msgid;
    }
     
    /**
     * @access	private
     * @return	string
     */
    function _suggest_msgid()
    {
	if (empty($cfg['FQDN']))
	    $dn = 'newsposter.org';
	else
	    $dn = $cfg['FQDN']; 
	
	$uniqid = substr(md5(uniqid(rand(), TRUE)), 0, 12);

	// date component
	$dc = my_date(11);

	$msgid = sprintf('%s.%s@%s', $uniqid, $dc, $dn);
	$msgid = str_replace(array('<', '>'), '', $msgid);
	
	return sprintf('<%s>', $msgid);
    }
    
}

?>