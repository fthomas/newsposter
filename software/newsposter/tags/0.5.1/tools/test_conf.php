<?php
/* $Id$ */
//
// Authors: Frank Thomas <frank@thomas-alfeld.de>

// test boolean variable
function test_bool($component)
{
    return ($component) ? ('<font color="green">Passed</font>')
		: ('<font color="red">Failed</font>');
}

$version   = version_compare('4.2.0', PHP_VERSION, '<=');
$session   = extension_loaded('session');
$mhash     = extension_loaded('mhash');
$spool     = is_writeable('../spool');
$mbox      = (file_exists('../spool/mbox')) ? (is_writeable('../spool/mbox')) : ($spool);

print('<p align="center">' . "\n");

print("<b>Essential checks</b> (must pass):<br />\n");
print('PHP version greater than 4.2.0: ' . test_bool($version) . ".<br />\n");
print('PHP session extension loaded: '   . test_bool($session) . ".<br />\n");
print('Spool directory is writeable: '   . test_bool($spool)   . ".<br />\n");
print('mbox file is writeable: '         . test_bool($mbox)    . ".<br />\n");

print("<br /><b>Additional checks</b> (may fail):<br />\n");
print('PHP mhash extension loaded:     ' . test_bool($mhash)   . ".<br />\n");

print('</p>');

?>
