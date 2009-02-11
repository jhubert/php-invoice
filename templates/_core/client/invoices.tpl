<?=$message?>
<p>
<a href="invoices.php?item=status&value=pending"><?=$lang['view_pending']?></a> | 
<a href="invoices.php?item=status&value=fully paid"><?=$lang['view_paid']?></a> | 
<a href="invoices.php?item=status&value=overdue"><?=$lang['view_overdue']?></a> |
<a href="invoices.php"><?=$lang['view_all']?></a></p>
<p>
<table class="content" border=0 cellspacing=0 cellpadding=0>
<tr>
	<th width="40"><a href='invoices.php?param=invoice_num&item=<?=$item?>&value=<?=$value?>'><?=$lang['inv']?></a> <a href='invoices.php?param=invoiceid&item=<?=$item?>&value=<?=$value?>'><?=$lang['num_sign']?></a></th>
	<th width="60"><a href='invoices.php?param=due_date&item=<?=$item?>&value=<?=$value?>'><?=$lang['due_date']?></a></th>
	<th width="70"><a href='invoices.php?param=total&item=<?=$item?>&value=<?=$value?>'><?=$lang['total']?></a></th>
	<th width="40"><a href='invoices.php?param=curr_status&item=<?=$item?>&value=<?=$value?>'><?=$lang['status']?></a></th>
	<th width="10">&nbsp;</th>
	<th width="10">&nbsp;</th>
	<th width="10">&nbsp;</th>
</tr>
<?
$x = 0;
foreach($invoices as $invoice):
$cls = ($x % 2 == 0) ? 'odd' : 'even';
if ($invoice['curr_status'] == 'overdue') $cls='overdue';
$x++;
?>
<tr class="<?=$cls?>" onmouseover="this.className='over'" onmouseout="this.className='<?=$cls?>'">
	<td><?=$invoice['invoice_num']?></td>
	<td><?=$invoice['due_date']?></td>
    <!--
	<td><?=$SYSTEM['curr_symbol'] . number_format($invoice['cost'],2)?></td>
	<td><?=$SYSTEM['curr_symbol'] . number_format($invoice['tax']+$invoice['tax2'],2)?></td>
    //-->
    <td><?=$invoice['total']?></td>
	<td><?=$invoice['curr_status']?></td>
	<td align="center"><a href='<?=$SITE_ROOT?>client/invoice.php?id=<?=$invoice['invoiceid']?>'><?=strtolower($lang['view'])?></a></td>
	<td align="center"><? if ($invoice['pay']) { ?> <a href='<?=$SITE_ROOT?>client/pay_invoice.php?id=<?=$invoice['invoiceid']?>'><?=strtolower($lang['pay'])?></a> <? } ?></td>
	<td align="center"><a href="<?=$SITE_ROOT?>print.php?id=<?=$invoice['invoiceid']?>" onClick="window.open(this.href,'printWindow','width=10,height=10');return false;"><?=strtolower($lang['print'])?></a></td>
</tr>
<? endforeach; ?>
<tr align=top>
	<th>&nbsp;</th>
	<th>&nbsp;</th>
	<th>&nbsp;</th>
	<th>&nbsp;</th>
	<th>&nbsp;</th>
	<th>&nbsp;</th> 
	<th>&nbsp;</th>
</tr>
</table>
