<table border="0" cellspacing="0" cellpadding="0">
<tr> 
  <td align="center"><img src="<?=$TEMPLATE_DIR?>images/paypal.gif" width="116" height="36"><br>
    <br>
    <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_Blank">
      <input type="hidden" name="cmd" value="_xclick">
      <input type="hidden" name="business" value="<?=$values['paypalID']?>">
      <input type="hidden" name="item_name" value="Invoice Payment">
      <input type="hidden" name="item_number" value="<?=$client['clientid']?>_<?=$invoice['invoiceid']?>">
      <input type="hidden" name="amount" value="<?=$invoice['total']?>">
      <input type="hidden" name="currency_code" value="<?=$values['curr_code']?>">
      <input type="hidden" name="tax" value="1">
      <input type="image" src="<?=$TEMPLATE_DIR?>images/paynow.gif" border="0" name="submit" alt="Make payments with PayPal - it's fast, free and secure!">
    </form>
  </td>
</tr>
</table>