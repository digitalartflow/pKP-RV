<?php /* Smarty version Smarty3-b7, created on 2015-09-28 23:32:17
         compiled from "../templates/account/recover_password.tpl" */ ?>
<?php /*%%SmartyHeaderCode:598518102560a3071587a02-95938094%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0efb2ff4271f2192be2847b6f13e940250f1bc54' => 
    array (
      0 => '../templates/account/recover_password.tpl',
      1 => 1438003865,
    ),
  ),
  'nocache_hash' => '598518102560a3071587a02-95938094',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
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