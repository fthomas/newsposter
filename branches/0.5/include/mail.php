<?php
/* $Id: mail.php 211 2004-09-12 20:09:48Z mrfrost $ */
//
// Authors: Frank Thomas <frank@thomas-alfeld.de>

// include all required files
require_once('constants.php');
require_once('misc.php');
require_once('posting.php');
require_once($np_dir . '/config.php');

/**
 * This class sends mail after a posting was written or
 * if somebody tried to access a restricted area. The newsletter
 * function has a less administrative purpose. These should
 * just be infos of new postings.
 * @brief	Mail and Newsletter handling class
 */
class NP_Mail {

    var $post_inst = 0;

    function NP_Mail()
    {
	$this->__construct();
    }
    
    function __construct()
    {
	// create global instance of NP_Posting
	$this->post_inst = &new NP_Posting;
    }

    /**
     * @access	public
     * @return	bool
     */
    function send_mail_error()
    {
	global $cfg, $lang;
	
	$addr      = $this->_get_host_addr();
	$sess_vars = '';
	
	// use output buffering to catch print_r output
	ob_start();
	
	if (isset($_SESSION['NP']))
	    print_r($_SESSION['NP']);
	
	$sess_vars = ob_get_contents();
	ob_end_clean();
    
	// compose body of error mail
	$body = $lang['mail_intro_error'] . ":\n"
	      . "\t{$lang['mail_ip']}: {$addr['ip']}\n"
	      . "\t{$lang['mail_hostname']}: {$addr['hostname']}\n\n"
	      . $sess_vars;

	return $this->_my_mail($cfg['EmailTo'],
				$lang['mail_subj_error'], $body);
    }
    
    /**
     * @access	public
     * @param	array	$posting
     * @return	bool
     */
    function send_mail_success($posting)
    {
	global $cfg, $lang;
	
	$addr = $this->_get_host_addr();
	// get type of posting
	$type = $this->post_inst->get_type($posting);
	
	// compose mail body
	$body = sprintf("{$lang['mail_intro_success']}:\n", $type)
	      . "\t{$lang['mail_ip']}: {$addr['ip']}\n"
	      . "\t{$lang['mail_hostname']}: {$addr['hostname']}\n\n"
	      . "\t{$lang['misc_name']}: {$posting['name']}\n"
	      . "\t{$lang['misc_mail']}: {$posting['mail']}\n"
	      . "\t{$lang['misc_subject']}: {$posting['subject']}\n\n"
	      . $posting['body'];
	
	return $this->_my_mail($cfg['EmailTo'],
				$lang['mail_subj_new'], $body);
    }
    
    /**
     * @access	public
     * @param	array	$posting
     * @return	bool
     */
    function send_newsletter($posting)
    {
	global $cfg, $lang;

	// get type of posting
	$type = $this->post_inst->get_type($posting);
	$link = $this->post_inst->get_posting_url($posting, VIEW);
	
	// compose mail body
	$body = sprintf("{$lang['mail_intro_success']}:\n", $type)
	      . "\t{$lang['misc_name']}: {$posting['name']}\n"
	      . "\t{$lang['misc_subject']}: {$posting['subject']}\n\n"
	      . "\t$link";
	
	return $this->_my_mail($cfg['NewsletterTo'],
				$lang['mail_subj_new'], $body, TRUE);
    }

    /**
     * @access	private
     * @param	string	$to	Comma seperated list of all recipients.
     * @param	string	$subject
     * @param	string	$body
     * @param	bool	$bcc	If it's true, we use BCC instead of To.
     *				To is $cfg['EmailFrom']. 
     * @return	bool
     */
    function _my_mail($to, $subject, $body, $bcc = FALSE)
    {
	global $cfg;
	
	if (empty($to))
	    return TRUE;
	
	$bcc_header = '';
	if ($bcc == TRUE)
	{
	    $bcc_header = "Bcc: $to\n";
	    $to         = $cfg['EmailFrom'];
	}
	
	$headers = "From: " . $cfg['EmailFrom'] . "\n"
		 . "Content-Type: text/plain; charset=utf-8\n"
		 . "Content-Transfer-Encoding: 8bit\n"
		 . USER_AGENT . "\n"
		 . $bcc_header;
    
	return mail($to, $subject, $body, $headers);
    }
     
    /**
     * @access	private
     * @return	array
     */
    function _get_host_addr()
    {
	global $_SERVER, $lang;
	
	// get ip address and hostname
	if (isset($_SERVER['REMOTE_ADDR']))
	{
	    $addr['ip']       = $_SERVER['REMOTE_ADDR'];
	    $addr['hostname'] = gethostbyaddr($addr['ip']);
	} else {
	    $addr['ip']       = $lang['misc_unknown'];
	    $addr['hostname'] = $lang['misc_unknown'];
	}
	
	return $addr;
    }
    
}

?>