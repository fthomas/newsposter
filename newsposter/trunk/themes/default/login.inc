
<!-- $Id$ -->
<br /><br />
<form action="index.php?np_act=chact" method="post">
<table border="1" width="50%" align="center" cellspacing="1" cellpadding="5">
    <tr>
	<td colspan="2">
	    <b><?php echo 'Newsposter ' . VERSION; ?></b>
	    <p align="right"><?php echo $cfg['PageTitle'] ?></p>
	</td>
    </tr>
    <tr>
	<td width="30%"><?php echo $lang['login_user']; ?></td>
	<td>
	    <input type="text" name="login_name"
	    <?php echo $login_add['user'] . " "; echo $login_add['block']; ?> />
	</td>
    </tr>
    <tr>
	<td width="30%"><?php echo $lang['login_pass']; ?></td>
	<td>
	    <input type="password" name="login_pass"
	    <?php echo $login_add['block'] ?> />
	</td>
    </tr>
    <tr>
	<td align="right" colspan="2">
	    <input type="submit" value="<?php echo $lang['login_submit']; ?>" />
	    <input type="reset"  value="<?php echo $lang['login_reset']; ?>" />
	</td>
    </tr>
</table>
</form>
