{{include file='main_pieces/header.tpl'}}
<div id="listItems" class="pagePieces">
<h1>Predefined styles<input type="button" value="Add" onclick="modifyItem(0)" /></h1>
<fieldset style="margin-bottom:5px">
<legend><strong>Search:</strong></legend>
<form method="get">
<input type="hidden" name="page" value="{{$smarty.get.page}}" />
<table width="100%" cellpadding="5" cellspacing="1">
<tr>
	<td><strong>Expression:</strong></td>
	<td width="100%"><input type="text" name="expression" value="{{$smarty.get.expression|default:''}}" /></td>
</tr>
<tr>
	<td align="center" colspan="2"><input type="submit" value="Search" /> <input type="button" value="Reset" onclick="window.location='?page={{$smarty.get.page}}'" /></td>
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
	<th align="left"></th>
	<th align="left" width="100%">Name</th>
	<th align="left">Default</th>
	<th align="left">Price order</th>
	<th align="center">Actions</th>
</tr>
{{foreach $items as $n}}
<tr bgcolor="{{cycle values='#EEE,#CCC'}}">
	<td>{{$n.Id}}</td>
	<td><img src="{{$config.siteurl}}uploads/predefined_styles/small/{{$n.pic}}" /></td>
	<td>{{$n.name}}</td>
	<td nowrap="nowrap">{{if $n.default == 1}}yes{{else}}no{{/if}}</td>
	<td nowrap="nowrap">{{$n.price_order}}</td>
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
	<td width="50%"><input type="text" name="name" value="" /> <div><input type="checkbox" name="default" value="1" /> Is default</div></td>
	<td nowrap="nowrap"><strong>Picture:</strong></td>
	<td width="50%"><input type="file" name="picture" value="" /></td>
</tr>
<tr>
	<td nowrap="nowrap"><strong>Price order:</strong></td>
	<td width="50%"><input type="text" name="price_order" value="0" /></td>
    <td colspan="2">used to order predefined styles from low prices (0) to high prices (highest number)</td>
</tr>


<tr>
	<td nowrap="nowrap"><strong>Regions</strong><br /><em>(selecting none has the same effect like selecting all)</em></td>
    <td>
    <select name="Regions[]" size="5" style="float:left" multiple="multiple">
    {{foreach $states as $s}}
    <optgroup label="{{$s.name}}">
    {{foreach from=$states_regions item=r}}
    	{{if $r.id_state==$s.Id}}
    	<option value="{{$r.Id}}">{{$r.min}} > {{$r.max}}</option>
        {{/if}}
     {{/foreach}}
    </optgroup>
    {{/foreach}}
    </select></td>
</tr>
<tr>
	<td nowrap="nowrap"><strong>Doors:</strong></td>
	<td width="50%"><select name="doors[]" multiple="multiple" size="5" style="width:100%">
    {{foreach from=$doors_categories item=s}}
    <option value="{{$s.Id}}">{{$s.Name}}</option>
    {{/foreach}}
    </select></td>
	<td nowrap="nowrap"><strong>Handles:</strong></td>
	<td width="50%"><select name="handles[]" multiple="multiple" size="5" style="width:100%">
    {{foreach from=$handles_categories item=s}}
    <option value="{{$s.Id}}">{{$s.Name}}</option>
    {{/foreach}}
    </select></td>
</tr>
<tr>
	<td nowrap="nowrap"><strong>Carcasses:</strong></td>
	<td width="50%"><select name="carcasses[]" multiple="multiple" size="5" style="width:100%">
    {{foreach from=$carcasses_categories item=s}}
    <option value="{{$s.Id}}">{{$s.Name}}</option>
    {{/foreach}}
    </select></td>
	<td nowrap="nowrap"><strong>Textures:</strong></td>
	<td width="50%"><select name="textures[]" multiple="multiple" size="5" style="width:100%">
    {{foreach from=$textures_categories item=s}}
    <option value="{{$s.Id}}">{{$s.Name}}</option>
    {{/foreach}}
    </select></td>
</tr>
<tr>
	<td nowrap="nowrap"><strong>Worktops:</strong></td>
	<td width="50%"><select name="top_textures[]" multiple="multiple" size="5" style="width:100%">
    {{foreach from=$tops_categories item=s}}
    <option value="{{$s.Id}}">{{$s.Name}}</option>
    {{/foreach}}
    </select></td>
	<td nowrap="nowrap"><strong>Manufacturer:</strong></td>
	<td width="50%"><select name="furniture_types[]" multiple="multiple" size="5" style="width:100%">
    {{foreach from=$furniture_types item=s}}
    <option value="{{$s.Id}}">{{$s.Name}}</option>
    {{/foreach}}
    </select></td>
</tr>
<tr>
	<td align="center" colspan="4"><input type="submit" value="Save" /> <input type="button" value="Cancel" onclick="showItemListing()" /></td>
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
	<td width="50%"><input type="text" name="name" value="{{$n.name}}" /> <div><input type="checkbox" name="default" value="1"{{if $n.default==1}} checked="checked"{{/if}} /> Is default</div></td>
	<td nowrap="nowrap"><strong>Picture:</strong></td>
	<td width="50%"><a href="{{$config.siteurl}}uploads/predefined_styles/original/{{$n.pic}}" target="_blank"><img src="{{$config.siteurl}}uploads/predefined_styles/small/{{$n.pic}}" align="left" /></a><input type="file" name="picture" value="" /></td>
</tr>
<tr>
	<td nowrap="nowrap"><strong>Price order:</strong></td>
	<td width="50%"><input type="text" name="price_order" value="{{$n.price_order}}" /></td>
    <td colspan="2">used to order predefined styles from low prices (0) to high prices (highest number)</td>
</tr>

<tr>
	<td nowrap="nowrap"><strong>Regions</strong><br /><em>(selecting none has the same effect like selecting all)</em></td>
    <td colspan="3">
    <select name="Regions[]" size="5" style="float:left; min-width:400px" multiple="multiple">
    {{foreach $states as $s}}
    <optgroup label="{{$s.name}}">
    {{foreach from=$states_regions item=r}}
    	{{if $r.id_state==$s.Id}}
    	<option value="{{$r.Id}}"{{if in_array($r.Id,$n.Regions)}} selected="selected"{{/if}}>{{$r.min}} > {{$r.max}}</option>
        {{/if}}
     {{/foreach}}
    </optgroup>
    {{/foreach}}
    </select></td>
</tr>
<tr>
	<td nowrap="nowrap"><strong>Made materials:</strong></td>
	<td width="50%"><select name="made_materials[]" multiple="multiple" size="5" style="width:100%">
    {{foreach from=$ps_made_material item=s}}
    <option value="{{$s.Id}}"{{if in_array($s.Id,$n.made_materials)}} selected="selected"{{/if}}>{{$s.name}}</option>
    {{/foreach}}
    </select></td>
	<td nowrap="nowrap"><strong>Styles:</strong></td>
	<td width="50%"><select name="styles[]" multiple="multiple" size="5" style="width:100%">
    {{foreach from=$ps_style item=s}}
    <option value="{{$s.Id}}"{{if in_array($s.Id,$n.styles)}} selected="selected"{{/if}}>{{$s.name}}</option>
    {{/foreach}}
    </select></td>
</tr>
<tr>
	<td nowrap="nowrap"><strong>Doors:</strong></td>
	<td width="50%"><select name="doors[]" multiple="multiple" size="5" style="width:100%">
    {{foreach from=$doors_categories item=s}}
    <option value="{{$s.Id}}"{{if in_array($s.Id,$n.doors)}} selected="selected"{{/if}}>{{$s.Name}}</option>
    {{/foreach}}
    </select></td>
	<td nowrap="nowrap"><strong>Handles:</strong></td>
	<td width="50%"><select name="handles[]" multiple="multiple" size="5" style="width:100%">
    {{foreach from=$handles_categories item=s}}
    <option value="{{$s.Id}}"{{if in_array($s.Id,$n.handles)}} selected="selected"{{/if}}>{{$s.Name}}</option>
    {{/foreach}}
    </select></td>
</tr>
<tr>
	<td nowrap="nowrap"><strong>Carcasses:</strong></td>
	<td width="50%"><select name="carcasses[]" multiple="multiple" size="5" style="width:100%">
    {{foreach from=$carcasses_categories item=s}}
    <option value="{{$s.Id}}"{{if in_array($s.Id,$n.carcasses)}} selected="selected"{{/if}}>{{$s.Name}}</option>
    {{/foreach}}
    </select></td>
	<td nowrap="nowrap"><strong>Textures:</strong></td>
	<td width="50%"><select name="textures[]" multiple="multiple" size="5" style="width:100%">
    {{foreach from=$textures_categories item=s}}
    <option value="{{$s.Id}}"{{if in_array($s.Id,$n.textures)}} selected="selected"{{/if}}>{{$s.Name}}</option>
    {{/foreach}}
    </select></td>
</tr>
<tr>
	<td nowrap="nowrap"><strong>Worktops:</strong></td>
	<td width="50%"><select name="top_textures[]" multiple="multiple" size="5" style="width:100%">
    {{foreach from=$tops_categories item=s}}
    <option value="{{$s.Id}}"{{if in_array($s.Id,$n.top_textures)}} selected="selected"{{/if}}>{{$s.Name}}</option>
    {{/foreach}}
    </select></td>
	<td nowrap="nowrap"><strong>Manufacturer:</strong></td>
	<td width="50%"><select name="furniture_types[]" multiple="multiple" size="5" style="width:100%">
    {{foreach from=$furniture_types item=s}}
    <option value="{{$s.Id}}"{{if in_array($s.Id,$n.furniture_types)}} selected="selected"{{/if}}>{{$s.Name}}</option>
    {{/foreach}}
    </select></td>
</tr>
<tr>
	<td align="center" colspan="4"><input type="submit" value="Save" /> <input type="button" value="Cancel" onclick="showItemListing()" /></td>
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