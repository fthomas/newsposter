
<!-- $Id$ -->
<form action="index.php?np_act=search" method="post">
<table class="container" border="0" cellspacing="0" cellpadding="4">
  <tr>
    <td style="background-color:#fafafa">
      <b><?php echo $lang['search_head']; ?></b>
    </td>
  </tr>
  <tr>
    <td style="text-align:center">
      <?php echo $lang['search_text']; ?>&nbsp;
      <input type="text" name="search_str" size="15" />&nbsp;
      <?php echo $lang['search_in']; ?>&nbsp;
      <select name="search_index">
        <option value="all"><?php echo $lang['search_all']; ?></option>
        <option value="news"><?php echo $lang['search_news']; ?></option>
        <option value="comments"><?php echo $lang['search_comment']; ?></option>
      </select>
    </td>
  </tr>
</table>
</form>
<br />
<br />
