
<!-- $Id$ -->
<br /><br />
<form action="index.php?np_act=chact_dispatch" method="post">
<table border="1" width="50%" align="center" cellspacing="1" cellpadding="5">
    <tr>
	<td colspan="2"><?php echo $lang['radio_text']; ?><br /><br /></td>
    </tr>
    <tr>
	<td width="20%" align="right">
	    <?php echo $radio_buttons['write']; ?>
	</td>
	<td><?php echo $lang['radio_write']; ?></td>
    </tr>
    <tr>
	<td width="20%" align="right">
	    <?php echo $radio_buttons['edit']; ?>
	</td>
	<td><?php echo $lang['radio_edit']; ?></td>
    </tr>
    <tr>
	<td width="20%" align="right">
	    <?php echo $radio_buttons['delete']; ?>
	</td>
	<td><?php echo $lang['radio_delete']; ?></td>
    </tr>
    <tr>
	<td colspan="2" align="center">
	    <input type="submit" value="<?php echo $lang['radio_submit']; ?>" />
	</td>
    </tr>
</table>
</form>