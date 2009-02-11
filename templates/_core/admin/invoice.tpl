<center>
  <table width="670" border="0" cellspacing="0" cellpadding="0">
    <tr valign="top">
      <td>
        <h2 align="center">INVOICE</h2>
        <form>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td>
            <a href="<?=$SITE_ROOT?>admin/view_client.php?id=<?=$invoice['clientid']?>"><?=$lang['view_client']?></a>&nbsp;|
            </td>
            <td>
            <a href="<?=$SITE_ROOT?>admin/quick_update.php?id=<?=$invoice['invoiceid']?>&st=fully%20paid" onClick="window.open(this.href,'mailWindow','width=200,height=50'); return false;"><?=$lang['update_paid']?></a>&nbsp;|
            </td>
            <td>
            <a href="<?=$SITE_ROOT?>mail.php?id=<?=$invoice['invoiceid']?>" onClick="window.open(this.href,'mailWindow','width=200,height=50'); return false;"><?=$lang['send_invoice']?></a>&nbsp;|
            </td>
            <SCRIPT LANGUAGE="JavaScript">
            if (window.print) {
                document.write('<td><a href="<?=$SITE_ROOT?>print.php?id=<?=$invoice['invoiceid']?>" onClick="window.open(this.href,\'printWindow\',\'width=10,height=10,resize\'); return false;"><?=$lang["print_invoice"]?></a>&nbsp;|</td>');
            }      
            </script>
            <td>
            <a href="<?=$SITE_ROOT?>admin/add_payment.php?iid=<?=$invoice['invoiceid']?>"><?=$lang['add_payment']?></a>&nbsp;|
            </td>
            <td>
            <a href="<?=$SITE_ROOT?>admin/edit_invoice.php?id=<?=$invoice['invoiceid']?>"><?=$lang['edit_invoice']?></a>
            </td>
          </tr>
        </table>
        </form>
      </td>
    </tr>
  </table>
  <table width="550" border="0" cellspacing="0" cellpadding="0">
    <tr valign="top">
    <td bgcolor="#FFFFFF" align="left">
        <div style="padding: 10px; position: relative; display: block;">
      <?=$this->fetch('forms/invoice.tpl')?>
      </div>
    </td>
    </tr>
  </table>
  <p>&nbsp;</p>
</center>