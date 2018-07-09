{{include file='main_pieces/header.tpl'}}

<script type="text/javascript" src="{{$config.static_admin.js}}/tiny_mce/jquery.tinymce.js"></script>

<script type="text/javascript">

        $(function() {

                $('textarea.tinymce').tinymce({

                        // Location of TinyMCE script

                        script_url : '{{$config.static_admin.js}}/tiny_mce/tiny_mce.js',



                        // General options

                        theme : "advanced",

                        plugins : "pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",



                        // Theme options

                        theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",

                        theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",

                        theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",

                        theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak",

                        theme_advanced_toolbar_location : "top",

                        theme_advanced_toolbar_align : "left",

                        theme_advanced_statusbar_location : "bottom",

                        theme_advanced_resizing : true,



                        // Drop lists for link/image/media/template dialogs

                        template_external_list_url : "lists/template_list.js",

                        external_link_list_url : "lists/link_list.js",

                        external_image_list_url : "lists/image_list.js",

                        media_external_list_url : "lists/media_list.js",

						

						height: 300,

						width: '100%'

                });

        });

function showTab( obj ){

	$('.tabs>a').removeClass('on');

	$(obj).addClass('on');

	$('[id^="divTab__"]').hide();

	$('#divTab__'+$(obj).attr('id').replace('tab__','')).show();

}

function showPrevTinyImage( prefix ){

	cur_pic = $('[id^="'+prefix+'"]:visible').attr('id').replace(prefix+'__','')*1;

	next_pic = cur_pic-90;

	if( next_pic < 0 ) next_pic = 270;

	$('[id^="'+prefix+'"]').hide();

	$('#'+prefix+'__'+next_pic).show();

}

function showNextTinyImage( prefix ){

	cur_pic = $('[id^="'+prefix+'"]:visible').attr('id').replace(prefix+'__','')*1;

	next_pic = cur_pic+90;

	if( next_pic > 270 ) next_pic = 0;

	$('[id^="'+prefix+'"]').hide();

	$('#'+prefix+'__'+next_pic).show();

}

</script>

<div class="pagePieces">

<h1>{{if $item}} Edit unit{{else}} Add unit{{/if}}</h1>

{{if $item}}

<div class="tabs">

	<a href="javascript: void(0)" onclick="showTab(this)" id="tab__unit_info" class="on">Unit info</a>

	<a href="javascript: void(0)" onclick="showTab(this)" id="tab__handles">Handles</a>

	<a href="javascript: void(0)" onclick="showTab(this)" id="tab__tops">Tops</a>

	<a href="javascript: void(0)" onclick="showTab(this)" id="tab__variations">Variations</a>

</div>

{{/if}}

<fieldset style="margin-bottom:5px" id="divTab__unit_info">

<form method="post" enctype="multipart/form-data">

<input type="hidden" name="action" value="modify" />

<input type="hidden" name="Id" value="{{$item.Id|default:-1}}" />

<table width="100%" cellpadding="5" cellspacing="0">

<tr>

	<td nowrap="nowrap"><strong>Name:</strong></td>

	<td width="100%"><input type="text" name="Name" value="{{$item.Name}}" /></td>

	<td nowrap="nowrap" valign="top" rowspan="2" style="border:1px solid #666; border-radius:5px"><div><strong>SWF:</strong></div>

    {{if $item}}<iframe src="{{$config.siteurl}}uploads/swf_2d/{{$item.Swf2D}}" frameborder="0" width="100%" height="100"></iframe><br>{{/if}}

    <input type="file" name="Swf2D" /></td>

</tr>

<tr>

	<td nowrap="nowrap"><strong>Regions</strong><br /><em>(selecting none has the same effect like selecting all)</em></td>

    <td>

    <select name="Regions[]" size="5" style="float:left" multiple="multiple">
    {{foreach $states as $s}}
    <optgroup label="{{$s.name}}">
    {{foreach from=$states_regions item=r}}
    	{{if $r.id_state==$s.Id}}
    	<option value="{{$r.Id}}"{{if $r.checked}} selected="selected"{{/if}}>{{$r.min}} > {{$r.max}}</option>
        {{/if}}
     {{/foreach}}
    </optgroup>
    {{/foreach}}

    </select></td>

</tr>

<tr>

	<td nowrap="nowrap"><strong>Manufacturer</strong></td>

    <td>

    <select name="IdManufacturer" onchange="$('#tinyLogoManufacturer').attr('src',$(this).find('option:selected').attr('data-picture'))" size="3" style="float:left">

    {{foreach $manufacturers as $m}}

    <option value="{{$m.Id}}" data-picture="{{$config.siteurl}}uploads/manufacturers/{{$m.Logo}}"{{if $item.IdManufacturer==$m.Id}} selected="selected"{{/if}}>{{$m.Name}}</option>

    {{/foreach}}

    </select>

    {{foreach $manufacturers as $m}}

    {{if $item.IdManufacturer==$m.Id}}

   	<img src="{{$config.siteurl}}uploads/manufacturers/{{$m.Logo}}" id="tinyLogoManufacturer" class="imgNice" style="float:left" />

    {{/if}}

    {{/foreach}}</td>

</tr>

<tr>

	<td nowrap="nowrap" valign="top"><strong>Categories:</strong></td>

	<td>

    {{foreach $categs as $c}}

    <div style="float:left; width:300px; overflow:auto; margin-left:5px">

    	<input type="checkbox" name="categs[]" value="{{$c.Id}}" onclick="disableCheckBoxChildrens(this)"{{if $c.checked}} checked="checked"{{/if}} /> {{$c.Name}}

    	{{foreach $c.categs as $s}}

        <div style="padding-left:35px"><input type="checkbox" name="categs[]" value="{{$s.Id}}" onclick="enableCheckBoxParent(this)"{{if $s.checked}} checked="checked"{{/if}} /> {{$s.Name}}</div>

    	{{/foreach}}

    </div>

    {{/foreach}}

    </td>

</tr>

<tr>

	<td nowrap="nowrap"><strong>Price:</strong></td>

	<td colspan="2"><input type="text" name="Price" value="{{$item.Price|default:0}}" /></td>

</tr>

<tr>

	<td nowrap="nowrap"><strong>Sizes:</strong></td>

	<td colspan="2"><strong>Widh:</strong> <input type="text" name="Width" value="{{$item.Width|default:0}}" style="width:75px" /> mm X <strong>Height:</strong>  <input type="text" name="Height" value="{{$item.Height|default:0}}" style="width:75px" /> mm X <strong>Depth:</strong>  <input type="text" name="Depth" value="{{$item.Depth|default:0}}" style="width:75px" /> mm</td>

</tr>

<tr>

	<td nowrap="nowrap"><strong>Distance from bottom:</strong></td>

	<td colspan="2"><input type="text" name="DistanceFromBottom" value="{{$item.DistanceFromBottom|default:0}}" style="width:75px" /> cm</td>

</tr>

<tr>

    <td nowrap="nowrap"><strong>Options:</strong></td>

    <td colspan="2"><input type="checkbox" name="HasAppliance" value="yes"{{if isset($item.HasAppliance) && $item.HasAppliance == 'yes'}} checked="checked"{{/if}} onclick="$('#appliance_info').toggle()" /> Has appliance | <input type="checkbox" name="HasWorktop" value="yes"{{if isset($item.HasWorktop) && $item.HasWorktop == 'yes'}} checked="checked"{{/if}} /> Has worktop </td>

</tr>

<tr>

	<td colspan="3">

    <fieldset style="margin-bottom:5px{{if !isset($item.HasAppliance) || $item.HasAppliance != 'yes'}}; display:none{{/if}}" id="appliance_info">

	<legend><strong>Appliance info:</strong></legend>

	<table width="100%" cellpadding="5" cellspacing="0">

    <tr>

        <td nowrap="nowrap"><strong>Appliance name:</strong></td>

        <td width="100%"><input type="text" name="ApplianceName" value="{{$item.ApplianceName|default:''}}" /></td>

    </tr>

    <tr>

        <td colspan="2"><strong>Appliance Description:</strong><textarea name="ApplianceDescription" class="tinymce">{{$item.ApplianceDescription}}</textarea></td>

    </tr>

    </table>

    </fieldset>

    </td>

</tr>

<tr>

	<td colspan="3"><strong>Description:</strong><textarea name="Description" class="tinymce">{{$item.Description}}</textarea></td>

</tr>

<tr>

	<td align="center" colspan="3"><input type="submit" value="Save" /> <input type="button" value="Cancel" onclick="window.location='?page=units'" /></td>

</tr>

</table>

</form>

</fieldset>

<fieldset style="margin-bottom:5px; display:none" id="divTab__handles">

<input type="button" value="Add new handle" onclick="$('#handle_0').show()" />

<form id="handle_0" method="post" enctype="multipart/form-data" style="padding:10px; background:#F3F3F3; margin-bottom:10px; border-radius:5px; display:none">

<input type="hidden" name="action" value="modify_handle" />

<input type="hidden" name="Id" value="-1" />

<input type="hidden" name="IdUnit" value="{{$item.Id}}" />

<table width="100%" cellpadding="5" cellspacing="0">

<tr>

	<td nowrap="nowrap"><strong>Handle category:</strong></td>

    <td nowrap="nowrap"><strong>Rendered 0* picture:</strong></td>

    <td><input type="file" name="dv_Render0" value="" /></td>

</tr>

<tr>

    <td rowspan="2" align="center">

   	<img src="{{$config.siteurl}}uploads/latches/{{$handles_categories.0.Picture}}" id="tinyPicHandle_0" width="200" class="imgNice" />

    </td>

    <td nowrap="nowrap"><strong>Rendered 90* picture:</strong></td>

    <td><input type="file" name="dv_Render90" value="" /></td>

</tr>

<tr>

    <td nowrap="nowrap"><strong>Rendered 180* picture:</strong></td>

    <td><input type="file" name="dv_Render180" value="" /></td>

</tr>

<tr>

    <td>

    <select name="IdHandle" onchange="$('#tinyPicHandle_0').attr('src',$(this).find('option:selected').attr('data-picture'))">

    {{foreach $handles_categories as $hc}}

    <option value="{{$hc.Id}}" data-picture="{{$config.siteurl}}uploads/latches/{{$hc.Picture}}"{{if $n.IdHandle==$hc.Id}} selected="selected"{{/if}}>{{$hc.Name}}</option>

    {{/foreach}}

    </select></td>

    <td nowrap="nowrap"><strong>Rendered 270* picture:</strong></td>

    <td width="100%"><input type="file" name="dv_Render270" value="" /></td>

</tr>

<tr>

	<td nowrap="nowrap"><strong>Price diff:</strong></td>

	<td colspan="3">+ <input type="text" style="width:100px" name="PriceDiff" value="{{$n.PriceDiff|default:0}}" /></td>

</tr>

<tr>

	<td align="center" colspan="4"><input type="submit" value="Add" /> <input type="button" value="Cancel" onclick="$('#handle_0').hide()" /></td>

</tr>

</table>

</form>

{{foreach $handles as $n}}

<form id="handle_{{$n.Id}}" method="post" enctype="multipart/form-data" style="padding:10px; background:#F3F3F3; margin-bottom:10px; border-radius:5px">

<input type="hidden" name="action" value="modify_handle" />

<input type="hidden" name="Id" value="{{$n.Id|default:-1}}" />

<table width="100%" cellpadding="5" cellspacing="0">

<tr>

	<td nowrap="nowrap"><strong>Handle category:</strong></td>

	<td align="center" rowspan="3">

   	<img src="{{$config.siteurl}}uploads/unit_handles/{{$n.Image0}}" width="200" class="imgNice" id="imgHandle{{$n.Id}}__0" />

   	<img src="{{$config.siteurl}}uploads/unit_handles/{{$n.Image90}}" width="200" class="imgNice" id="imgHandle{{$n.Id}}__90" style="display:none" />

   	<img src="{{$config.siteurl}}uploads/unit_handles/{{$n.Image180}}" width="200" class="imgNice" id="imgHandle{{$n.Id}}__180" style="display:none" />

   	<img src="{{$config.siteurl}}uploads/unit_handles/{{$n.Image270}}" width="200" class="imgNice" id="imgHandle{{$n.Id}}__270" style="display:none" />

    </td>

    <td nowrap="nowrap"><strong>Rendered 0* picture:</strong></td>

    <td><input type="file" name="dv_Render0" value="" /></td>

</tr>

<tr>

    <td rowspan="2" align="center">

    {{foreach $handles_categories as $hc}}

    {{if $n.IdHandle==$hc.Id}}

   	<img src="{{$config.siteurl}}uploads/latches/{{$hc.Picture}}" id="tinyPicHandle_{{$n.Id}}" width="200" class="imgNice" />

    {{/if}}

    {{/foreach}}</td>

    <td nowrap="nowrap"><strong>Rendered 90* picture:</strong></td>

    <td><input type="file" name="dv_Render90" value="" /></td>

</tr>

<tr>

    <td nowrap="nowrap"><strong>Rendered 180* picture:</strong></td>

    <td><input type="file" name="dv_Render180" value="" /></td>

</tr>

<tr>

    <td>

    <select name="IdHandle" onchange="$('#tinyPicHandle_{{$n.Id}}').attr('src',$(this).find('option:selected').attr('data-picture'))">

    {{foreach $handles_categories as $hc}}

    <option value="{{$hc.Id}}" data-picture="{{$config.siteurl}}uploads/latches/{{$hc.Picture}}"{{if $n.IdHandle==$hc.Id}} selected="selected"{{/if}}>{{$hc.Name}}</option>

    {{/foreach}}

    </select></td>

    <td align="center"><a class="arrow_link" href="javascript:void(0)" onclick="showPrevTinyImage('imgHandle{{$n.Id}}')">&laquo;</a><a class="arrow_link" href="javascript:void(0)" onclick="showNextTinyImage('imgHandle{{$n.Id}}')">&raquo;</a></td>

    <td nowrap="nowrap"><strong>Rendered 270* picture:</strong></td>

    <td width="100%"><input type="file" name="dv_Render270" value="" /></td>

</tr>

<tr>

	<td nowrap="nowrap"><strong>Price diff:</strong></td>

	<td colspan="3">+ <input type="text" style="width:100px" name="PriceDiff" value="{{$n.PriceDiff|default:0}}" /></td>

</tr>

<tr>

	<td align="center" colspan="4"><input type="submit" value="Save" /> <input type="button" value="Delete" onclick="doDelete('handle',{{$n.Id}})" /></td>

</tr>

</table>

</form>

{{/foreach}}

</fieldset>

<fieldset style="margin-bottom:5px; display:none" id="divTab__tops">

<input type="button" value="Add new top" onclick="$('#top_0').show()" />

<form id="top_0" method="post" enctype="multipart/form-data" style="padding:10px; background:#F3F3F3; margin-bottom:10px; border-radius:5px; display:none">

<input type="hidden" name="action" value="modify_top" />

<input type="hidden" name="Id" value="-1" />

<input type="hidden" name="IdUnit" value="{{$item.Id}}" />

<table width="100%" cellpadding="5" cellspacing="0">

<tr>

	<td nowrap="nowrap"><strong>Top category:</strong></td>

    <td nowrap="nowrap"><strong>Rendered 0* picture:</strong></td>

    <td><input type="file" name="dv_Render0" value="" /></td>

</tr>

<tr>

    <td rowspan="2" align="center">

   	<img src="{{$config.siteurl}}uploads/top_textures/{{$tops_categories.0.Picture}}" id="tinyPicTop_0" width="200" class="imgNice" /></td>

    <td nowrap="nowrap"><strong>Rendered 90* picture:</strong></td>

    <td><input type="file" name="dv_Render90" value="" /></td>

</tr>

<tr>

    <td nowrap="nowrap"><strong>Rendered 180* picture:</strong></td>

    <td><input type="file" name="dv_Render180" value="" /></td>

</tr>

<tr>

    <td>

    <select name="IdTop" onchange="$('#tinyPicTop_0').attr('src',$(this).find('option:selected').attr('data-picture'))">

    {{foreach $tops_categories as $hc}}

    <option value="{{$hc.Id}}" data-picture="{{$config.siteurl}}uploads/top_textures/{{$hc.Picture}}"{{if $n.IdTop==$hc.Id}} selected="selected"{{/if}}>{{$hc.Name}}</option>

    {{/foreach}}

    </select></td>

    <td nowrap="nowrap"><strong>Rendered 270* picture:</strong></td>

    <td width="100%"><input type="file" name="dv_Render270" value="" /></td>

</tr>

<tr>

	<td nowrap="nowrap"><strong>Price diff:</strong></td>

	<td colspan="3">+ <input type="text" style="width:100px" name="PriceDiff" value="{{$n.PriceDiff|default:0}}" /></td>

</tr>

<tr>

	<td align="center" colspan="4"><input type="submit" value="Add" /> <input type="button" value="Cancel" onclick="$('#top_0').hide()" /></td>

</tr>

</table>

</form>

{{foreach $tops as $n}}

<form id="top_{{$n.Id}}" method="post" enctype="multipart/form-data" style="padding:10px; background:#F3F3F3; margin-bottom:10px; border-radius:5px">

<input type="hidden" name="action" value="modify_top" />

<input type="hidden" name="Id" value="{{$n.Id|default:-1}}" />

<table width="100%" cellpadding="5" cellspacing="0">

<tr>

	<td nowrap="nowrap"><strong>Top category:</strong></td>

	<td align="center" rowspan="3">

   	<img src="{{$config.siteurl}}uploads/unit_tops/{{$n.Image0}}" width="200" class="imgNice" id="imgTop{{$n.Id}}__0" />

   	<img src="{{$config.siteurl}}uploads/unit_tops/{{$n.Image90}}" width="200" class="imgNice" id="imgTop{{$n.Id}}__90" style="display:none" />

   	<img src="{{$config.siteurl}}uploads/unit_tops/{{$n.Image180}}" width="200" class="imgNice" id="imgTop{{$n.Id}}__180" style="display:none" />

   	<img src="{{$config.siteurl}}uploads/unit_tops/{{$n.Image270}}" width="200" class="imgNice" id="imgTop{{$n.Id}}__270" style="display:none" />

    </td>

    <td nowrap="nowrap"><strong>Rendered 0* picture:</strong></td>

    <td><input type="file" name="dv_Render0" value="" /></td>

</tr>

<tr>

    <td rowspan="2" align="center">

    {{foreach $tops_categories as $hc}}

    {{if $n.IdTop==$hc.Id}}

   	<img src="{{$config.siteurl}}uploads/top_textures/{{$hc.Picture}}" id="tinyPicTop_{{$n.Id}}" width="200" class="imgNice" />

    {{/if}}

    {{/foreach}}</td>

    <td nowrap="nowrap"><strong>Rendered 90* picture:</strong></td>

    <td><input type="file" name="dv_Render90" value="" /></td>

</tr>

<tr>

    <td nowrap="nowrap"><strong>Rendered 180* picture:</strong></td>

    <td><input type="file" name="dv_Render180" value="" /></td>

</tr>

<tr>

    <td>

    <select name="IdTop" onchange="$('#tinyPicTop_{{$n.Id}}').attr('src',$(this).find('option:selected').attr('data-picture'))">

    {{foreach $tops_categories as $hc}}

    <option value="{{$hc.Id}}" data-picture="{{$config.siteurl}}uploads/top_textures/{{$hc.Picture}}"{{if $n.IdTop==$hc.Id}} selected="selected"{{/if}}>{{$hc.Name}}</option>

    {{/foreach}}

    </select></td>

    <td align="center"><a class="arrow_link" href="javascript:void(0)" onclick="showPrevTinyImage('imgTop{{$n.Id}}')">&laquo;</a><a class="arrow_link" href="javascript:void(0)" onclick="showNextTinyImage('imgTop{{$n.Id}}')">&raquo;</a></td>

    <td nowrap="nowrap"><strong>Rendered 270* picture:</strong></td>

    <td width="100%"><input type="file" name="dv_Render270" value="" /></td>

</tr>

<tr>

	<td nowrap="nowrap"><strong>Price diff:</strong></td>

	<td colspan="3">+ <input type="text" style="width:100px" name="PriceDiff" value="{{$n.PriceDiff|default:0}}" /></td>

</tr>

<tr>

	<td align="center" colspan="4"><input type="submit" value="Save" /> <input type="button" value="Delete" onclick="doDelete('top',{{$n.Id}})" /></td>

</tr>

</table>

</form>

{{/foreach}}

</fieldset>

<fieldset style="margin-bottom:5px; display:none" id="divTab__variations">

<input type="button" value="Add new variation" onclick="$('#variation_0').show()" />

<form id="variation_0" method="post" enctype="multipart/form-data" style="padding:10px; background:#F3F3F3; margin-bottom:10px; border-radius:5px; display:none">

<input type="hidden" name="action" value="modify_variation" />

<input type="hidden" name="Id" value="-1" />

<input type="hidden" name="IdUnit" value="{{$item.Id}}" />

<table width="100%" cellpadding="5" cellspacing="0">

<tr>

	<td nowrap="nowrap"><strong>Door:</strong></td>

	<td nowrap="nowrap"><strong>Texture:</strong></td>

	<td nowrap="nowrap"><strong>Carcass:</strong></td>

    <td nowrap="nowrap"><strong>Rendered 0* picture:</strong></td>

    <td><input type="file" name="dv_Render0" value="" /></td>

</tr>

<tr>

    <td rowspan="2" align="center">

   	<img src="{{$config.siteurl}}uploads/unit_doors/{{$doors_categories.0.Picture}}" id="tinyPicDoor_0" width="200" class="imgNice" />

    </td>

    <td rowspan="2" align="center">

   	<img src="{{$config.siteurl}}uploads/textures/{{$textures_categories.0.Picture}}" id="tinyPicTexture_0" width="200" class="imgNice" />

    </td>

    <td rowspan="2" align="center">

   	<img src="{{$config.siteurl}}uploads/carcasses/{{$carcasses_categories.0.Picture}}" id="tinyPicCarcass_0" width="200" class="imgNice" />

    </td>

    <td nowrap="nowrap"><strong>Rendered 90* picture:</strong></td>

    <td><input type="file" name="dv_Render90" value="" /></td>

</tr>

<tr>

    <td nowrap="nowrap"><strong>Rendered 180* picture:</strong></td>

    <td><input type="file" name="dv_Render180" value="" /></td>

</tr>

<tr>

    <td>

    <select name="IdDoor" onchange="$('#tinyPicDoor_0').attr('src',$(this).find('option:selected').attr('data-picture'))">

    {{foreach $doors_categories as $hc}}

    <option value="{{$hc.Id}}" data-picture="{{$config.siteurl}}uploads/unit_doors/{{$hc.Picture}}"{{if $n.IdDoor==$hc.Id}} selected="selected"{{/if}}>{{$hc.Name}}</option>

    {{/foreach}}

    </select></td>

    <td>

    <select name="IdTexture" onchange="$('#tinyPicTexture_0').attr('src',$(this).find('option:selected').attr('data-picture'))">

    {{foreach $textures_categories as $hc}}

    <option value="{{$hc.Id}}" data-picture="{{$config.siteurl}}uploads/textures/{{$hc.Picture}}"{{if $n.IdTexture==$hc.Id}} selected="selected"{{/if}}>{{$hc.Name}}</option>

    {{/foreach}}

    </select></td>

    <td>

    <select name="IdCarcass" onchange="$('#tinyPicCarcass_0').attr('src',$(this).find('option:selected').attr('data-picture'))">

    {{foreach $carcasses_categories as $hc}}

    <option value="{{$hc.Id}}" data-picture="{{$config.siteurl}}uploads/carcasses/{{$hc.Picture}}"{{if $n.IdCarcass==$hc.Id}} selected="selected"{{/if}}>{{$hc.Name}}</option>

    {{/foreach}}

    </select></td>

    <td nowrap="nowrap"><strong>Rendered 270* picture:</strong></td>

    <td width="100%"><input type="file" name="dv_Render270" value="" /></td>

</tr>

<tr>

	<td nowrap="nowrap"><strong>Price diff:</strong></td>

	<td colspan="5">+ <input type="text" style="width:100px" name="PriceDiff" value="{{$n.PriceDiff|default:0}}" /></td>

</tr>

<tr>

	<td nowrap="nowrap"><strong>Product Code:</strong></td>

	<td colspan="5">+ <input type="text" style="width:100px" name="Code" value="{{$n.Code|default:''}}" /></td>

</tr>

<tr>

	<td align="center" colspan="6"><input type="submit" value="Add" /> <input type="button" value="Cancel" onclick="$('#variation_0').hide()" /></td>

</tr>

</table>

</form>

{{foreach $variations as $n}}

<form id="variation_{{$n.Id}}" method="post" enctype="multipart/form-data" style="padding:10px; background:#F3F3F3; margin-bottom:10px; border-radius:5px">

<input type="hidden" name="action" value="modify_variation" />

<input type="hidden" name="Id" value="{{$n.Id|default:-1}}" />

<table width="100%" cellpadding="5" cellspacing="0">

<tr>

	<td nowrap="nowrap"><strong>Door:</strong></td>

	<td nowrap="nowrap"><strong>Texture:</strong></td>

	<td nowrap="nowrap"><strong>Carcass:</strong></td>

	<td align="center" rowspan="3">

   	<img src="{{$config.siteurl}}uploads/unit_variations/{{$n.Image0}}" width="200" class="imgNice" id="imgVariation{{$n.Id}}__0" />

   	<img src="{{$config.siteurl}}uploads/unit_variations/{{$n.Image90}}" width="200" class="imgNice" id="imgVariation{{$n.Id}}__90" style="display:none" />

   	<img src="{{$config.siteurl}}uploads/unit_variations/{{$n.Image180}}" width="200" class="imgNice" id="imgVariation{{$n.Id}}__180" style="display:none" />

   	<img src="{{$config.siteurl}}uploads/unit_variations/{{$n.Image270}}" width="200" class="imgNice" id="imgVariation{{$n.Id}}__270" style="display:none" />

    </td>

    <td nowrap="nowrap"><strong>Rendered 0* picture:</strong></td>

    <td><input type="file" name="dv_Render0" value="" /></td>

</tr>

<tr>

    <td rowspan="2" align="center">

    {{foreach $doors_categories as $hc}}

    {{if $n.IdDoor==$hc.Id}}

   	<img src="{{$config.siteurl}}uploads/unit_doors/{{$hc.Picture}}" id="tinyPicDoor_{{$n.Id}}" width="200" class="imgNice" />

    {{/if}}

    {{/foreach}}</td>

    <td rowspan="2" align="center">

    {{foreach $textures_categories as $hc}}

    {{if $n.IdTexture==$hc.Id}}

   	<img src="{{$config.siteurl}}uploads/textures/{{$hc.Picture}}" id="tinyPicTexture_{{$n.Id}}" width="200" class="imgNice" />

    {{/if}}

    {{/foreach}}</td>

    <td rowspan="2" align="center">

    {{foreach $carcasses_categories as $hc}}

    {{if $n.IdCarcass==$hc.Id}}

   	<img src="{{$config.siteurl}}uploads/carcasses/{{$hc.Picture}}" id="tinyPicCarcass_{{$n.Id}}" width="200" class="imgNice" />

    {{/if}}

    {{/foreach}}</td>

    <td nowrap="nowrap"><strong>Rendered 90* picture:</strong></td>

    <td><input type="file" name="dv_Render90" value="" /></td>

</tr>

<tr>

    <td nowrap="nowrap"><strong>Rendered 180* picture:</strong></td>

    <td><input type="file" name="dv_Render180" value="" /></td>

</tr>

<tr>

    <td>

    <select name="IdDoor" onchange="$('#tinyPicDoor_{{$n.Id}}').attr('src',$(this).find('option:selected').attr('data-picture'))">

    {{foreach $doors_categories as $hc}}

    <option value="{{$hc.Id}}" data-picture="{{$config.siteurl}}uploads/unit_doors/{{$hc.Picture}}"{{if $n.IdDoor==$hc.Id}} selected="selected"{{/if}}>{{$hc.Name}}</option>

    {{/foreach}}

    </select></td>

    <td>

    <select name="IdTexture" onchange="$('#tinyPicTexture_{{$n.Id}}').attr('src',$(this).find('option:selected').attr('data-picture'))">

    {{foreach $textures_categories as $hc}}

    <option value="{{$hc.Id}}" data-picture="{{$config.siteurl}}uploads/textures/{{$hc.Picture}}"{{if $n.IdTexture==$hc.Id}} selected="selected"{{/if}}>{{$hc.Name}}</option>

    {{/foreach}}

    </select></td>

    <td>

    <select name="IdCarcass" onchange="$('#tinyPicCarcass_{{$n.Id}}').attr('src',$(this).find('option:selected').attr('data-picture'))">

    {{foreach $carcasses_categories as $hc}}

    <option value="{{$hc.Id}}" data-picture="{{$config.siteurl}}uploads/carcasses/{{$hc.Picture}}"{{if $n.IdCarcass==$hc.Id}} selected="selected"{{/if}}>{{$hc.Name}}</option>

    {{/foreach}}

    </select></td>

    <td align="center"><a class="arrow_link" href="javascript:void(0)" onclick="showPrevTinyImage('imgVariation{{$n.Id}}')">&laquo;</a><a class="arrow_link" href="javascript:void(0)" onclick="showNextTinyImage('imgVariation{{$n.Id}}')">&raquo;</a></td>

    <td nowrap="nowrap"><strong>Rendered 270* picture:</strong></td>

    <td width="100%"><input type="file" name="dv_Render270" value="" /></td>

</tr>

<tr>

	<td nowrap="nowrap"><strong>Price diff:</strong></td>

	<td colspan="5">+ <input type="text" style="width:100px" name="PriceDiff" value="{{$n.PriceDiff|default:0}}" /></td>

</tr>

<tr>

	<td nowrap="nowrap"><strong>Product Code:</strong></td>

	<td colspan="5">+ <input type="text" style="width:100px" name="Code" value="{{$n.Code|default:''}}" /></td>

</tr>

<tr>

	<td align="center" colspan="6"><input type="submit" value="Save" /> <input type="button" value="Delete" onclick="doDelete('variation',{{$n.Id}})" /></td>

</tr>

</table>

</form>

{{/foreach}}

</fieldset>

</div>



<script>

function doDelete(type, pid){

	if( confirm( 'Really delete?' ) )

	{

		$('#'+type+'_'+pid+'>input[name=action]').val('delete_'+type);

		$('#'+type+'_'+pid).submit();

	}

}

function enableCheckBoxParent( obj ){

	$($(obj).parent().parent().find('input').get(0)).attr('checked',true);

}

function disableCheckBoxChildrens( obj ){

	if( $(obj).attr('checked') )

		$(obj).parent().find('div>input').attr('checked',false);

}

$(document).ready(function() {

	$( ".date" ).datepicker({dateFormat:"yy-mm-dd"});

});

</script>

{{include file='main_pieces/footer.tpl'}}