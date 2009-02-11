<?=($message)?"<h4>$message</h4>":''?>
<p align=right>
<form method="GET" action="search.php">
<input type="hidden" name="sub" value="client">
<input type="hidden" name="quick_search" value="true">
<?=$lang['quick_search']?> <input type="textbox" name="query"> <?=$lang['in']?> 
<select name="criteria">
<option value="username"><?=$lang['username']?>
<option value="company"><?=$lang['company']?>
<option value="firstName"><?=$lang['first_name']?>
<option value="lastName"><?=$lang['last_name']?>
<option value="ref"><?=$lang['ref_key']?>
</select>
<input type="submit" value="<?=$lang['go']?>"></p>

<table class="content" border=0 cellspacing=0 cellpadding=0 align="center">
<tr>
	<th><b><?=$lang['company']?></b></th>
    <th><b><?=$lang['username']?></b></th>
	<th><b><?=$lang['ref_key']?></b></th>
	<th><b><?=$lang['invoice_count']?></b></th>
	<th>&nbsp;</th>
    <th>&nbsp;</th>
	<th>&nbsp;</th>
	<th>&nbsp;</th>
</tr>
<? 
$x = 0;
foreach($clients as $client):
$cls = ($x % 2 == 0) ? 'odd' : 'even';
$x++;
?>
<tr class="<?=$cls?>" onmouseover="this.className='over'" onmouseout="this.className='<?=$cls?>'">
	<td><a href="view_client.php?id=<?=$client['clientid']?>"><b><?=$client['company']?></b></a></td>
    <td><?=$client['username']?></td>
	<td><?=$client['ref']?></td>
	<td><?=$client['invoicecount']?></td>
	<td align="center"><a href="edit_invoice.php?cid=<?=$client['clientid']?>"><?=$lang['new_invoice']?></a></td>
	<td align="center"><a href="view_client.php?id=<?=$client['clientid']?>"><?=$lang['view']?></a></td>
    <td align="center"><a href="edit_client.php?id=<?=$client['clientid']?>"><?=$lang['edit']?></a></td>
	<td align="center"><a href="clients.php?disp=<?=$display?>&del=1&id=<?=$client['clientid']?>" onClick="return confirm('<?=$lang['confirm_delete']?>')"><?=$lang['del']?></a></td>
</tr>
<? endforeach; ?>
</table>
<p><a href="edit_client.php"><?=$lang['add_new_client']?></a></p>