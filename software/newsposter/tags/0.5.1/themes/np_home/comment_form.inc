
<!-- $Id$ -->
<a name="form"></a>
<form action="<?php echo $val['index']; ?>" method="post">
<input type="hidden" name="ref" value="<?php echo $val['msgid']; ?>" />
<table border="0" width="400px" align="center" cellspacing="0">
    <tr><td colspan="3" style="background-image:url(themes/np_home/images/misc/border.png)"></td></tr>
    <tr><td width="1px" style="background-image:url(themes/np_home/images/misc/border.png)"></td>
	<td width="398px">
	    <table border="0" cellspacing="5" width="100%">
		<tr>
		    <td><?php echo $lang['misc_name']; ?></td>
		    <td><input type="text" name="name" value="<?php echo $val['name']; ?>" size="20" /></td>
		</tr>
		<tr>
		    <td><?php echo $lang['misc_mail']; ?></td>
		    <td><input type="text" name="mail" value="" size="20" /></td>
		</tr>
		<tr>
		    <td><?php echo $lang['misc_subject']; ?></td>
		    <td><input type="text" name="subject" value="<?php echo $val['subject']; ?>" size="20" /></td>
		</tr>
		<tr>
		    <td><?php echo $lang['misc_emoticon']; ?></td>
		    <td>
			<select name="emoticon">
			    <?php echo $val['emots_opts']; ?>
			</select>
		    </td>
		</tr>
		<tr>
		    <td valign="top"><?php echo $lang['misc_comment']; ?></td>
		    <td><textarea name="body" cols="30" rows="10"></textarea></td>
		</tr>
		<tr>
		    <td colspan="2" align="right">
		    <input type="submit" value="<?php echo $lang['comment_send']; ?>" />
		    &nbsp;
		    <input type="reset" value="<?php echo $lang['login_reset']; ?>" />
		    </td>
		</tr>
	    </table>
        </td>
	<td width="1px" style="background-image:url(themes/np_home/images/misc/border.png)"></td></tr>
    <tr><td colspan="3" style="background-image:url(themes/np_home/images/misc/border.png)"></td></tr>
</table>
</form>
