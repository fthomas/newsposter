
<!-- $Id: preview.inc 56 2003-02-11 19:43:43Z mrfrost $ -->
<table align="center" style="border: solid 1px black" cellspacing="0" cellpadding="5">
    <tr>
	<td colspan="2">
	    <b><?php echo $lang['preview_head']; ?></b>
	    <p align="right"><?php echo 'Newsposter ' . VERSION; ?></p>
	</td>
    </tr>
    <tr>
	<td align="center">
	    <form action="index.php?np_act=posting_form" method="post">
		<?php echo create_sess_post(); ?>
		<input type="submit" value="<?php echo $lang['preview_edit']; ?>" />
	    </form>
	</td>
	<td align="center">
	    <form action="index.php?np_act=write" method="post">
		<?php echo create_sess_post(); ?>
		<input type="submit" value="<?php echo $lang['preview_save']; ?>" />
	    </form>
	</td>
    </tr>
</table>
<br /><br />
