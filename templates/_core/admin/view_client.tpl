<p><a href="clients.php"><?=$lang['return_client_list']?></a> |
   <a href="edit_client.php?id=<?=$client['clientid']?>"><?=$lang['edit_client']?></a> |
   <a href="invoices.php?item=client&value=<?=$client['clientid']?>"><?=$lang['view_invoices']?></a> |
   <a href="mailtrack.php?cid=<?=$client['clientid']?>"><?=$lang['view_email_history']?></a> | 
   <a href="edit_notes.php?cid=<?=$client['clientid']?>"><?=$lang['view_notes']?></a> | 
   <a href="edit_invoice.php?cid=<?=$client['clientid']?>"><?=$lang['new_invoice']?></a></p>
<?
if ($client['logo']) : ?>
<img src="<?=$client['logo']?>">
<? endif; ?>
  <table border="0" cellpadding="0" cellspacing="0" class="content">
    <tr> 
      <th colspan="2">
        <?=$lang['client_details']?> : <?=$lang['client_id']?> <?=$client['clientid']?>
      </th>
    </tr>
    <tr class="odd"> 
      <td class="leftvalue"><?=$lang['company']?> :</td>
      <td> <?=$client['company']?> </td>
    </tr>
    <tr class="odd"> 
      <td class="leftvalue"><?=$lang['first_name']?> :</td>
      <td> <?=$client['firstname']?> </td>
    </tr>
    <tr class="odd"> 
      <td class="leftvalue"><?=$lang['last_name']?> :</td>
      <td> <?=$client['lastname']?> </td>
    </tr>
    <tr class="odd"> 
      <td class="leftvalue"><?=$lang['title']?> :</td>
      <td> <?=$client['contacttitle']?> </td>
    </tr>
    <tr class="odd"> 
      <td class="leftvalue"><?=$lang['email']?> :</td>
      <td> <?=$client['email']?> </td>
    </tr>
    <tr class="odd"> 
      <td class="leftvalue"><?=$lang['address']?> :</td>
      <td> <?=nl2br($client['address'])?> </td>
    </tr>
    <tr class="odd"> 
      <td class="leftvalue"><?=$lang['phone_number']?> :</td>
      <td> <?=$client['phonenumber']?> </td>
    </tr>
    <tr class="odd"> 
      <td class="leftvalue"><?=$lang['fax_number']?> :</td>
      <td> <?=$client['faxnumber']?> </td>
    </tr>
    <tr class="odd"> 
      <td class="leftvalue"><?=$lang['website']?> :</td>
      <td> <?=$client['url']?> </td>
    </tr>
    <tr class="odd"> 
      <td class="leftvalue"><?=$lang['account_number']?> :</td>
      <td><?=$client['account_num']?> </td>
    </tr>
  </table>
  <table border="0" cellpadding="0" cellspacing="0" class="content">
    <tr> 
      <th colspan="2"><?=$lang['account_information']?></th>
    </tr>
    <tr class="odd"> 
      <td class="leftvalue"><?=$lang['reference_key']?> :</td>
      <td> <?=$client['ref']?> </td>
    </tr>
    <tr class="odd"> 
      <td class="leftvalue"><?=$lang['username']?> :</td>
      <td> <?=$client['username']?> </td>
    </tr>
    <tr class="odd"> 
      <td class="leftvalue"><?=$lang['password']?> :</td>
      <td> <?=$client['passwd']?> </td>
    </tr>
    <tr class="odd"> 
      <td class="leftvalue"><?=$lang['access']?> :</td>
      <td><?=$client['access']?></td>
    </tr>
    <tr class="odd"> 
      <td class="leftvalue"><?=$lang['template']?> :</td>
      <td><?=$client['template']?></td>
    </tr>
    <tr class="odd"> 
      <td class="leftvalue"><?=$lang['visible']?> :</td>
      <td>        <?
        if ($client['visible'])
            echo "Yes";
        else
            echo "No";
        ?></td>
    </tr>
  </table>
  <table width="200" border="0" cellspacing="0" cellpadding="0" class="content">
    <tr> 
      <th colspan="2"><?=$lang['default_invoice_details']?></th>
    </tr>
    <tr class="odd"> 
      <td class="leftvalue"><?=$lang['default_tax']?> :</td>
      <td> <?=$client['def_tax']?>% </td>
    </tr>
    <tr class="odd"> 
      <td class="leftvalue"><?=$lang['default_tax_2']?> :</td>
      <td> <?=$client['def_tax2']?>% </td>
    </tr>
    <tr class="odd"> 
      <td class="leftvalue"><?=$lang['default_term_days']?> :</td>
      <td> <?=$client['term_days']?> <?=$lang['days']?> </td>
    </tr>
    <tr class="odd"> 
      <td class="leftvalue"><?=$lang['default_terms']?> :</td>
      <td> <?=nl2br($client['def_terms'])?> </td>
    </tr>
    <tr class="odd"> 
      <td class="leftvalue"><?=$lang['default_comment']?> :</td>
      <td> <?=nl2br($client['def_comments'])?> </td>
    </tr>
  </table>