<table border="0" cellspacing="0" cellpadding="0">
<tr>
<td width="396">
<p><?=$message?>&nbsp;</p>
<form enctype="multipart/form-data" method="post" action="import.php">
<table align="center"><tr><td class="gen">
<b>File to Import:</b><br>
<input type="file" name="csvfile" size="30">
</td></tr><tr><td class="gen">
<b>Import Type:</b><br>
<select name="itemtype">
<option value="v1_invoice">TI Basic - Invoices</option>
<option value="v1_client">TI Basic - Clients</option>
</select>
</td></tr><tr><td class="gen"><br>
<input type="submit" name="submit" value="Upload File">
</td></tr></table>
</form>
<p>** Please note that due to issues unencrypting the passwords from typical<b>Invoice</b> Basic, all users will have their passwords reset.  The new password will be the same as their username.</p>
<p>Return to the <a href="<?=$SITE_ROOT?>login.php">login area.</a></p>
</td></tr></table>