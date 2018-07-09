<?php /* Smarty version Smarty3-b7, created on 2015-11-23 09:57:31
         compiled from "../templates/myaccount/showSaveRoomDesign.tpl" */ ?>
<?php /*%%SmartyHeaderCode:21149074275653457b722d97-72619537%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a1fb5b93cc1e7220beb239cface371cacce3dd39' => 
    array (
      0 => '../templates/myaccount/showSaveRoomDesign.tpl',
      1 => 1438003865,
    ),
  ),
  'nocache_hash' => '21149074275653457b722d97-72619537',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_date_format')) include '/home/content/87/6010387/html/kitchenplanner/demo/libs/plugins/modifier.date_format.php';
?><style>
h1{
	padding:4px;
	margin:0px;
	font-size:12px;
	text-align:left
}
input[type=text], input[type=password], select
{
	border:1px solid #333333;
	background:#FFFFFF;
	color:#333333;
	padding:2px;
}
fieldset
{
	border:1px solid #666666
}
fieldset legend{
	padding:10px
}
</style>
<div id="divLoadingSaveRoomDesign" align="center" style="display:none">
<img src="images/loading.gif" />
</div>
<div align="left" id="holderSaveRoomDesignForm">
<fieldset>
<legend>Overwrite saved design</legend>
<?php if (count($_smarty_tpl->getVariable('rd')->value)==0){?>
You have no room design saved
<?php }else{ ?>
<table width="100%" cellpadding="2" cellspacing="1">
<tr bgcolor="#666666">
	<td width="65%"><strong>Name</strong></td>
	<td width="35%"><strong>Last date modified</strong></td>
	<td></td>
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
	<td><input type="button" value="Save" onclick="doSaveRoomDesign(<?php echo $_smarty_tpl->getVariable('n')->value['Id'];?>
,'')" /></td>
</tr>
<?php }} ?>
</table>
<?php }?>
</fieldset>
<fieldset>
<legend>Save design as new</legend>
<strong>New name:</strong> <input type="text" id="newNameRoomDesign" style="width:65%" value="Type new name here" /> <input type="button" value="Save" onclick="doSaveRoomDesign(0,$('#newNameRoomDesign').val())" />
</fieldset>
</div>
<script>
$('.btnMode').button();
function doSaveRoomDesign( sid, sname )
{
	$('#divLoadingSaveRoomDesign').show();
	$('#holderSaveRoomDesignForm').hide();
	$.post('ajax/myaccount/doSaveRoomDesign.php',{ id:sid, name:sname },function(data){
		alert(data.msg);
		$('#divLoadingSaveRoomDesign').hide();
		$('#holderSaveRoomDesignForm').show();
		if( data.resp == 'ok' )
			$( "#saveRoomDesignDiv" ).dialog('close');
	},'json');
}
</script>