
<!-- $Id: posting_sel.inc 56 2003-02-11 19:43:43Z mrfrost $ -->
<?php echo create_sess_post(); ?>
<table align="center" width="60%" style="border: solid 1px black" cellspacing="0" cellpadding="5">
    <tr>
        <td bgcolor="#DFDFDF" colspan="2">
            <?php printf("<b>%s</b>", $lang['misc_selection']); ?>
        </td>
    </tr>
    <tr>
	<td width="50%" align="right">
	    <input type="submit" value="<?php echo $submit_text; ?>" />
	</td>
	<td width="50%" align="left">
	    <input type="reset" value="<?php echo $lang['login_reset']; ?>" />
	</td>
    </tr>
</table>
<br /><br />
