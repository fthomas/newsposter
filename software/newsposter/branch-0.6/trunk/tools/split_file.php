#!/usr/bin/php4 -q
<?php
/* $Id$ */
//
// Authors: Frank Thomas <frank@thomas-alfeld.de>

$header = 'header.html';
$footer = 'footer.html';

$help_text = "Usage: split_file.php [FILE] [STRING1]\n"
           . "       split_file.php [FILE] [STRING1] [STRING2]\n"
           . "Splits FILE into two files (header.html and footer.html).\n";

// less than two or more than three parameters
if ($argc < 3 or $argc > 4)
{
    print($help_text);
    exit(1);
}

// input file does not exists or is not readable
if (!is_readable($argv[1]))
{
    print($help_text);
    exit(1);
}
// read content of FILE
else
{
    $fp   = fopen($argv[1], 'r');
    $cont = fread($fp, filesize($argv[1]));
    fclose($fp);
}

$pos1 = TRUE;
$pos2 = TRUE;

if ($argc == 3)
{
    $pos1 = strpos($cont, $argv[2]);
}
else if ($argc == 4)
{
    $pos1 = strpos($cont, $argv[2]);
    $pos2 = strpos($cont, $argv[3]);
}

// STRING1 not found in FILE
if ($pos1 == FALSE)
{
    print("Error: STRING1 not found in FILE.\n");
    exit(1);
}

// STRING2 not found in FILE
if ($pos2 == FALSE)
{
    print("Error: STRING2 not found in FILE.\n");
    exit(1);
}

if ($argc == 3)
{
    $cont1 = substr($cont, 0, $pos1);
    $cont2 = substr($cont, $pos1 + strlen($argv[2]));
}
else if ($argc == 4)
{
    $cont1 = substr($cont, 0, $pos1);
    $cont2 = substr($cont, $pos2 + strlen($argv[3]));
}

$fp1 = fopen($header, 'w');
$fp2 = fopen($footer, 'w');

fwrite($fp1, $cont1);
fwrite($fp2, $cont2);
  
fclose($fp1);
fclose($fp2);

?>
