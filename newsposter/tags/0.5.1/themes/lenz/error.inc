
<!-- $Id: error.inc 48 2003-01-23 22:50:58Z mrfrost $ -->
<table align="center" width="60%" style="border: solid 1px black" cellspacing="0" cellpadding="5">
    <tr>
        <td align="left" bgcolor="#DFDFDF">
            <?php
                printf("<font color=\"#CC00CC\"><b><i>%s</i></b></font>\n&nbsp;<b>%s</b>",
                    $lang['error'], $val['text_error']);
            ?>
        </td>
    </tr>
    <tr>
        <td align="center">
            <?php
                printf("%s <a href=\"%s\">[URL]</a>", $val['text_link'], $val['link_url']);
            ?>
        </td>
    </tr>
</table>
<br /><br />
