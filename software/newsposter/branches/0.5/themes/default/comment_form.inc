
<!-- $Id: comment_form.inc 49 2003-01-28 19:35:02Z mrfrost $ -->
<br /><a name="form"></a>
<form action="<?php echo $val['index']; ?>" method="post">
<input type="hidden" name="ref" value="<?php echo $val['msgid']; ?>" />
<table border="1" width="50%" align="center" cellspacing="1" cellpadding="5">
    <tr>
	<td colspan="2">
	    <b><?php echo $lang['comment_head']; ?></b>
	    <p align="right"><?php echo 'Newsposter ' . VERSION; ?></p>
	</td>
    </tr>
    <tr>
	<td align="right" width="25%"><?php echo $lang['misc_name']; ?></td>
	<td><input type="text" name="name" value="<?php echo $val['name']; ?>" <?php echo $val['name_add']; ?> size="30" /></td>
    </tr>
    <tr>
	<td align="right" width="25%"><?php echo $lang['misc_mail']; ?></td>
	<td><input type="text" name="mail" value="" size="30" /></td>
    </tr>
    <tr>
	<td align="right" width="25%"><?php echo $lang['misc_subject']; ?></td>
	<td><input type="text" name="subject" value="<?php echo $val['subject']; ?>" size="30" /></td>
    </tr>
    <tr>
	<td align="right" width="25%"><?php echo $lang['misc_emoticon']; ?></td>
	<td>
	    <select name="emoticon">
		<?php echo $val['emots_opts']; ?>
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
