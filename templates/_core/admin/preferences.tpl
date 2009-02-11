<?=isset($message)?($message)?"<h4>$message</h4>":'':''?>
<form action="preferences.php" method="post">
<input type="hidden" name="timeoffset" value="<?=$configvars['arr']['regional.timeoffset']?>">
<table border="0" cellpadding="0" cellspacing="0" class="content">
    <tr> 
      <th colspan="2">Server Settings</th>
    </tr>
<tr class="odd"> 
    <td class="leftvalue">HTTP Root:</td>
    <td><input type="text" name="httproot" value="<?=$configvars['con']['HTTP_ROOT']?>" size="40" /></td>
</tr>
<tr class="odd"> 
    <td class="leftvalue" title="This is the e-mail address that you want system error messages sent to.">Error Email Address: [?]</td>
        <td><input type="text" name="email_err" value="<?=$configvars['con']['EMAIL_ERR']?>" size="40"/></td>
</tr>
<tr class="odd"> 
    <td class="leftvalue" title="This is the directory where error logs are kept. IT MUST BE WRITEABLE. (Relative to /)">Error Directory: [?]</td>
        <td><input type="text" name="dir_error" value="<?=$configvars['con']['DIR_ERR']?>" /><br /></td>
</tr>
<tr class="odd"> 
    <td class="leftvalue" title="This is the directory that e-mail copies are stored in. IT MUST BE WRITEABLE.(Relative to /)"">Email Directory: [?]</td>
        <td><input type="text" name="dir_email" value="<?=$configvars['con']['DIR_EMAIL']?>" /><br /></td>
</tr>
    <tr> 
      <th colspan="2">Regional Settings</th>
    </tr>
<tr class="odd"> 
    <td class="leftvalue">Currency Symbol:</td>
        <td><input type="text" name="currencysymbol" value="<?=$configvars['arr']['regional.currency_sym']?>" size="5" /></td>
</tr>
<tr class="odd"> 
    <td class="leftvalue">Currency Text:</td>
        <td><input type="text" name="currencytext" value="<?=$configvars['arr']['regional.currency_txt']?>" size="5" /></td>
</tr>
<tr class="odd"> 
    <td class="leftvalue">Currency Format:</td>
        <td><input type="text" name="currencyformat" value="<?=$configvars['arr']['regional.currency_format']?>" size="10" /></td>
</tr>
<tr class="odd"> 
    <td class="leftvalue">Default Language:</td>
        <td><select name="deflanguage"><?=getLanguagesDD($configvars['var']['def_lang'])?></select></td>
</tr>
<tr class="odd"> 
    <td class="leftvalue">Short Date Format:</td>
        <td><input type="text" name="shortdate" value="<?=$configvars['arr']['regional.shortdate']?>" /></td>
</tr>
<tr class="odd"> 
    <td class="leftvalue">Long Date Format:</td>
        <td><input type="text" name="longdate" value="<?=$configvars['arr']['regional.longdate']?>" /></td>
</tr>
<tr class="odd"> 
    <td class="leftvalue">Invoice Date Format:</td>
        <td><input type="text" name="invoicedate" value="<?=$configvars['arr']['regional.invoicedate']?>" /></td>
</tr>
<tr class="odd"> 
    <td class="leftvalue">Date & Time Format:</td>
        <td><input type="text" name="datetime" value="<?=$configvars['arr']['regional.datetime']?>" /></td>
</tr>
    <tr> 
      <th colspan="2">Display Settings</th>
    </tr>
<tr class="odd"> 
    <td class="leftvalue">Default Template:</td>
        <td><select name="deftemplate"><?=getTemplatesDD($configvars['var']['def_template'])?></select></td>
</tr>
<tr class="odd"> 
    <td class="leftvalue">Results / Page:</td>
        <td><input type="text" name="invoicerpp" value="<?=$configvars['var']['invoicerpp']?>" size="5" /></td>
</tr>
<tr> 
  <th colspan="2">Email Settings</th>
</tr>
<tr class="odd"> 
    <td class="leftvalue" title="This is the e-mail address that you want invoices sent from.">From Address:</td>
    <td><input type="text" name="fromaddress" value="<?=$configvars['arr']['email.from']?>" size="40" /></td>
</tr>
<tr class="odd"> 
    <td class="leftvalue" title="This is the name that you want the invoices sent from.">From Name: [?]</td>
    <td><input type="text" name="fromname" value="<?=$configvars['arr']['email.fromName']?>" size="40"/><br /></td>
</tr>
<tr> 
    <td class="rightvalue">
        <input type="submit" value="Save Settings" /></td>
</tr>
</table>
</form>
