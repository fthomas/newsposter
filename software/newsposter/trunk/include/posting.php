<?php
/* $Id$
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
 * @package Newsposter
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
