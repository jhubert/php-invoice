<? if($ispayed) : ?>
<img src="<?=$HTTP_ROOT?>images/paid.gif" id="paidstamp">
<? endif; ?>
<div id="invoice" style="valign: top">
<table border="0"width="650">
    <tr>
    <td width="475"><img src="<?=$admin['logo']?>"></td>
    <td width="175"><b>
      <div align="right"><?=$admin['company'] . "<br>" . nl2br($admin['address'])?></div></b></font>
    </td>
    </tr>
    <tr>
        <td width="650" colspan="2" align="right"><hr><font size="6" face="Arial"><u><b>Invoice</b></u></font></td>
    </tr>
</table><br>
<table border="0"width="650">
    <tr>
        <td width="417" valign="top" rowspan="3"><b><?=$lang['client']?>:<br><?=$client['company']?></b><br><?=nl2br($client['address'])?><br></b></font></td>
        <td width="108" align="right" valign="top"><b><?=$lang['ref_number']?></b></font></td>
        <td width="111" align="right" valign="top"><b><?=$client['ref']?> / <?=$invoice['invoice_num']?></b></font></td>
    </tr>
    <tr>
        <td width="108" align="right" valign="top"><b><?=$lang['invoice_date']?></b></font></td>
        <td width="111" align="right" valign="top"><b><?=$invoice['issue_date']?></b></font></td>
    </tr>
    <tr>
        <td width="108" align="right" valign="top"><b><?=$lang['pay_by']?></b></font></td>
        <td width="111" align="right" valign="top"><b><?=$invoice['due_date']?></b></font></td>
    </tr>
</table>
<br>
<table border="0"width="650">
    <tr> 
        <td width="320" valign="top"><b><?=$lang['description']?></b></font></td>
        <td width="110" valign="top" align="right"><b><?=$lang['qty']?></b></font></td>
        <td width="110" valign="top" align="right"><b><?=$lang['price']?></b></font></td>
        <td width="110" valign="top" align="right"><b><?=$lang['item_total']?></b></font></td>
    </tr>
    <tr> 
        <td colspan="4"><hr></td>
    </tr>
    <? foreach($invoice['items'] as $item) : ?>
    <tr> 
        <td width="320" valign="top" class="lineitem"><?=$item['details']?></td>
        <td width="110" align="right" valign="top" class="lineitem"><?=$item['qty']?></td>
        <td width="110" align="right" valign="top" class="lineitem"><?=$item['cost']?></td>
        <td width="110" align="right" valign="top" class="lineitem"><?=number_format($item['cost']*$item['qty'],2)?></td>
    </tr>
    <? endforeach; ?>
    <tr> 
        <td colspan="4"><hr></td>
    </tr>
</table>
<table border="0"width="650">
  <tr> 
    <td width="404" valign="middle"> 
      <table width="330" border="1" cellspacing="0" cellpadding="10" align="center">
        <tr>
          <td>
            <div align="center"><?=nl2br($invoice['terms'])?></font></div>
          </td>
        </tr>
      </table>
      </font></td>
  <td width="232">
  <table width="232" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="135" align="left" valign="top"><b><?=$lang['sub_total']?></b></font></td>
    <td width="97" align="right" valign="top"><b><?=$invoice['cost']?></b></font></td>
  </tr>
<? if ($invoice['show_tax']) : ?>
  <tr> 
    <td width="135" align="left" valign="top"><b><?=$lang['tax']?></b></font></td>
    <td width="97" align="right" valign="top"><b><?=$invoice['calc_tax']?></b></font></td>
  </tr>
<? endif;
   if ($invoice['show_tax2']) : ?>
  <tr> 
    <td width="135" align="left" valign="top"><b><?=$lang['tax2']?></b></font></td>
    <td width="97" align="right" valign="top"><b><?=$invoice['calc_tax2']?></b></font></td>
  </tr>
<? endif;
   if ($invoice['show_shipping']) : ?>
  <tr> 
    <td width="135" align="left" valign="top"><b><?=$lang['shipping']?></b></font></td>
    <td width="97" align="right" valign="top"><b><?=$invoice['shipping']?></b></font></td>
  </tr>
<? endif; ?>
  <tr> 
    <td width="135" align="left" valign="top"><b><?=$lang['inv_total']?></b></font></td>
    <td width="97" align="right" valign="top"><b><?=$invoice['total']?></b></font></td>
  </tr>
  </table>
  </td></tr>
  <tr>
  <td colspan="3" align="center" valign="top">
      <hr>
      <font size="1" face="Arial"><?=nl2br($invoice['comments'])?></font></td>
  </tr>
</table>
</div>