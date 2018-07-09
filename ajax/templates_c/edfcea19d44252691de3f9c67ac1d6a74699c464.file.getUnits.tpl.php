<?php /* Smarty version Smarty3-b7, created on 2015-07-27 06:31:23
         compiled from "templates/getUnits.tpl" */ ?>
<?php /*%%SmartyHeaderCode:148054141955b632abd42f54-67471130%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'edfcea19d44252691de3f9c67ac1d6a74699c464' => 
    array (
      0 => 'templates/getUnits.tpl',
      1 => 1438003865,
    ),
  ),
  'nocache_hash' => '148054141955b632abd42f54-67471130',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php  $_smarty_tpl->tpl_vars['n'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('items')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if (count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['n']->key => $_smarty_tpl->tpl_vars['n']->value){
?>
	<div class="unit">
    <table width="100%">
    <tr>
    	<td valign="top"><div style="background:url(<?php echo $_smarty_tpl->getVariable('n')->value['pic'];?>
) no-repeat center; width:75px; height:75px; background-size:contain"></div></td>
    	<td width="100%" valign="top" style="height:105px"><strong style="font-size:14px"><?php echo $_smarty_tpl->getVariable('n')->value['UnitName'];?>
</strong><br />
       <em><?php echo $_smarty_tpl->getVariable('n')->value['Code'];?>
</em>
        <?php if ($_smarty_tpl->getVariable('n')->value['HasAppliance']=="yes"){?>
        <div style="background:#E2E2E2; padding:5px 5px 5px 0px"><strong>Appliance:</strong> <?php echo $_smarty_tpl->getVariable('n')->value['ApplianceName'];?>
</div>
        <?php }?><br />
    	<?php if ($_smarty_tpl->getVariable('n')->value['UnitAttaching']=="2"){?>corner unit<br /><?php }?>
        <a href="javascript: void(0)" onclick="showUnitInfo(<?php echo $_smarty_tpl->getVariable('n')->value['Id'];?>
)" style="color:#990000">View description</a>
    	</td>
    </tr>
    <tr>
    <td colspan="2" align="center">
    <strong style="font-size:24px; display:block; float:left; color:#006600"><?php echo $_smarty_tpl->getVariable('n')->value['FinalPrice'];?>
 $</strong><input type="button" value="Add unit" onclick='addUnit(<?php echo $_smarty_tpl->getVariable('n')->value['Id'];?>
,"<?php echo $_smarty_tpl->getVariable('n')->value['JSON_DATA'];?>
")' style="background:#006600; color:#FFFFFF; border:0px; float:right; border-radius:3px; padding:4px 8px 4px 8px; cursor:pointer" /></td>
    </tr>
    </table>
    </div>
<?php }} ?>