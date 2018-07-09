{{foreach from=$items item=n}}
	<div class="unit">
    <table width="100%">
    <tr>
    	<td valign="top"><div style="background:url({{$n.pic}}) no-repeat center; width:75px; height:75px; background-size:contain"></div></td>
    	<td width="100%" valign="top" style="height:105px"><strong style="font-size:14px">{{$n.UnitName}}</strong><br />
       <em>{{$n.Code}}</em>
        {{if $n.HasAppliance=="yes"}}
        <div style="background:#E2E2E2; padding:5px 5px 5px 0px"><strong>Appliance:</strong> {{$n.ApplianceName}}</div>
        {{/if}}<br />
    	{{if $n.UnitAttaching=="2"}}corner unit<br />{{/if}}
        <a href="javascript: void(0)" onclick="showUnitInfo({{$n.Id}})" style="color:#990000">View description</a>
    	</td>
    </tr>
    <tr>
    <td colspan="2" align="center">
    <strong style="font-size:24px; display:block; float:left; color:#006600">{{$n.FinalPrice}} $</strong><input type="button" value="Add unit" onclick='addUnit({{$n.Id}},"{{$n.JSON_DATA}}")' style="background:#006600; color:#FFFFFF; border:0px; float:right; border-radius:3px; padding:4px 8px 4px 8px; cursor:pointer" /></td>
    </tr>
    </table>
    </div>
{{/foreach}}