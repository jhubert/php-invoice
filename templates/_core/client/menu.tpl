<table width=150 border="0" cellspacing="0" cellpadding="0" class="content">
    <tr> 
      <th><?=$lang['n_menu']?></th>
    </tr>
    <tr> 
      <td class="item"><a href="<?=$SITE_ROOT?>client/invoices.php?item=status&value=pending"><?=$lang['n_view_pending_invoices']?></a></td>
    </tr>
    <tr> 
      <td class="item"><a href="<?=$SITE_ROOT?>client/invoices.php?item=status&value=fully%20paid"><?=$lang['n_view_paid_invoices']?></a></td>
    </tr>
    <tr> 
      <td class="item"><a href="<?=$SITE_ROOT?>client/invoices.php"><?=$lang['n_view_all_invoices']?></a></td>
    </tr>
    <tr> 
      <td class="item"><a href="<?=$SITE_ROOT?>client/edit_client.php?id=<?=$session['ses_client_id']?>"><?=$lang['n_edit_account']?></a></td>
    </tr>
    <tr>
      <td class="item">&nbsp;</td>
    </tr>
    <tr> 
      <td><a href="<?=$SITE_ROOT?>logout.php"><?=$lang['n_logout']?></a></td>
    </tr>
</table>