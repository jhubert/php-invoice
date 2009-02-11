<?=isset($message) ? $message : ''?>
<table width="100%" border="0" cellspacing="10" cellpadding="0">
  <tr>
    <td>
      <table class="content" border="0" cellspacing="0" cellpadding="0">
        <form action="editfile.php" method="post">
        <tr>
          <th><?=$page?></th>
        </tr>
        <tr>
          <td><textarea name="content" cols="100" rows="20" style="width: 100%"><?=$content?></textarea></td>
        </tr>
        <tr>
          <td><input type="submit" name="btnSubmit" value="<?=$lang['submit']?>"><input type="hidden" name="page" value="<?=$page?>"><input type="hidden" name="template" value="<?=$template?>"></td>
        </tr>
        </form>
      </table>
    </td>
  </tr>
</table>
