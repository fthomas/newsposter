<?php
/* $Id$ */
//
// Authors: Frank Thomas <frank@thomas-alfeld.de>

// include all required files
require_once('misc.php');
require_once('constants.php');
require_once('date.php');
require_once($np_dir . '/config.php');
require_once(create_theme_path('topics/_control.php'));

/**
 * This class defines functions which handle the dynamic part
 * of all Newsposter's HTML output.
 * @brief	HTML output handling and creation
 */
class NP_Output {

    /**
     * @access	public
     * @return	array
     */
    function get_values_login()
    {
	global $cfg, $lang;
	
	$retval['user']  = '';
	$retval['block'] = '';
	
	// if auth is disabled, we also disable the text inputs
	// and specify a username
	if ($cfg['UseBuiltInAuth'] === FALSE)
	{
	    $retval['user']  = 'value="' . $lang['login_anonym'] . '"';
	    $retval['block'] = 'disabled="disabled"';
	}

	return $retval;
    }
    
    /**
     * @access	public
     * @return	array
     */
    function get_error_text()
    {
	global $cfg, $lang;
	
	if (isset($_GET['auth']))
	{
	    $url = $cfg['IndexURL'] . '?np_act=login';     
	    
	    $val['text_error'] = $lang['error_auth_text'];
	    $val['text_link']  = $lang['error_auth_link'];
	    $val['link']       = sprintf('<a href="%s">%s</a>', $url, $url);
	}
	else if (isset($_GET['perm']))
	{
	    $sess_id = create_sess_param(); 
	    $url     = $cfg['IndexURL'] .'?np_act=chact';
	    
	    $val['text_error'] = $lang['error_perm_text'];
	    $val['text_link']  = $lang['error_perm_link'];
	    $val['link']       = sprintf('<a href="%s&%s">%s</a>', $url,
					$sess_id, $url);
	}
	
	return $val;
    }
    
    /**
     * @access	public
     * @param	object	$auth_inst
     * @return	array	An array of the radio buttons used by chact glue.
     */
    function get_radio_buttons($auth_inst)
    {
	$lookup = $auth_inst->perm_lookup();
	
	if ($lookup[P_WRITE] == TRUE)
	    $retval['write'] = '<input type="radio" name="action" value="write" />';
	else
	    $retval['write'] = '<input type="radio" name="action" value="write" disabled="disabled" />';
	    
	if ($lookup[P_EDIT] == TRUE || $lookup[P_EDIT_NEWS] == TRUE)
	    $retval['edit'] = '<input type="radio" name="action" value="edit" />';
	else
	    $retval['edit'] = '<input type="radio" name="action" value="edit" disabled="disabled" />';
	    
	if ($lookup[P_DEL] == TRUE || $lookup[P_DEL_NEWS] == TRUE)
	    $retval['delete'] = '<input type="radio" name="action" value="delete" />';
	else
	    $retval['delete'] = '<input type="radio" name="action" value="delete" disabled="disabled" />';
	    
	return $retval;
    }
    
    /**
     * @access	public
     * @return	array
     */
    function get_values_perform()
    {
	global $cfg;
	
	$form['name']  = $form['name_add'] = '';
	$form['mail']  = $form['subject']  = '';
	$form['topic'] = $form['body']     = '';
	
	$form['nl2br_add'] = '';
	$form['emoticon']  = 'none';
	
	if ($cfg['AllowChangeNames'] == FALSE)
	{
	    $form['name']     = eval(" return {$cfg['NameVar']}; ");
	    $form['name_add'] = 'readonly="true"';
	}
	
	if (isset($_SESSION['NP']['name']))
	    $form['name'] = $_SESSION['NP']['name'];
	if (isset($_SESSION['NP']['mail']))
	    $form['mail'] = $_SESSION['NP']['mail'];
	if (isset($_SESSION['NP']['subject']))
	    $form['subject'] = $_SESSION['NP']['subject'];
	if (isset($_SESSION['NP']['emoticon']))
	    $form['emoticon'] = $_SESSION['NP']['emoticon'];
	if (isset($_SESSION['NP']['topic']))
	    $form['topic'] = $_SESSION['NP']['topic'];
	if (isset($_SESSION['NP']['body']))
	    $form['body'] = $_SESSION['NP']['body'];
	if (isset($_SESSION['NP']['nl2br']) && $_SESSION['NP']['nl2br'])
	{
	    $form['nl2br_add'] = 'checked="true"';
	    $form['body']      = str_replace("<br />\n", "\n", $form['body']);
	}
	
	// if double quotes are used in the HTML code
	$form['name']    = str_replace('"', "'", $form['name']);
	$form['mail']    = str_replace('"', "'", $form['mail']);
	$form['subject'] = str_replace('"', "'", $form['subject']);
	
	if ($cfg['StripSlashes'])
	{
	    $form['name']    = stripslashes($form['name']); 
	    $form['mail']    = stripslashes($form['mail']); 
	    $form['subject'] = stripslashes($form['subject']);
	    $form['body']    = stripslashes($form['body']);
	}
	
	return $form;
    }
    
    /**
     * @access	public
     * @return	array
     */
    function get_values_comment()
    {
	global $cfg;
    
	$val['index'] 	= 'index.php?np_act=expanded&amp;msg_id='
	    		. urlencode($_GET['msg_id']);
	
	$val['msgid']	= (isset($_GET['child_of'])) ? ($_GET['child_of']) :
			($_GET['msg_id']);
	
	$ref = $_SESSION['NP']['store_inst']->get_posting($val['msgid']); 
	$val['subject'] = (substr($ref['subject'], 0, 4) == 'Re: ') ?
			  ($ref['subject']) : ('Re: ' . $ref['subject']);
	
	// remove all double quotes
	$val['subject'] = str_replace('"', "'", stripslashes($val['subject']));
    
	$val['name'] = $val['name_add'] = '';
	if ($cfg['AllowChangeNames'] == FALSE)
	{
	    $val['name']     = eval(" return {$cfg['NameVar']}; ");
	    $val['name_add'] = 'readonly="true"';
	}
	
	$val['emots_opts']   = $this->get_selection_emots();
	
	return $val;
    }
    
    /**
     * @access	public
     * @param	string
     * @return	string
     */
    function get_selection_topic($selected = '')
    {
	global $topics;

	if ($selected === $topics[0]['name'] || empty($selected))
	    $select_opts = "<option value=\"{$topics[0]['name']}\" "
			 . "selected=\"true\">"
			 . "{$topics[0]['name']}</option>\n";
	else
	    $select_opts = "<option value=\"{$topics[0]['name']}\">"
			 . "{$topics[0]['name']}</option>\n";

	foreach($topics as $key => $entry)
	{
	    if ($key == 0 || $entry['name'] === 'comment')
		continue;
	
	    $opt_add = '';
	    if ($entry['name'] === $selected)
		$opt_add = ' selected="selected"';
		
	    $select_opts .= "\t\t<option value=\"{$entry['name']}\"$opt_add>"
	                  . "{$entry['name']}</option>\n";
	}
    
	return $select_opts;
    }
    
    /**
     * @access	public
     * @param	string	$selected	This defines the selected option.
     * @return	string
     */
    function get_selection_emots($selected = 'none')
    {
	global $lang;
	
	if ($selected === 'none')
	    $opts = '<option value="none" selected="selected"></option>'."\n";
	else
	    $opts = '<option value="none"></option>'."\n"; 
	
	$emots = array( 'angry',    'dead',      'discuss',
			'evil',     'happy',     'insane',
			'laughing', 'mean',      'pissed',
			'sad',      'satisfied', 'shocked',
			'sleepy',   'suprised',  'uplooking');
	
	foreach($emots as $entry)
	{
	    $opt_add = '';
	    if ($selected === $entry)
		$opt_add = ' selected="selected"';
	    
	    $index = 'emot_' . $entry;
	    $opts .= "\t\t<option value=\"$entry\"$opt_add>{$lang[$index]}</option>\n";
	}
	
	return $opts;
    }
    
    /**
     * @access	public
     * @param	array	$int_post
     * @return	string
     */
    function render_posting($int_post, $can_cut = TRUE, $search_str = NULL)
    {
	global $cfg, $lang;

	$topic_cont = $this->_get_topic_content($int_post['topic']);
	
	// if submitter want to cut a part of the article
	$read_more = '';
	if ($pos = strpos($int_post['body'], ' CUT '))
	{
	    if ($can_cut)
	    {
		$int_post['body'] = substr($int_post['body'], 0, $pos);
	    	$msg_id           = urlencode($int_post['msgid']); 
		$read_more = sprintf('<a href="index.php?np_act=expanded&amp;'.
				     'msg_id=%s">%s</a>',$msg_id,
				     $lang['misc_more']); 
	    }
	    else
		$int_post['body'] = str_replace(' CUT ', '',
				$int_post['body']);
	}
	
	// create path for emoticon. edit image extension here
	$emoticon = create_theme_path('images/smile/' . $int_post['emoticon']);

	// calculate the date string
	$int_post['date'] = $this->_calc_date($int_post['stamp']);	
	
	// are comments used?
	$comment    = '';
	$fresh_bool = FALSE;
	if ($cfg['UseComments'])
	{
	    $references = $_SESSION['NP']['store_inst']->get_thread(
			    $int_post['msgid'], FALSE);
	    $children   = count($references);
	    
	    if (isset($references[$children-1]))
	    {
		$latest     = $references[$children-1];
		$diff       = time() - $latest['stamp'];
		$fresh_bool = ($diff <= $cfg['MarkFresh']);
	    }
	    
	    $url = '<a href="index.php?np_act=expanded&amp;msg_id=%s">'
	         . '%s [ %s ]</a>';
	    $msg_id  = urlencode($int_post['msgid']);
	    $comment = sprintf($url, $msg_id,
			    $lang['misc_comments'], $children);
	}
	
	// replace UBB code?
	if ($cfg['ParseUBB'])
	    $int_post['body'] =
		    $_SESSION['NP']['ubb_inst']->replace($int_post['body']);
	
	// should this posting marked as fresh or old?
	$diff  = time() - $int_post['stamp'];
	$fresh = create_theme_path('images/misc/mark_fresh.png');
	$old   = create_theme_path('images/misc/mark_old.png');
	$mark  = '';
	
	if ($cfg['MarkFresh'] !== 0 && 
		    ($diff <= $cfg['MarkFresh'] || $fresh_bool))
	    $mark = sprintf('<img src="%s" alt="" border="0" />', $fresh);
	    
	if ($cfg['MarkOld'] !== 0 && $diff >= $cfg['MarkOld'] && !$fresh_bool)
	    $mark = sprintf('<img src="%s" alt="" border="0" />', $old);
	
	// strip all slashes?
	$int_post = $this->_my_stripslashes($int_post);
	
	if ($search_str !== NULL)
	{
	    $int_post['name']    = $this->_mark_string($int_post['name'],
							$search_str); 
	    $int_post['subject'] = $this->_mark_string($int_post['subject'],
							$search_str);
	    $int_post['body']    = $this->_mark_string($int_post['body'],
							$search_str);
	}
	
	$search  = array(
	     0 => 'NAME',       1 => 'MAIL',
	     2 => 'SUBJECT',    3 => 'MSG_ID',
	     4 => 'NEWSGROUP',  5 => 'DATE',
	     6 => 'TIMESTAMP',  7 => 'TOPIC',
	     8 => 'EMOTICON',   9 => 'READ_MORE',
	    10 => 'COMMENTS',  11 => 'MARK',
	    12 => 'BODY'
	);
	
	$replace = array(
	     0 => $int_post['name'],     1 => $int_post['mail'],
	     2 => $int_post['subject'],  3 => $int_post['msgid'],
	     4 => $int_post['ngs'],      5 => $int_post['date'],
	     6 => $int_post['stamp'],    7 => $int_post['topic'],
	     8 => $emoticon,             9 => $read_more,
	    10 => $comment,             11 => $mark,
	    12 => $int_post['body']
	);
    
	$topic_cont = str_replace($search, $replace, $topic_cont);
	return $topic_cont;
    }
    
    /**
     * @access	public
     * @param	array	$comment
     * @param	string	$parent_msgid
     * @return	string
     */
    function render_comment($comment, $parent_msgid, $search_str = NULL)
    {
	global $cfg, $lang;
    
	if ($parent_msgid === NULL)
	{
	    $parent_msgid = explode(' ', $comment['refs']);
	    $parent_msgid = $parent_msgid[0];
	}
	
	$topic_cont = $this->_get_topic_content($comment['topic']);
	
	// create path for emoticon. edit image extension here
	$emoticon = create_theme_path('images/smile/' . $comment['emoticon']);
	
	$parent_msgid = urlencode($parent_msgid);
	$msgid        = urlencode($comment['msgid']);
	
	$date   = $this->_calc_date($comment['stamp']);			
	$answer = sprintf('<a href="index.php?np_act=expanded&amp;'.
	                  'msg_id=%s&amp;child_of=%s#form">%s</a>',
			  $parent_msgid, $msgid, $lang['comment_answer']);
	
	// HTML is not allowed, but maybe the user uses UBB code
	if (!$cfg['AllowHTML'])
	{
	    $comment['name']    = strip_tags($comment['name']);
	    $comment['mail']    = strip_tags($comment['mail']);
	    $comment['subject'] = strip_tags($comment['subject']);
	    $comment['body']    = strip_tags($comment['body'],
				    $cfg['AllowedTags']);
	}
	
	// convert newlines to break
	$comment['body'] = str_replace("\n", "<br />\n", $comment['body']);
	
	// replace UBB code?
	if ($cfg['ParseUBB'])
	    $comment['body'] = $_SESSION['NP']['ubb_inst']->replace(
				$comment['body']);
	
	// strip all slashes?
	$comment = $this->_my_stripslashes($comment);
	
	if ($search_str !== NULL)
	{
	    $comment['name']    = $this->_mark_string($comment['name'],
							$search_str); 
	    $comment['subject'] = $this->_mark_string($comment['subject'],
							$search_str);
	    $comment['body']    = $this->_mark_string($comment['body'],
							$search_str);
	}
	
	$search  = array(
	    0 => 'EMOTICON', 1 => 'NAME',  2 => 'MAIL',
	    3 => 'SUBJECT',  4 => 'DATE',  5 => 'MSG_ID',
	    6 => 'BODY',     7 => 'ANSWER'
	);
	
	$replace = array(
	    0 => $emoticon,        1 => $comment['name'],
	    2 => $comment['mail'], 3 => $comment['subject'],
	    4 => $date,            5 => $comment['msgid'],
	    6 => $comment['body'], 7 => $answer
	);
	
	$topic_cont = str_replace($search, $replace, $topic_cont);
	return $topic_cont;
    }
    
    /**
     * @access	public
     * @param	array	$int_post
     * @param	bool	$with_boxes
     * @return	string
     */
    function render_oview($posts, $with_boxes = FALSE)
    {
	global $cfg;
	
	// filename of oview entry template
	$file  = create_theme_path('oview_item.inc');	    
	
	if (($fp = fopen($file, 'r')) == FALSE)
	    return FALSE;
	    
	$item = fread($fp, filesize($file));
	fclose($fp);

	// read skeleton 
	$file  = create_theme_path('oview.inc');	    
	
	if (($fp = fopen($file, 'r')) == FALSE)
	    return FALSE;
	    
	$skeleton = fread($fp, filesize($file));
	fclose($fp);
	
	$search = array(
	    1 => 'NAME',   2 => 'MAIL', 3 => 'SUBJECT',
	    4 => 'MSG_ID', 5 => 'DATE', 6 => 'LINK',
	    7 => 'DEEP',   8 => 'BOX'
	);
	
	$oview_entries = '';
	foreach($posts as $posting)
	{
	    $msgid    = urlencode($posting['msgid']);
	    $link     = sprintf('index.php?np_act=output_all#%s', $msgid);
	    $deep_add = '';
	
	    if (isset($posting['refs']))
	    {
		$refs = explode(' ', $posting['refs']);		
		$deep = count($refs);
		$link = sprintf('index.php?np_act=expanded&amp;msg_id=%s#%s',
			    urlencode($refs[0]), $msgid);
		
		// compose depth indicator
		$deep_add     .= $cfg['DepthStart'];
		
		for($i = 1; $i < $deep; $i++)
		    $deep_add .= $cfg['DepthLength'];
		
		$deep_add     .= $cfg['DepthStop'];
	    }
	    
	    // strip all slashes?
	    $posting = $this->_my_stripslashes($posting);

	    // create checkbox
	    $checkbox = '';
	    if ($with_boxes === TRUE)
		$checkbox = sprintf('<input type="checkbox" name="cb[]"'
				  . ' value="%s" />', $posting['msgid']);
	    
	    $replace = array(
		1 => $posting['name'],    2 => $posting['mail'],
		3 => $posting['subject'], 4 => $posting['msgid'],
		5 => $this->_calc_date($posting['stamp']),
		6 => $link,               7 => $deep_add,
		8 => $checkbox
	    );
	
	    $oview_entries .= str_replace($search, $replace, $item);
	}
	
	$oview = '';
	if (!empty($oview_entries))
	    $oview = str_replace('ENTRIES', $oview_entries, $skeleton);
	
	return $oview;
    }
    
    /**
     * @access	private
     * @param	int	$stamp
     * @return	string
     */
    function _calc_date($stamp)
    {
	global $cfg;
	
	$stamp = $cfg['TimeVariance'] + $stamp; 
	return stamp2string($stamp, $cfg['DateFormat']);
    }
    
    /**
     * @access	private
     * @param	string	$topic
     * @return	string	
     */
    function _get_topic_content($topic)
    {
	global $topics;
    
	// initialize filename variable with default topic
	$filename  = $topics[0]['filename'];
	
	foreach($topics as $key => $entry)
	{
	    if ($entry['name'] === $topic)
	    {
		$filename = $entry['filename'];
		break;
	    }
	}

	$filename = create_theme_path('topics/' . $filename);
	if (!file_exists($filename))
	{
	    trigger_error("File $filename does not exists in _control.php.");
	    return FALSE;
	}

	$fp = fopen($filename, 'r');
	$topic_cont = fread($fp, filesize($filename));
	fclose($fp);
    
	return $topic_cont;
    }
    
    /**
     * @access	private
     * @param	array	$posting
     * @return	array
     */
    function _my_stripslashes($posting)
    {
	global $cfg;
	
	if ($cfg['StripSlashes'])
	{
	    $posting['name']    = stripslashes($posting['name']);
	    $posting['mail']    = stripslashes($posting['mail']);
	    $posting['subject'] = stripslashes($posting['subject']);
	    $posting['body']    = stripslashes($posting['body']);
	}
	
	return $posting;
    }
    
    /**
     * @access	private
     * @param	string	$haystack
     * @param	string	$needle
     * @return	string
     */
    function _mark_string($haystack, $needle)
    {
	global $cfg;
	
	// if $needle is not in $haystack, return $haystack
	if (stristr($haystack, $needle) === FALSE)
	    return $haystack;
	
	$needle_len  = strlen($needle);
    
	$start = 0;
	while (($pos = strpos(strtolower($haystack),
		    strtolower($needle), $start)) !== FALSE)
	{
	    // create replacement string. we do not touch case of
	    // the found string
	    $match_repl = sprintf('<b style="background: %s">%s</b>',
		    $cfg['MatchColor'], substr($haystack, $pos, $needle_len));

	    $start    = $pos + strlen($match_repl);
	    
	    $haystack = substr_replace($haystack, $match_repl,
		    $pos, $needle_len);
	}
	
	return $haystack;
    }
    
}

?>