<?=$message?>
<p align=right>
<form method="GET" action="search.php">
<input type="hidden" name="sub" value="invoice">
<input type="hidden" name="quick_search" value="true">
<?=$lang['quick_search']?> <input type="textbox" name="query"> <?=$lang['in']?> 
<select name="criteria">
<option value="invoice_num"><?=$lang['invoice_num']?>
<option value="invoice_date"><?=$lang['sel_sent_date']?>
<option value="due_date"><?=$lang['sel_due_date']?>
<option value="clientID"><?=$lang['client_id']?>
</select>
<input type="submit" value="go"></p>
<table class="content" width="700" border=0 cellspacing=0 cellpadding=2>
<tr>
	<th colspan="2"><b><?=$lang['invoice_counts']?></b></th>
</tr>
<? 
$x=0;
foreach($count as $key=>$value): 
$cls = ($x % 2 == 0) ? 'odd' : 'even';
$x++;
?>
<tr valign=top class="<?=$cls?>">
	<td style="text-case: uppercase"><?=$key?></td>
	<td><?=$value?></td>
</tr>
<? endforeach; ?>
</table>

<table class="content" width="700" border=0 cellspacing=0 cellpadding=2>
<tr>
	<th colspan="2"><b><?=$lang['financial_figures']?></b></th>
</tr>
<? 
$x=0;
foreach($totals as $key=>$value): 
$cls = ($x % 2 == 0) ? 'odd' : 'even';
$x++;
?>
<tr valign=top class="<?=$cls?>">
	<td><?=$key?></td>
	<td>$<?=number_format($value['total'],2)?></td>
</tr>
<? endforeach; ?>
</table>