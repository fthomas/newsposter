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

    var $user = '';
    var $name = '';
    var $email = '';
    var $url = '';
    var $title = '';
    var $msgid = '';
    var $refs = array();
    var $created = 0;
    var $modified = 0;
    var $topic = '';
    var $content = '';
    var $category = array();
    var $database = '';
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
    
    function _create_msgid()
    {
        $storing_inst = &new NP_Storing;
     
        do { 
            $msgid = $this->_suggest_msgid();
            $msgid_exists = $storing_inst->msgid_exists($msgid);
        } 
        while ($msgid_exists);
    
        return $msgid;
    }
     
    function _suggest_msgid()
    {
        $uniqid = substr(md5(uniqid(rand(), TRUE)), 0, 4);        
        $msgid = sprintf('ID.%s.%s.%s', $uniqid, my_date(11), $_SERVER['HTTP_HOST']);
        
        return $msgid;
    }
}

?>
