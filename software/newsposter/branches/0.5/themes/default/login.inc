
<!-- $Id: login.inc 51 2003-02-02 13:14:37Z anonymous $ -->
<form action="index.php?np_act=chact" method="post">
<table border="1" width="50%" align="center" cellspacing="1" cellpadding="5">
    <tr>
	<td colspan="2">
	    <b><?php echo $lang['login_head'] ." - ". $cfg['PageTitle'] ?></b>    
	    <p align="right"><?php echo 'Newsposter ' . VERSION; ?></p>
	</td>
    </tr>
    <tr>
	<td width="30%"><?php echo $lang['login_user']; ?></td>
	<td>
	    <input type="text" name="login_name" size="20"
	    <?php echo $login_add['user'] . " "; echo $login_add['block']; ?> />
	</td>
    </tr>
    <tr>
	<td width="30%"><?php echo $lang['login_pass']; ?></td>
	<td>
	    <input type="password" name="login_pass" size="20"
	    <?php echo $login_add['block'] ?> />
	</td>
    </tr>
    <tr>
	<td align="right" colspan="2">
	    <input type="submit" value="<?php echo $lang['login_submit']; ?>" />
	    &nbsp;
	    <input type="reset"  value="<?php echo $lang['login_reset']; ?>" />
	</td>
    </tr>
</table>
</form>
