<?php
/* $Id$ */
//
// Authors: Frank Thomas <frank@thomas-alfeld.de>

// include all required files
require_once('misc.php');
require_once('passwd.php');
require_once('constants.php');
require_once($np_dir . '/config.php');

/**
 * This class handles newsposter's authentication. You can easily add
 * functions to do authentication against /etc/passwd, SQL servers,
 * text files etc. Look at auth_user and the _search_* functions for
 * more details.
 * @brief	Authentication and permission validation class
 */
class NP_Auth {

    var $username   = '';
    var $password   = '';
    var $perm       = 0;
    var $error_page = '';

    function NP_Auth()
    {
        $this->__construct();
    }

    function __construct()
    {
	global $cfg;
	
        $this->error_page = $cfg['IndexURL'] . "?np_act=error";
    }

    /**
     * @access	public
     * @param	string	$username
     * @param	string	$password
     */
    function auth_user($username, $password)
    {
        global $cfg;

	// if we use a remote spool dir we can login, but have
	// no permissions to do anything (except reading of course)
	if (!empty($cfg['RemoteNPDir']))
	{
	    $this->username = $username;
	    $this->perm     = PEON;
	    
	    $this->_make_session();
	    return TRUE;
	}

        if ($cfg['UseBuiltInAuth'] == FALSE)
        {
            $this->username = 'anonymous';
            $this->perm     = ADMIN;

            $this->_make_session();
            return TRUE;
        }
        
        if (empty($username) || empty($password))
        {
            my_trigger_error('Empty username or password');
            return FALSE;
        }

        // search config.php for user
        if ($this->_search_conf($username, $password) == TRUE)
        {
            $this->_make_session();
            return TRUE;
        }
        
        // search ldap directory for user
        if ($this->_search_ldap($username, $password) == TRUE)
        {
            $this->_make_session();
            return TRUE;
        }

        // user & password not found
        my_trigger_error('Invalid credentials');
        return FALSE;
    }

    /**
     * @access	public
     * @return	bool
     */
    function check_post()
    {
	global $cfg;	

	// If we disable the text inputs, the post vars
	// are not set.
	if ($cfg['UseBuiltInAuth'] === FALSE)
	{
	    $_POST['login_name'] = '';
	    $_POST['login_pass'] = '';
	}

	else if (!isset($_POST['login_name']) || !isset($_POST['login_pass']))
	    return $this->check_auth();
    
        return $this->auth_user($_POST['login_name'], $_POST['login_pass']);
    }

    /**
     * @access	private
     * @param	string	$username
     * @param	string	$password
     * @return	bool
     */
    function _search_conf($username, $password)
    {
        global $cfg;

        foreach($cfg['username'] as $key => $value)
        {
            if (!strcmp($value, $username))
            {
                $pass = &new NP_Passwords;
                if ($pass->cmp_hashes($password, $cfg['password'][$key]))
                {
                    $this->username = $username;
                    $this->password = $password;
                    $this->perm = $cfg['permission'][$key];

                    return TRUE;
                }
            }
        }
        return FALSE;
    }

    /**
     * @access	private
     * @param	string	$username
     * @param	string	$password
     * @return	bool
     */
    function _search_ldap($username, $password)
    {
        global $cfg;

        if ($cfg['UseLDAPAuth'] == FALSE)
            return FALSE;
        
	if (!function_exists('ldap_connect'))
	{
	    my_trigger_error('LDAP extension not available in this PHP version');
	    return FALSE;
	}
	    
        if (!$ldap_rs = ldap_connect($cfg['LDAPServer'], $cfg['LDAPPort']))
        {
	    my_trigger_error('Could not connect to LDAP server');
	    return FALSE;
	}

        if (!ldap_bind($ldap_rs, $cfg['BindDN'], $cfg['BindPassword']))
        {
	    my_trigger_error('Could not bind to LDAP server');
	    return FALSE;
	}

        // search for username
        $filter = sprintf('(%s=%s)', $cfg['UsernameAttr'], $username);
        $attrs  = array($cfg['UsernameAttr'], 'userPassword', $cfg['PermAttr']);

        if (!$search = ldap_search($ldap_rs, $cfg['SearchBase'], $filter, $attrs))
        {
            ldap_unbind($ldap_rs);
            return FALSE;
        }

        $entries = ldap_get_entries($ldap_rs, $search);

        // empty userPassword attribute is not allowed
        if (!isset($entries[0]['userpassword'][0]))
        {
            ldap_unbind($ldap_rs);
            return FALSE;
        }

        // set permission for ldap user
        $perm = @$entries[0][$cfg['PermAttr']][0];

        if ((!is_numeric($perm) || ($perm > ADMIN || $perm < SLAVE)) || !isset($perm))
            $perm = $cfg['DefaultPerm'];

        // test user's password
        $pass = &new NP_Passwords;
        if ($pass->cmp_hashes($password, $entries[0]['userpassword'][0]))
        {
            $this->username = $username;
            $this->password = $password;
            $this->perm = (int) $perm;

            ldap_unbind($ldap_rs);
            return TRUE;
        }

        ldap_unbind($ldap_rs);
        return FALSE;
    }

    /**
     * @access	private
     */
    function _make_session()
    {
        if (!isset($_SESSION))
            session_start();

        $_SESSION['NP']['auth']     = TRUE;
        $_SESSION['NP']['username'] = $this->username;
        $_SESSION['NP']['perm']     = $this->perm;
    }
    
    /**
     * @access	public
     * @return	bool
     */
    function check_auth()
    {
        if (!isset($_SESSION))
            session_start();

        if (isset($_SESSION['NP']['auth']) && $_SESSION['NP']['auth'] == TRUE)
            return TRUE;
        else {
            header("Location: $this->error_page&auth");
            exit();
        }
    }

    /**
     * @access	public
     * @return	array
     */
    function perm_lookup()
    {
        if (!isset($_SESSION))
            session_start();
		
	$perms_array = array(P_WRITE, P_EDIT, P_DEL,
			P_EDIT_NEWS, P_DEL_NEWS, P_DEL_COMMENTS);
	
	// creates an array with a bool
	// value for each permission bit
	foreach($perms_array as $perm_bit)
	{
	    if (($_SESSION['NP']['perm'] & $perm_bit) != 0)
		$result[$perm_bit] = TRUE;
	    else
		$result[$perm_bit] = FALSE;
	}
	
	return $result;
    }
    
    /**
     * @access	public
     * @param	mixed	$action
     * @return	bool
     */
    function check_perm($action, $redirect = TRUE)
    {
	$lookup = $this->perm_lookup();
    
	if (is_array($action))
	{
	    foreach($action as $perm_bit)
	    {
		if ($lookup[$perm_bit])
		    return TRUE;
	    }
	}
	
	else if (is_int($action) && $lookup[$action])
	    return TRUE;
	
	if ($redirect !== TRUE)
	    return FALSE;
	    
	else
	{
	    $sess_id = create_sess_param();
	    header("Location: $this->error_page&perm&$sess_id");
	    exit();
	}
    }

}

?>
