
<!-- $Id: search.inc 51 2003-02-02 13:14:37Z anonymous $ -->
<form action="index.php?np_act=search" method="post">
<table align="center" style="border: solid 1px black" cellspacing="0" cellpadding="5">
    <tr>
	<td>	
	    <b><?php echo $lang['search_head']; ?></b>
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
