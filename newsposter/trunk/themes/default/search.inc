
<!-- $Id$ -->
<form action="index.php?np_act=search" method="post">
<table border="1" width="50%" align="center" cellspacing="1" cellpadding="5">
    <tr>
	<td>	
	    <b><?php echo $lang['search_head']; ?></b>
	    <p align="right"><?php echo 'Newsposter ' . VERSION; ?></p>
	</td>
    </tr>
    <tr>
	<td align="center">
	    <?php echo $lang['search_text']; ?>&nbsp;
	    <input type="text" />
	    <?php echo $lang['search_in']; ?>
	    <select name="search_val">
		<option><?php echo $lang['search_all']; ?></option>
		<option><?php echo $lang['search_news']; ?></option>
		<option><?php echo $lang['search_comment']; ?></option>
	    </select>
	</td>
    </tr>
</table>
</form>

