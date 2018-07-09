{{include file='main_pieces/header.tpl'}}

<style>

#loadingHoverHolder{

	padding:0px;

	margin:0px;

	width:100%;

	height:100%;

	position:fixed;

	background:rgba(0,0,0,0.5);

	display:none;

	top:0px;

	left:220px

}

#loadingHover{

	background:url(../images/loading.gif);

	width:128px;

	height:15px;

	position:fixed

}
.preview_img{
	display:none
}

</style>

<div id="loadingHoverHolder"><div id="loadingHover"></div></div>

<h1>Multi-Unit manager</h1>



<div class="tabs">

<a href="javascript: void(0)" onclick="showTab(this)" id="tab__importer" class="on">Units Importer</a>

<a href="javascript: void(0)" onclick="showTab(this)" id="tab__generator">Units Generator</a>

</div>

<fieldset style="margin-bottom:5px" id="divTab__importer">

    <h2 style="padding:4px">Upload units zip <a href="{{$config.admin_url}}download_zip.zip" target="_blank">Download full zip folders</a> / <a href="{{$config.admin_url}}download_db_zip.zip" target="_blank">Download existing zip folders</a></h2>

    <fieldset style="margin-bottom:5px">

    <legend>Upload zip file</legend>

    <form method="post" enctype="multipart/form-data" onsubmit="showLoader()">

    <div>

        <input type="file" name="file" />

    </div>

    <div align="center" style="padding:5px"><input type="submit" value="Upload" /></div>

    </form>

    </fieldset>

    <fieldset style="margin-bottom:5px">

    <legend>Directories found</legend>

    <table width="100%" cellspacing="1" cellpadding="4">

    <tr>

        <th align="left" colspan="3">Directory</th>

    </tr>

    {{foreach from=$dirs item=dir}}

    <tr style="background:#E6E6E6">

        <td width="100%">{{$dir}}</td>

        <td nowrap><a href="{{$config.admin_url}}?page={{$smarty.get.page}}&scan_folder={{$dir}}" onclick="showLoader()">Scan</a></td>

        <td nowrap><a href="javascript: void(0)" onClick="if(confirm('Delete?')){window.location='{{$config.admin_url}}?page={{$smarty.get.page}}&delete_folder={{$dir}}'}">Delete</a></td>

    </tr>

    {{/foreach}}

    </table>

    </fieldset>

    {{if isset($units)}}

    <fieldset style="margin-bottom:5px">

    <legend>Units found in folder "{{$smarty.get.scan_folder}}" <input type="button" value="Toggle images" onclick="$('.preview_img').toggle()" /></legend>

    <form method="post">
    <input type="hidden" name="action" value="import" />

    {{foreach from=$units item=unit name=units}}

    <div style="margin:2px; padding:4px; border:1px solid #CCC">

    <h2 style="color:{{if $unit.found|@count > 0}}#090{{else}}#F00{{/if}}">{{$unit.name}} {{if $unit.found|@count == 0}}(will be added on load){{/if}}</h2>

    {{if $unit.found|@count <= 0}}

    <div style="border:1px solid #CCC">

    <table width="100%" cellspacing="1" cellpadding="4">

    <tr>

        <th width="100%" align="left">Nume</th>

        <th nowrap>Width (mm)</th>

        <th nowrap>Height (mm)</th>

        <th nowrap>Depth (mm)</th>

        <th nowrap>Dfb (cm)</th>

        <th nowrap>Worktop</th>

        <th nowrap>Appliance</th>

        <th nowrap>Swf</th>

    </tr>

    <tr>

        <td><input type="text" name="name_{{$smarty.foreach.units.index}}" value="{{$unit.name}}" style="width:calc(100% - 5px)" /></td>

        <td><input type="text" name="width_{{$smarty.foreach.units.index}}" style="width:80px" value="0" /></td>

        <td><input type="text" name="height_{{$smarty.foreach.units.index}}" style="width:80px" value="0" /></td>

        <td><input type="text" name="depth_{{$smarty.foreach.units.index}}" style="width:80px" value="0" /></td>

        <td><input type="text" name="dfb_{{$smarty.foreach.units.index}}" style="width:80px" value="0" /></td>

        <td><select name="worktop_{{$smarty.foreach.units.index}}" style="width:100%">

            <option value="0" selected>nu</option>

            <option value="1">da</option>

        </select></td>

        <td><select name="appliance_{{$smarty.foreach.units.index}}" style="width:100%">

            <option value="0" selected>nu</option>

            <option value="1">da</option>

        </select></td>

        <td><select name="swf_{{$smarty.foreach.units.index}}">

            {{foreach $swfs as $file name=swfs}}

            <option value="{{$file}}"{{if $smarty.foreach.swfs.first}} selected{{/if}}>{{$file}}</option>

            {{/foreach}}

        </select></td>

    </tr>

    <tr>

        <td colspan="10"><strong>Categorii</strong>{{foreach $categs as $categ}}<label style="cursor:pointer"><input type="checkbox" name="categories_{{$smarty.foreach.units.index}}[]" value="{{$categ.Id}}" /> {{$categ.Name}}</label>{{foreach $categ.categs as $scateg}}<label style="cursor:pointer"><input type="checkbox" name="categories_{{$smarty.foreach.units.index}}[]" value="{{$scateg.Id}}" /> {{$scateg.Name}}</label>{{/foreach}}{{/foreach}}</td>

    </tr>

    </table>

    </div>

    {{/if}}

    <h4>Handles ({{$unit.handles|count|default:0}})</h4>

    <table width="100%" cellspacing="1" cellpadding="4">

    <tr>

        <th><input type="checkbox" onClick="$('input[name^=unit_{{$smarty.foreach.units.index}}_handle_]').prop('checked',$(this).prop('checked'))" checked /></th>

        <th align="left" width="100%">Name</th>

        <th align="left">Pic 0</th>

        <th align="left">Pic 90</th>

        <th align="left">Pic 180</th>

        <th align="left">Pic 270</th>

    </tr>

    {{foreach from=$unit.handles item=handle name=handles}}

    <tr {{if $handle.found|@count == 0}} style="background:#FCC"{{else}} style="background:#AEFFAE"{{/if}}>

        <td><input type="checkbox" name="unit_{{$smarty.foreach.units.index}}_handle_{{$smarty.foreach.handles.index}}" {{if  $handle.found|@count > 0}}checked{{/if}} /></td>

        <td>{{$handle.name}}</td>

        <td><img class="preview_img" src="{{$handle.pics.0}}" style="max-height:50px; border:1px solid #CCC; background:#FFF" /></td>

        <td><img class="preview_img" src="{{$handle.pics.1}}" style="max-height:50px; border:1px solid #CCC; background:#FFF" /></td>

        <td><img class="preview_img" src="{{$handle.pics.2}}" style="max-height:50px; border:1px solid #CCC; background:#FFF" /></td>

        <td><img class="preview_img" src="{{$handle.pics.3}}" style="max-height:50px; border:1px solid #CCC; background:#FFF" /></td>

    </tr>

    {{/foreach}}

    </table>

    <h4>Worktops ({{$unit.worktops|count|default:0}})</h4>

    <table width="100%" cellspacing="1" cellpadding="4">

    <tr>

        <th><input type="checkbox" onClick="$('input[name^=unit_{{$smarty.foreach.units.index}}_worktop_]').prop('checked',$(this).prop('checked'))" checked /></th>

        <th align="left" width="100%">Name</th>

        <th align="left">Pic 0</th>

        <th align="left">Pic 90</th>

        <th align="left">Pic 180</th>

        <th align="left">Pic 270</th>

    </tr>

    {{foreach from=$unit.worktops item=worktop name=worktops}}

    <tr {{if $worktop.found|@count == 0}} style="background:#FCC"{{else}} style="background:#AEFFAE"{{/if}}>

        <td><input type="checkbox" name="unit_{{$smarty.foreach.units.index}}_worktop_{{$smarty.foreach.worktops.index}}" {{if  $worktop.found|@count > 0}}checked{{/if}} /></td>

        <td>{{$worktop.name}}</td>

        <td><img class="preview_img" src="{{$worktop.pics.0}}" style="max-height:50px; border:1px solid #CCC; background:#FFF" /></td>

        <td><img class="preview_img" src="{{$worktop.pics.1}}" style="max-height:50px; border:1px solid #CCC; background:#FFF" /></td>

        <td><img class="preview_img" src="{{$worktop.pics.2}}" style="max-height:50px; border:1px solid #CCC; background:#FFF" /></td>

        <td><img class="preview_img" src="{{$worktop.pics.3}}" style="max-height:50px; border:1px solid #CCC; background:#FFF" /></td>

    </tr>

    {{/foreach}}

    </table>

    <h4>Variations ({{$unit.variations|count|default:0}})</h4>

    <table width="100%" cellspacing="1" cellpadding="4">

    <tr>

        <th><input type="checkbox" onClick="$('input[name^=unit_{{$smarty.foreach.units.index}}_variation_]').prop('checked',$(this).prop('checked'))" checked /></th>

        <th align="left" width="33%">Door</th>

        <th align="left" width="33%">Range</th>

        <th align="left" width="34%">Carcass</th>

        <th align="left">Pic 0</th>

        <th align="left">Pic 90</th>

        <th align="left">Pic 180</th>

        <th align="left">Pic 270</th>

    </tr>

    {{foreach from=$unit.variations item=variation name=variations}}

    <tr {{if $variation.door_found|@count == 0 || $variation.range_found|@count == 0 || $variation.carcass_found|@count == 0}} style="background:#FCC"{{else}} style="background:#AEFFAE"{{/if}}>

        <td><input type="checkbox" name="unit_{{$smarty.foreach.units.index}}_variation_{{$smarty.foreach.variations.index}}" {{if  $variation.door_found|@count > 0 && $variation.range_found|@count > 0 && $variation.carcass_found|@count > 0}}checked{{/if}} /></td>

        <td {{if $variation.door_found|@count == 0}} style="background:#FCC"{{else}} style="background:#AEFFAE"{{/if}}>{{$variation.door}}</td>

        <td {{if $variation.range_found|@count == 0}} style="background:#FCC"{{else}} style="background:#AEFFAE"{{/if}}>{{$variation.range}}</td>

        <td {{if $variation.carcass_found|@count == 0}} style="background:#FCC"{{else}} style="background:#AEFFAE"{{/if}}>{{$variation.carcass}}</td>

        <td><img class="preview_img" src="{{$variation.pics.0}}" style="max-height:50px; border:1px solid #CCC; background:#FFF" /></td>

        <td><img class="preview_img" src="{{$variation.pics.1}}" style="max-height:50px; border:1px solid #CCC; background:#FFF" /></td>

        <td><img class="preview_img" src="{{$variation.pics.2}}" style="max-height:50px; border:1px solid #CCC; background:#FFF" /></td>

        <td><img class="preview_img" src="{{$variation.pics.3}}" style="max-height:50px; border:1px solid #CCC; background:#FFF" /></td>

    </tr>

    {{/foreach}}

    </table>

    </div>

    {{/foreach}}

    <div align="center" style="padding:5px"><input type="submit" value="Load" /></div>

    </form>

    </fieldset>

    {{/if}}

<script>

function initTab_importer(){

	//do nothing

}

</script>

</fieldset>



<fieldset style="margin-bottom:5px; display:none" id="divTab__generator">

<h2 style="padding:4px">Generate units</h2>

<form method="post" onsubmit="showLoader()">

<input type="hidden" name="action" value="generate" />

<table width="100%" cellspacing="2" cellpadding="2">

<tr>

	<th width="100%" align="left">Nume</th>

    <th nowrap>Width (mm)</th>

    <th nowrap>Height (mm)</th>

    <th nowrap>Depth (mm)</th>

    <th nowrap>Dfb (cm)</th>

    <th nowrap>Worktop</th>

    <th nowrap>Appliance</th>

    <th nowrap>Swf</th>

</tr>

<tbody id="tbl_body">

</tbody>

</table>

<div align="center">

<input type="button" value="Add 10 more" onclick="addUnitsGeneratorRows()" />

<input type="submit" name="Submit" />

</div>

</form>

<script type="text/template" id="tpl_row">

<tr bgcolor="##BGCOLOR##">

	<td><input type="text" name="name_##NRROW##" value="" style="width:calc(100% - 5px)" /></td>

	<td><input type="text" name="width_##NRROW##" style="width:80px" value="0" /></td>

	<td><input type="text" name="height_##NRROW##" style="width:80px" value="0" /></td>

	<td><input type="text" name="depth_##NRROW##" style="width:80px" value="0" /></td>

	<td><input type="text" name="dfb_##NRROW##" style="width:80px" value="0" /></td>

	<td><select name="worktop_##NRROW##" style="width:100%">

    	<option value="0" selected>nu</option>

        <option value="1">da</option>

    </select></td>

	<td><select name="appliance_##NRROW##" style="width:100%">

    	<option value="0" selected>nu</option>

        <option value="1">da</option>

    </select></td>

    <td><select name="swf_##NRROW##">

    	{{foreach $swfs as $file name=swfs}}

    	<option value="{{$file}}"{{if $smarty.foreach.swfs.first}} selected{{/if}}>{{$file}}</option>

        {{/foreach}}

    </select></td>

</tr>

<tr bgcolor="##BGCOLOR##">

	<td colspan="10"><strong>Categorii</strong>{{foreach $categs as $categ}}<label style="cursor:pointer"><input type="checkbox" name="categories_##NRROW##[]" value="{{$categ.Id}}" /> {{$categ.Name}}</label>{{foreach $categ.categs as $scateg}}<label style="cursor:pointer"><input type="checkbox" name="categories_##NRROW##[]" value="{{$scateg.Id}}" /> {{$scateg.Name}}</label>{{/foreach}}{{/foreach}}</td>

</tr>

</script>

<script type="text/javascript">

var nrrow = 0;

var colors = ['#FFF','#CCC'];

var tab_generator_initialized = false;

function addUnitsGeneratorRows(nr){

	if( typeof nr === "undefined" ) nr = 10;

	var rows = '';

	for( i = 0; i < nr; i++ ){

		var row = $('#tpl_row').html().replace(/##BGCOLOR##/g,colors[nrrow%2]).replace(/##NRROW##/g,nrrow);

		rows += row;

		nrrow++;

	}

	$('#tbl_body').append(rows);

}

function initTab_generator(){

	if( !tab_generator_initialized ){

		tab_generator_initialized = true;

		addUnitsGeneratorRows();

	}

}

</script>

</fieldset>

<script>

function showTab( obj ){

	$('.tabs>a').removeClass('on');

	$(obj).addClass('on');

	$('[id^="divTab__"]').hide();

	$('#divTab__'+$(obj).attr('id').replace('tab__','')).show();

	eval('initTab_'+$(obj).attr('id').replace('tab__','')+'()');

}

function downloadFile( file ){

	showLoader();

	var downloadWindow = window.open(file,'downloadWindow',"status=0,toolbar=0");

	setInterval(function(){

		if( downloadWindow.closed ) hideLoader();

	},500);

	/*$.fileDownload(file, {

		successCallback: function (url) {

			console.log('finished'); hideLoader();

		},

		failCallback: function (responseHtml, url) {

			console.log('error '+responseHtml+' '+url); hideLoader();

		}

	});*/

}

function showLoader(){

	w = $(window).width()-$('#meniu').outerWidth();

	h = $(window).height();

	$('#loadingHoverHolder').show().css({width:w+'px', height:h+'px'});

	$('#loadingHover').css({marginLeft:((w-128)/2)+'px', marginTop:((h-15)/2)+'px'});

}

function hideLoader(){

	$('#loadingHoverHolder').hide();

}

</script>

{{if $smarty.get|count >= 2}}

<script>

showLoader()

$(document).ready(function(e) {

    hideLoader();

});

</script>

{{/if}}

{{include file='main_pieces/footer.tpl'}}