
<!-- $Id: login.inc 221 2004-09-15 21:35:23Z mrfrost $ -->

<form action="index.php?np_act=chact" method="post">
<table class="container" border="0" cellspacing="0" cellpadding="4">
  <tr>
    <td colspan="2" style="background-color:#fafafa">
      <?php printf("%s - <b>%s</b>", $lang['login_head'], $cfg['PageTitle']); ?>
    </td>
  </tr>
  <tr>
    <td style="text-align:right;width:25%"><?php echo $lang['login_user']; ?></td>
    <td>
      <input type="text" name="login_name" size="30" <?php echo $login_add['user'] . " "; echo $login_add['block']; ?> />
    </td>
  </tr>
  <tr>
    <td style="text-align:right;width:25%"><?php echo $lang['login_pass']; ?></td>
    <td>
      <input type="password" name="login_pass" size="30" <?php echo $login_add['block'] ?> />
    </td>
  </tr>
  <tr>
    <td colspan="2" style="text-align:center">
      <input type="submit" value="<?php echo $lang['login_submit']; ?>" />
      &nbsp;
      <input type="reset"  value="<?php echo $lang['login_reset']; ?>" />
    </td>
  </tr>
</table>
</form>
<br />
