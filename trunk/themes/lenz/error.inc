
<!-- $Id: error.inc 217 2004-09-14 17:46:20Z mrfrost $ -->
<table class="container" border="0" cellspacing="0" cellpadding="4">
  <tr>
    <td style="background-color:#fafafa;text-align:left">
      <?php
        printf("<span style=\"color:#CC00CC\"><b><i>%s</i></b></span>\n&nbsp;<b>%s</b>",
                    $lang['error'], $val['text_error']);
      ?>
    </td>
  </tr>
  <tr>
    <td style="text-align:center">
      <?php printf("%s <a href=\"%s\">[URL]</a>", $val['text_link'], $val['link_url']);?>
    </td>
  </tr>
</table>
<br />
