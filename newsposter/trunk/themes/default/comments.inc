
<!-- $Id$ -->
<br />
<form>
<input type="hidden" name="ref" value="<?php echo $msgid; ?>" />
<table border="1" width="50%" align="center" cellspacing="1" cellpadding="5">
    <tr>
	<td colspan="2">
	    <b><?php echo $lang['comment_head']; ?></b>
	    <p align="right"><?php echo 'Newsposter ' . VERSION; ?></p>
	</td>
    </tr>
    <tr>
	<td align="right" width="25%"><?php echo $lang['misc_name']; ?></td>
	<td><input type="text" name="name" value="" size="30" /></td>
    </tr>
    <tr>
	<td align="right" width="25%"><?php echo $lang['misc_mail']; ?></td>
	<td><input type="text" name="mail" value="" size="30" /></td>
    </tr>
    <tr>
	<td align="right" width="25%"><?php echo $lang['misc_emoticon']; ?></td>
	<td>
	    <select name="topic">
		<?php echo $emots_opts; ?>
	    </select>
	</td>
    </tr>
    <tr>
	<td align="right" width="25%" valign="top"><?php echo $lang['misc_comment']; ?></td>
	<td><textarea name="body" cols="30" rows="10"></textarea></td>
    </tr>
    <tr>
	<td colspan="2" align="right">
	    <input type="submit" value="<?php echo $lang['comment_send']; ?>" />
	    &nbsp;
	    <input type="reset"  value="<?php echo $lang['login_reset']; ?>" />
	</td>
    </tr>
</table>
</form>
