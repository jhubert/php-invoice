<?=$message?>
<p>
<a href="invoices.php">View All</a> | 
<a href="invoices.php?item=status&value=pending">View Pending</a> | 
<a href="invoices.php?item=status&value=fully paid">View Paid</a> | 
<a href="invoices.php?item=status&value=unsent">View Unsent</a> | 
<a href="invoices.php?item=status&value=outstanding">View Outstanding</a></p>
<p>
<table class="content" border=0 cellspacing=0 cellpadding=0>
<tr>
	<th width="40"><b><a href='invoices.php?param=invoice_num'>Inv </a><a href='invoices.php?param=invoiceID'>#</a></b></th>
	<th><b><a href='invoices.php?param=clientid'>Client</a></b></th>
	<th width="60"><b><a href='invoices.php?param=due_date'>Date</a></b></th>
	<th width="70"><b><a href='invoices.php?param=total'>Total</a></b></th>
	<th width="40"><b><a href='invoices.php?param=curr_status'>Status</a></b></th>
	<th width="10">&nbsp;</th>
	<th width="10">&nbsp;</th>
	<th>&nbsp;</th>
</tr>
<?
$LOC_cost = 0;
$LOC_tax = 0;
$LOC_total = 0;
$x = 0;
foreach($invoices as $invoice):
$cls = ($x % 2 == 0) ? 'odd' : 'even';
$x++;
$LOC_cost = $LOC_cost + $invoice['cost'];
$LOC_tax = $LOC_tax + ($invoice['cost']*($invoice['tax']/100));
$LOC_total = $LOC_total + $invoice['total'];
?>
<tr class="<?=$cls?>" valign=top>
	<td><?=$invoice['invoice_num']?></td>
	<td><?=(strlen($invoice['company'])>20)?substr($invoice['company'],0,17).'...':$invoice['company']?></td>
	<td><?=date($SYSTEM['SHORT_DATE'],strtotime($invoice['due_date']))?></td>
    <!--
	<td><?=$SYSTEM['curr_symbol'] . number_format($invoice['cost'],2)?></td>
	<td><?=$SYSTEM['curr_symbol'] . number_format($invoice['tax']+$invoice['tax2'],2)?></td>
    //-->
    <td><?=$SYSTEM['curr_symbol'] . number_format($invoice['total'],2)?></td>
	<td><?=$invoice['curr_status']?></td>
	<td align="center"><a href='invoice.php?id=<?=$invoice['invoiceID']?>'>view</a></td>
	<td align="center"><a href='edit_invoice.php?id=<?=$invoice['invoiceID']?>'>edit</a></td>
	<td align="center"><a href='invoices.php?del=1&id=<?=$invoice['invoiceID']?>' onClick="return confirm('Are you sure?')">del</a></td>
</tr>
<? endforeach; ?>
<tr align=top>
	<th>&nbsp;</th>
	<th>&nbsp;</th>
	<th><b>Total:</b></th>
    <th><b><?=$SYSTEM['curr_symbol'] . number_format($LOC_total,2)?></b></th>
	<th>&nbsp;</th>
	<th>&nbsp;</th>
	<th>&nbsp;</th> 
	<th>&nbsp;</th> 
</tr>
</table>
<p><a href='edit_invoice.php'>add an invoice</a> | <a href='clients.php'>manage client profiles</a>

