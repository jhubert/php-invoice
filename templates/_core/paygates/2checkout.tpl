<table border="0" cellspacing="0" cellpadding="0">
<tr> 
  <td align="center"><img src="<?=$TEMPLATE_DIR?>images/2checkout.gif" width="150" height="41"><br>
    <br>
    <form action=https://www.2checkout.com/cgi-bin/sbuyers/cartpurchase.2c method=post target="_Blank">
      <input type=hidden name=sid value="<?=$values['sid']?>">
      <input type=hidden name=cart_order_id value="Donation">
      <input type=hidden name=total value="<?=$invoice['total']?>">
      <input type="image" src="<?=$TEMPLATE_DIR?>images/paynow.gif" border="0" alt="Pay your invoice with 2checkout" name="image">
    </form>
  </td>
</tr>
</table>