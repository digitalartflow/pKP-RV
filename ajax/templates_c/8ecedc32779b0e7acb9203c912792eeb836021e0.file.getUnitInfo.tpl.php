<?php /* Smarty version Smarty3-b7, created on 2015-08-02 20:08:47
         compiled from "templates/getUnitInfo.tpl" */ ?>
<?php /*%%SmartyHeaderCode:166449687355bedb3f652ed0-94509670%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '8ecedc32779b0e7acb9203c912792eeb836021e0' => 
    array (
      0 => 'templates/getUnitInfo.tpl',
      1 => 1438003865,
    ),
  ),
  'nocache_hash' => '166449687355bedb3f652ed0-94509670',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<style>
#unitInfo p{
	padding:0px;
	margin:0px
}
#unitInfo .price{
	padding:10px 0px 10px 0px
}
#unitInfo .price sup{
	font-size:12px;
	color:#FF9900
}
#unitInfo .price strong{
	font-size:22px;
	color:#FFCC00
}
</style>
<div id="unitinfotabs">
        <ul>
            <li><a href="#tabs-1">Unit info</a></li>
            <li><a href="#tabs-2">Manufacturer info</a></li>
            <?php if ($_smarty_tpl->getVariable('u')->value['HasAppliance']){?><li><a href="#tabs-3">Appliance info</a></li><?php }?>
        </ul>
        <div id="tabs-1">
            <table width="100%" id="unitInfo">
<tr>
	<td valign="top" align="center"><img id="imgPreviewUnitInfo" src="<?php echo @WEBSITE_URL;?>
uploads/unit_u<?php echo $_smarty_tpl->getVariable('uv')->value['Id'];?>
_h<?php echo $_SESSION['getUnitsPost']['h'];?>
_t<?php echo $_SESSION['getUnitsPost']['to'];?>
_a0.png" height="100" />
    <button onclick="goPreview('left')" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-icon-only" role="button" aria-disabled="false" title="left"><span class="ui-button-icon-primary ui-icon ui-icon-circle-triangle-w"></span><span class="ui-button-text">left</span></button>
    <button onclick="goPreview('right')" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-icon-only" role="button" aria-disabled="false" title="right"><span class="ui-button-icon-primary ui-icon ui-icon-circle-triangle-e"></span><span class="ui-button-text">right</span></button>
    <div class="price">
    	<strong><?php echo $_smarty_tpl->getVariable('price')->value;?>
</strong> <sup>$</sup>
    </div>
    </td>
    <td valign="top" width="100%" style="padding:4px">
        <strong style="font-size:14px"><?php echo $_smarty_tpl->getVariable('u')->value['Name'];?>
</strong>
        <div><strong>Description:</strong></div>
        <div style="padding-left:10px">
            <?php echo $_smarty_tpl->getVariable('u')->value['Description'];?>

        </div>
    </td>
</tr>
</table>
        </div>
        <div id="tabs-2">
            <img src="<?php echo @WEBSITE_URL;?>
/uploads/manufacturers/<?php echo $_smarty_tpl->getVariable('manuf')->value['Logo'];?>
" />
        </div>
        <div id="tabs-3">
            <strong><?php echo $_smarty_tpl->getVariable('u')->value['ApplianceName'];?>
</strong><br />
            <?php echo nl2br($_smarty_tpl->getVariable('u')->value['ApplianceDescription']);?>

        </div>
    </div>

<script>
var angle = 0;
var baseImg = '<?php echo @WEBSITE_URL;?>
uploads/unit_u<?php echo $_smarty_tpl->getVariable('uv')->value['Id'];?>
_h<?php echo $_SESSION['getUnitsPost']['h'];?>
_t<?php echo $_SESSION['getUnitsPost']['to'];?>
_a';
function goPreview( dir )
{
	if( dir == 'left' ) angle += 90;
	else angle -= 90;
	if( angle < 0 ) angle += 360;
	if( angle >= 360 ) angle -= 360;
	$('#imgPreviewUnitInfo').attr('src',baseImg+angle+'.png');
}
$(function() {
	$( "#unitinfotabs" ).tabs();
});
</script>
