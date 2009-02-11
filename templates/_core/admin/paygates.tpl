<?=isset($message)?($message)?"<h4>$message</h4>":'':''?>
<form action="paygates.php" method="post">
<? foreach($paygates as $paygate) : 
$active = ($paygate['enabled']=='yes') ? ' checked' : '';
?>
<table border="0" cellpadding="0" cellspacing="0" class="content">
<tr> 
  <th colspan="2"><?=$paygate['company']?></th>
</tr>
<tr class="odd"> 
    <td class="leftvalue"><?=strtolower($lang["enabled"])?></td>
    <td><input type="checkbox" name="<?=$paygate['paygateid'] . '_enabled'?>" value="1"<?=$active?> /></td>
</tr>
<? foreach(split(',',$paygate['variables']) as $var) : ?>
<tr class="odd"> 
    <td class="leftvalue"><?=$var?></td>
    <td><input type="text" name="<?=$paygate['paygateid'] . '_' . $var?>" value="<?=$paygate['values'][$var]?>" size="40" /></td>
</tr>
<? endforeach; ?>
</table><br>
<? endforeach; ?>
<input type="submit" name="submit" value="Update" />&nbsp;
<input type="button" name="cancel" value="Cancel" onClick="history.back()" />
</form>