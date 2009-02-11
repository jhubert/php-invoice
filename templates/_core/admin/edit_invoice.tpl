<form name="editinvoice" method="post" action="edit_invoice.php">
  <table class="content" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <th colspan="2"><?=$lang['invoice_values']?></th>
    </tr>
    <tr class="odd">
      <td class="req"><?=$lang['client']?> :</td>
      <td>
        <input type="hidden" name="id" value="<?=$invoiceID?>">
        <input type="hidden" name="posted" value="1">
        <input type="hidden" name="isnew" value="<?=$isnew?>">
        <select name="clientid">
          <? foreach($clients as $value=>$option): ?>
          <option value="<?=$value?>"<?=($value == $invoice['clientid'])?' selected':''?>> 
          <?=$option?>
          </option>
          <? endforeach; ?>
        </select>
        <a href="#" onClick="document.location='edit_invoice.php?cid='+clientid.options[clientid.selectedIndex].value;"><?=$lang["load_defaults"]?></a>
      </td>
    </tr>
    <tr class="odd">
      <td class="req"><?=$lang['invoice_num']?> :</td>
      <td>
      <? if ($isnew) : ?>
        <input type="text" name="invoice_num" value="<?=$invoice['invoice_num']?>">
	<? else: ?>
        <input type="hidden" name="invoice_num" value="<?=$invoice['invoice_num']?>"><?=$invoice['invoice_num']?>
    <? endif; ?>
      </td>
    </tr>

    <tr class="odd">
      <td class="req"><?=$lang['issue_date']?> :</td>
      <td>
        <input type="text" name="issue_date" value="<?=$invoice['issue_date']?>"> (mm/dd/yyyy)
      </td>
    </tr>
    <tr class="odd">
      <td class="req"><?=$lang['due_date']?> :</td>
      <td>
        <input type="text" name="due_date" value="<?=$invoice['due_date']?>"> (mm/dd/yyyy)
      </td>
    </tr>
    <tr class="odd">
      <td class="leftvalue"><?=$lang['status']?> :</td>
      <td>
        <select name="curr_status">
          <? foreach($invoiceStatus as $value): ?>
          <option value="<?=$value?>"<?=($value == $invoice['curr_status'])?' selected':''?>> 
          <?=$value?>
          </option>
          <? endforeach; ?>
        </select>
      </td>
    </tr>
  </table>
  <table class="content" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <th colspan="2"><?=$lang['invoice_items']?></th>
    </tr>
    <tr class="odd">
      <td colspan=2>
        <table class="content" border="0" cellspacing="0" cellpadding="0">
        <tr class="odd">
        <td><b><?=$lang['description']?></b></td>
        <td><b><?=$lang['qty']?></b></td>
        <td><b><?=$lang['cost']?></b></td>
        <td><b><?=$lang['total']?></b></td>
        <td><b><?=$lang['del']?></b></td>
        </tr>
        <? 
        foreach($invoice['items'] as $item): ?>
        <tr>
        <td class="lineitem"><?=$item['details']?></td>
        <td class="lineitem"><?=$item['qty']?></td>
        <td class="lineitem"><?=$item['cost']?></td>
        <td class="lineitem"><?=number_format($item['cost']*$item['qty'],2)?></td>
        <td class="lineitem"><input type="checkbox" name="delItem[]" value="<?=$item['invoiceitemid']?>"></td>
        </tr>
        <? endforeach; ?>
        <tr>
        <td><input type="text" name="newItemDetails" size=40></td>
        <td><input type="text" name="newItemQty" size=4></td>
        <td><input type="text" name="newItemCost" size=10></td>
        <td><input type="submit" name="addNewItem" value="<?=$lang['add_new']?>"></td>
        <td><input type="submit" name="delItems" value="<?=$lang['delete']?>"></td>
        </tr>
        </table>
      </td>
    </tr>
  </table>
  <table class="content" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <th colspan="2"><?=$lang['invoice_details']?></th>
    </tr>
    <tr class="odd">
      <td class="leftvalue"><?=$lang['sub_total']?> :</td>
      <td>
        <input type="text" name="cost" value="<?=$invoice['cost']?>" size="10" maxlength="10" onBlur="updateTotal();"><?=$SYSTEM["regional"]["currency_sym"]?>
      </td>
    </tr>
    <tr class="odd">
      <td class="leftvalue"><?=$lang['tax']?> :</td>
      <td>
        <input type="text" name="tax" value="<?=$invoice['tax']?>" size="3" maxlength="5" onBlur="updateTotal();">%
      </td>
    </tr>
    <tr class="odd">
      <td class="leftvalue"><?=$lang['tax2']?> :</td>
      <td>
        <input type="text" name="tax2" value="<?=$invoice['tax2']?>" size="3" maxlength="5" onBlur="updateTotal();">%
      </td>
    </tr>	
    <tr class="odd">
      <td class="leftvalue"><?=$lang['shipping']?> :</td>
      <td>
        <input type="text" name="shipping" value="<?=$invoice['shipping']?>" size="8" maxlength="10" onBlur="updateTotal();"><?=$SYSTEM["regional"]["currency_sym"]?>
      </td>
    </tr>
    <tr class="odd">
      <td class="leftvalue"><?=$lang['total']?> :</td>
      <td>
        <input type="text" name="disp_total" value="<?=number_format(($invoice['cost']+$invoice['shipping'])*(1+($invoice['tax']/100))*(1+($invoice['tax2']/100)),2)?>" size="8" maxlength="6" disabled><?=$SYSTEM["regional"]["currency_sym"]?>
      </td>
    </tr>
  </table>
  <table class="content" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <th colspan="2"><?=$lang['extra_information']?></th>
    </tr>
    <tr class="odd">
      <td class="leftvalue"><?=$lang['terms']?> : </td>
      <td>
        <textarea name="terms" rows="4" cols="50"><?=$invoice['terms']?></textarea>
      </td>
    </tr>
    <tr class="odd">
      <td class="leftvalue"><?=$lang['comments']?> : </td>
      <td>
        <textarea name="comments" rows="4" cols="50"><?=$invoice['comments']?></textarea>
      </td>
    </tr>
    <? if (!$isnew) : ?>	
    <tr class="odd">
      <td class="leftvalue"><?=$lang['reason_for_edit']?> : </td>
      <td>
        <textarea name="reason" rows="4" cols="50"></textarea>
      </td>
    </tr>
	<? endif; ?>
    <tr class="odd">
      <td class="leftvalue"><?=$lang['action']?> : </td>
      <td>
        <select name="invoice_action">
			<option><?=$lang['none']?>
			<option value="send_inv"><?=$lang['send_invoice']?>
			<option value="send_not"><?=$lang['send_email_notice']?>
			<option value="mark"><?=$lang['mark_as_paid']?>
		</select>
      </td>
    </tr>
    <tr class="odd">
      <td>&nbsp;</td>
      <td>
        <input type="Submit" name="submit" value="<?=$lang['submit']?>">
      </td>
    </tr>
  </table>
  <p>&nbsp; </p>
</form>

<SCRIPT LANGUAGE="JavaScript">
<!--
function updateTotal() {
    fn = editinvoice;

    fn.disp_total.value = Math.round(((1*fn.cost.value) + (1*fn.shipping.value)) * (1+(fn.tax.value/100)) * (1+(fn.tax2.value/100))*100)/100;
}
//-->
</SCRIPT>