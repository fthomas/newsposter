<?php
/* $Id$ */
//
// Authors: Frank Thomas <frank@thomas-alfeld.de>

/// this should be the newsposter's main dir, not the include dir
$np_dir = getcwd();

if (substr($np_dir, -7) == 'include')
{
    $np_dir = substr($np_dir, 0, -7);
}

// make XHTML compatible
ini_set('arg_separator.output', '&amp;');

// uncomment this for debugging
//ini_set('error_log'      , $np_dir . '/var/php_error.log');
//ini_set('error_reporting', E_ALL);
//ini_set('log_errors'     , 1);

/**
 * write error message to file
 */
function np_trigger_error($error_msg)
{
    $error_log = $GLOBALS['np_dir'] . '/var/error.log';

    if (!file_exists($error_log))
        touch($error_log);

    if (($fp = fopen($error_log, 'a')) === FALSE)
        return FALSE;

    $date = sprintf('[%s] ', date('r'));	
    fwrite($fp, $date . $error_msg . "\n");	
    fclose($fp);
}

/**
 * includes file before newsposter's output
 */
function print_header()
{
    $_SESSION['NP']['i18n_inst']->include_frame(HEADER);
}

/**
 * includes file after newsposter's output
 */
function print_footer()
{
    $_SESSION['NP']['i18n_inst']->include_frame(FOOTER);
}

/**
 * makes an absolute uri
 * @return	string
 * @deprecated	We use now $cfg['PageURL'], so users can
 *		cloak the page url.
 */
function abs_uri()
{
    if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on')
        $prot = 'https://';
    else
        $prot = 'http://';

    $server = $_SERVER['HTTP_HOST'];
    $dir    = dirname($_SERVER['PHP_SELF']);

    return $prot . $server . $dir . '/';
}


/**
 * Creates a path for theme files.
 * @param	string	$filename
 * @return	string
 */
function create_theme_path($filename)
{
    global $cfg;
    return 'themes/' . $cfg['Theme'] . "/$filename";
}

/**
 * create GET paramter for session_id
 */
function create_sess_param()
{
    return session_name() . '=' . session_id();
}

/**
 * create POST variable for session
 */
function create_sess_post()
{
    return sprintf('<input type="hidden" name="%s" value="%s" />%s',
               session_name(), session_id(), "\n");
}

?>
