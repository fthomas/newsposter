<?php
/* $Id$ */
//
// Authors: Frank Thomas <frank@thomas-alfeld.de>

require_once('misc.php');

require_once('date.php');
require_once('posting.php');

/**
 * The NP_Storing class handles all save/load/delete actions for
 * Newsposter's postings. This store_fs.php file uses a mbox like
 * spool and it directly operates with the filesystem.
 * @package    Newsposter
 * @brief	Database backend (using native FS)
 */
class NP_Storing {

    var $mbox_file  = '';
    var $mbox_bak   = '';
    var $mbox_cont  = '';
    var $oview_file = '';
    var $oview_bak  = '';
    var $post_inst  = 0;

    function NP_Storing()
    {
	$this->__construct();
    }

    function __construct()
    {
	global $np_dir, $cfg;

	// create global instance of NP_Posting for this class
	$this->post_inst  = &new NP_Posting;
	
	// use a remote dir? so we don't need to touch our files
	if (!empty($cfg['RemoteSpoolDir']))
	{
	    $this->mbox_file  = $cfg['RemoteSpoolDir'] . 'mbox';
	    $this->oview_file = $cfg['RemoteSpoolDir'] . 'overview_fs';
	    
	    return TRUE;
	}
	    
	$this->mbox_file  = $np_dir . '/spool/mbox';
	$this->mbox_bak   = $np_dir . '/spool/mbox.bak';
	
	$this->oview_file = $np_dir . '/spool/overview_fs';
	$this->oview_bak  = $np_dir . '/spool/overview_fs.bak';
    
	if (! file_exists($this->mbox_file))
	    touch($this->mbox_file);
	if (! file_exists($this->mbox_bak))
	    touch($this->mbox_bak);
	
	if (! file_exists($this->oview_file))
	    touch($this->oview_file);
	if (! file_exists($this->oview_bak))
	    touch($this->oview_bak);

	// compose a new overview file
	if ((filesize($this->oview_file) == 0)
	    && (filesize($this->mbox_file) > 0))
	{
	    $fp = $this->_open_files();
	    $this->_create_oview_file($fp);
	    $this->_close_files($fp);
	}
    }

    /**
     * @access	public
     * @param	array	$posting
     * @return	bool
     */
    function store_posting($posting)
    {
	// open files for writing
	if (($fp = $this->_open_files()) == FALSE)
	    return FALSE;
	
	// set file pointer to end of the file
	fseek($fp['mbox'],  0, SEEK_END);
	fseek($fp['oview'], 0, SEEK_END);
	
	$fp_pos['start'] = ftell($fp['mbox']);
	
	fwrite($fp['mbox'], $this->_create_postmark($posting));
	fwrite($fp['mbox'], $this->post_inst->int2ext($posting));
	
	$fp_pos['stop']  = ftell($fp['mbox']);
	fwrite($fp['mbox'], "\n\n");
	
	fwrite($fp['oview'], $this->_create_oview_line($posting, $fp_pos));
    
	return $this->_close_files($fp);
    }

    /**
     * @access	public
     * @param	mixed	$msgid		Can be a string or an array.
     * @param	bool	$rm_childs	Also remove all posting, which have
     *					$msgid as reference, or not. 
     * @return	bool
     */
    function remove_posting($msgid, $rm_childs = TRUE)
    {
	$oview = $this->_parse_oview_file();
	$posts = array();
    
    	if (($fp = $this->_open_files()) == FALSE)
	    return FALSE;
	
	if (is_string($msgid))
	{
	    $is_string = TRUE;
	    $is_array  = FALSE;
	}
	
	else if (is_array($msgid))
	{
	    $is_array  = TRUE;
	    $is_string = FALSE;
	}
	
	// if msgid is not in msgid or refs,
	// we will save the posting
	foreach($oview as $entry)
	{
	    // maybe this can cause errors...
	    if (!isset($entry['refs']))
		$entry['refs'] = array();
	
	    if ($is_string)
	    {
		if ($rm_childs == TRUE)
		    $cond = ( ($msgid != $entry['msgid']) &&
			    (!in_array($msgid, $entry['refs'])) );
		else if ($rm_childs == FALSE)
		    $cond = ($msgid != $entry['msgid']);
	    }
	    
	    else if ($is_array)
	    {
		if ($rm_childs == TRUE)
		{
		    $cond = (!in_array($entry['msgid'], $msgid));    
		    foreach($msgid as $one_msgid)
		    {
			// if an element of $msgid is in $entry['refs'],
			// we want to delete this posting	
			if (in_array($one_msgid, $entry['refs']))
			{
			    $cond = FALSE;
			    break;
			}
		    }
		}
		    
		else if ($rm_childs == FALSE)
		    $cond = (!in_array($entry['msgid'], $msgid));
	    }
	    	
	    if ($cond)
		$posts[] = $entry;
	}
	
	$new_mbox = '';
	foreach($posts as $posting)
	{
	    $ext_post = $this->_get_file_selection($fp['mbox'],
		$posting['start'], $posting['stop']);
	    
	    if (!empty($ext_post))
		$new_mbox .= $ext_post . "\n\n";
	}
	
	// we used _get_file_selection, so we have to rewind 
	// the file pointer. otherwise ftruncate fills up mbox with
	// NULLs
	rewind($fp['mbox']);
	ftruncate($fp['mbox'], 0);
	fwrite($fp['mbox'], $new_mbox);

	$this->_create_oview_file($fp);
	return $this->_close_files($fp);
    }
    
    /**
     * @access	public
     * @param	array	$posting
     * @param	string	$rep_msgid	msgid of the replaced posting
     * @return	bool
     */
    function replace_posting($posting, $rep_msgid)
    {
	$old_messages = $this->get_thread($rep_msgid, FALSE);
	$new_messages = array($posting);
	
	foreach($old_messages as $entry)
	{
	    // replace the old msgid
	    $entry['refs']  = str_replace($rep_msgid, $posting['msgid'],
				    $entry['refs']);
	    $new_messages[] = $entry;
	}

	// delete the replaced posting and $old_messages
	$this->remove_posting($rep_msgid, TRUE);
    
	// add now $new_messages
	foreach($new_messages as $entry)
	{
	    $this->store_posting($entry);
	}
    }

    /**
     * @access	public
     * @param	mixed	$offset
     * @param	mixed	$length
     * @return	array	Array of all postings, internal formatted.
     */
    function get_all_postings($offset = NULL, $length = NULL)
    {
	$oview = $this->_parse_oview_file();
	$posts = array();
	
	if (($fp = $this->_open_for_reading()) == FALSE)
	    return $posts;
	
	foreach($oview as $entry)
	{
	    $ext_post = $this->_get_file_selection($fp,
		    $entry['start'], $entry['stop']);
	    $posts[] = $this->post_inst->ext2int($ext_post);
	}
	
	fclose($fp);
	return $this->_my_array_slice($posts, $offset, $length);
    }

    /**
     * @access	public
     * @param	mixed	$offset
     * @param	mixed	$length
     * @return	array	Returns array (or a slice) of all postings,
     *			which have no references.
     */
    function get_all_news($offset = NULL, $length = NULL)
    {
	$oview = $this->_parse_oview_file();
	$posts = array();
	
	if (($fp = $this->_open_for_reading()) == FALSE)
	    return $posts;
	    
	foreach($oview as $entry)
	{
	    if(empty($entry['refs']))
	    {
		$ext_post = $this->_get_file_selection($fp,
			$entry['start'], $entry['stop']);
		$posts[] = $this->post_inst->ext2int($ext_post);
	    }
	}
	
	fclose($fp);
	return $this->_my_array_slice($posts, $offset, $length);		
    }

    /**
     * @access	public
     * @param	mixed	$offset
     * @param	mixed	$length
     * @return	array	Returns array (or a slice) of all postings,
     *			which have no references.
     */
    function get_all_comments($offset = NULL, $length = NULL)
    {
	$oview = $this->_parse_oview_file();
	$posts = array();
	
	if (($fp = $this->_open_for_reading()) == FALSE)
	    return $posts;

	foreach($oview as $entry)
	{
	    if(!empty($entry['refs']))
	    {
		$ext_post = $this->_get_file_selection($fp,
			$entry['start'], $entry['stop']);
		$posts[] = $this->post_inst->ext2int($ext_post);
	    }
	}
	
	fclose($fp);
	return $this->_my_array_slice($posts, $offset, $length);		
    }
    
    /**
     * @access	public
     * @return	array	Returns array of all posting whose first reference
     *			does not exist. They lost their parents.
     */
    function get_orphan_postings()
    {
	$oview = $this->_parse_oview_file();
	$posts = array();
	
	if (($fp = $this->_open_for_reading()) == FALSE)
	    return $posts;
		    
	foreach($oview as $entry_1st)
	{
	    foreach($oview as $entry_2nd)
	    {
		// if there are no references, it's a news posting
		if (!isset($entry_1st['refs'][0]))
		{
		    $is_orphan = FALSE;
		    break;
		}
		
		// we've got references, but also it's parent	
		else if ($entry_1st['refs'][0] == $entry_2nd['msgid'])
		{
		    $is_orphan = FALSE;
		    break;
		}
		
		else
		    $is_orphan = TRUE;
	    }
	    
	    if ($is_orphan)
	    {
		$ext_post = $this->_get_file_selection($fp,
			$entry_1st['start'], $entry_1st['stop']);
		$posts[] = $this->post_inst->ext2int($ext_post);
	    }
	}
	
	fclose($fp);
	return $posts;
    }

    /**
     * @access	public
     * @param	string	$msgid
     * @return	mixed	Returns an internal formatted posting or bool
     *			if posting was not found.
     */
    function get_posting($msgid)
    {
	$oview = $this->_parse_oview_file();
	
	if (($fp = $this->_open_for_reading()) == FALSE)
	    return FALSE;
		    
	foreach($oview as $entry)
	{
	    if ($msgid == $entry['msgid'])
	    {
		$ext_post = $this->_get_file_selection($fp,
			$entry['start'], $entry['stop']);
		
		fclose($fp);	
		return $this->post_inst->ext2int($ext_post);
	    }
	}
	
	fclose($fp);
	return FALSE;
    }
    
    /**
     * @access	public
     * @param	string	$username
     * @param	mixed	$offset
     * @param	mixed	$length
     * @return	array
     */
    function get_postings_from($username, $offset = NULL, $length = NULL)
    {
	$posts     = $this->get_all_postings($offset, $length);
	$new_posts = array();
	
	foreach($posts as $posting)
	{
	    if ($username === $posting['user'])
		$new_posts[] = $posting;
	}
	
	return $new_posts;
    }
    
    /**
     * @access	public
     * @param	string	$msgid
     * @param	bool	$with_parent
     * @return	array	Returns array of internal formatted postings.
     */
    function get_thread($msgid, $with_parent = TRUE)
    {
	$oview = $this->_parse_oview_file();
	$posts = array();
    
	if (($fp = $this->_open_for_reading()) == FALSE)
	    return $posts;
	    
	foreach($oview as $entry)
	{
	    $is_parent = ($msgid == $entry['msgid']);
	    if ($is_parent)
		$parent_key = count($posts);
	    
	    if ($is_parent ||
		(isset($entry['refs']) && in_array($msgid, $entry['refs']) ))
	    {
		$ext_post = $this->_get_file_selection($fp, $entry['start'], $entry['stop']);
		$posts[] = $this->post_inst->ext2int($ext_post);
	    }
	}
	
	if ($with_parent == FALSE && isset($parent_key))
	    unset($posts[$parent_key]);
	
	fclose($fp);
	$posts = array_reverse($posts);
	return $posts;
    }
    
    /**
     * @access	public
     * @param	string	$msgid
     * @return	bool	Returns false if $msgid already exists,
     *			true otherwise.
     */
    function validate_msgid($msgid)
    {
	$oview = $this->_parse_oview_file();
	foreach($oview as $entry)
	{
	    if (strcmp($entry['msgid'], $msgid) == 0)
		return FALSE;
	}
	
	return TRUE;
    }

    /**
     * @access	public
     * @return	int	Unix time stamp of the latest posting
     *			(could also be a comment).
     */
    function get_latest_date()
    {
	$oview = $this->_parse_oview_file();
	
	reset($oview);
	$key = key($oview);
	
	return $oview[$key]['stamp'];
    }

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
     * @param	int	$fp
     * @param	int	$start
     * @param	int	$end
     * @return	string
     */
    function _get_file_selection($fp, $start, $end)
    {	
	global $cfg;
	
	if (!empty($cfg['RemoteSpoolDir']))
	{
	    $selection = substr($this->mbox_cont, $start, ($end - $start));    
	    return $selection;
	}
    
	rewind($fp);
	fseek($fp, $start, SEEK_SET);
	$selection = fread($fp, ($end - $start));
    
	return $selection;
    }
    
    /**
     * @access	private
     * @param	array	$int_post
     * @return	string	Postmark line for the mbox format.
     */
    function _create_postmark($int_post)
    {
	$postmark = sprintf("From %s %s\n",
	    str_replace(' ', '', $int_post['mail']),
	    stamp2string($int_post['stamp'], 12));
    
	return $postmark;
    }
    
    /**
     * @access	private
     * @param	array	$fp	Array of file pointers.
     */
    function _create_oview_file($fp)
    {
	rewind($fp['mbox']);	
    
	// initialize some variables
	$oview_con     = '';
	$fp_pos['cur'] = 0;
	$filesize      = filesize($this->mbox_file);
	
	while ($filesize > $fp_pos['cur'])
	{
	    $fp_pos['start'] = ftell($fp['mbox']);
	    $header = '';
	    $buffer = '';
	    
	    do {
		$header .= $buffer;
		// if name or subject are longer than 4096
		// bytes, we have got a problem
		$buffer  = fgets($fp['mbox'], 4096);
		
		// get lines number
		if (substr($buffer, 0, 6) == 'Lines:')
		    $lines = (int) substr(trim($buffer), 7);
	    
	    // if buffer is a newline we reached the end of
	    // the header
	    } while($buffer != "\n");
	    
	    // now we set the file pointer to the first newline
	    // included by this class (after storing the posting) 
	    for($i = 0; $i < $lines; ){
		$char = fgetc($fp['mbox']);
		if ($char == "\n") $i++;
	    }
	
	    // set file pointer to the beginning of the next 
	    // posting or EOF, save some fp positions
	    $fp_pos['stop'] = ftell($fp['mbox']) - 1;
	    fseek($fp['mbox'], 1, SEEK_CUR);
	    $fp_pos['cur']  = ftell($fp['mbox']);

	    $int_post   = $this->post_inst->ext2int($header);
	    $oview_con .= $this->_create_oview_line($int_post, $fp_pos);
	}

	// truncate overview file to zero length and
	// write new content to file
	ftruncate($fp['oview'], 0);	
	fwrite($fp['oview'], $oview_con);
    }
    
    /**
     * @access	private
     * @param	array	$int_post
     * @param	array	$fp_pos
     * @return	string
     */
    function _create_oview_line($int_post, $fp_pos)
    {
	if (!isset($int_post['refs']))
	    $refs = '';
	else
	    $refs = $int_post['refs'];
    
	// lines in the overview file consits of tabs
	// seperated values
	return sprintf("%s\t%s\t%s\t%s\t%s\t%s\t%s\n",
	    $int_post['subject'], $int_post['name'],
	    $int_post['stamp'],   $fp_pos['start'],
	    $fp_pos['stop'],      $int_post['msgid'],
	    $refs);
    }
    
    /**
     * @access	private
     * @return	array
     */
    function _parse_oview_file()
    {
	$oview_con = file($this->oview_file);
	$oview_con = str_replace("\n", '', $oview_con);
	$oview     = array();
	
	foreach($oview_con as $line)
	{
	    $values = explode("\t", $line);
	    $pos = $values[2] ." ". count($oview);
	    
	    list($oview[$pos]['subject'],
		 $oview[$pos]['name'],
		 $oview[$pos]['stamp'],
		 $oview[$pos]['start'],
		 $oview[$pos]['stop'],
		 $oview[$pos]['msgid'],
		 $oview[$pos]['refs']) = $values;

	    // clean up the refs
	    if (empty($oview[$pos]['refs']))
		unset($oview[$pos]['refs']);
	    else
		$oview[$pos]['refs'] = explode(" ", $oview[$pos]['refs']);
	}
	
	krsort($oview, SORT_NUMERIC);
	return $oview;
    }
    
    /**
     * @access	private
     * @param	array	$posts
     * @param	int	$offset
     * @param	int	$length
     * @return	array
     */
    function _my_array_slice($posts, $offset, $length)
    {
	if      ($offset === NULL && $length === NULL)
	    return $posts;      
	    
	else if ($offset !== NULL && $length === NULL)
	    return array_slice($posts, $offset);
	    
	else if ($offset !== NULL && $length !== NULL)
	    return array_slice($posts, $offset, $length);
    }
    
    /**
     * @access	private
     * @return	mixed
     */
    function _open_for_reading()
    {
	global $cfg;
	
	if (($fp = fopen($this->mbox_file, 'r')) == FALSE)
	    return FALSE;
	
	if (!empty($cfg['RemoteSpoolDir']))
	    $this->mbox_cont = fread($fp, 1024 * 1024 * 2);
	
	return $fp;
    }
        
}

?>