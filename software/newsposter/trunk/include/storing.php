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

/**
 *
 * @package Newsposter
 */
class NP_Storing {

    function set_database($name = 'default'){}
 
    function get_all_postings($category = '', $date = 0){}
  
    function get_all_articles($category = '', $date = 0){}

    function get_all_comments($category = '', $date = 0){}

    function get_all_postings_from($username, $category = '', $date = 0){}

    function get_posting($msgid){}

    function get_thread($msgid, $with_ancestors = TRUE){}

    function store_posting($posting){}

    function replace_posting($posting, $msgid){}

    function remove_posting($msgid, $remove_descendants = TRUE){}

    function msgid_exists($msgid){}   
}

/**
 *
 * @package Newsposter
 */
class NP_Storing_String extends NP_Storing {

    var $db = array();
    var $db_filename = '';
    
    function NP_Storing_String()
    {
        // set 'default' database
        $this->set_database();
    }
    
    function set_database($name = 'default')
    {
        global $cfg, $np_dir;
        
        $this->db_filename = "{$np_dir}/var/{$name}.db.txt";
        
        if (file_exists($this->db_filename))
            return TRUE;
        else
        {
            $this->db_filename = "{$np_dir}/var/default.db.txt";
            touch($this->db_filename);
        }
        
        return FALSE;
    }
    
    function get_posting($msgid)
    {
        $fp = $this->_open_db();
        
        if (!$fp)
            return FALSE;
            
        $this->_close_db($fp);
        
        if (array_key_exists($msgid, $this->db))
            return $this->db[$msgid];
    
        return FALSE;
    }
    
    function get_thread($msgid, $with_ancestors = TRUE)
    {
        $fp = $this->_open_db();
    
        $postings = array();
        
        $node = $this->db[$msgid];
        $postings[$msgid] = $node;
        
        foreach ($this->db as $key_msgid => $posting)
        {
            // $posting is child of $node
            if (in_array($msgid, $posting->refs))
                $postings[$key_msgid] = $posting;
            
            // $posting is parent of $node
            if ($with_ancestors && in_array($key_msgid, $node->refs))
                $postings[$key_msgid] = $posting;
        }
        
        $this->_close_db($fp);
        
        return $postings;
    }
    
    function store_posting($posting)
    {
        $fp = $this->_open_db();
        
        if (!$fp)
            return FALSE;
            
        $this->db[$posting->msgid] = $posting;

        return $this->_dump_db($fp);
    }
    
    function replace_posting($posting, $msgid)
    {
        $fp = $this->_open_db();
        
        if (!$fp)
            return FALSE;
            
        if (!array_key_exists($msgid, $this->db))
            return FALSE;
            
        $posting->msgid = $msgid;
        $this->db[$msgid] = $posting;
        
        return $this->_dump_db($fp);
    }
    
    function msgid_exists($msgid)
    {
        $fp = $this->_open_db();
        
        if (!$fp)
            return FALSE;
            
        $this->_close_db($fp);
        
        if (array_key_exists($msgid, $this->db))
            return TRUE;
            
        return FALSE;
    }
    
    function _open_db()
    {
        clearstatcache();
    
        $fp = fopen($this->db_filename, 'r+');

        if (!$fp)
            return FALSE;
        
        flock($fp, LOCK_EX);

        $db_file_age = time() - filectime($this->db_filename);
        if ($db_file_age > 3600 * 24)
            $this->_backup_db();
        
        $db_filesize = filesize($this->db_filename);
        if ($db_filesize > 0)
        {
            $db_string = fread($fp, $db_filesize);
            $this->db = unserialize($db_string);
            
            if ($this->db == FALSE)
                return FALSE;
        }
        
        return $fp;
    }
    
    function _dump_db($fp)
    {
        $db_string = serialize($this->db);
        
        rewind($fp);
        ftruncate($fp, 0);
        fwrite($fp, $db_string);

        return $this->_close_db($fp);
    }
    
    function _close_db($fp)
    {
        flock($fp, LOCK_UN);
        return fclose($fp);
    }
    
    function _backup_db()
    {
        if (filesize($this->db_filename) == 0)
            return FALSE;
            
        return copy($this->db_filename, $this->db_filename.'.bak');
    }
}

?>
