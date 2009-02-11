<?=($message)?"<h4>$message</h4>":''?>
<table width="100%" border="0" cellspacing="10" cellpadding="0">
  <tr>
    <td width="50%"> 
      <table class="content" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <th>Actions</th>
        </tr>
        <tr class="odd">
          <td><A HREF="edit_client.php?id=<?=$session['ses_client_id']?>">Edit Your Account</A></td>
        </tr>
        <tr class="even">
          <td>Change System Settings</td>
        </tr>
        <tr class="odd">
          <td>View Admins</td>
        </tr>
        <tr class="even">
          <td>Edit Personal Options</td>
        </tr>
      </table>
    </td>
    <td width="50%">
      <table class="content" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <th>Statistics</th>
        </tr>
        <tr class="odd"> 
          <td>Paid:</td>
        </tr>
        <tr class="even"> 
          <td>Outstanding:</td>
        </tr>
        <tr class="odd"> 
          <td>Not Due:</td>
        </tr>
        <tr class="even"> 
          <td>Total Invoiced:</td>
        </tr>
      </table>
    </td>
  </tr>
</table>
