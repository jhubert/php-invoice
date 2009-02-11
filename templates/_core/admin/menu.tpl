<table width=150 border="0" cellspacing="0" cellpadding="0" class="menu">
    <tr> 
      <th><a href="<?=$SITE_ROOT?>admin/index.php"><?=$lang['n_main']?></a></th>
    </tr>
</table>
<table width=150 border="0" cellspacing="0" cellpadding="0" class="menu">
    <tr> 
      <th><a href="<?=$SITE_ROOT?>admin/invoice_overview.php"><?=$lang['n_invoices']?></a> 
        :: <a href="<?=$SITE_ROOT?>admin/edit_invoice.php"><?=$lang['n_new']?></a></th>
    </tr>
    <tr> 
      <td class="item"> - <a href="<?=$SITE_ROOT?>admin/invoices.php?item=status&value=pending"><?=$lang['n_view_pending_invoices']?></a></td>
    </tr>
    <tr> 
      <td class="item"> - <a href="<?=$SITE_ROOT?>admin/invoices.php?item=status&value=fully%20paid"><?=$lang['n_view_paid_invoices']?></a></td>
    </tr>
    <tr> 
      <td class="item"> - <a href="<?=$SITE_ROOT?>admin/invoices.php?item=status&value=unsent"><?=$lang['n_view_unsent_invoices']?></a></td>
    </tr>
    <tr> 
      <td class="item"> - <a href="<?=$SITE_ROOT?>admin/invoices.php"><?=$lang['n_view_all_invoices']?></a></td>
    </tr>
    <tr> 
      <td class="item"> - <a href="<?=$SITE_ROOT?>admin/search.php?sub=invoice"><?=$lang['n_search']?></a></td>
    </tr>
    <tr>
      <td class="item">&nbsp;</td>
    </tr>
</table>
<table width=150 border="0" cellspacing="0" cellpadding="0" class="menu">
    <tr> 
      <th><a href="<?=$SITE_ROOT?>admin/clients.php"><?=$lang['n_clients']?></a> 
        :: <a href="<?=$SITE_ROOT?>admin/edit_client.php"><?=$lang['n_new']?></a></th>
    </tr>
    <tr> 
      <td class="item"> - <a href="<?=$SITE_ROOT?>admin/clients.php"><?=$lang['n_view_active_clients']?></a></td>
    </tr>
    <tr> 
      <td class="item"> - <a href="<?=$SITE_ROOT?>admin/clients.php?disp=all"><?=$lang['n_view_all_clients']?></a></td>
    </tr>
    <tr> 
      <td class="item"> - <a href="<?=$SITE_ROOT?>admin/clients.php?disp=inactive"><?=$lang["n_view_inactive_clients"]?></a></td>
    </tr>
    <tr> 
      <td class="item"> - <a href="<?=$SITE_ROOT?>admin/search.php?sub=client"><?=$lang['n_search']?></a></td>
    </tr>
    <tr> 
      <td>&nbsp;</td>
    </tr>
</table>
<table width=150 border="0" cellspacing="0" cellpadding="0" class="menu">
    <tr> 
      <th><?=$lang['n_reports']?></th>
    </tr>
    <tr> 
      <td class="item"> - <a href="<?=$SITE_ROOT?>admin/payments.php"><?=$lang['n_payments']?></a></td>
    </tr>
    <tr> 
      <td class="item"> - <a href="<?=$SITE_ROOT?>admin/mailtrack.php"><?=$lang['n_sent_emails']?></a></td>
    </tr>
    <tr> 
      <td class="item"> - <a href="<?=$SITE_ROOT?>admin/viewlog.php"><?=$lang['n_login_logout_history']?></a></td>
    </tr>
    <tr> 
      <td>&nbsp;</td>
    </tr>
</table>
<table width=150 border="0" cellspacing="0" cellpadding="0" class="menu">
    <tr> 
      <th><a href="<?=$SITE_ROOT?>admin/#"><?=$lang['n_admin']?></a></th>
    </tr>
    <tr> 
      <td class="item"> - <a href="<?=$SITE_ROOT?>admin/edit_client.php?id=<?=$session['ses_client_id']?>"><?=$lang['n_edit_account']?></a></td>
    </tr>
    <tr> 
      <td class="item"> - <a href="<?=$SITE_ROOT?>admin/preferences.php"><?=$lang['n_edit_preferences']?></a></td>
    </tr>
    <tr> 
      <td class="item"> - <a href="<?=$SITE_ROOT?>admin/paygates.php"><?=$lang['n_edit_paygates']?></a></td>
    </tr>
    <tr> 
      <td class="item"> - <a href="<?=$SITE_ROOT?>admin/editor/"><?=$lang['n_editor']?></a></td>
    </tr>
    <tr> 
      <td class="item">&nbsp;</td>
    </tr>
</table>
<table width=150 border="0" cellspacing="0" cellpadding="0" class="menu">
    <tr> 
        <th><a href="<?=$SITE_ROOT?>logout.php"><?=$lang['n_logout']?></a></th>
    </tr>
</table> 
