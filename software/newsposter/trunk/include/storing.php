<?php
/* $Id$
 *
 * This file is part of 'Newsposter - A versatile weblog'
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

require_once('misc.php');

/**
 *
 * @package Newsposter
 */
class NP_Storing {

    /**
     *
     */
    function set_database($filename = ''){}
 
    /**
     *
     */
    function get_all_postings($category = '', $date = 0){}
  
    /**
     *
     */
    function get_all_articles($category = '', $date = 0){}

    /**
     *
     */
    function get_all_comments($category = '', $date = 0){}

    /**
     *
     */
    function get_all_postings_from($username, $category = '', $date = 0){}
    
    /**
     *
     */
    function get_posting($msgid){}
 
    /**
     *
     */
    function get_thread($msgid, $with_ancestors = TRUE){}
 
    /**
     *
     */
    function store_posting($posting){}
  
    /**
     *
     */
    function replace_posting($posting, $msgid){}
    
    /**
     *
     */
    function remove_posting($msgid, $remove_descendants = TRUE){}

    /**
     *
     */
    function msgid_exists($msgid){}   
}

/**
 *
 * @package Newsposter
 */
class NP_StoringXML extends NP_Storing {

}

?>