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
    function login()
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
     * @param	object	$auth_inst
     * @return	array	An array of the radio buttons used by chact glue.
     */
    function chact($auth_inst)
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

}

?>