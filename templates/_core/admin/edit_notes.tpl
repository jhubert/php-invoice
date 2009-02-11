<? if ($clientID) : ?>
<p><a href="view_client.php?id=<?=$clientID?>">return to clients details</a></p>
<? endif; ?>
<table border="0" cellpadding="0" cellspacing="0" class="content">
<tr> 
  <th colspan="4"><?=$lang['notes']?></th>
</tr>
<? foreach($notes as $note) : ?>
<tr class="even"> 
  <td width="200"><?=$note['posted']?></td>
  <td><?=$note['content']?></td>
  <td><?=$note['isprivate']?></td>
  <td><a href="edit_notes.php?cid=<?=$note['r_clientid']?>&id=<?=$note['noteid']?>&delete=1"><?=$lang['delete']?></a></td>
</tr>
<? endforeach; ?>
</table>
<form action="edit_notes.php" method="POST">
<table border="0" cellpadding="0" cellspacing="0" class="content">
<tr class="odd"> 
    <tr> 
      <th colspan="2"><?=$lang['add_note']?></th>
    </tr>
</tr>
<tr class="odd"> 
  <td class="leftvalue"><?=$lang['note']?> : </td>
  <td><textarea name="content" rows="3" cols="40" tabindex="1"></textarea></td>
</tr>
<tr class="odd"> 
  <td class="leftvalue"><?=$lang['is_private']?> : </td>
  <td><input name="isprivate" type="checkbox" tabindex="2" checked> 
  </td>
</tr>
<tr class="odd"> 
  <td class="leftvalue">&nbsp;<input type="hidden" name="cid" value="<?=$clientID?>"></td>
  <td><input name="submit" type="Submit" id="submit" tabindex="3" value="<?=$lang['add_note']?>"> 
  </td>
</tr>
</table>
</form>
<SCRIPT LANGUAGE="JavaScript">
<!--
function popLogo() {
    if (editclient.logo.value != '') {
        window.open(editclient.logo.value,'printWindow','width=300,height=200');
    }
}
//-->
</SCRIPT>