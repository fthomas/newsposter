
<!-- $Id$ -->
<form action="index.php?np_act=chact" method="post">
<table border="0" width="400px" align="center" cellspacing="0">
    <tr><td colspan="3" style="background-image:url(themes/np_home/images/misc/border.png)"></td></tr>
    <tr><td width="1px" style="background-image:url(themes/np_home/images/misc/border.png)"></td>
	<td width="398px">
	    <table border="0" cellspacing="5" width="100%">
		<tr>
		    <td><?php echo $lang['login_user']; ?></td>
		    <td><input type="text" name="login_name" size="20" /></td>
		</tr>
		<tr>
		    <td><?php echo $lang['login_pass']; ?></td>
		    <td><input type="password" name="login_pass" size="20" /></td>
		</tr>
		<tr>
		    <td colspan="2" align="right">
			<input type="submit" value="<?php echo $lang['login_submit']; ?>" />&nbsp;
			<input type="reset" value="<?php echo $lang['login_reset']; ?>" />
		    </td>
		</tr>
	    </table>
        </td>
	<td width="1px" style="background-image:url(themes/np_home/images/misc/border.png)"></td></tr>
    <tr><td colspan="3" style="background-image:url(themes/np_home/images/misc/border.png)"></td></tr>
</table>
</form>
