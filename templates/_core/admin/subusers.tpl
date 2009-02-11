<?=($message)?"<h4>$message</h4>":''?>
<table class="content" border=0 cellspacing=0 cellpadding=0 align="center">
<tr>
	<th><b>Username</b></th>
    <th><b>login name</b></th>
	<th><b>Full Name</b></th>
	<th><b>ref num</b></th>
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
	<td><?=$client['firstName'] . " " . $client['lastName']?></td>
	<td><?=$client['ref']?></td>
	<td align="center"><a href="view_client.php?id=<?=$client['clientid']?>">view</a></td>
    <td align="center"><a href="edit_client.php?id=<?=$client['clientid']?>">edit</a></td>
	<td align="center"><a href="clients.php?del=1&id=<?=$client['clientid']?>" onClick="return confirm('Are you sure?')">del</a></td>
</tr>
<? endforeach; ?>
</table>
<p><a href="edit_client.php?type=">add a new sub-user</a></p>