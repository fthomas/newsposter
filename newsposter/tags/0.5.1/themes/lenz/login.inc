
<!-- $Id: login.inc 51 2003-02-02 13:14:37Z anonymous $ -->
<form action="index.php?np_act=chact" method="post">
<table align="center" width="60%" style="border: solid 1px black" cellspacing="0" cellpadding="5">
    <tr>
	<td colspan="2" bgcolor="#DFDFDF">
	    <?php printf("<b>%s (%s)</b>", $lang['login_head'], $cfg['PageTitle']); ?>
	</td>
    </tr>
    <tr>
	<td align="right" width="25%"><?php echo $lang['login_user']; ?></td>
	<td>
	    <input type="text" name="login_name" size="30"
	    <?php echo $login_add['user'] . " "; echo $login_add['block']; ?> />
	</td>
    </tr>
    <tr>
	<td align="right" width="25%"><?php echo $lang['login_pass']; ?></td>
	<td>
	    <input type="password" name="login_pass" size="30"
	    <?php echo $login_add['block'] ?> />
	</td>
    </tr>
    <tr>
	<td colspan="2" align="center">
	    <input type="submit" value="<?php echo $lang['login_submit']; ?>" />
	    &nbsp;
	    <input type="reset"  value="<?php echo $lang['login_reset']; ?>" />
	</td>
    </tr>
</table>
</form>
<br /><br />
