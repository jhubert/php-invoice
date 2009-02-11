<? if ($client['clientid']) : ?>
 <p><a href="view_client.php?id=<?=$client['clientid']?>"><?=$lang['return_to'] . $lang['client_details']?></a></p>
 <? endif; ?>
 <form name="editclient" method="post" action="edit_client.php">
   <input type="hidden" name="parentclientid" value="<?=(isset($client['parentclientid']))?$client['parentclientid']:$session['ses_client_id']?>">
   <table border="0" cellpadding="0" cellspacing="0" class="content">
     <tr> 
       <th colspan="2"><input type="hidden" name="id" value="<?=$client['clientid']?>">
         <?=$lang["client_details"]?> : 
         <?=($client['clientid']) ? $lang["client_id"] . " " . $client['clientid'] : $lang["new_client"]?>
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
       <td><input type="text" name="phonenumber" value="<?=$client['phonenumber']?>" size="12" maxlength="20" class="textfield" tabindex="7" id="phoneNumber" /> 
       </td>
     </tr>
     <tr class="odd"> 
       <td class="leftvalue"><?=$lang['fax_number']?> :</td>
       <td><input type="text" name="faxnumber" value="<?=$client['faxnumber']?>" size="12" maxlength="20" class="textfield" tabindex="8" id="faxNumber" /> 
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
         <input type="text" id="logo" name="logo" value="<?=$client['logo']?>" size="60" class="textfield" tabindex="10" /><a name="logo"><a href="#logo" onClick="popLogo();"><?=$lang['view_logo']?></a>
       </td>
     </tr>
     <tr class="odd"> 
       <td class="leftvalue"><?=$lang['account_number']?> :</td>
       <td><input type="text" name="account_num" value="<?=$client['account_num']?>" size="20" maxlength="20" class="textfield" tabindex="11" id="startDate" /> 
       </td>
     </tr>
   </table>
   <table border="0" cellpadding="0" cellspacing="0" class="content">
     <tr> 
       <th colspan="2"><?=$lang['account_information']?></th>
     </tr>
     <tr class="odd"> 
       <td class="req"><?=$lang['reference_key']?> :</td>
       <td><input name="ref" type="text" class="textfield" id="ref" tabindex="12" value="<?=$client['ref']?>" size="40" maxlength="50" /> 
       </td>
     </tr>
     <tr class="odd"> 
       <td class="req"><?=$lang['username']?> :</td>
       <td><input name="username" type="text" class="textfield" id="username" tabindex="13" value="<?=$client['username']?>" size="40" maxlength="50" /> 
       </td>
     </tr>
     <tr class="odd"> 
       <td class="req"><?=$lang['password']?> :</td>
       <td><input name="passwd" type="text" class="textfield" id="passwd" tabindex="14" value="<?=$client['passwd']?>" size="40" maxlength="50" /> 
       </td>
     </tr>
     <tr class="odd"> 
       <td class="req"><?=$lang['access']?> :</td>
       <td><?=$client['access']?><input type="hidden" name="access" value="<?=$client['access']?>"></td>
     </tr>
     <tr class="odd"> 
       <td class="req"><?=$lang['template']?> :</td>
       <td> <select name="template" tabindex="15" id="template">
           <?=$templateDD?>
         </select> </td>
     </tr>
     <tr class="odd"> 
       <td class="req"><?=$lang['language']?> :</td>
       <td> <select name="language" tabindex="15" id="language">
           <?=$languageDD?>
         </select> </td>
     </tr>
     <tr class="odd"> 
       <td class="leftvalue"><?=$lang['visible']?> :</td>
       <td><input type="radio" id="visible_0" name="visible" value="0"<?=(!$client['visible'])?' checked':''?> tabindex="16" /> 
         <label for="visible_0"><?=$lang['no']?></label><input id="visible_1" type="radio" name="visible" value="1"<?=($client['visible'])?' checked':''?> tabindex="16" /> 
         <label for="visible_1"><?=$lang['yes']?></label> </td>
     </tr>
   </table>
   <table width="200" border="0" cellspacing="0" cellpadding="0" class="content">
     <tr> 
       <th colspan="2"><?=$lang['default_invoice_details']?></th>
     </tr>
     <tr class="odd"> 
       <td class="leftvalue"><?=$lang['default_tax']?> :</td>
       <td><input name="def_tax" type="text" class="textfield" id="def_tax" tabindex="17" value="<?=$client['def_tax']?>" size="5" maxlength="20" />% 
       </td>
     </tr>
     <tr class="odd"> 
       <td class="leftvalue"><?=$lang['default_tax_2']?> :</td>
       <td><input name="def_tax2" type="text" class="textfield" id="def_tax2" tabindex="18" value="<?=$client['def_tax2']?>" size="5" maxlength="20" />%
       </td>
     </tr>
     <tr class="odd"> 
       <td class="leftvalue"><?=$lang['default_term_days']?> :</td>
       <td><input name="term_days" type="text" class="textfield" id="term_days" tabindex="19" value="<?=$client['term_days']?>" size="5" maxlength="20" /> <?=$lang['days']?>
       </td>
     </tr>
     <tr class="odd"> 
       <td class="leftvalue"><?=$lang['default_terms']?> :</td>
       <td> <textarea name="def_terms" cols="40" rows="4" tabindex="19" id="def_terms"><?=$client['def_terms']?></textarea> 
       </td>
     </tr>
     <tr class="odd"> 
       <td class="leftvalue"><?=$lang['default_comment']?> :</td>
       <td> <textarea name="def_comments" cols="40" rows="4" tabindex="20" id="def_comments"><?=$client['def_comments']?></textarea> 
       </td>
     </tr>
     <tr class="odd"> 
       <td class="leftvalue"> </td>
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