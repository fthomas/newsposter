
<!-- $Id$ -->
<form action="index.php?np_act=chact_dispatch" method="post">
<?php echo create_sess_post(); ?>
<table border="0" width="400px" align="center" cellspacing="0">
    <tr><td colspan="3" style="background-image:url(themes/np_home/images/misc/border.png)"></td></tr>
    <tr><td width="1px" style="background-image:url(themes/np_home/images/misc/border.png)"></td>
	<td width="398px">
	    <table border="0" cellspacing="5" width="100%">
		<tr>
		    <td width="35%" align="right"><?php echo $radio_buttons['write']; ?>&nbsp;</td>
		    <td><?php echo $lang['radio_write']; ?></td>
		</tr>
		<tr>
		    <td align="right"><?php echo $radio_buttons['edit']; ?>&nbsp;</td>
		    <td><?php echo $lang['radio_edit']; ?></td>
		</tr>
		<tr>
		    <td align="right"><?php echo $radio_buttons['delete']; ?>&nbsp;</td>
		    <td><?php echo $lang['radio_delete']; ?></td>
		</tr>

		<tr>
		    <td align="center" colspan="2">
			<input type="submit" value="<?php echo $lang['radio_submit']; ?>" />&nbsp;
		    </td>
		</tr>
	    </table>
        </td>
	<td width="1px" style="background-image:url(themes/np_home/images/misc/border.png)"></td></tr>
    <tr><td colspan="3" style="background-image:url(themes/np_home/images/misc/border.png)"></td></tr>
</table>
</form>
