<p>
<a href="invoices.php?item=status&value=pending"><?=$lang['view_pending']?></a> | 
<a href="invoices.php?item=status&value=fully paid"><?=$lang['view_paid']?></a> | 
<a href="invoices.php?item=status&value=unsent"><?=$lang['view_unsent']?></a> | 
<a href="invoices.php?item=status&value=overdue"><?=$lang['view_overdue']?></a> |
<a href="invoices.php"><?=$lang['view_all']?></a></p>
<p>
<p><?=$lang['enter_search_criteria']?></p>
<p><form method="get" action="search.php">
<input type="hidden" name="sub" value="invoice">
<?=$lang['search_for']?> <input type="textbox" name="query" value=""> <?=$lang['in']?> 
<select name="criteria">
<option value="invoice_num"><?=$lang['invoice_num']?>
<option value="issue_date"><?=$lang['sel_sent_date']?>
<option value="due_date"><?=$lang['sel_due_date']?>
<option value="clientID"><?=$lang['client_id']?>
</select>
<input type="submit" value="Search">
</form></p>
<?=$message?>
<p>
<table class="content" border=0 cellspacing=0 cellpadding=0>
<tr>
	<th width="40"><b><a href='search.php?sub=invoice&param=invoice_num<?=$search_params?>'><?=$lang['inv']?> </a><a href='search.php?sub=invoice&param=invoiceID<?=$search_params?>'><?=$lang['num_sign']?></a></b></th>
	<th><b><a href='search.php?sub=invoice&param=clientid<?=$search_params?>'><?=$lang['client']?></a></b></th>
	<th width="60"><b><a href='search.php?sub=invoice&param=due_date<?=$search_params?>'><?=$lang['due_date']?></a></b></th>
	<th width="70"><b><a href='search.php?sub=invoice&param=total<?=$search_params?>'><?=$lang['total']?></a></b></th>
	<th width="40"><b><a href='search.php?sub=invoice&param=curr_status<?=$search_params?>'><?=$lang['status']?></a></b></th>
	<th width="10">&nbsp;</th>
	<th width="10">&nbsp;</th>
	<th>&nbsp;</th>
</tr>
<?
if (isset($search_results)) {
	$x = 0;
	foreach($search_results as $invoice):
		$cls = ($x % 2 == 0) ? 'odd' : 'even';
		if (($x >= $p_start)&&($x < $p_end)) {
?>
<tr class="<?=$cls?>" valign=top>
	<td><?=$invoice['invoice_num']?></td>
<td><?=(strlen($invoice['company'])>20)?substr($invoice['company'],0,17).'...':$invoice['company']?></td>
	<td><?=$invoice['due_date']?></td>
    <td><?=$invoice['total']?></td>
	<td><?=$invoice['curr_status']?></td>
	<td align="center"><a href='invoice.php?id=<?=$invoice['invoiceid']?>'><?=$lang['view']?></a></td>
	<td align="center"><a href='edit_invoice.php?id=<?=$invoice['invoiceid']?>'><?=$lang['view']?></a></td>
	<td align="center"><a href='invoices.php?del=1&id=<?=$invoice['invoiceid']?>' onClick="return confirm('Are you sure?')"><?=$lang['del']?></a></td>
</tr>
<?
        }
		$x++;
endforeach; 
}?><tr align=top>
	<th>&nbsp;</th>
	<th>&nbsp;</th>
	<th>&nbsp;</th>
    <th>&nbsp;</th>
	<th>&nbsp;</th>
    <th>&nbsp;</th>
    <th>&nbsp;</th>
	<th>&nbsp;</th>
</tr>
</table>
<?
if (isset($search_results)) {
    if ($p_start + $show >= $r_count) {
        echo $p_start . " - " . ($r_count) . " of " . $r_count;
    } else {
        echo $p_start . " - " . ($p_start + $show) . " of " . $r_count;
    }
	echo '<p>';
	if ($p_start > 0) { 
		echo '<a href="search.php?sub=invoice'.$search_params.'&page='.($page - 1).'&show='.$show.'"><< previous '.$show.'</a> ';
	} 
    echo ' | ';
	if ($p_end < ($r_count)) {
		echo '<a href="search.php?sub=invoice'.$search_params.'&page='.($page + 1).'&show='.$show.'">next '.$show.' >></a>';
	}
	echo '</p>';
}
?>
<br>
<table class="content" border=0 cellspacing=0 cellpadding=0>
<tr>
    <th colspan=2><?=$lang['total']?></th>
</tr>
<? foreach($totals as $key=>$total) : ?>
<tr class="odd"><td><?=$key?></td><td><?=$total?></td></tr>
<?
endforeach;
?>
</table>