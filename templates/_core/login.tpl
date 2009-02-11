<?=(isset($message) && $message)?"<h4>$message</h4>":''?>
<table width="300" cellspacing="0" cellpadding="0">
<form action="<?=$SITE_ROOT?>dologin.php" method="post" name="login">
<tr><td valign="top">* <?=$lang['username']?> :</td><td><input value="" type="text" name="name"></td></tr>
<tr><td valign="top">* <?=$lang['password']?> :</td><td><input value="" type="password" name="password"></td></tr>
<tr><td valign="top"> </td><td><input type="submit" name="save" value="<?=$lang['log_in']?>"></td></tr>
</form>
</table>