  <form name=editadmin method="post" action="edit_client.php">
  <input type="hidden" name="parentClientID" value="<?=($client['parentclientid'])?$client['parentclientid']:$session['ses_client_id']?>">
  <input type="hidden" name="access" value="admin">
<table border="0">
<? if ($client['clientid']) : ?>
    <tr> 
      <td>Client ID</td>
      <td>
          <input type="hidden" name="id" value="<?=$client['clientid']?>"><?=$client['clientid']?>
      </td>
    </tr>
<? endif; ?>
    <tr> 
      <td>User name</td>
      <td> 
        <input type="text" name="username" value="<?=$client['username']?>" size="40" maxlength="50" class="textfield" tabindex="1" />
      </td>
    </tr>
    <tr> 
      <td>Password</td>
      <td> 
        <input type="text" name="passwd" value="<?=$client['passwd']?>" size="40" maxlength="50" class="textfield" tabindex="2" />
      </td>
    </tr>
    <tr> 
      <td>Email</td>
      <td> 
        <input type="text" name="email" value="<?=$client['email']?>" size="40" maxlength="255" class="textfield" tabindex="3" />
      </td>
    </tr>
    <tr> 
      <td>Address</td>
      <td>
        <textarea name="address" rows="3" cols="40" tabindex="4"><?=$client['address']?></textarea>
      </td>
    </tr>
    <tr> 
      <td>Default Tax</td>
      <td> 
        <input type="text" name="def_tax" value="<?=$client['def_tax']?>" size="20" maxlength="20" class="textfield" tabindex="5" />
      </td>
    </tr>
    <tr> 
      <td>Default Tax 2</td>
      <td> 
        <input type="text" name="def_tax2" value="<?=$client['def_tax2']?>" size="20" maxlength="20" class="textfield" tabindex="6" />
      </td>
    </tr>
    <tr> 
      <td>REF Key</td>
      <td> 
        <input type="text" name="ref" value="<?=$client['ref']?>" size="40" maxlength="50" class="textfield" tabindex="7" />
      </td>
    </tr>
    <tr> 
      <td>Company</td>
      <td> 
        <input type="text" name="company" value="<?=$client['company']?>" size="40" maxlength="100" class="textfield" tabindex="8" />
      </td>
    </tr>
    <tr>
      <td>First Name</td>
      <td> 
        <input type="text" name="firstName" value="<?=$client['firstName']?>" size="20" maxlength="20" class="textfield" tabindex="9" id="field_8_3" />
      </td>
    </tr>
    <tr> 
      <td>Last Name</td>
      <td> 
        <input type="text" name="lastName" value="<?=$client['lastName']?>" size="20" maxlength="20" class="textfield" tabindex="10" id="field_9_3" />
      </td>
    </tr>
    <tr> 
      <td>Title</td>
      <td> 
        <input type="text" name="contactTitle" value="<?=$client['contactTitle']?>" size="20" maxlength="20" class="textfield" tabindex="11" id="field_10_3" />
      </td>
    </tr>
    <tr> 
      <td>Phone Number</td>
      <td> 
        <input type="text" name="phoneNumber" value="<?=$client['phoneNumber']?>" size="12" maxlength="12" class="textfield" tabindex="12" id="field_11_3" />
      </td>
    </tr>
    <tr> 
      <td>Fax Number</td>
      <td> 
        <input type="text" name="faxNumber" value="<?=$client['faxNumber']?>" size="12" maxlength="12" class="textfield" tabindex="13" id="field_12_3" />
      </td>
    </tr>
    <tr> 
      <td>Website</td>
      <td> 
        <input type="text" name="url" value="<?=$client['url']?>" size="40" maxlength="50" class="textfield" tabindex="14" id="field_13_3" />
      </td>
    </tr>
    <tr> 
      <td>Logo</td>
      <td> 
        <input type="text" name="logo" value="<?=$client['logo']?>" size="40" class="textfield" tabindex="15" id="field_13_3" />  <a name="logo"><a href="#logo" onClick="window.open(editadmin.logo.value,'printWindow','width=300,height=200');">view logo</a>
      </td>
    </tr>
    <tr> 
      <td>Account Number</td>
      <td> 
        <input type="text" name="account_num" value="<?=$client['account_num']?>" size="20" maxlength="20" class="textfield" tabindex="16" id="field_14_3" />
      </td>
    </tr>
<!--
    <tr> 
      <td>Access</td>
      <td> 
        <select name="access" tabindex="17" id="field_15_3">
          <option value="<?=$client['access']?>" selected><?=$client['access']?></option>
          <option value="client">client</option>
          <option value="staff">staff</option>
          <option value="admin">admin</option>
        </select>
      </td>
    </tr>
//-->
    <tr> 
      <td>Visible</td>
      <td> 
        <input type="radio" name="visible" value="0"<?=(!$client['visible'])?' checked':''?> tabindex="18" />
        <label for="field_16_3_0">No</label> 
        <input type="radio" name="visible" value="1"<?=($client['visible'])?' checked':''?> tabindex="18" />
        <label for="field_16_3_1">Yes</label> </td>
    </tr>
    <tr> 
      <td>&nbsp;</td>
      <td> 
        <input type="Submit" name="submit" value="Update information" tabindex="19">
      </td>
    </tr>
  </table>
    
  </form>