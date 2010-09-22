
<!-- $Id: preview.inc 221 2004-09-15 21:35:23Z mrfrost $ -->
<table class="container" border="0" cellspacing="0" cellpadding="4">
  <tr>
    <td colspan="2" style="background-color:#fafafa">
      <b><?php echo $lang['preview_head']; ?></b>
    </td>
  </tr>
  <tr>
    <td style="text-align:right;width:50%">
      <form action="index.php?np_act=posting_form" method="post">
        <?php echo create_sess_post(); ?>
        <input type="submit" value="<?php echo $lang['preview_edit']; ?>" />
      </form>
    </td>
    <td style="text-align:left;width:50%">
      <form action="index.php?np_act=write" method="post">
        <?php echo create_sess_post(); ?>
        <input type="submit" value="<?php echo $lang['preview_save']; ?>" />
      </form>
    </td>
  </tr>
</table>
<br />
<br />
