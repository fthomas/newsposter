
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
	    <br />    
	    <table border="0">
		<tr>
		    <td><?php echo $lang['search_text']; ?></td>
		    <td><input type="text" name="search_str" size="15" /></td>
		    <td><?php echo $lang['search_in']; ?></td>
		    <td>
			<select name="search_index">
			    <option value="all">
				<?php echo $lang['search_all']; ?>
			    </option>
			    <option value="news">
				<?php echo $lang['search_news']; ?>
			    </option>
			    <option value="comments">
				<?php echo $lang['search_comment']; ?>
			    </option>
			</select>
		    </td>
		</tr>
	    </table>
	    <br />
	</td>
    </tr>
</table>
</form>
<br /><br />