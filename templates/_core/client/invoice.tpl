<center>
  <table width="550" border="0" cellspacing="0" cellpadding="0">
    <tr valign="top">
      <td>
        <h2 align="center">INVOICE</h2>
        <form>
        <table width="550" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <? if ($session['ses_access'] != 'client') : ?>
            <td>
            <input type="button" name="Submit" value="Update as PAID" onClick="window.open('<?=$SITE_ROOT?>admin/quick_update.php?id=<?=$invoice['invoiceid']?>&st=Fully%20Paid','mailWindow','width=200,height=50');">
            </td>
            <td>
            <input type="button" name="Email" value="E-mail to Client" onClick="window.open('<?=$SITE_ROOT?>mail.php?id=<?=$invoice['invoiceid']?>','mailWindow','width=200,height=50');">
            </td>
            <? endif; ?>
            <SCRIPT LANGUAGE="JavaScript">
            if (window.print) {
                document.write('<td align="center"><input type="button" name="Print" value="Print invoice" onClick="window.open(\'<?=$SITE_ROOT?>print.php?id=<?=$invoice['invoiceid']?>\',\'printWindow\',\'width=10,height=10\');"></td>');
            }      
            </script>
          </tr>
        </table>
        </form>
      </td>
    </tr>
  </table>
  <table width="550" border="0" cellspacing="0" cellpadding="0">
    <tr valign="top">
    <td bgcolor="#FFFFFF" align="left" style="padding: 10px">
      <div style="padding: 10px; position: relative; display: block;">
      <?=$this->fetch('forms/invoice.tpl')?>
      </div>
    </td>
    </tr>
  </table>
  <p>&nbsp;</p>
</center>
</body>
</html>