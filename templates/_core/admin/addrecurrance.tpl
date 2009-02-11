<?=($message)?'<h4>'.$message.'</h4>:''?>
<form action="addrecurrance.php" method="POST">
<table class="content" cellpadding="0" cellspacing="0" border="0">
<tr>
	<th>&nbsp;</th>
</tr>
<tr>
	<td class='leftvalue'><?=$lang['invoice']?></td>
	<td><input type="text" name="invoiceid" value="<?=$recurrance['invoiceid']?>"></td>
</tr>
<tr>
	<td class='leftvalue'><?=$lang['days']?></td>
	<td><select name="days"><?=$sel_days?></select></td>
</tr>
<tr>
	<td class='leftvalue'><?=$lang['months']?></td>
	<td><select name="months"><?=$sel_months?></select></td>
</tr>
<tr>
	<td class='leftvalue'><?=$lang['until']?></td>
	<td><input type="text" name="until" value="<?=$recurrance['until']?>"></td>
</tr>
<tr>
	<td class='leftvalue'><?=$lang['action']?></td>
	<td><select name="action"><?=$sel_action?></select></td>
</tr>
<tr>
	<td class='leftvalue'>$nbsp;<input type="hidden" name="id" value="<?=$recurrance['id']?>"></td>
	<td><input type="submit" name="submit" value="<?=$lang['submit']?>"> <input type="button" value="<?=$lang['cancel']?>"></td>
</tr>
</table>
</form>