<p>Enter your search criteria below:</p>
<p>
<form method="get" action="search.php">
<input type="hidden" name="sub" value="client">
Search for <input type="textbox" name="query" value="<?=isset($_GET['query']) ? $_GET['query'] : '' ?>"> in 
<select name="criteria">
<option value="username">Username
<option value="company">Company Name
<option value="firstName">First Name
<option value="lastName">Last Name
<option value="ref">Ref Key
</select>
<input type="submit" value="Search">
</form></p>
<?=$message?>
<table class="content" border=0 cellspacing=0 cellpadding=0>
<tr>
	<th><b>Company</b></th>
    <th><b>login name</b></th>
	<th><b>Full Name</b></th>
	<th><b>Ref Num</b></th>
	<th>&nbsp;</th>
	<th>&nbsp;</th>
	<th>&nbsp;</th>
</tr>
<? 

if (isset($search_results)) {
	$x = 0;
	foreach($search_results as $client):
		$cls = ($x % 2 == 0) ? 'odd' : 'even';
		if (($x >= $p_start)&&($x < $p_end)) {
?>
<tr class="<?=$cls?>">
	<td><a href="view_client.php?id=<?=$client['clientid']?>"><b><?=$client['company']?></b></a></td>
    <td><?=$client['username']?></td>
	<td><?=$client['firstname'] . " " . $client['lastname']?></td>
	<td><?=$client['ref']?></td>
	<td align="center"><a href="view_client.php?id=<?=$client['clientid']?>">view</a></td>
    <td align="center"><a href="edit_client.php?id=<?=$client['clientid']?>">edit</a></td>
	<td align="center"><a href="clients.php?del=1&id=<?=$client['clientid']?>" onClick="return confirm('Are you sure?')">del</a></td>
</tr>
<? 
		}
		$x++;
	endforeach;
}
?>
</table>
<?
if (isset($search_results)) {
	echo '<p>';
	if ($p_start > 0) { 
		echo '<a href="search.php?sub=client'.$search_params.'&page='.($page - 1).'&show='.$show.'">previous '.$show.'</a> ';
	} 
	if ($p_end < ($r_count-1)) {
		echo '<a href="search.php?sub=client'.$search_params.'&page='.($page + 1).'&show='.$show.'">next '.$show.'</a>';
	}
	echo '</p>';
}
?>
