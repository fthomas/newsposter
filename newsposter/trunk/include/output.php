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
	
	$form['name']     = '';
	$form['name_add'] = '';
	
	if ($cfg['AllowChangeNames'] == FALSE)
	{
	    $form['name']     = eval(" return {$cfg['NameVar']}; ");
	    $form['name_add'] = 'readonly="true"';
	}
	
	return $form;
    }
    
    /**
     * @access	public
     * @return	string
     */
    function get_selection_topic()
    {
	// include the topics control file
	require_once(create_theme_path('topics/_control.php'));

	//init select_opts
	$select_opts = '';

	foreach($topic as $key => $entry)
	{
	    if ($key == 0)
		$select_opts .= "<option value=\"{$entry['filename']}\">"
			      . "{$entry['name']}</option>\n";
	    
	    else 
		$select_opts .= "\t\t<option value=\"{$entry['filename']}\">"
	                     . "{$entry['name']}</option>\n";
	}
    
	return $select_opts;
    }
    
    /**
     * @access	public
     * @return	string
     */
    function get_selection_emots()
    {
	global $lang;
	
	$emots[0]['name']  = '';
	$emots[0]['trans'] = ;
	$emots[1]['name']  = '';
	$emots[1]['trans'] = ;
	
	$opts = "<option value=\"none\"></option>\n"
	      . "\t\t<option value=\"angry\">{$lang['emot_angry']}</option>\n"
	      . "\t\t<option value=\"dead\">{$lang['emot_']}</option>"
	      . "\t\t<option value=\"discuss\">{$lang['emot_']}</option>"	      
	      . "\t\t<option value=\"evil\">{$lang['emot_']}</option>"
	      . "\t\t<option value=\"happy\">{$lang['emot_']}</option>"
	      . "\t\t<option value=\"insane\">{$lang['emot_']}</option>"
	      . "\t\t<option value=\"laughing\">{$lang['emot_']}</option>"
	      . "\t\t<option value=\"mean\">{$lang['emot_']}</option>"
	      . "\t\t<option value=\"pissed-off\">{$lang['emot_']}</option>"
	      . "\t\t<option value=\"sad\">{$lang['emot_']}</option>"	      
	      . "\t\t<option value=\"satisfied\">{$lang['emot_']}</option>"
	      . "\t\t<option value=\"shocked\">{$lang['emot_']}</option>"
	      . "\t\t<option value=\"sleepy\">{$lang['emot_']}</option>";
	      . "\t\t<option value=\"suprised\">{$lang['emot_']}</option>";
	      . "\t\t<option value=\"uplooking\">{$lang['emot_']}</option>";

	return $opts;
    }
    
}

?>