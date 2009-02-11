<? if ($clientID) : ?>
<p><a href="view_client.php?id=<?=$clientID?>"><?=$lang['return_client_details']?></a></p>
<? endif; ?>
<p><a href="add_payment.php?cid=<?=$clientID?>"><?=$lang["add_payment"]?></a></p>
<table border="0" cellpadding="0" cellspacing="0" class="content">
<tr> 
  <th width="200"><?=$lang['date']?></th>
  <th><?=$lang['company']?></th>
  <th><?=$lang['invoice_num']?></th>
  <th><?=$lang['amount']?></th>
  <th><?=$lang['method']?></th>
  <th>&nbsp;</th>
</tr>
<? 
if (count($payments)) :
    foreach($payments as $payment) : ?>
<tr class="even"> 
  <td width="200"><?=$payment['made_on']?></td>
  <td><a href='view_client.php?id=<?=$payment['clientid']?>'><?=$payment['company']?></a></td>
  <td><a href="<?=$SITE_ROOT?>admin/invoice.php?id=<?=$payment['invoiceid']?>"><?=$payment['invoice_num']?></a></td>
  <td><?=$payment['amount']?></td>
  <td><?=$payment['method']?></td>
  <td><a href="payments.php?cid=<?=$clientID?>&id=<?=$payment['paymentid']?>&delete=1" onClick="return confirm('Are you sure?\n\nThis action is not reversible.\nAlso, it will not make any changes to the associated Invoice.\n\nDo you wish you continue?')"><?=$lang['delete']?></a></td>
</tr>
<? endforeach; 
else:
?>
<tr class="even"> 
  <td colspan="7"><?=$lang['no_results']?></td>
</tr>
<? endif; ?>
</table>