<?php
/* $Id$ */
//
// Authors: Frank Thomas <frank@thomas-alfeld.de>

// this should be the newsposter's main dir,
// not the include dir
$np_dir = getcwd();

if (substr($np_dir, -7) == 'include')
{
    $np_dir = substr($np_dir, 0, -7);
}

ini_set('error_log'      , $np_dir . '/error.log');
ini_set('error_reporting', E_ALL);
//ini_set('track_errors'   , 1);

ini_set('session.use_trans_sid', 1);
ini_set('session.use_cookies'  , 0);
ini_set('arg_separator.output' , '&amp;'); // make it XHTML compatible

// prints file before newsposter's output
function print_header()
{
    global $cfg;
    if (!empty($cfg['IncludeHeader']) && file_exists($cfg['IncludeHeader']))
        include_once($cfg['IncludeHeader']);
}

// prints file after newsposter's output
function print_footer()
{
    global $cfg;
    if (!empty($cfg['IncludeFooter']) && file_exists($cfg['IncludeFooter']))
        include_once($cfg['IncludeFooter']);
}

// makes an absolute uri
/**
 * @returns string
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

// only for debug purposes
function v_output($var)
{
    print '<pre>';
    print_r($var);
    print '</pre>';
}

?>