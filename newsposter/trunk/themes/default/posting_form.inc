
<!-- $Id$ -->
<br /><br />
<form action="index.php?np_act=preview" method="post">
<table border="1" width="50%" align="center" cellspacing="1" cellpadding="5">
    <tr>
	<td colspan="2">
	    <b><?php echo $lang['perform_head']; ?></b>
	    <p align="right"><?php echo 'Newsposter ' . VERSION; ?></p>
	</td>
    </tr>
    <tr>
	<td align="right" width="25%"><?php echo $lang['misc_name']; ?></td>
	<td><input type="text" name="name" value="<?php echo $form['name']; ?>" <?php echo $form['name_add']; ?> size="30" /></td>
    <tr>
    <tr>
	<td align="right" width="25%"><?php echo $lang['misc_mail']; ?></td>
	<td><input type="text" name="mail" value="<?php echo $form['mail']; ?>" size="30" /></td>
    </tr>
    <tr>
	<td align="right" width="25%"><?php echo $lang['misc_subject']; ?></td>
	<td><input type="text" name="subject" value="<?php echo $form['subject']; ?>" size="30" /></td>
    </tr>
    <tr>
	<td align="right" width="25%">
	    <?php echo $lang['misc_topic']; ?> /
	    <?php echo $lang['misc_emoticon']; ?>
	</td>
	<td>
	    <select name="topic">
		<?php echo $topic_opts; ?>
	    </select>
	    &nbsp;
	    <select name="emoticon">
		<?php echo $emots_opts; ?>
	    </select>
	</td>
    </tr>
    <tr>
	<td align="right" width="25%" valign="top"><?php echo $lang['misc_body']; ?></td>
	<td><textarea name="body" cols="30" rows="10"><?php echo $form['body']; ?></textarea></td>
    </tr>
    <tr>
	<td align="right" width="25%">
	    <input name="nl2br" value="ON" type="checkbox" <?php echo $form['nl2br_add']; ?> />
	</td>
	<td><?php echo $lang['perform_nl2br']; ?></td>
    </tr>
    <tr>
	<td colspan="2" align="right">
	    <input type="submit" value="<?php echo $lang['perform_preview']; ?>" />
	    &nbsp;
	    <input type="reset"  value="<?php echo $lang['login_reset']; ?>" />
	</td>
    </tr>
</table>
</form>
