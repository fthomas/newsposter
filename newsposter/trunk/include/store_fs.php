<?php
/* $Id$ */
//
// Authors: Frank Thomas <frank@thomas-alfeld.de>

/**
 * The NP_Storing class handles all save/load/delete actions for
 * Newsposter's postings. This store_fs.php file uses a mbox like
 * spool and it directly operates with the filesystem.
 */

// include all required files
require_once('misc.php');
require_once('posting.php');
require_once('date.php');

class NP_Storing {

    var $mbox_file  = '';
    var $mbox_bak   = '';
    var $oview_file = '';
    var $oview_bak  = '';
    var $post_inst  = 0;

    function NP_Storing()
    {
	$this->__construct();
    }

    function __construct()
    {
	global $np_dir;
    
	$this->mbox_file  = $np_dir . '/spool/mbox';
	$this->mbox_bak   = $np_dir . '/spool/mbox.bak';
	
	$this->oview_file = $np_dir . '/spool/.overview_fs';
	$this->oview_bak  = $np_dir . '/spool/.overview_fs.bak';
    
	if (! file_exists($this->mbox_file))
	    touch($this->mbox_file);
	if (! file_exists($this->mbox_bak))
	    touch($this->mbox_bak);
	
	if (! file_exists($this->oview_file))
	    touch($this->oview_file);
	if (! file_exists($this->oview_bak))
	    touch($this->oview_bak);
	
	// create a global instance of NP_Posting for this class
	$this->post_inst = &new NP_Posting;
    }

    function store_posting($posting){}

    function remove_posting($msgid){}
    
    function replace_posting($posting, $rep_msgid){}

    function get_all_postings(){}

    function get_posting($msgid){}

    function get_thread($msgid){}

    function validate_msgid($msgid)
    {
	return TRUE;
    }

    function get_latest_date(){}

    /**
     * @access	private
     * @return	array	Array of file pointers.
     */
    function _open_files()
    {
	$fp['mbox']  = fopen($this->mbox_file,  'r+');
	$fp['oview'] = fopen($this->oview_file, 'r+');
	
	if ((!$fp['mbox']) || (!$fp['oview']))
	    return FALSE;
	
	flock($fp['mbox'],  LOCK_EX);
	flock($fp['oview'], LOCK_EX);

	// make new backups if the old ones are older than one day
	if ((time() - filectime($this->mbox_bak)) > 3600 * 24)
	{
	    $mbox_cont  = fread($fp['mbox'],  filesize($this->mbox_file));
	    $oview_cont = fread($fp['oview'], filesize($this->oview_file));
	
	    $fp['mbox_bak']  = fopen($this->mbox_bak,  'w+');
	    $fp['oview_bak'] = fopen($this->oview_bak, 'w+');
	    
	    fwrite($fp['mbox_bak'],  $mbox_cont);  fclose($fp['mbox_bak']);
	    fwrite($fp['oview_bak'], $oview_cont); fclose($fp['oview_bak']);
	}
	
	// the backups file pointer are useless, cause we have closed
	// them before
	return $fp;
    }
    
    /**
     * @access	private
     * @param	array	$fp
     * @return	bool
     */
    function _close_files($fp)
    {
	flock($fp['mbox'],  LOCK_UN);
	flock($fp['oview'], LOCK_UN);

	$ret_mbox  = fclose($fp['mbox']);
	$ret_oview = fclose($fp['oview']);
	
	return ($ret_mbox && $ret_oview);
    }
    
    /**
     * @access	private
     * @param	array	$int_post
     * @return	string	Postmark line for the mbox format.
     */
    function _create_postmark($int_post)
    {
	$postmark = sprintf("From %s %s\n", $int_post['mail'],
	    stamp2string($int_post['stamp'], 8));
    
	return $postmark;
    }
    
}

?>