<?php
/* $Id$ */
//
// Authors: Frank Thomas <frank@thomas-alfeld.de>

// include all required files
require_once('misc.php');
require_once('constants.php');
require_once($np_dir . '/config.php');

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
	    $retval['block'] = 'disabled="true"';
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
	    $retval['write'] = '<input type="radio" name="action" value="write" disabled="true" />';
	    
	if ($lookup[P_EDIT] == TRUE || $lookup[P_EDIT_NEWS] == TRUE)
	    $retval['edit'] = '<input type="radio" name="action" value="edit" />';
	else
	    $retval['edit'] = '<input type="radio" name="action" value="edit" disabled="true" />';
	    
	if ($lookup[P_DEL] == TRUE || $lookup[P_DEL_NEWS] == TRUE)
	    $retval['delete'] = '<input type="radio" name="action" value="delete" />';
	else
	    $retval['delete'] = '<input type="radio" name="action" value="delete" disabled="true" />';
	    
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
	    $form['name']    = stripslashes($formm['name']); 
	    $form['mail']    = stripslashes($form['mail']); 
	    $form['subject'] = stripslashes($form['subject']);
	    $form['body']    = stripslashes($form['body']);
	}
	
	return $form;
    }
    
    /**
     * @access	public
     * @param	string
     * @return	string
     */
    function get_selection_topic($selected = '')
    {
	// include the topics control file
	require_once(create_theme_path('topics/_control.php'));

	if ($selected === $topic[0]['name'] || empty($selected))
	    $select_opts = "<option value=\"{$topic[0]['name']}\" "
			 . "selected=\"true\">"
			 . "{$topic[0]['name']}</option>\n";
	else
	    $select_opts = "<option value=\"{$topic[0]['name']}\">"
			 . "{$topic[0]['name']}</option>\n";

	foreach($topic as $key => $entry)
	{
	    if ($key == 0)
		continue;
	
	    $opt_add = '';
	    if ($entry['name'] === $selected)
		$opt_add = ' selected="true"';
		
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
	    $opts = '<option value="none" selected="true"></option>'."\n";
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
		$opt_add = ' selected="true"';
	    
	    $index = 'emot_' . $entry;
	    $opts .= "\t\t<option value=\"$entry\"$opt_add>{$lang[$index]}</option>\n";
	}
	
	return $opts;
    }
    
    /**
     *
     */
    function render_posting($int_post)
    {
	// include topics control file
	require_once(create_theme_path('topics/_control.php'));
	
	// initialize filename variable with default topic
	$filename = $topic[0]['filename'];
	$emoticon = create_theme_path('images/smile/' .
			$int_post['emoticon'] . '.png');
			
	foreach($topic as $key => $entry)
	{
	    if ($entry['name'] === $int_post['topic'])
	    {
		$filename = $entry['filename'];
		break;
	    }
	}
	
	$filename = create_theme_path('topics/' . $filename);
	if (!file_exists($filename))
	{
	    trigger_error("File $filename does not exists. "
	                 ."Check your _control.php file");
	    return FALSE;
	}
	
	$fp = fopen($filename, 'r');
	// tc = topic content
	$tc = fread($fp, filesize($filename));
	fclose($fp);
	
	$search  = array(
	    0  => 'NAME',
	    1  => 'MAIL',
	    2  => 'SUBJECT',
	    3  => 'MSG_ID',
	    5  => 'NEWSGROUP',
	    6  => 'DATE',
	    7  => 'TIMESTAMP',
	    8  => 'TOPIC',
	    9  => 'EMOTICON',
	    10 => 'BODY'
	);
	
	$replace = array(
	    0  => $int_post['name'],
	    1  => $int_post['mail'],
	    2  => $int_post['subject'],
	    3  => $int_post['msgid'],
	    5  => $int_post['ngs'],
	    6  => $int_post['date'],
	    7  => $int_post['stamp'],
	    8  => $int_post['topic'],
	    9  => $emoticon,
	    10 => $int_post['body']
	);
    
	$tc = str_replace($search, $replace, $tc);
	return $tc;
    }
    
}

?>