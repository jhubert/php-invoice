<table class="content" cellspacing="0" cellpadding="0">
<tr><th valign="top"><?=$lang['introduction']?></th></tr>
<tr class="odd"><td valign="top"><?=$lang['txt_welcome']?></td></tr>
</table>
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