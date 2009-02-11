<?=isset($message)?$message:''?>
<table border=0 cellspacing=0 cellpadding=0>
<form action="forgotpass.php" method="post">
<tr>
    <td width="100" class="leftvalue"> 
    <?=$lang['username']?> : </td>
    <td><input type="text" name="username"></td>
</tr>
<tr>
    <td colspan=2 align="center"><?=$lang['or']?></td>
</tr>
<tr>
    <td width="100" class="leftvalue"><?=$lang['email']?> : </td>
    <td><input type="text" name="email"></td>
</tr>
<tr class="odd">
    <td>&nbsp;</td>
    <td><input type="submit" name="btnSubmit" value="<?=$lang['submit']?>">&nbsp;<input type="button" name="cancel" value="<?=$lang['cancel']?>" onClick="history.back();"></td>
</tr>
</form>
</table>