<div id="divLoadingDoRecoverPassword" align="center" style="display:none">
<img src="images/loading.gif" />
</div>
<div id="divHolderDoRecoverPassword" align="center">
<form method="post" onsubmit="return doRecoverPassword()" id="formDoRecoverPassword">
<table width="80%" cellpadding="2" cellspacing="1" align:"left">
<tr>
	<td align="left"><h1>Forgot your password?</h1></td>
</tr>
<tr>
	<td align="left">To recover your password please type your e-mail:</td>
</tr>
<tr>
	<td width="75%"><input type="text" name="email"/></td>
</tr>
<tr>
	<td colspan="2" align="left"><input class="btnMode" type="submit" value="Recover password" /></td>
</tr>
<tr>
	<td colspan="2"><a href="javascript: void(0)" onclick="showAccount('login')">Log In</a></td>
</tr>
</table>
</form>
</div>
<script>

$('.btnMode').button();
function doRecoverPassword()
{
	obj = Object();
	tc  = $('#formDoRecoverPassword').find('input[type=text],input[type=password]');
	for( i=0; i<tc.length; i++ )
	{
		eval('obj.'+$(tc[i]).attr('name')+'="'+$(tc[i]).val()+'"');
	}
	$('#divLoadingDoRecoverPassword').toggle();
	$('#divHolderDoRecoverPassword').toggle();
	$.post('ajax/account/doRecoverPassword.php',obj,function(data){
		$('#divLoadingDoRecoverPassword').toggle();
		$('#divHolderDoRecoverPassword').toggle();
		alert(data.msg);
	},'json');
	return false;
}
</script>