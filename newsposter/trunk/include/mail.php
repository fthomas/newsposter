<?php
/* $Id:$ */
//
// Authors: Frank Thomas <frank@thomas-alfeld.de>

// include all required files
require_once('misc.php');
require_once($np_dir . '/config.php');

/**
 * This class sends mail after a posting was written or
 * if somebody tried to access a restricted area. The newsletter
 * function has a less administrative purpose. These should
 * just be infos of new postings.
 * @brief	Mail and Newsletter handling class
 */
class NP_Mail {

    /**
     * @access	public
     */
    function send_mail_error()
    {
	global $cfg, $lang;
	
	$addr      = $this->_get_host_addr();
	$sess_vars = var_export($_SESSION['NP'], TRUE);
    
	$body =
    }
    
    /**
     * @access	public
     * @param	array	$posting
     */
    function send_mail_success($posting)
    {
	global $cfg, $lang;
	
	$addr = $this->_get_host_addr();
	$type = (isset($posting['refs'])) ? ($lang['']) : ($lang['']);
	
	$body = ""
	      . "\t{$lang['']}: {$posting['name']}\n"
	      . "\t{$lang['']}: {$posting['mail']}\n"
	      . "\t{$lang['']}: {$posting['subject']}\n\n"
	      . $posting['body'];
    }
    
    /**
     * @access	public
     * @param	array	$posting
     */
    function send_newsletter($posting)
    {
	global $cfg;
    }

    /**
     * @access	private
     * @return	array
     */
    function _get_host_addr()
    {
	global $_SERVER;
	
	// get ip address and hostname
	$addr['ip']       = $_SERVER['REMOTE_ADDR'];
	$addr['hostname'] = gethostbyaddr($addr['ip']);
    
	return $addr;
    }
    
}

?>