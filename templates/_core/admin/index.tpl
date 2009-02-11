<table class="content" cellspacing="0" cellpadding="0">
    <tr><th valign="top"><?=$lang['introduction']?></th></tr>
    <tr class="odd"><td valign="top"><?=$lang['txt_welcome']?></td></tr>
</table><br>
<table class="content" cellspacing="0" cellpadding="0">
    <tr><th valign="top" colspan="100%"><?=$lang['recent_logins']?></th></tr>
    <? if (count($stats['logins'])) : 
       foreach($stats['logins'] as $item): ?>
    <tr class="odd"><td><?=$item['occured']?></td><td><?=$item['company']?></td><td><?=$item['details']?></td></tr>
    <? endforeach; 
       else: ?>
    <tr class="odd"><td><?=$lang["no_results"]?></td></tr>
    <? endif; ?>
</table><br>
<table class="content" cellspacing="0" cellpadding="0">
    <tr><th valign="top" colspan="100%"><?=$lang['recent_payments']?></th></tr>
    <? if (count($stats['payments'])) : 
       foreach($stats['payments'] as $item): ?>
    <tr class="odd"><td><?=$item['made_on']?></td><td><?=$item['company']?></td><td><?=$item['amount']?></td></tr>
    <? endforeach; 
       else: ?>
    <tr class="odd"><td><?=$lang["no_results"]?></td></tr>
    <? endif; ?>
</table><br>
<table class="content" cellspacing="0" cellpadding="0">
    <tr><th valign="top" colspan="100%"><?=$lang['overdue']?></th></tr>
    <? if (count($stats['overdue'])) : 
       foreach($stats['overdue'] as $item): ?>
    <tr class="odd"><td><?=$item['occured']?></td><td><?=$item['company']?></td><td><?=$item['details']?></td></tr>
    <? endforeach; 
       else: ?>
    <tr class="odd"><td><?=$lang["no_results"]?></td></tr>
    <? endif; ?>
</table><br>
<table border="0" cellpadding="0" cellspacing="0" class="content">
<tr> 
  <th colspan="2"><?=$lang['notes']?></th>
</tr>
<? foreach($notes as $note) : ?>
<tr class="even"> 
  <td width="200"><?=$note['posted']?></td>
  <td><?=$note['content']?></td>
</tr>
<? endforeach; ?>
</table>