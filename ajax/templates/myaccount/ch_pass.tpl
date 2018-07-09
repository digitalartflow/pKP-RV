<style>
input[type=text], input[type=password], select
{
	border:1px solid #333333;
	background:#FFFFFF;
	color:#333333;
	padding:2px;
}
</style>
<div id="divLoadingChPass" align="center" style="display:none">
<img src="images/loading.gif" />
</div>
<div align="left" id="divHolderChPass">
<form method="post" id="formCreateAccount" onsubmit="return doChPass()">
<table width="100%" cellpadding="2" cellspacing="1">
<tr>
	<td colspan="2"><h1>Change password</h1></td>
</tr>
<tr>
	<td width="25%"><strong>Current password:</strong></td>
	<td width="75%"><input type="password" name="OPassword" value="" /></td>
</tr>
<tr>
	<td><strong>New password:</strong></td>
	<td><input type="password" name="Password" value="" /></td>
</tr>
<tr>
	<td><strong>Retype new password:</strong></td>
	<td><input type="password" name="RePassword" value="" /></td>
</tr>
<tr>
	<td colspan="2" align="center"><input class="btnMode" type="submit" value="Change password" /></td>
</tr>
</table>
</form>
</div>
<script>
$('.btnMode').button();
function doChPass()
{
	obj = Object();
	tc  = $('#formCreateAccount').find('input[type=text],input[type=password],input[type=checkbox]:checked,select');
	for( i=0; i<tc.length; i++ )
	{
		eval('obj.'+$(tc[i]).attr('name')+'="'+$(tc[i]).val()+'"');
	}
	$('#divLoadingChPass').toggle();
	$('#divHolderChPass').toggle();
	$.post('ajax/account/doChangePassword.php',obj,function(data){
		$('#divLoadingChPass').toggle();
		$('#divHolderChPass').toggle();
		alert(data.msg);
	},'json');
	return false;
}
</script>