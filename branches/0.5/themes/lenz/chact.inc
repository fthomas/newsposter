
<!-- $Id: chact.inc 220 2004-09-15 21:16:12Z mrfrost $ -->
<form action="index.php?np_act=chact_dispatch" method="post">
<p style="display:none"><?php echo create_sess_post(); ?></p>
<table class="container" border="0" cellspacing="0" cellpadding="4">
  <tr>
    <td colspan="2" style="background-color:#fafafa">
      <b><?php echo $lang['radio_text']; ?></b>
    </td>
  </tr>
  <tr>
    <td style="text-align:right;width:25%">
      <?php echo $radio_buttons['write']; ?>
    </td>
    <td><?php echo $lang['radio_write']; ?></td>
  </tr>
  <tr>
    <td style="text-align:right;width:25%">
     <?php echo $radio_buttons['edit']; ?>
    </td>
    <td><?php echo $lang['radio_edit']; ?></td>
  </tr>
  <tr>
    <td style="text-align:right;width:25%">
      <?php echo $radio_buttons['delete']; ?>
    </td>
    <td><?php echo $lang['radio_delete']; ?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td style="text-align:left">
      <input type="submit" value="<?php echo $lang['radio_submit']; ?>" />
    </td>
  </tr>
</table>
</form>
<br />
