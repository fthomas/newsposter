#!/usr/bin/php4 -q
<?php
/* $Id$ */
//
// Authors: Frank Thomas <frank@thomas-alfeld.de>

$help_text = "Usage: cut_file.php [FILE] [SEPARATOR_STRING]\n"
	   . "Creates two files with content of FILE before and"
	   . " after SEPARATOR_STRING.\n";

if ($argc != 3 || !file_exists($argv[1]))
    echo $help_text;

else if (file_exists($argv[1]))
{
    $fp   = fopen($argv[1], 'r');
    $cont = fread($fp, filesize($argv[1]));
    fclose($fp);
    
    $pos = strpos($cont, $argv[2]);
    if ($pos === FALSE)
    {
	echo "SEPARATOR_STRING not found in FILE.\n";
	exit(1);
    }
    
    $cont1 = substr($cont, 0, $pos);
    $cont2 = substr($cont, $pos + strlen($argv[1]));

    $fp1 = fopen('part_one.html', 'w');
    $fp2 = fopen('part_two.html', 'w');

    fwrite($fp1, $cont1);
    fwrite($fp2, $cont2);
    
    fclose($fp1);
    fclose($fp2);
}

else
    echo $help_text;

?>
