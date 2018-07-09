{{include file='main_pieces/header.tpl'}}
<div id="listItems" class="pagePieces">
<h1>Room doors <input type="button" value="Add" onclick="modifyItem(0)" /></h1>
<fieldset style="margin-bottom:5px">
<legend><strong>Search:</strong></legend>
<form method="get">
<input type="hidden" name="page" value="{{$smarty.get.page}}" />
<table width="100%" cellpadding="5" cellspacing="1">
<tr>
	<td><strong>Expression:</strong></td>
	<td><input type="text" name="expression" value="{{$smarty.get.expression|default:''}}" /></td>
	<td><strong>Type:</strong></td>
	<td><select name="type">
    <option value="">--choose--</option>
    {{foreach $types as $n}}
    <option value="{{$n.Id}}"{{if isset($smarty.get.type) && $smarty.get.type==$n.Id}} selected="selected"{{/if}}>{{$n.Name}}</option>
    {{/foreach}}
    </select></td>
</tr>
<tr>
	<td align="center" colspan="4"><input type="submit" value="Search" /> <input type="button" value="Reset" onclick="window.location='?page={{$smarty.get.page}}'" /></td>
</tr>
</table>
</form>
</fieldset>
<div class="paginare">
Pages: {{section loop=$pagini name=pagini}} <a href="{{$linkwcp}}&pg={{$smarty.section.pagini.iteration}}"{{if $curpag==$smarty.section.pagini.iteration}} class="on"{{/if}}>{{$smarty.section.pagini.iteration}}</a>{{/section}}
</div>
<table width="100%" cellpadding="5" cellspacing="1">
<tr bgcolor="#000000" style="color:#FFF">
	<th align="center">#</th>
	<th align="left" width="100%">Name</th>
	<th align="center">Type</th>
	<th align="center">WxH</th>
	<th align="center">D.Nr.</th>
	<th align="center">Actions</th>
</tr>
{{foreach $items as $n}}
<tr bgcolor="{{cycle values='#EEE,#CCC'}}">
	<td>{{$n.Id}}</td>
	<td><strong>{{$n.Name}}</strong></td>
	<td align="left" nowrap="nowrap">{{$types[$n.IdType].Name}}</td>
	<td align="left" nowrap="nowrap">{{$n.W}}x{{$n.H}} mm</td>
	<td align="center" nowrap="nowrap">{{$n.Pics|@count}}</td>
    <td align="center"><input type="button" value="Edit" onclick="modifyItem({{$n.Id}})" /><br /><form id="form_{{$n.Id}}" method="post"><input type="hidden" name="action" value="delete" /><input type="hidden" name="Id" value="{{$n.Id}}" /><input type="button" onclick="del({{$n.Id}})" value="Delete" style="margin-top:2px; background:#900" />
</form></td>
</tr>
{{/foreach}}
</table
>
<div class="paginare">
Pages: {{section loop=$pagini name=pagini}} <a href="{{$linkwcp}}&pg={{$smarty.section.pagini.iteration}}"{{if $curpag==$smarty.section.pagini.iteration}} class="on"{{/if}}>{{$smarty.section.pagini.iteration}}</a>{{/section}}
</div>
<script>
$(document).ready(function() {
		$( ".date" ).datepicker({dateFormat:"yy-mm-dd"});
	});
</script>
<script>
function del( obj )
{
	if( confirm('Really delete?') )
	{
		obj = $('#form_'+obj);
		//$(obj).find('input[name=action]').val('delete');
		$(obj).submit();
	}
}
</script>
</div>
<div id="modifyItem0" class="pagePieces" style="display:none">
<h1>Add <input type="button" value="Cancel" onclick="showItemListing()" /></h1>
<fieldset style="margin-bottom:5px">
<legend><strong>Form:</strong></legend>
<form method="post" enctype="multipart/form-data">
<input type="hidden" name="action" value="modify" />
<input type="hidden" name="Id" value="-1" />
<table width="100%" cellpadding="5" cellspacing="1">
<tr>
	<td nowrap="nowrap"><strong>Name:</strong></td>
	<td width="100%"><input type="text" name="Name" value="" /></td>
</tr>
<tr>
	<td nowrap="nowrap"><strong>Type:</strong></td>
	<td><select name="IdType">
    {{foreach $types as $n}}
    <option value="{{$n.Id}}">{{$n.Name}}</option>
    {{/foreach}}
    </select></td>
</tr>
<tr>
	<td nowrap="nowrap"><strong>Width x Height:</strong></td>
	<td><input type="text" name="W" value="0" style="width:75px" /> mm X <input type="text" name="H" value="0" style="width:75px" /> mm</td>
</tr>
<tr>
	<td align="center" colspan="2"><input type="submit" value="Save" /> <input type="button" value="Cancel" onclick="showItemListing()" /></td>
</tr>
</table>

<fieldset style="margin-bottom:5px">
<legend><strong>Door variations:</strong></legend>
<div id="innerItemsHolder0">
	<div class="innerItemsHolderChild">
    <input type="button" value="Delete" onclick="$(this).parent().remove()" style="float:right; margin:5px" />
    <input type="hidden" name="dv_Id[]" value="-1" />
    <table width="100%" cellpadding="5" cellspacing="1"style="border-bottom:1px dashed #999999; background:#EFEFEF; margin-bottom:2px">
    <tr>
        <td nowrap="nowrap"><strong>Name:</strong></td>
        <td width="50%"><input type="text" name="dv_Name[]" value="" /></td>
        <td nowrap="nowrap"><strong>Presentation picture:</strong></td>
        <td width="50%"><input type="file" name="dv_Picture[]" value="" /></td>
    </tr>
    <tr>
        <td nowrap="nowrap"><strong>Rendered 0* picture:</strong></td>
        <td><input type="file" name="dv_Render0[]" value="" /></td>
        <td nowrap="nowrap"><strong>Rendered 90* picture:</strong></td>
        <td><input type="file" name="dv_Render90[]" value="" /></td>
    </tr>
    <tr>
        <td nowrap="nowrap"><strong>Rendered 180* picture:</strong></td>
        <td><input type="file" name="dv_Render180[]" value="" /></td>
        <td nowrap="nowrap"><strong>Rendered 270* picture:</strong></td>
        <td><input type="file" name="dv_Render270[]" value="" /></td>
    </tr>
    </table>
    </div>
</div>
<div align="center"><input type="button" value="+ Add door variation" onclick="addInnerItem(0)" /></div>
</fieldset>
<table width="100%" cellpadding="5" cellspacing="1">
<tr>
	<td align="center"><input type="submit" value="Save" /> <input type="button" value="Cancel" onclick="showItemListing()" /></td>
</tr>
</table>
</form>
</fieldset>
</div>
{{foreach $items as $n}}
<div id="modifyItem{{$n.Id}}" class="pagePieces" style="display:none">
{{*<pre>{{$n|@print_r}}</pre>*}}
<h1>Edit <input type="button" value="Cancel" onclick="showItemListing()" /></h1>
<fieldset style="margin-bottom:5px">
<legend><strong>Form:</strong></legend>
<form method="post" enctype="multipart/form-data">
<input type="hidden" name="action" value="modify" />
<input type="hidden" name="Id" value="{{$n.Id}}" />
<table width="100%" cellpadding="5" cellspacing="1">
<tr>
	<td nowrap="nowrap"><strong>Name:</strong></td>
	<td width="100%"><input type="text" name="Name" value="{{$n.Name}}" /></td>
</tr>
<tr>
	<td nowrap="nowrap"><strong>Type:</strong></td>
	<td><select name="IdType">
    {{foreach $types as $t}}
    <option value="{{$t.Id}}"{{if $t.Id==$n.IdType}} selected="selected"{{/if}}>{{$t.Name}}</option>
    {{/foreach}}
    </select></td>
</tr>
<tr>
	<td nowrap="nowrap"><strong>Width x Height:</strong></td>
	<td><input type="text" name="W" style="width:75px" value="{{$n.W}}" /> mm X <input type="text" name="H" style="width:75px" value="{{$n.H}}" /> mm</td>
</tr>
<tr>
	<td align="center" colspan="2"><input type="submit" value="Save" /> <input type="button" value="Cancel" onclick="showItemListing()" /></td>
</tr>
</table>

<fieldset style="margin-bottom:5px">
<legend><strong>Door variations:</strong></legend>
<div id="innerItemsHolder{{$n.Id}}">
	<div class="innerItemsHolderChild" style="display:none">
    <input type="button" value="Delete" onclick="$(this).parent().remove()" style="float:right; margin:5px" />
    <input type="hidden" name="dv_Id[]" value="-1" />
    <table width="100%" cellpadding="5" cellspacing="1"style="border-bottom:1px dashed #999999; background:#EFEFEF; margin-bottom:2px">
    <tr>
        <td nowrap="nowrap"><strong>Name:</strong></td>
        <td width="50%"><input type="text" name="dv_Name[]" value="" /></td>
        <td nowrap="nowrap"><strong>Presentation picture:</strong></td>
        <td width="50%"><input type="file" name="dv_Picture[]" value="" /></td>
    </tr>
    <tr>
        <td nowrap="nowrap"><strong>Rendered 0* picture:</strong></td>
        <td><input type="file" name="dv_Render0[]" value="" /></td>
        <td nowrap="nowrap"><strong>Rendered 90* picture:</strong></td>
        <td><input type="file" name="dv_Render90[]" value="" /></td>
    </tr>
    <tr>
        <td nowrap="nowrap"><strong>Rendered 180* picture:</strong></td>
        <td><input type="file" name="dv_Render180[]" value="" /></td>
        <td nowrap="nowrap"><strong>Rendered 270* picture:</strong></td>
        <td><input type="file" name="dv_Render270[]" value="" /></td>
    </tr>
    </table>
    </div>
	{{foreach $n.Pics as $p}}
	<div class="innerItemsHolderChild">
    <input type="button" value="Delete" onclick="$(this).parent().remove()" style="float:right; margin:5px" />
    <input type="hidden" name="dv_Id[]" value="{{$p.Id}}" />
    <table width="100%" cellpadding="5" cellspacing="1"style="border-bottom:1px dashed #999999; background:#EFEFEF; margin-bottom:2px">
    <tr>
    	<td rowspan="3"><img src="{{$config.siteurl}}uploads/door_variation/{{$p.Picture}}" class="imgNice" /></td>
        <td nowrap="nowrap"><strong>Name:</strong></td>
        <td width="50%"><input type="text" name="dv_Name[]" value="{{$p.Name}}" /></td>
        <td nowrap="nowrap"><strong>Presentation picture:</strong></td>
        <td width="50%"><input type="file" name="dv_Picture[]" value="" /></td>
    </tr>
    <tr>
        <td nowrap="nowrap"><strong>Rendered 0* picture:</strong></td>
        <td><input type="file" name="dv_Render0[]" value="" /></td>
        <td nowrap="nowrap"><strong>Rendered 90* picture:</strong></td>
        <td><input type="file" name="dv_Render90[]" value="" /></td>
    </tr>
    <tr>
        <td nowrap="nowrap"><strong>Rendered 180* picture:</strong></td>
        <td><input type="file" name="dv_Render180[]" value="" /></td>
        <td nowrap="nowrap"><strong>Rendered 270* picture:</strong></td>
        <td><input type="file" name="dv_Render270[]" value="" /></td>
    </tr>
    </table>
    </div>
    {{/foreach}}
</div>
<div align="center"><input type="button" value="+ Add door variation" onclick="addInnerItem({{$n.Id}})" /></div>
</fieldset>
<table width="100%" cellpadding="5" cellspacing="1">
<tr>
	<td align="center"><input type="submit" value="Save" /> <input type="button" value="Cancel" onclick="showItemListing()" /></td>
</tr>
</table>
</form>
</fieldset>
</div>
{{/foreach}}
<script>
function addInnerItem(iId){
	$('#innerItemsHolder'+iId).append('<div class="innerItemsHolderChild">'+$($('#innerItemsHolder'+iId+'>div').get(0)).html()+'</div>');
}
function showItemListing()
{
	$('.pagePieces:visible').slideUp();
	$('#listItems').slideDown();
}
function modifyItem( iId )
{
	$('#listItems').slideUp();
	$('#modifyItem'+iId).slideDown();
}
</script>
{{include file='main_pieces/footer.tpl'}}