
<!-- $Id$ -->
<br />
<a name="form" />

<form action="<?php echo $val['index']; ?>" method="post">
<input type="hidden" name="ref" value="<?php echo $val['msgid']; ?>" />
<table class="comment_form" border="0" cellspacing="0" cellpadding="4">
  <tr style="background-color:#fafafa">
    <td colspan="2"><b><?php echo $lang['comment_head']; ?></b></td>
  </tr>
  <tr>
    <td style="text-align:right;width:25%"><?php echo $lang['misc_name']; ?></td>
    <td><input type="text" name="name" value="<?php echo $val['name']; ?>" <?php echo $val['name_add']; ?> size="30"></td>
  </tr>
  <tr>
    <td style="text-align:right;width:25%"><?php echo $lang['misc_mail']; ?></td>
    <td><input type="text" name="mail" value="<?php echo $val['name']; ?>" size="30"></td>
  </tr>
  <tr>
    <td style="text-align:right;width:25%"><?php echo $lang['misc_subject']; ?></td>
    <td><input type="text" name="subject" value="<?php echo $val['subject']; ?>" size="30" /></td>
  </tr>
  <tr>
    <td style="text-align:right;width:25%"><?php echo $lang['misc_emoticon']; ?></td>
    <td>
      <select name="emoticon">
        <?php echo $val['emots_opts']; ?>
      </select>
    </td>
  </tr>
  <tr>
    <td style="text-align:right;width:25%;vertical-align:top"><?php echo $lang['misc_comment']; ?></td>
    <td><textarea name="body" cols="40" rows="10"></textarea></td>
  </tr>
  <tr>
    <td colspan="2" style="text-align:center">
      <input type="submit" value="<?php echo $lang['comment_send']; ?>" /> 
      <input type="reset"  value="<?php echo $lang['login_reset']; ?>" />
    </td>
  </tr>
</table>
</form>
<br />
