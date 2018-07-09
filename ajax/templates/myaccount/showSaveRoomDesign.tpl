<style>
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
{{if $rd|@count == 0}}
You have no room design saved
{{else}}
<table width="100%" cellpadding="2" cellspacing="1">
<tr bgcolor="#666666">
	<td width="65%"><strong>Name</strong></td>
	<td width="35%"><strong>Last date modified</strong></td>
	<td></td>
</tr>
{{foreach from=$rd item=n}}
<tr bgcolor="#333333">
	<td>{{$n.Name}}</td>
	<td style="font-size:10px">{{$n.SaveDate|date_format:"%d %b %Y %H:%M"}}</td>
	<td><input type="button" value="Save" onclick="doSaveRoomDesign({{$n.Id}},'')" /></td>
</tr>
{{/foreach}}
</table>
{{/if}}
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