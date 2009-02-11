<form name="editclient" method="post" action="edit_client.php">
  <table border="0" cellpadding="0" cellspacing="0" class="content">
    <tr> 
      <th colspan="2">
        <?=$lang["account_details"]?>
      </th>
    </tr>
    <tr class="odd"> 
      <td class="req"><?=$lang['company']?> :</td>
      <td><input name="company" type="text" class="textfield" id="company" tabindex="1" value="<?=$client['company']?>" size="40" maxlength="100" /> 
      </td>
    </tr>
    <tr class="odd"> 
      <td class="leftvalue"><?=$lang['first_name']?> :</td>
      <td><input type="text" name="firstname" value="<?=$client['firstname']?>" size="20" maxlength="20" class="textfield" tabindex="2" id="firstName" /> 
      </td>
    </tr>
    <tr class="odd"> 
      <td class="leftvalue"><?=$lang['last_name']?> :</td>
      <td><input type="text" name="lastname" value="<?=$client['lastname']?>" size="20" maxlength="20" class="textfield" tabindex="3" id="lastName" /> 
      </td>
    </tr>
    <tr class="odd"> 
      <td class="leftvalue"><?=$lang['title']?> :</td>
      <td><input type="text" name="contacttitle" value="<?=$client['contacttitle']?>" size="20" maxlength="20" class="textfield" tabindex="4" id="contactTitle" /> 
      </td>
    </tr>
    <tr class="odd"> 
      <td class="req"><?=$lang['email']?> :</td>
      <td><input name="email" type="text" class="textfield" id="email" tabindex="5" value="<?=$client['email']?>" size="40" maxlength="255" /> 
      </td>
    </tr>
    <tr class="odd"> 
      <td class="leftvalue"><?=$lang['address']?> :</td>
      <td> <textarea name="address" cols="40" rows="3" tabindex="6" id="address"><?=$client['address']?></textarea> 
      </td>
    </tr>
    <tr class="odd"> 
      <td class="leftvalue"><?=$lang['phone_number']?> :</td>
      <td><input type="text" name="phonenumber" value="<?=$client['phonenumber']?>" size="12" maxlength="12" class="textfield" tabindex="7" id="phoneNumber" /> 
      </td>
    </tr>
    <tr class="odd"> 
      <td class="leftvalue"><?=$lang['fax_number']?> :</td>
      <td><input type="text" name="faxnumber" value="<?=$client['faxnumber']?>" size="12" maxlength="12" class="textfield" tabindex="8" id="faxNumber" /> 
      </td>
    </tr>
    <tr class="odd"> 
      <td class="leftvalue"><?=$lang['website']?> :</td>
      <td><input type="text" name="url" value="<?=$client['url']?>" size="40" maxlength="50" class="textfield" tabindex="9" id="url" /> 
      </td>
    </tr>
    <tr class="odd"> 
      <td class="leftvalue"><?=$lang['logo']?> :</td>
      <td> 
        <input type="text" id="logo" name="logo" value="<?=$client['logo']?>" size="40" class="textfield" tabindex="10" /><a name="logo"><a href="#logo" onClick="popLogo();"><?=$lang['view_logo']?></a>
      </td>
    </tr>
  </table>
  <table border="0" cellpadding="0" cellspacing="0" class="content">
    <tr> 
      <th colspan="2"><?=$lang['account_information']?></th>
    </tr>
    <tr class="odd"> 
      <td class="req"><?=$lang['username']?> :</td>
      <td><?=$client['username']?> 
      </td>
    </tr>
    <tr class="odd"> 
      <td class="req"><?=$lang['password']?> :</td>
      <td><input name="passwd" type="text" class="textfield" id="passwd" tabindex="14" value="<?=$client['passwd']?>" size="40" maxlength="50" /> 
      </td>
    </tr>
    <tr class="odd"> 
      <td class="req"><?=$lang['language']?> :</td>
      <td> <select name="language" tabindex="15" id="language">
          <?=$languageDD?>
        </select> </td>
    </tr>
    <tr class="odd"> 
      <td class="leftvalue">&nbsp;</td>
      <td><input name="submit" type="Submit" id="submit" tabindex="21" value="<?=$lang['submit']?>"> 
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