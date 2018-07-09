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
            {{if $u.HasAppliance}}<li><a href="#tabs-3">Appliance info</a></li>{{/if}}
        </ul>
        <div id="tabs-1">
            <table width="100%" id="unitInfo">
<tr>
	<td valign="top" align="center"><img id="imgPreviewUnitInfo" src="{{$smarty.const.WEBSITE_URL}}uploads/unit_u{{$uv.Id}}_h{{$smarty.session.getUnitsPost.h}}_t{{$smarty.session.getUnitsPost.to}}_a0.png" height="100" />
    <button onclick="goPreview('left')" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-icon-only" role="button" aria-disabled="false" title="left"><span class="ui-button-icon-primary ui-icon ui-icon-circle-triangle-w"></span><span class="ui-button-text">left</span></button>
    <button onclick="goPreview('right')" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-icon-only" role="button" aria-disabled="false" title="right"><span class="ui-button-icon-primary ui-icon ui-icon-circle-triangle-e"></span><span class="ui-button-text">right</span></button>
    <div class="price">
    	<strong>{{$price}}</strong> <sup>$</sup>
    </div>
    </td>
    <td valign="top" width="100%" style="padding:4px">
        <strong style="font-size:14px">{{$u.Name}}</strong>
        <div><strong>Description:</strong></div>
        <div style="padding-left:10px">
            {{$u.Description}}
        </div>
    </td>
</tr>
</table>
        </div>
        <div id="tabs-2">
            <img src="{{$smarty.const.WEBSITE_URL}}/uploads/manufacturers/{{$manuf.Logo}}" />
        </div>
        <div id="tabs-3">
            <strong>{{$u.ApplianceName}}</strong><br />
            {{$u.ApplianceDescription|nl2br}}
        </div>
    </div>

<script>
var angle = 0;
var baseImg = '{{$smarty.const.WEBSITE_URL}}uploads/unit_u{{$uv.Id}}_h{{$smarty.session.getUnitsPost.h}}_t{{$smarty.session.getUnitsPost.to}}_a';
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
