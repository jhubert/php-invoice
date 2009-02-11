<p><a href="javascript: history.back();">&lt;&lt; &nbsp;<?=$lang['back']?></a></p>
<form action="add_payment.php" method="POST">
<table border="0" cellpadding="0" cellspacing="0" class="content">
<tr class="odd"> 
      <th colspan="2"><?=$lang['add_payment']?></th>
</tr>
<tr class="odd"> 
  <td class="leftvalue"><?=$lang['client']?> : </td>
  <td>
  <? if (isset($clients)) : ?>
    <select name="client" onChange="document.location='add_payment.php?cid='+this.options[this.selectedIndex].value;">
        <option>Select Client</option>
      <? foreach($clients as $id=>$client) : ?>
            <option value="<?=$id?>"><?=$client?></option>
      <? endforeach; ?>
    </select>
  <? else : ?>
      <?=$client?>
  <? endif; ?>
</td>
</tr>
<tr class="odd"> 
  <td class="leftvalue"><?=$lang['invoice']?> : </td>
  <td>
  <? if (isset($invoice_num)) : 
        echo $invoice_num;
  ?>
  <input type="hidden" name="invoiceid" value="<?=$invoiceid?>">    
  <? elseif (isset($invoices)) : ?>
  <select name="invoiceid">
  <? foreach($invoices as $id=>$invoice) : ?>
        <option value="<?=$id?>"><?=$invoice?></option>
  <? endforeach; ?>
  </select>
  <? else : ?>
    Please select a client.
  <? endif; ?>
  </td>
</tr>
<tr class="odd"> 
  <td class="leftvalue"><?=$lang['amount']?> : </td>
  <td><input name="amount" type="text"> 
  </td>
</tr>
<tr class="odd">
  <td class="leftvalue"><?=$lang['method']?> : </td>
  <td><input name="method" type="text"> 
  </td>
</tr>
<tr class="odd"> 
  <td class="leftvalue">&nbsp;<input type="hidden" name="cid" value="<?=$clientID?>"></td>
  <td><input name="submit" type="Submit" id="submit" value="<?=$lang['submit']?>"> 
  </td>
</tr>
</table>
</form>