<table border="0" cellspacing="0" cellpadding="0">
<tr> 
  <td align="center"><img src="http://www.worldpay.com/usa_en/img/new_wplogo.gif"><br>
    <br>
	<form action="https://select.worldpay.com/wcc/purchase" method=POST>
	<input type=hidden name="instId" value="<?=$values['instId']?>"> 
	<input type=hidden name="cartId" value="Invoice Payment">
	<input type=hidden name="amount" value="<?=$invoice['total']?>">
	<input type=hidden name="currency" value="<?=$values['currency']?>">
	<input type=hidden name="desc" value="<?=$client['clientid']?>_<?=$invoice['invoiceid']?>">
<? if ($values['testmode'] == 1) : ?>
    <input type=hidden name="testMode" value="100">
<? endif; ?>
	<input type=submit value="Pay Now">
	</form>
  </td>
</tr>
</table>