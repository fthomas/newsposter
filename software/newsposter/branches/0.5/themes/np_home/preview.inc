
<!-- $Id: preview.inc 66 2003-02-14 17:11:54Z anonymous $ -->
<table border="0" width="400px" align="center" cellspacing="0">
    <tr><td colspan="3" style="background-image:url(themes/np_home/images/misc/border.png)"></td></tr>
    <tr><td width="1px" style="background-image:url(themes/np_home/images/misc/border.png)"></td>
	<td width="398px">
	    <table border="0" cellspacing="5" width="100%">
		<tr>
		    <td align="center">
			<form action="index.php?np_act=posting_form" method="post">
			<?php echo create_sess_post(); ?>
			<input type="submit" value="<?php echo $lang['preview_edit']?>" />
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
        </td>
	<td width="1px" style="background-image:url(themes/np_home/images/misc/border.png)"></td></tr>
    <tr><td colspan="3" style="background-image:url(themes/np_home/images/misc/border.png)"></td></tr>
</table>
<br />
