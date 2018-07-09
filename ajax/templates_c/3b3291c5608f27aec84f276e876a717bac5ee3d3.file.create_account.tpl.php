<?php /* Smarty version Smarty3-b7, created on 2015-07-27 06:54:46
         compiled from "../templates/account/create_account.tpl" */ ?>
<?php /*%%SmartyHeaderCode:113224539055b63826050719-65728665%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '3b3291c5608f27aec84f276e876a717bac5ee3d3' => 
    array (
      0 => '../templates/account/create_account.tpl',
      1 => 1438003865,
    ),
  ),
  'nocache_hash' => '113224539055b63826050719-65728665',
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
h1{
	padding:0px;
	margin:0px
}
</style>
<div id="divLoadingCreateAccount" align="center" style="display:none">
<img src="images/loading.gif" />
</div>
<div align="left" id="divHolderCreateAccount">
<form method="post" id="formCreateAccount" onsubmit="return doCreateAccount()">
<table width="80%" cellpadding="2" cellspacing="1">
<tr>
	<td colspan="2"><h1>Create an Account</h1></td>
</tr>
<tr>
	<td width="25%"><strong>Name:</strong></td>
	<td width="75%"><input type="text" name="Name" /></td>
</tr>
<tr>
	<td><strong>Gender:</strong></td>
	<td><select name="Gender">
    	<option value="m">m</option>
    	<option value="f">f</option>
    </select></td>
</tr>
<tr>
	<td><strong>State:</strong></td>
	<td><select name="State">
    <option value="-">--Please Select</option>
    <?php  $_smarty_tpl->tpl_vars['n'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('states')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if (count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['n']->key => $_smarty_tpl->tpl_vars['n']->value){
?>
    	<option value="<?php echo $_smarty_tpl->getVariable('n')->value['Id'];?>
"><?php echo $_smarty_tpl->getVariable('n')->value['name'];?>
</option>
    <?php }} ?>
    </select></td>
</tr>
<tr>
	<td><strong>Postal Code:</strong></td>
	<td><input type="text" name="PostalCode" value="" /></td>
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
	<td valign="top"><strong>How did you heard about us?</strong></td>
	<td><select id="found_us" name="found_us" onchange="toggleFUE()">
    	<option value=""> -- pick -- </option>
    	<option value="Google">Google</option>
    	<option value="Yahoo">Yahoo</option>
    	<option value="Bing">Bing</option>
    	<option class="sfue" value="Website ads">Website ads</option>
    	<option value="TV">TV</option>
    	<option value="Radio">Radio</option>
    	<option value="Facebook">Facebook</option>
    	<option value="Google Plus">Google+</option>
    	<option class="sfue" value="Other">Other</option>
    </select>
    <div id="found_us_extra" style="display:none">
    <em>More Information:</em><br />
    <textarea name="found_us_extra" style="width:60%"></textarea>
    </div>
    <script>
	function toggleFUE(){
		if($('#found_us>.sfue:selected').length > 0){
			$('#found_us_extra').show();
		}else{
			$('#found_us_extra').hide();
		}
	}
	</script>
    </td>
</tr>
<tr>
	<td><strong>Security Code:</strong></td>
	<td><input type="text" name="SecurityCode" style="width:50px; float:left" /> <img src="images/refresh.gif" style="float:left; border:1px solid #333333; cursor:pointer" height="20" onclick="$('#imgCodSecuritate').attr('src','images/codsecuritate.jpg?r='+Math.random())" /> <img src="images/codsecuritate.jpg" id="imgCodSecuritate" style="float:left; border:1px solid #333333" /></td>
</tr>
<tr>
	<td colspan="2" align="center"><input type="checkbox" name="Terms" value="yes" /> I have read and agree to the Terms of Use and Privacy Policy.</td>
</tr>
<tr>
	<td colspan="2" align="center"><input class="btnMode" type="submit" value="Create account" /></td>
</tr>
<tr>
	<td colspan="2"><a href="javascript: void(0)" onclick="showAccount('login')">Log In</a></td>
</tr>
</table>
</form>
</div>
<script>
$('.btnMode').button();

function doCreateAccount()
{
	dob = $('#dob .birth-month').val()+'-'+$('#dob .birth-day').val()+'-'+$('#dob .birth-year').val();
	$('#DateOfBirth').val(dob);
	$('#dob .birthday-picker').remove();
	obj = Object();
	tc  = $('#formCreateAccount').find('input[type=text],input[type=password],input[type=hidden],input[type=checkbox]:checked,select');
	for( i=0; i<tc.length; i++ )
	{
		eval('obj.'+$(tc[i]).attr('name')+'="'+$(tc[i]).val()+'"');
	}
	$('#divLoadingCreateAccount').toggle();
	$('#divHolderCreateAccount').toggle();
	$.post('ajax/account/doCreateAccount.php',obj,function(data){
		$('#imgCodSecuritate').attr('src','images/codsecuritate.jpg?r='+Math.random());
		$('#divLoadingCreateAccount').toggle();
		$('#divHolderCreateAccount').toggle();
		alert(data.msg);
		if( data.action == "login" )
		{
			$('#accountDataDiv').dialog('close');
			refreshLogIn();
		}
	},'json');
	return false;
}
</script>