<?php /* Smarty version Smarty3-b7, created on 2015-07-27 06:33:11
         compiled from "../templates/myaccount/saved_rooms.tpl" */ ?>
<?php /*%%SmartyHeaderCode:125911038855b633179576d7-87011270%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '81a7b50dceb3d09cda16f5d59a5118d9d268e279' => 
    array (
      0 => '../templates/myaccount/saved_rooms.tpl',
      1 => 1438003865,
    ),
  ),
  'nocache_hash' => '125911038855b633179576d7-87011270',
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
<div align="left" id="divHolderModifyAccount">
<h1 align="left">Saved rooms</h1>
<?php if (count($_smarty_tpl->getVariable('rd')->value)==0){?>
You have no room design saved
<?php }else{ ?>
<table width="100%" cellpadding="2" cellspacing="1">
<tr bgcolor="#666666">
	<td width="65%"><strong>Name</strong></td>
	<td width="35%"><strong>Last date modified</strong></td>
	<td colspan="2"></td>
</tr>
<?php  $_smarty_tpl->tpl_vars['n'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('rd')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if (count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['n']->key => $_smarty_tpl->tpl_vars['n']->value){
?>
<tr bgcolor="#333333">
	<td><?php echo $_smarty_tpl->getVariable('n')->value['Name'];?>
</td>
	<td style="font-size:10px"><?php echo smarty_modifier_date_format($_smarty_tpl->getVariable('n')->value['SaveDate'],"%d %b %Y %H:%M");?>
</td>
	<td><input type="button" value="LOAD" onclick="doLoadRoomDesign(<?php echo $_smarty_tpl->getVariable('n')->value['Id'];?>
)" /></td>
	<td><input type="button" value="DELETE" onclick="doDeleteRoomDesign(<?php echo $_smarty_tpl->getVariable('n')->value['Id'];?>
)" /></td>
</tr>
<?php }} ?>
</table>
<?php }?>
</div>
<script>
$('.btnMode').button();
function doLoadRoomDesign(rid)
{
	window.location='<?php echo @WEBSITE_URL;?>
room-planner.html?lrid='+rid;
	return false;
	$('#divLoadingModifyAccount').toggle();
	$('#divHolderModifyAccount').toggle();
	$.post('ajax/myaccount/doLoadRoomDesign.php',{ id: rid },function(data){
		$('#divLoadingModifyAccount').toggle();
		$('#divHolderModifyAccount').toggle();
		alert(data.msg);
		if( data.resp == "ok" )
			window.location='<?php echo @WEBSITE_URL;?>
room-planner.html';
	},'json');
	return false;
}
function doDeleteRoomDesign(rid)
{
	if( confirm( 'Realy delete?' ) )
	{
		$('#divLoadingModifyAccount').toggle();
		$('#divHolderModifyAccount').toggle();
		$.post('ajax/myaccount/doDeleteRoomDesign.php',{ id: rid },function(data){
			$('#divLoadingModifyAccount').toggle();
			$('#divHolderModifyAccount').toggle();
			alert(data.msg);
			if( data.resp == "ok" )
				window.location=window.location;
		},'json');
		return false;
	}
}
</script>