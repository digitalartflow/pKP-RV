<?php /* Smarty version Smarty3-b7, created on 2015-07-27 06:54:49
         compiled from "../templates/account/login.tpl" */ ?>
<?php /*%%SmartyHeaderCode:20949691255b6382950bdd4-51760389%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f024fe8f6f39da978d41e8b8d737e3b4e6598ed6' => 
    array (
      0 => '../templates/account/login.tpl',
      1 => 1438003865,
    ),
  ),
  'nocache_hash' => '20949691255b6382950bdd4-51760389',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<div id="divLoadingDoLogin" align="center" style="display:none">
<img src="images/loading.gif" />
</div>
<div id="divHolderDoLogin" align="center">
<form method="post" onsubmit="return doLogin()" id="formDoLogin">
<table width="400" cellpadding="2" cellspacing="1">
<tr>
	<td><h1>Log In</h1></td>
</tr>
<tr>
	<td><strong>Email:</strong></td>
	<td><input type="text" name="Email" /></td>
</tr>
<tr>
	<td><strong>Password:</strong></td>
	<td><input type="password" name="Password" /></td>
</tr>
<tr>
	<td align="center" colspan="2"><input type="submit" class="btnMode" value="Login" /></td>
</tr>
<tr>
	<td><a href="javascript: void(0)" onclick="showAccount('recover_password')">Recover password</a></td>
</tr>
<tr>
	<td><a href="javascript: void(0)" onclick="showAccount('create_account')">Create an account</a></td>
</tr>
</table>
</form>
</div>
<script>

$('.btnMode').button();
function doLogin()
{
	obj = Object();
	tc  = $('#formDoLogin').find('input[type=text],input[type=password]');
	for( i=0; i<tc.length; i++ )
	{
		eval('obj.'+$(tc[i]).attr('name')+'="'+$(tc[i]).val()+'"');
	}
	$('#divLoadingDoLogin').toggle();
	$('#divHolderDoLogin').toggle();
	$.post('ajax/account/doLogin.php',obj,function(data){
		$('#divLoadingDoLogin').toggle();
		$('#divHolderDoLogin').toggle();
		alert(data.msg);
		if( data.action == "login" )
		{
			$('#accountDataDiv').dialog('close');
			
			if( cpg == 'checkout' ){
				window.location = window.location;
			}else{
				refreshLogIn();
			}
		}
	},'json');
	return false;
}
</script>