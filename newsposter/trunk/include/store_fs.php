<?php
/* $Id$ */
//
// Authors: Frank Thomas <frank@thomas-alfeld.de>

class NP_Storing {

    function NP_Storing()
    {
	$this->__construct();
    }

    function __construct(){}

    function store_posting($posting){}

    function remove_posting($msgid){}

    function get_all_postings(){}

    function get_posting($msgid){}

    function get_thread($msgid){}

    function validate_msgid($msgid)
    {
	return TRUE;
    }

    function get_latest_date(){}
}

?>