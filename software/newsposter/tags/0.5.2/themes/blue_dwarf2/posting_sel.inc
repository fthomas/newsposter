
<!-- $Id$ -->
<div class="container">
<p style="display:none"><?php echo create_sess_post(); ?></p>
<table style="width:100%" border="0" cellspacing="0" cellpadding="4">
  <tr>
    <td colspan="2" style="background-color:#fafafa">
      <?php printf("<b>%s</b>", $lang['misc_selection']); ?>
    </td>
  </tr>
  <tr>
    <td style="text-align:right;width:50%">
      <input type="submit" value="<?php echo $submit_text; ?>" />
    </td>
    <td style="text-align:left;width:50%">
      <input type="reset" value="<?php echo $lang['login_reset']; ?>" />
    </td>
  </tr>
</table>
</div>
<div>
<br />
<br />
</div>