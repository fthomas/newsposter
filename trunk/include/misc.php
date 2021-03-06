<?php
/* $Id$
 *
 * This file is part of Newsposter
 * Copyright (C) 2001-2004 by Frank S. Thomas <frank@thomas-alfeld.de>
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License 
 * along with this program; if not, write to the
 * Free Software Foundation, Inc.,
 * 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 */


/**
 *
 */
function np_get_dir()
{
    $cwd = getcwd();

   // """""" $seven = 
    // oder plugins
    if (substr($cwd, -7) == 'include')
    {
        $np_dir = substr($np_dir, 0, -7);
    }
    return $dir;
}
 
$NP['dir'] = np_get_dir();


/**
 *
 */
function np_get_url()
{
    if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on')
        $prot = 'https://';
    else
        $prot = 'http://';

    $server = $_SERVER['HTTP_HOST'];
    $dir    = dirname($_SERVER['PHP_SELF']);

    return $prot . $server . $dir . '/';
}


// make XHTML compatible
ini_set('arg_separator.output', '&amp;');

// uncomment this for debugging
//ini_set('error_log'      , $np_dir . '/var/error_php.log');
//ini_set('error_reporting', E_ALL);
//ini_set('log_errors'     , 1);

/**
 * write error message to file
 */
function np_trigger_error($error_msg)
{
    $error_log = $GLOBALS['np_dir'] . '/var/error_np.log';

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
