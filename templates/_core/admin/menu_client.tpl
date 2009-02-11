<p>
<table border=1 cellspacing=0 cellpadding=2 bordercolor=#eeeeee width=600>
<tr align=top>
	<td><b><a href='menu.php?param=invoiceid'>Invoice # </a></b></td>
	<td width="90"><b><a href='menu.php?param=date'>Date </a></b></td>
	<td width="50"><b><a href='menu.php?param=total'>Total </a></b></td>
	<td width="80"><b><a href='menu.php?param=status'>Status </a></b></td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
</tr>
<? 
foreach($invoices as $invoice) : ?>
<tr valign=top>
	<td><?=$invoice['invoiceID']?></td>
	<td><?=$invoice['due_date']?></td>
	<td><?=$SYSTEM['curr_symbol'] . $invoice['total']?></td>
	<td><?=$invoice['curr_status']?></td>
	<td>[ <a href='invoice.php?id=<?=$invoice['invoiceID']?>'>view / print</a> ]</td>
    <? if ($SYSTEM['paynow']) : ?>
	<td>[ <a href='pay_invoice.php?id=<?=$invoice['invoiceID']?>'>pay</a> ]</td>
    <? endif; ?>
</tr>
<? endforeach; ?>
</table>