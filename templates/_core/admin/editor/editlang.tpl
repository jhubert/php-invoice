<?=$message?>
<table width="100%" border="0" cellspacing="10" cellpadding="0">
  <tr>
    <td> 
      <table class="content" border="0" cellspacing="0" cellpadding="0">
      <form action="editlang.php" method="post">
        <tr>
          <th title="<?=$topinfo?>"><?=$language?> [?]</th>
        </tr>
        <tr>
        <td>
      <table class="content" border="0" cellspacing="0" cellpadding="0">
        <? 
        $x = 0;
        foreach($langVars as $var=>$val) : 
        $cls = ($x % 2 == 0) ? 'odd' : 'even';
        $x++;
        ?>
        <tr class="<?=$cls?>">
          <td width="200" class="leftvalue">
          <?=$var?>
          </td>
          <td>
          <input type="text" name="<?=$var?>" value="<?=str_replace('"',"&quot;",$val)?>" size="100">
          </td>
        </tr>
        <? endforeach; ?>
      </table>
        </td>
        </tr>
        <tr>
          <th><input type="submit" name="btnSubmit" value="<?=$lang['submit']?>">
          <input type="hidden" name="pass_lang" value="<?=$language?>">
          <input type="hidden" name="skip" value="btnSubmit,pass_lang,skip">
          </th>
        </tr>
        </form>
    </table>
    </td>
  </tr>
</table>