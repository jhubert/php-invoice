<?=($message)?"<h4>$message</h4>":''?>
<?

$qstr['item'] = isset($item) ? ($item ? $item : 'status') : 'status';
$qstr['param'] = isset($param) ? $param : 0;
$qstr['value'] = isset($value) ? $value : 0;

?>
<p>
<a href="invoices.php?<?=qstrSwap($qstr,'value','pending')?>"><?=$lang['view_pending']?></a> | 
<a href="invoices.php?<?=qstrSwap($qstr,'value','fully paid')?>"><?=$lang['view_paid']?></a> | 
<a href="invoices.php?<?=qstrSwap($qstr,'value','unsent')?>"><?=$lang['view_unsent']?></a> | 
<a href="invoices.php?<?=qstrSwap($qstr,'value','overdue')?>"><?=$lang['view_overdue']?></a> |
<a href="search.php"><?=$lang['search']?></a> |
<a href="invoices.php?<?=qstrSwap($qstr,'value',0)?>"><?=$lang['view_all']?></a></p>
<p>
<table class="content" border=0 cellspacing=0 cellpadding=0>
<tr>
	<th width="40"><a href='invoices.php?<?=qstrSwap($qstr,'param','invoice_num')?>'><?=$lang['inv']?></a> <a href='invoices.php?<?=qstrSwap($qstr,'param','invoiceid')?>'><?=$lang['num_sign']?></a></th>
	<th><a href='invoices.php?<?=qstrSwap($qstr,'param','clientid')?>'><?=$lang['client']?></a></th>
	<th width="60"><a href='invoices.php?<?=qstrSwap($qstr,'param','due_date')?>'><?=$lang['due_date']?></a></th>
	<th width="70"><a href='invoices.php?<?=qstrSwap($qstr,'param','total')?>'><?=$lang['total']?></a></th>
	<th width="40"><a href='invoices.php?<?=qstrSwap($qstr,'param','curr_status')?>'><?=$lang['status']?></a></th>
	<th width="10">&nbsp;</th>
	<th width="10">&nbsp;</th>
	<th>&nbsp;</th>
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
	<td><a href='view_client.php?id=<?=$invoice['clientid']?>'><?=(strlen($invoice['company'])>20)?substr($invoice['company'],0,17).'...':$invoice['company']?></a></td>
	<td><?=$invoice['due_date']?></td>
    <!--
	<td><?=$SYSTEM['curr_symbol'] . number_format($invoice['cost'],2)?></td>
	<td><?=$SYSTEM['curr_symbol'] . number_format($invoice['tax']+$invoice['tax2'],2)?></td>
    //-->
    <td><?=$invoice['total']?></td>
	<td><?=$invoice['curr_status']?></td>
	<td align="center"><a href='invoice.php?id=<?=$invoice['invoiceid']?>'><?=strtolower($lang['view'])?></a></td>
	<td align="center"><a href='edit_invoice.php?id=<?=$invoice['invoiceid']?>'><?=strtolower($lang['edit'])?></a></td>
	<td align="center"><a href='invoices.php?del=1&id=<?=$invoice['invoiceid']?>' onClick="return confirm('Are you sure?')"><?=strtolower($lang['del'])?></a></td>
</tr>
<? endforeach; ?>
<tr align=top>
	<th>&nbsp;</th>
	<th>&nbsp;</th>
	<th><b><?=$lang['total']?>:</b></th>
    <th><b><?=$totals['total']?></b></th>
	<th>&nbsp;</th>
	<th>&nbsp;</th>
	<th>&nbsp;</th> 
	<th>&nbsp;</th> 
</tr>
</table>
<p><a href='edit_invoice.php'><?=$lang['add_new_invoice']?></a> | <a href='clients.php'><?=$lang['manage_clients']?></a>

