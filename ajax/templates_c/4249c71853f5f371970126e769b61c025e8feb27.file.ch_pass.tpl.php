<?php /* Smarty version Smarty3-b7, created on 2015-07-27 06:33:13
         compiled from "../templates/myaccount/ch_pass.tpl" */ ?>
<?php /*%%SmartyHeaderCode:5029085555b633198c6a99-67173764%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '4249c71853f5f371970126e769b61c025e8feb27' => 
    array (
      0 => '../templates/myaccount/ch_pass.tpl',
      1 => 1438003865,
    ),
  ),
  'nocache_hash' => '5029085555b633198c6a99-67173764',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
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