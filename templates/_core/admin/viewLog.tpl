<?=isset($message)?($message)?"<h4>$message</h4>":'':''?>
<table class="content" width="700" border=0 cellspacing=0 cellpadding=2>
<tr>
	<th><b>Date</b></th>
	<th><b>Company</b></th>
	<th><b>Action</b></th>
	<th><b>Details</b></th>
</tr>
<? 
$x=0;
foreach($logItems as $item): 
$cls = ($x % 2 == 0) ? 'odd' : 'even';
$x++;
?>
<tr valign=top class="<?=$cls?>">
	<td><?=date('h:i:s M d, Y',$item['occured'])?>&nbsp;</td>
	<td><?=$item['company']?>&nbsp;</td>
	<td><?=$eventItems[$item['eventid']]?>&nbsp;</td>
	<td><?=$item['details']?>&nbsp;</td>
</tr>
<? endforeach; ?>
</table>