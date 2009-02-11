<?=($message)?"<h4>$message</h4>":''?>
<table class="content" border=0 cellspacing=0 cellpadding=0>
<tr>
	<th width="130"><b><?=$lang['date_sent']?></b></th>
	<th><b><?=$lang['client']?></b></th>
	<th width="80"><b><?=$lang['type']?></b></th>
	<th width="130"><b><?=$lang['lastopened']?></b></th>
	<th width="40"><b><?=$lang['count']?></b></th>
	<th width="40"><b>&nbsp;</b></th>
</tr>
<? 
$x = 0;
foreach($history as $item):
$cls = ($x % 2 == 0) ? 'odd' : 'even';
$x++;
?>
<tr class="<?=$cls?>">
	<td><?=$item['datesent']?></td>
    <td title="sent to: <?=$item['emailaddress']?>"><a href="view_client.php?id=<?=$item['clientid']?>"><b><?=$item['company']?></b></a></td>
    <td><?=$item['type']?></td>
	<td title="<?=$lang['firstopened']?>: <?=$item['firstopened']?>"><?=$item['lastopened']?></td>
	<td align="center"><?=$item['opencount']?></td>
    <td align="center">
    <? if ($item['invoiceid']) :?>
    <a href="invoice.php?id=<?=$item['invoiceid']?>"><?=$lang['view']?></a>
    <? else : ?>
    &nbsp;
    <? endif; ?>
    </td>
</tr>
<? endforeach; ?>
</table>
<p><a href="javascript: history.go(-1);">&lt;&lt;&nbsp;<?=$lang['back']?></a></p>