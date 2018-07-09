{{include file='main_pieces/header.tpl'}}
<div id="listItems" class="pagePieces">
<fieldset style="margin-bottom:5px">
<legend><strong>Change admin login:</strong></legend>
<form method="post" enctype="multipart/form-data" autocomplete="off">
<input type="hidden" name="action" value="modify" />
<table width="100%" cellpadding="5" cellspacing="1">
<tr>
	<td nowrap="nowrap"><strong>Old user:</strong></td>
	<td width="100%"><input type="text" name="old_admin_user" value="" /></td>
</tr>
<tr>
	<td nowrap="nowrap"><strong>Old Password:</strong></td>
	<td width="100%"><input type="password" name="old_admin_pass" value="" /></td>
</tr>
<tr>
	<td nowrap="nowrap"><strong>New user:</strong></td>
	<td width="100%"><input type="text" name="admin_user" value="" /></td>
</tr>
<tr>
	<td nowrap="nowrap"><strong>New password:</strong></td>
	<td width="100%"><input type="password" name="admin_pass" value="" /></td>
</tr>
<tr>
	<td nowrap="nowrap"><strong>Repeat new password:</strong></td>
	<td width="100%"><input type="password" name="re_admin_pass" value="" /></td>
</tr>
<tr>
	<td align="center" colspan="2"><input value="Disabled in demo version" /> </td>
</tr>
</table>
</form>
</fieldset>
{{include file='main_pieces/footer.tpl'}}