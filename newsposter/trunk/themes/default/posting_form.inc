
<!-- $Id$ -->
<br /><br />
<form action="index.php" method="post">
<table border="1" width="50%" align="center" cellspacing="1" cellpadding="5">
    <tr>
	<td align="right" width="25%"><?php echo $lang['misc_name']; ?></td>
	<td><input type="text" name="" value="<?php echo $form['name']; ?>" <?php echo $form['name_add']; ?> size="30" /></td>
    <tr>
    <tr>
	<td align="right" width="25%"><?php echo $lang['misc_mail']; ?></td>
	<td><input type="text" name="" size="30" /></td>
    </tr>
    <tr>
	<td align="right" width="25%"><?php echo $lang['misc_subject']; ?></td>
	<td><input type="text" name="" size="30" /></td>
    </tr>
    <tr>
	<td align="right" width="25%">
	    <?php echo $lang['misc_topic']; ?> /
	    <?php echo $lang['misc_emoticon']; ?>
	</td>
	<td>
	    <select>
		<?php echo $select_opts; ?>
	    </select>
	    <select>
		<?php echo $emoticon_opts; ?>
	    </select>
	</td>
    </tr>
    <tr>
	<td align="right" width="25%" valign="top"><?php echo $lang['misc_body']; ?></td>
	<td><textarea cols="30" rows="10"></textarea></td>
    </tr>
    <tr>
	<td align="right" width="25%"><input name="" type="checkbox" /></td>
	<td><?php echo $lang['perform_nl2br']; ?></td>
    </tr>
    <tr>
	<td colspan="2" align="right">
	    <input type="submit" value="<?php echo $lang['perform_preview']; ?>" />
	    <input type="reset"  value="<?php echo $lang['login_reset']; ?>" />
	</td>
    </tr>
</table>
</form>