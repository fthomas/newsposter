<?php
/* $Id$ */
//
// Authors: Frank Thomas <frank@thomas-alfeld.de>

require_once('../include/passwd.php');

$hashed_pass = '';

if (!empty($_POST['pass']))
{
    $pass = &new NP_Passwords();
    $hash_type   = $pass->get_mode($_POST['hash']);
    $hashed_pass = $pass->create_hash($_POST['pass'], $hash_type);
}

$file = basename($_SERVER['PHP_SELF']);

print <<< HTML

<?xml version="1.0" encoding="UTF-8" ?>
<!DOCTYPE html
     PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
     "DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <title>Newsposter Password Generator</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-15" />
  <head>
  <body>
  <br />
    <form action="$file" method="post">
      <table border="1" cellspacing="1" cellpadding="5" align="center" width="55%">
        <tr>
          <td colspan="2"><h3>Newsposter Password Generator</h3></td>
        </tr>
        <tr>
          <td align="right">Hash type:</td>
          <td>
            <select name="hash">
              <option>CRYPT</option>
              <option>SHA</option>
              <option selected="selected">SSHA</option>
              <option>MD5</option>
              <option>SMD5</option>
            </select>
          </td>
        </tr>
        <tr>
          <td align="right">Password:</td>
          <td><input type="text" name="pass" value="" size="15" /></td>
        </tr>
        <tr>
          <td colspan="2" align="center"><input type="submit" value="Generate hashed password!" /></td>
        </tr>
        <tr>
          <td align="right">Hashed password:</td>
          <td><input type="text" name="hashpass" value="$hashed_pass" size="25" /></td>
        </tr>
      </table>
    </form>
  </body>
</html>

HTML;

?>
