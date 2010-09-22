
<!-- $Id: chact.inc 56 2003-02-11 19:43:43Z mrfrost $ -->
<form action="index.php?np_act=chact_dispatch" method="post">
<?php echo create_sess_post(); ?>
<table border="1" width="50%" align="center" cellspacing="1" cellpadding="5">
    <tr>
	<td colspan="2">
	    <b><?php echo $lang['radio_text']; ?></b>
	    <p align="right"><?php echo 'Newsposter ' . VERSION; ?></p></td>
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
