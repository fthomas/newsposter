#!/usr/bin/php4 -q
<?php
/* $Id$ */
//
// Authors: Frank Thomas <frank@thomas-alfeld.de>

require_once('../include/passwd.php');
require_once('../include/com_line.php');

$com = &new NP_ComLine();

$com->write_ln("\nValid hash types: CRYPT  SHA  SSHA  MD5  SMD5\n\n");
$com->write_ln("Enter your favourite hash type [SSHA]> ");

$hash_input = strtoupper($com->read_ln());

if (empty($hash_input))
    $hash_input = 'SSHA';

// create new password
$pass = &new NP_Passwords();

if ( !($hash_type = $pass->get_mode($hash_input)) )
    $com->write_err("Wrong hash type.\n");

$com->write_ln("You selected '$hash_input'.\n\n");
$com->write_ln("Enter your password in cleartext []> ");

$pass_input = $com->read_ln();

$hashed_pass = $pass->create_hash($pass_input, $hash_type);

$com->write_ln("\nYour $hash_input encrypted password is:\n$hashed_pass\n\n");

?>
