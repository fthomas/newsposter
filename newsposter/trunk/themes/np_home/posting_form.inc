
<!-- $Id$ -->
<form action="index.php?np_act=preview" method="post">
<?php echo create_sess_post(); ?>
<table border="0" width="400px" align="center" cellspacing="0">
    <tr><td colspan="3" background="themes/np_home/images/misc/border.png"></td></tr>
    <tr><td width="1px" background="themes/np_home/images/misc/border.png"></td>
	<td width="398px">
	    <table border="0" cellspacing="5" width="100%">
		<tr>
		    <td><?php echo $lang['misc_name']; ?></td>
		    <td><input type="text" name="name" value="<?php echo $form['name']; ?>" size="20" /></td>
		</tr>
		<tr>
		    <td><?php echo $lang['misc_mail']; ?></td>
		    <td><input type="text" name="mail" value="<?php echo $form['mail']; ?>" size="20" /></td>
		</tr>
		<tr>
		    <td><?php echo $lang['misc_subject']; ?></td>
		    <td><input type="text" name="subject" value="<?php echo $form['subject']; ?>" size="20" /></td>
		</tr>
		<tr>
		    <td>
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
		    <td valign="top"><?php echo $lang['misc_body']; ?></td>
		    <td>
			<textarea name="body" cols="30" rows="10"><?php echo $form['body']; ?></textarea>
		    </td>
		</tr>
		<tr>
		    <td colspan="2" align="right">
			<input type="checkbox" name="nl2br" value="ON" <?php echo $form['nl2br_add']; ?> /> &nbsp;
			<?php echo $lang['perform_nl2br']; ?>
		    </td>
		</tr>
		<tr>
		    <td colspan="2" align="right">
		    <input type="submit" value="<?php echo $lang['perform_preview']; ?>" />
		    &nbsp;
		    <input type="reset" value="<?php echo $lang['login_reset']; ?>" />
		    </td>
		</tr>
	    </table>
        </td>
	<td width="1px" background="themes/np_home/images/misc/border.png"></td></tr>
    <tr><td colspan="3" background="themes/np_home/images/misc/border.png"></td></tr>
</table>
</form>
