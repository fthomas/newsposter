<?php
/* $Id$ */
//
// Authors: Frank Thomas <frank@thomas-alfeld.de>

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