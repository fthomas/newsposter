<?php
/* $Id: posting.php 241 2004-09-30 20:27:25Z mrfrost $
 *
 * This file is part of Newsposter
 * Copyright (C) 2001-2004 by Frank S. Thomas <frank@thomas-alfeld.de>
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License 
 * along with this program; if not, write to the
 * Free Software Foundation, Inc.,
 * 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 */

require_once('constants.php');
require_once('misc.php');
require_once($np_dir . '/conf/config.php');
require_once('date.php');
require_once('storing.php');
require_once('url.php');

/**
 *
 */
class NP_Posting {

    var $user      = '';
    var $name      = '';
    var $uri       = '';
    var $title     = '';
    var $msgid     = '';
    var $refs      = array();
    var $created   = 0;
    var $modified  = 0;
    var $topic     = '';
    var $content   = '';
    var $category  = array();
    var $database  = '';
    var $is_hidden = FALSE;
    
    function create_from_array($array, $parent = NULL){}
    
    function import_from_array($array){}
    
    function get_author()
    {
        if (empty($this->name) && empty($this->uri))
            return $lang['show_unknown_author'];
        
        else if (empty($this->uri)) 
            return $this->name;
        
        else if (empty($this->name))
            return NP_URL::create_link($this->uri, $this->uri);
        
        else
            return NP_URL::create_link($this->name, $this->uri);
    }
    
   
    function get_posting_type()
    {
        if ($this->is_article())
            return $lang['misc_article'];
        
        if ($this->is_comment())
            return $lang['misc_comment'];
    }
    
    function is_article()
    {
        return (count($this->refs) == 0);
    }
    
    function is_comment()
    {
        return (count($this->refs) != 0);
    }

    function get_date_created($format)
    {
        return stamp2string($this->created, $format);
    }
    
    function get_date_modified($format)
    {
        return stamp2string($this->modified, $format);
    }    
        
    function is_older_than($seconds)
    {
        $now = time();
        $age = $now - $this->modified;
        
        return ($age > $seconds);
    }
    
    function is_younger_than($seconds)
    {
        $now = time();
        $age = $now - $this->modified;
        
        return ($age < $seconds);
    }
}

/**
 * The NP_Posting class can create postings and comments.
 * It also transforms the internal to the external posting
 * format and the other way round and there are functions
 * to retrive some meta informations of postings.
 *
 * <pre>
 * The internal posting format (associative array):
 *
 *	array (
 *		'user'    => 'mrfrost {login username}',
 *		'name'    => 'Frank Thomas',
 *		'mail'    => 'frank\@thomas-alfeld.de',
 *		'subject' => 'Announcing Newsposter 0.5.0!',
 *		'msgid'   => '<{unique ID}@{FQDN}>',
 *		'refs'    => '<{msgid}> <{msgid}>',
 *		'ngs'     => 'de.alt.test',
 *		'date'    => '17.11.2002 14:34',
 *		'stamp'   => '{unix time stamp}',
 *		'topic'   => 'default',
 *		'emoticon'=> 'happy',
 *		'body'    => 'hello.<br /> this is the content of the posting',
 *              'modified'  => '{unix time stamp}',
 *              'is_hidden' => false
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
 *	X-NP-Name: Frank Thomas
 *	X-NP-Mail: frank@thomas-alfeld.de
 *	X-NP-User: mrfrost {login username}	
 *	X-NP-Stamp: {unix time stamp}
 *	X-NP-Topic: default
 *	X-NP-Emoticon: happy
 *      X-NP-Modified: {unix time stamp}
 *      X-NP-IsHidden: false
 *	
 *	hello.<br /> this is the content of the posting
 * </pre>
 * @brief	Internal/external format handling of postings
 */
class NP_Posting1 {

    /**
     * @access	public
     * @param	array	$reference	An internal formatted  posting. 
     * @return	array	The returned array is an internal formatted posting.
     */
    function create_post($reference = NULL)
    {
	global $cfg, $lang;

        if (!isset($_SESSION))
            session_start();
	
	$new_msgid = (isset($_SESSION['NP']['msgid']))
		? ($_SESSION['NP']['msgid']) : ($this->_create_msgid());
	
	$new_stamp = (isset($_SESSION['NP']['stamp']) && $reference == NULL)
		? ($_SESSION['NP']['stamp']) : (my_date(10));
    
	// for anonymous posting set name/mail/subject to
	// unknown
	$_SESSION['NP']['name']    = trim($_SESSION['NP']['name']);
	$_SESSION['NP']['mail']    = trim($_SESSION['NP']['mail']);
	$_SESSION['NP']['subject'] = trim($_SESSION['NP']['subject']);
	
	if (!empty($_SESSION['NP']['name'])) 
	    $int_post['name'] = $_SESSION['NP']['name'];
	else
	    $int_post['name'] = $lang['misc_unknown'];
	
	if (!empty($_SESSION['NP']['mail']))
	    $int_post['mail'] = $_SESSION['NP']['mail'];
	else
	    $int_post['mail'] = $lang['misc_unknown'];
    
	if (!empty($_SESSION['NP']['subject']))
	    $int_post['subject'] = $_SESSION['NP']['subject'];
	else
	    $int_post['subject'] = $lang['misc_unknown'];

        if (!empty($_SESSION['NP']['refs']))
            $int_post['refs'] = $_SESSION['NP']['refs'];

        $int_post['is_hidden'] = false;
        if (isset($_SESSION['NP']['is_hidden']))
            $int_post['is_hidden'] = $_SESSION['NP']['is_hidden'];            
            
	$int_post['user']     = $_SESSION['NP']['username'];
	$int_post['msgid']    = $new_msgid;
	$int_post['ngs']      = $cfg['Newsgroup'];
	$int_post['date']     = stamp2string($new_stamp, $cfg['DateFormat']);
	$int_post['stamp']    = $new_stamp;
	$int_post['topic']    = $_SESSION['NP']['topic'];
	$int_post['emoticon'] = $_SESSION['NP']['emoticon'];
	$int_post['body']     = $_SESSION['NP']['body'];
        $int_post['modified'] = time();
        
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
		
	    else if ($header_field == 'X-NP-Topic')
		$int_array['topic'] = $header_value;
	
	    else if ($header_field == 'X-NP-Emoticon')
		$int_array['emoticon'] = $header_value;
	    
            else if ($header_field == 'X-NP-Modified')
                $int_array['modified'] = $header_value;
                
            else if ($header_field == 'X-NP-IsHidden')
                $int_array['is_hidden'] = $header_value;
                
	    else if ($header_field == 'References')
	    {
		$int_array['refs'] = $header_value;
		$refs_line = $key;
	    }
	}
	
	// now collect all unfolded references
	while(isset($refs_line) && ($lines[++$refs_line]['0'] == ' '))
	{
	    $msgid = trim($lines[$refs_line]);
	    $int_array['refs'] .= " " . $msgid;
	}
	
        // if this posting has no modified date, set the creation date as
        // modified date
        if (!isset($int_array['modified']))
            $int_array['modified'] = $int_array['stamp'];
            
        if (!isset($int_array['is_hidden']))
            $int_array['is_hidden'] = FALSE;
        
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
	
	$ext .= USER_AGENT . "\n";
	$ext .= "Content-Type: text/plain; charset=utf-8\n";
	$ext .= "Content-Transfer-Encoding: 8bit\n";
	$ext .= "X-NP-Name: $name\n";
	$ext .= "X-NP-Mail: $mail\n";
	$ext .= "X-NP-User: {$int_post['user']}\n";
	$ext .= "X-NP-Stamp: {$int_post['stamp']}\n";
	$ext .= "X-NP-Topic: {$int_post['topic']}\n";
	$ext .= "X-NP-Emoticon: {$int_post['emoticon']}\n";
        $ext .= "X-NP-Modified: {$int_post['modified']}\n";
        $ext .= "X-NP-IsHidden: {$int_post['is_hidden']}\n";
	$ext .= "\n";
	$ext .= $int_post['body'];
	
	return $ext;
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
     * @access  private
     * @return  string
     */
    function _suggest_msgid()
    {
        $uniqid = substr(md5(uniqid(rand(), TRUE)), 0, 4);
        $host   = $_SERVER['HTTP_HOST'];
        $date   = my_date(11);
        $msgid  = sprintf('%s.%s@%s', $uniqid, $date, $host);

        return sprintf('<%s>', $msgid);
    }
    
}

?>
