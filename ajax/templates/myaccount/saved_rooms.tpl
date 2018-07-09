<style>
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
{{if $rd|@count == 0}}
You have no room design saved
{{else}}
<table width="100%" cellpadding="2" cellspacing="1">
<tr bgcolor="#666666">
	<td width="65%"><strong>Name</strong></td>
	<td width="35%"><strong>Last date modified</strong></td>
	<td colspan="2"></td>
</tr>
{{foreach from=$rd item=n}}
<tr bgcolor="#333333">
	<td>{{$n.Name}}</td>
	<td style="font-size:10px">{{$n.SaveDate|date_format:"%d %b %Y %H:%M"}}</td>
	<td><input type="button" value="LOAD" onclick="doLoadRoomDesign({{$n.Id}})" /></td>
	<td><input type="button" value="DELETE" onclick="doDeleteRoomDesign({{$n.Id}})" /></td>
</tr>
{{/foreach}}
</table>
{{/if}}
</div>
<script>
$('.btnMode').button();
function doLoadRoomDesign(rid)
{
	window.location='{{$smarty.const.WEBSITE_URL}}room-planner.html?lrid='+rid;
	return false;
	$('#divLoadingModifyAccount').toggle();
	$('#divHolderModifyAccount').toggle();
	$.post('ajax/myaccount/doLoadRoomDesign.php',{ id: rid },function(data){
		$('#divLoadingModifyAccount').toggle();
		$('#divHolderModifyAccount').toggle();
		alert(data.msg);
		if( data.resp == "ok" )
			window.location='{{$smarty.const.WEBSITE_URL}}room-planner.html';
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