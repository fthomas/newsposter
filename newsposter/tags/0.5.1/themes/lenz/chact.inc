
<!-- $Id: chact.inc 56 2003-02-11 19:43:43Z mrfrost $ -->
<form action="index.php?np_act=chact_dispatch" method="post">
<?php echo create_sess_post(); ?>
<table align="center" width="60%" style="border: solid 1px black" cellspacing="0" cellpadding="5">
    <tr>
	<td colspan="2" bgcolor="#DFDFDF">
	    <b><?php echo $lang['radio_text']; ?></b>
    </tr>
    <tr>
	<td width="25%" align="right">
	    <?php echo $radio_buttons['write']; ?>
	</td>
	<td><?php echo $lang['radio_write']; ?></td>
    </tr>
    <tr>
	<td width="25%" align="right">
	    <?php echo $radio_buttons['edit']; ?>
	</td>
	<td><?php echo $lang['radio_edit']; ?></td>
    </tr>
    <tr>
	<td width="25%" align="right">
	    <?php echo $radio_buttons['delete']; ?>
	</td>
	<td><?php echo $lang['radio_delete']; ?></td>
    </tr>
    <tr>
        <td>&nbsp;</td>
	<td align="left">
	    <input type="submit" value="<?php echo $lang['radio_submit']; ?>" />
	</td>
    </tr>
</table>
</form>
<br /><br />
