<?php /* Smarty version Smarty3-b7, created on 2015-08-12 01:11:03
         compiled from "../templates/myaccount/info.tpl" */ ?>
<?php /*%%SmartyHeaderCode:82305249055caff9756ad74-43385411%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '766458e28f6df13f71f562a6a1860d14e0a6d40d' => 
    array (
      0 => '../templates/myaccount/info.tpl',
      1 => 1438003865,
    ),
  ),
  'nocache_hash' => '82305249055caff9756ad74-43385411',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_date_format')) include '/home/content/87/6010387/html/kitchenplanner/demo/libs/plugins/modifier.date_format.php';
?><style>
input[type=text], input[type=password], select
{
	border:1px solid #333333;
	background:#FFFFFF;
	color:#333333;
	padding:2px;
}
</style>
<div id="divLoadingModifyAccount" align="center" style="display:none">
<img src="images/loading.gif" />
</div>
<div align="center" id="divHolderModifyAccount">
<form method="post" id="formCreateAccount" onsubmit="return doModifyAccount()">
<table width="100%" cellpadding="2" cellspacing="1">
<tr>
	<td colspan="2"><h1>Edit Account Information</h1></td>
</tr>
<tr>
	<td width="25%"><strong>Name:</strong></td>
	<td width="75%"><input type="text" name="Name" value="<?php echo $_SESSION['logged']['Name'];?>
" /></td>
</tr>
<tr>
	<td><strong>Gender:</strong></td>
	<td><select name="Gender">
    	<option value="m"<?php if ($_SESSION['logged']['Gender']=="m"){?> selected="selected"<?php }?>>m</option>
    	<option value="f"<?php if ($_SESSION['logged']['Gender']=="f"){?> selected="selected"<?php }?>>f</option>
    </select></td>
</tr>
<tr>
	<td><strong>State:</strong></td>
	<td><select name="State">
    <?php  $_smarty_tpl->tpl_vars['n'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('states')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if (count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['n']->key => $_smarty_tpl->tpl_vars['n']->value){
?>
    	<option value="<?php echo $_smarty_tpl->getVariable('n')->value['Id'];?>
"<?php if ($_SESSION['logged']['State']==$_smarty_tpl->getVariable('n')->value['Id']){?> selected="selected"<?php }?>><?php echo $_smarty_tpl->getVariable('n')->value['name'];?>
</option>
    <?php }} ?>
    </select></td>
</tr>
<tr>
	<td><strong>Postal Code:</strong></td>
	<td><input type="text" name="PostalCode" value="<?php echo $_SESSION['logged']['PostalCode'];?>
" /></td>
</tr>
<tr>
	<td><strong>Date of Birth:</strong></td>
	<td id="dob"><input type="hidden" name="DateOfBirth" id="DateOfBirth" value="<?php echo $_SESSION['logged']['DateOfBirth'];?>
" /></td>
</tr>
<tr>
	<td><strong>Email:</strong></td>
	<td><input type="text" readonly="readonly" name="Email" value="<?php echo $_SESSION['logged']['Email'];?>
" /></td>
</tr>
<tr>
	<td colspan="2" align="center"><input class="btnMode" type="submit" value="Modify" /></td>
</tr>
</table>
</form>
</div>
<script>
$('.btnMode').button();
$(document).ready(function(){
        $("#dob").birthdaypicker({defaultDate:"<?php echo smarty_modifier_date_format($_SESSION['logged']['DateOfBirth'],'%m-%d-%Y');?>
"});
});
function doModifyAccount()
{
	$('#DateOfBirth').val($('#dob .birth-year').val()+'-'+$('#dob .birth-month').val()+'-'+$('#dob .birth-day').val());
	$('#dob .birthday-picker').remove();
	obj = Object();
	tc  = $('#formCreateAccount').find('input[type=text],input[type=password],input[type=hidden],input[type=checkbox]:checked,select');
	for( i=0; i<tc.length; i++ )
	{
		eval('obj.'+$(tc[i]).attr('name')+'="'+$(tc[i]).val()+'"');
	}
	$('#divLoadingModifyAccount').toggle();
	$('#divHolderModifyAccount').toggle();
	$.post('ajax/account/doModifyAccount.php',obj,function(data){
		$('#divLoadingModifyAccount').toggle();
		$('#divHolderModifyAccount').toggle();
		alert(data.msg);
		loadMyAccount('info');
	},'json');
	return false;
}
</script>