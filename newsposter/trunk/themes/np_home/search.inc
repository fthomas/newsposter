
<!-- $Id$ -->
<form action="index.php?np_act=search" method="post">
<table border="0" width="400px" align="center" cellspacing="0">
    <tr><td colspan="3" background="themes/np_home/images/misc/border.png"></td></tr>
    <tr><td width="1px" background="themes/np_home/images/misc/border.png"></td>
	<td width="398px">
	    <table border="0" cellspacing="5" width="100%">
		<tr>
		    <td><?php echo $lang['search_text']; ?></td>
		    <td><input type="text" name="search_str" size="15" /></td>
		    <td><?php echo $lang['search_in']; ?></td>
		    <td>
			<select name="search_index">
			    <option value="all"><?php echo $lang['search_all']; ?></option>
			    <option value="news"><?php echo $lang['search_news']; ?></option>
			    <option value="comments"><?php echo $lang['search_comment']; ?></option>
			</select>
		    </td>
		</tr>
	    </table>
        </td>
	<td width="1px" background="themes/np_home/images/misc/border.png"></td></tr>
    <tr><td colspan="3" background="themes/np_home/images/misc/border.png"></td></tr>
</table>
</form>
<br />
