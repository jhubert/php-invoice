<table class="content">
<tr>
<th>Invoice Information</th>
</tr>
<tr>
<td>
<table width="400" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td width="137"><b><?=$lang['reference']?>:</b></td>
    <td width="113"> 
      <?=$client['ref']?>_<?=$invoice['invoiceid']?>
    </td>
  </tr>
  <tr> 
    <td width="137"><b><?=$lang['today_date']?>:</b></td>
    <td width="113"> 
      <?=date($SYSTEM['regional']['datetime'])?>
    </td>
  </tr>
  <tr> 
    <td width="137"><b><?=$lang['total_amount']?>:</b></td>
    <td width="113"> 
      <?=$invoice['total']?>
    </td>
  </tr>
</table>
</td>
</tr>
<? foreach($gates as $key=>$gate) : ?>
<tr>
<th><?=$key?></th>
</tr>
<tr>
<td><?=$gate?></td>
</tr>
<? endforeach; ?>
</table>
<br>
<br>