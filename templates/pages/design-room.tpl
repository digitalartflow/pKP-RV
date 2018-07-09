<img id="loading" style="position:absolute" src="images/loading.gif" />

<div id="pageHolder" style="display:none; overflow:auto">

<div id="innerData" style="margin:100px 0px 0px 10px">

<div id="swfHolderH" style="position:fixed; background:url({{$smarty.const.WEBSITE_URL}}images/rendering_loader.gif) no-repeat center">

<div id="swfHolder"></div>

</div>

</div>

</div>

</div>

{{$header}}

<div style="display:none">

<style>

a.addDoor{

background:url(images/room_design/add_door_off.png);

width:97px;

height:174px;

overflow:hidden;

display:block;

text-indent:-9999px

}

a:hover.addDoor{

background:url(images/room_design/add_door_on.png);

}

a.addWindow{

background:url(images/room_design/add_window_off.png);

width:97px;

height:174px;

overflow:hidden;

display:block;

text-indent:-9999px

}

a:hover.addWindow{

background:url(images/room_design/add_window_on.png);

}

a.customiseDoor{

background:url(images/room_design/customize_door_off.png);

width:97px;

height:174px;

overflow:hidden;

display:block;

text-indent:-9999px

}

a:hover.customiseDoor{

background:url(images/room_design/customize_door_on.png);

}

a.chooseDoor{

background:url(images/room_design/choose_doors_off.png);

width:97px;

height:174px;

overflow:hidden;

display:block;

text-indent:-9999px

}

a:hover.chooseDoor{

background:url(images/room_design/choose_doors_on.png);

}

a.chooseWindow{

background:url(images/room_design/choose_window_off.png);

width:97px;

height:174px;

overflow:hidden;

display:block;

text-indent:-9999px

}

a:hover.chooseWindow{

background:url(images/room_design/choose_window_on.png);

}

a.customiseWindow{

background:url(images/room_design/customize_window_off.png);

width:97px;

height:174px;

overflow:hidden;

display:block;

text-indent:-9999px

}

a:hover.customiseWindow{

background:url(images/room_design/customize_window_on.png);

}

</style>

<div id="actionForInnerWall" title="Add inner wall">

<div id="aFIW_settings">

<table width="100%" cellpadding="2" cellspacing="2">

<tr style="display:none">

<td>Wall height:</td>

<td><input type="text" readonly="readonly" name="wall_h" value="1800" style="width:50px" /> mm</td>

</tr>

<tr>

<td>Wall length:</td>

<td><input type="text" name="wall_w" value="1000" style="width:50px" /> mm</td>

</tr>

<tr>

<td>Wall thicknes:</td>

<td><input type="text" name="wall_t" value="350" style="width:50px" /> mm</td>

</tr>

<tr>

<td>Angle:</td>

<td><input type="radio" name="wall_a" value="0" checked="checked" /> 0&deg; <input type="radio" name="wall_a" value="90" /> 90&deg;</td>

</tr>

</table>

</div>

</div>

<script>

function showAddWall(rh)

{

h  = $('input[name=wall_h]').val(rh);

$('#actionForInnerWall').dialog('open');

$("#actionForInnerWall").dialog( "option", "buttons", { "Add": function() {

h  = $('input[name=wall_h]').val();

w  = $('input[name=wall_w]').val();

t  = $('input[name=wall_t]').val();

a  = $('input[name=wall_a]:checked').val();

//alert(h);

flashMovie('room_design').doAddWall(w, h, t, a);	

$('#actionForInnerWall').dialog('close');	

}});

}

var extraWallId = '';

function initEditWall(wn, wl, wh, wa, wt)

{

$('input[name=wall_h]').val(wh*10);

$('input[name=wall_w]').val(wl*10);

$('input[name=wall_t]').val(wt*10);

$('input[name=wall_a][value="'+wa+'"]').attr('checked',true);

extraWallId = wn;

$('#actionForInnerWall').dialog('open');

$("#actionForInnerWall").dialog( "option", "buttons", { 

"Save": function() {

h  = $('input[name=wall_h]').val();

w  = $('input[name=wall_w]').val();

t  = $('input[name=wall_t]').val();

a  = $('input[name=wall_a]:checked').val();

flashMovie('room_design').doEditWall(w, h, t, a, extraWallId);	

$('#actionForInnerWall').dialog('close');	

},

"Delete": function() {

if( confirm('Really delete?') )

{

flashMovie('room_design').doDeleteWall(extraWallId);	

$('#actionForInnerWall').dialog('close');	

}

}

});

}

</script>

<div id="actionForWall" title="Wall Options">

<div id="aFW_first">

<table width="100%" cellpadding="2" cellspacing="2">

<tr>

<td width="50%" align="center" valign="bottom">

<a href="javascript:void(0)" class="addDoor" onclick="showDoorsStep1()">Add Door</a>

<strong>Add Door</strong>

</td>

<td width="50%" align="center" valign="bottom">

<a href="javascript:void(0)" class="addWindow" onclick="showWindowsStep1()">Add Window</a>

<strong>Add Window</strong></td>

</tr>

</table>

</div>

<div id="aFW_ds1" style="display:none">

<table width="100%" cellpadding="2" cellspacing="2">

<tr>

<td width="50%" align="center" valign="bottom">

<a href="javascript:void(0)" class="customiseDoor" onclick="showCustomizeDoor()">Customize Door</a>

<strong>Customizable Door</strong>

</td>

<td width="50%" align="center" valign="bottom">

<a href="javascript:void(0)" class="chooseDoor" onclick="showPredefinedDoors()">Predefined Door</a>

<strong>Predefined Door</strong></td>

</tr>

</table>

</div>

<div id="aFW_ws1" style="display:none">

<table width="100%" cellpadding="2" cellspacing="2">

<tr>

<td width="50%" align="center" valign="bottom">

<a href="javascript:void(0)" class="customiseWindow" onclick="showCustomizeWindow()">Customize Window</a>

<strong>Customizable Window</strong>

</td>

<td width="50%" align="center" valign="bottom">

<a href="javascript:void(0)" class="chooseWindow" onclick="showPredefinedWindows()">Predefined Window</a>

<strong>Predefined Window</strong></td>

</tr>

</table>

</div>

<div id="aFW_dc" style="display:none">

<table width="100%" cellpadding="2" cellspacing="2">

<tr>

<td>Door Height:</td>

<td><input type="text" name="door_h_0" value="1800" style="width:50px" /> mm</td>

</tr>

<tr>

<td>Door Width:</td>

<td><input type="text" name="door_w_0" value="700" style="width:50px" /> mm</td>

</tr>

<tr>

<td>Opening Direction:</td>

<td><input type="radio" name="door_openingDirection_0" value="indoor" checked="checked" /> indoor  <input type="radio" name="door_openingDirection_0" value="outdoor" /> outdoor</td>

</tr>

<tr>

<td>Distance from Left:</td>

<td><input type="text" name="dfl_0" value="0" style="width:50px" /> mm</td>

</tr>

<tr>

<td>Distance from Right:</td>

<td><input type="text" name="dfr_0" value="0" style="width:50px" /> mm</td>

</tr>

</table>

</div>

<div id="aFW_wc" style="display:none">

<table width="100%" cellpadding="2" cellspacing="2">

<tr>

<td>Window Height:</td>

<td><input type="text" name="window_h_0" value="600" style="width:50px" /> mm</td>

</tr>

<tr>

<td>Window Width:</td>

<td><input type="text" name="window_w_0" value="700" style="width:50px" /> mm</td>

</tr>

<tr>

<td>Distance from Bottom:</td>

<td><input type="text" name="wfb_0" value="500" style="width:50px" /> mm</td>

</tr>

<tr>

<td>Distance from Left:</td>

<td><input type="text" name="wfl_0" value="0" style="width:50px" /> mm</td>

</tr>

<tr>

<td>Distance from Right:</td>

<td><input type="text" name="wfr_0" value="0" style="width:50px" /> mm</td>

</tr>

</table>

</div>

<div id="aFW_dp" style="display:none; overflow:auto">

<table>

<tr>

{{foreach from=$doors_cats item=n}}

<td onmouseover="$(this).find('.front').hide(); $(this).find('.back').show()" onmouseout="$(this).find('.front').show(); $(this).find('.back').hide()"><div align="center" class="ui-widget ui-corner-all" style="background:#000000; color:#FFFFFF">

<div class="front" align="center" style="width:225px; height:175px; padding-top:5px">

<strong>{{$n.Name}}</strong><br />

<img src="uploads/door_variation/{{$n.Picture}}" style="margin-top:5px" />

</div>

<div class="back" style="display:none; width:225px; height:175px; padding-top:5px">

<table width="100%" cellpadding="2" cellspacing="2" height="175">

<tr>

<td>Door Height:</td>

<td>{{$n.H}} mm</td>

</tr>

<tr>

<td>Door Width:</td>

<td>{{$n.W}} mm</td>

</tr>

<tr>

<td colspan="2" align="right" valign="bottom" height="100%"><input type="button" value="Show doors" onclick="showDoorsVariations({{$n.Id}},{{$n.W}},{{$n.H}})" /></td>

</tr>

</table>

</div>

</div></td>

{{/foreach}}

</tr>

</table>

</div>

<div id="aFW_wp" style="display:none; overflow:auto">

<table>

<tr>

{{foreach from=$windows_cats item=n}}

<td onmouseover="$(this).find('.front').hide(); $(this).find('.back').show()" onmouseout="$(this).find('.front').show(); $(this).find('.back').hide()"><div align="center" class="ui-widget ui-corner-all" style="background:#000000; color:#FFFFFF">

<div class="front" align="center" style="width:225px; height:175px; padding-top:5px">

<strong>{{$n.Name}}</strong><br />

<img src="uploads/window_variation/{{$n.Picture}}" style="margin-top:5px" />

</div>

<div class="back" style="display:none; width:225px; height:175px; padding-top:5px">

<table width="100%" cellpadding="2" cellspacing="2" height="175">

<tr>

<td>Window Height:</td>

<td>{{$n.H}} mm</td>

</tr>

<tr>

<td>Window Width:</td>

<td>{{$n.W}} mm</td>

</tr>

<tr>

<td colspan="2" align="right" valign="bottom" height="100%"><input type="button" value="Show windows" onclick="showWindowsVariations({{$n.Id}},{{$n.W}},{{$n.H}})" /></td>

</tr>

</table>

</div>

</div></td>

{{/foreach}}

</tr>

</table>

</div>

<div id="aFW_dv" style="display:block; overflow:auto">

<table>

<tr>

{{foreach from=$doors_vars item=n}}

<td><div align="center" class="ui-widget ui-corner-all dvar d{{$n.IdDoor}}" style="background:#000000; color:#FFFFFF">

<div class="back" style="display:block; width:450px; height:175px; padding-top:5px">

<input type="hidden" name="door_swf_{{$n.Id}}" value="door_types/swf/{{$n.Swf}}" />

<input type="hidden" name="door_h_{{$n.Id}}" value="{{$n.H}}" />

<input type="hidden" name="door_w_{{$n.Id}}" value="{{$n.W}}" />

<input type="hidden" name="render_0_{{$n.Id}}" value="{{$n.Render0}}" />

<input type="hidden" name="render_90_{{$n.Id}}" value="{{$n.Render90}}" />

<input type="hidden" name="render_180_{{$n.Id}}" value="{{$n.Render180}}" />

<input type="hidden" name="render_270_{{$n.Id}}" value="{{$n.Render270}}" />

<table width="100%" cellpadding="2" cellspacing="2" style="font-size:10px">

<tr>

<td rowspan="7" align="center" valign="middle">

<strong id="door_name_{{$n.Id}}">{{$n.Name}}</strong><br />

<img id="door_pic_{{$n.Id}}" src="uploads/door_variation/{{$n.Picture}}" style="margin-top:5px" /></td>

</tr>

<tr>

<td>Door Height:</td>

<td>{{$n.H}} mm</td>

</tr>

<tr>

<td>Door Width:</td>

<td>{{$n.W}} mm</td>

</tr>

<tr>

<td>Opening Direction:</td>

<td><input type="radio" name="door_openingDirection_{{$n.Id}}" value="indoor" checked="checked" /> indoor<br /><input type="radio" name="door_openingDirection_{{$n.Id}}" value="outdoor" /> outdoor</td>

</tr>

<tr>

<td>Distance from Left:</td>

<td><input type="text" name="dfl_{{$n.Id}}" value="0" style="width:50px" onkeyup="checkDoorLeft({{$n.Id}})" /> mm</td>

</tr>

<tr>

<td>Distance from Right:</td>

<td><input type="text" name="dfr_{{$n.Id}}" value="0" style="width:50px" onkeyup="checkDoorRight({{$n.Id}})" /> mm</td>

</tr>

<tr>

<td colspan="2" align="right"><input type="button" value="Add door" onclick="addDoor({{$n.Id}})" /></td>

</tr>

</table>

</div>

</div></td>

{{/foreach}}

<script>

function addDoor( did )

{

dswf = $('input[name=door_swf_'+did+']').val();

w    = $('input[name=door_w_'+did+']').val();

h    = $('input[name=door_h_'+did+']').val();

l    = $('input[name=dfl_'+did+']').val();

dir  = $('input[name=door_openingDirection_'+did+']:checked').val();

pics = ['{{$smarty.const.WEBSITE_URL}}uploads/door_variation/'+$('input[name=render_0_'+did+']').val(),'{{$smarty.const.WEBSITE_URL}}uploads/door_variation/'+$('input[name=render_90_'+did+']').val(),'{{$smarty.const.WEBSITE_URL}}uploads/door_variation/'+$('input[name=render_180_'+did+']').val(),'{{$smarty.const.WEBSITE_URL}}uploads/door_variation/'+$('input[name=render_270_'+did+']').val()];

flashMovie('room_design').doAddDoor(dswf, w, h, l, dir, did, pics);	

$('#actionForWall').dialog('close');			

}

</script>

</tr>

</table>

</div>

<div id="aFW_wv" style="display:block; overflow:auto">

<table>

<tr>

{{foreach from=$windows_vars item=n}}

<td><div align="center" class="ui-widget ui-corner-all dvar d{{$n.IdWindow}}" style="background:#000000; color:#FFFFFF">

<div class="back" style="display:block; width:450px; height:175px; padding-top:5px">

<input type="hidden" name="window_h_{{$n.Id}}" value="{{$n.H}}" />

<input type="hidden" name="window_w_{{$n.Id}}" value="{{$n.W}}" />

<input type="hidden" name="render_w_0_{{$n.Id}}" value="{{$n.Render0}}" />

<input type="hidden" name="render_w_90_{{$n.Id}}" value="{{$n.Render90}}" />

<input type="hidden" name="render_w_180_{{$n.Id}}" value="{{$n.Render180}}" />

<input type="hidden" name="render_w_270_{{$n.Id}}" value="{{$n.Render270}}" />

<table width="100%" cellpadding="2" cellspacing="2" style="font-size:10px">

<tr>

<td rowspan="7" align="center" valign="middle">

<strong id="window_name_{{$n.Id}}">{{$n.Name}}</strong><br />

<img id="window_pic_{{$n.Id}}" src="uploads/window_variation/{{$n.Picture}}" style="margin-top:5px" /></td>

</tr>

<tr>

<td>Window Height:</td>

<td>{{$n.H}} mm</td>

</tr>

<tr>

<td>Window Width:</td>

<td>{{$n.W}} mm</td>

</tr>

<tr>

<td>Distance from Bottom:</td>

<td><input type="text" name="wfb_{{$n.Id}}" value="1000" style="width:50px" /> mm</td>

</tr>

<tr>

<td>Distance from Left:</td>

<td><input type="text" name="wfl_{{$n.Id}}" value="0" style="width:50px" onkeyup="checkWindowLeft({{$n.Id}})" /> mm</td>

</tr>

<tr>

<td>Distance from Right:</td>

<td><input type="text" name="wfr_{{$n.Id}}" value="0" style="width:50px" onkeyup="checkWindowRight({{$n.Id}})" /> mm</td>

</tr>

<tr>

<td colspan="2" align="right"><input type="button" value="Add window" onclick="addWindow({{$n.Id}})" /></td>

</tr>

</table>

</div>

</div></td>

{{/foreach}}

<script>

function addWindow( did )

{

b    = $('input[name=wfb_'+did+']').val();

w    = $('input[name=window_w_'+did+']').val();

h    = $('input[name=window_h_'+did+']').val();

l    = $('input[name=wfl_'+did+']').val();

pics = ['{{$smarty.const.WEBSITE_URL}}uploads/window_variation/'+$('input[name=render_w_0_'+did+']').val(),'{{$smarty.const.WEBSITE_URL}}uploads/window_variation/'+$('input[name=render_w_90_'+did+']').val(),'{{$smarty.const.WEBSITE_URL}}uploads/window_variation/'+$('input[name=render_w_180_'+did+']').val(),'{{$smarty.const.WEBSITE_URL}}uploads/window_variation/'+$('input[name=render_w_270_'+did+']').val()];

flashMovie('room_design').doAddWindow(w, h, l, b, did, pics);	

$('#actionForWall').dialog('close');			

}

</script>

</tr>

</table>

</div>

<div id="aFW_dedit" style="display:block; overflow:auto">

<table>

<tr>

<td><div align="center" class="ui-widget ui-corner-all dvar d{{$n.IdDoor}}" style="background:#000000; color:#FFFFFF">

<div class="back" style="display:block; width:450px; height:175px; padding-top:5px">

<table width="100%" cellpadding="2" cellspacing="2" style="font-size:10px">

<tr>

<td rowspan="7" align="center" valign="middle">

<strong id="edit_door_name">Name</strong><br />

<img id="edit_door_pic" src="" style="margin-top:5px" /></td>

</tr>

<tr>

<td>Door Height:</td>

<td><span id="edit_door_h">0</span> mm</td>

</tr>

<tr>

<td>Door Width:</td>

<td><span id="edit_door_w">0</span> mm</td>

</tr>

<tr>

<td>Opening Direction:</td>

<td><input type="radio" name="edit_door_openingDirection" value="indoor" class="indoor" /> indoor<br /><input type="radio" name="edit_door_openingDirection" value="outdoor" class="outdoor" /> outdoor</td>

</tr>

<tr>

<td>Distance from Left:</td>

<td><input type="text" name="edit_dfl" value="0" style="width:50px" onkeyup="checkDoorLeft()" /> mm</td>

</tr>

<tr>

<td>Distance from Right:</td>

<td><input type="text" name="edit_dfr" value="0" style="width:50px" onkeyup="checkDoorRight()" /> mm</td>

</tr>

<tr>

<td colspan="2" align="right"><input type="button" value="Save door" onclick="saveDoor()" /> <input type="button" value="Delete door" onclick="deleteDoor()" /></td>

</tr>

</table>

</div>

</div></td>

<script>

function initEditDoor( cwl, l, dir, w, h, did )

{

//alert('initDoor');

//alert(cwl+'/'+l+'/'+dir+'/'+w+'/'+h+'/'+did);

curWallLenght = cwl*10;

w = w*10;

h = h*10;

l = l;

$('#edit_door_w').html(w);

$('#edit_door_h').html(h);

$('#edit_door_pic').attr('src',$('#door_pic_'+did).attr('src'));

$('#edit_door_name').html($('#door_name_'+did).html());

$('[name="edit_door_openingDirection"]:checked').attr('checked',false);

$('[name="edit_door_openingDirection"].'+dir+'').attr('checked',true);

$('input[name=edit_dfl]').val(l);

$('input[name=edit_dfr]').val(curWallLenght-w-l);

$('#actionForWall').dialog('open');

$('#actionForWall').find('div[id^=aFW_]').css('opacity',1).hide();

$('#actionForWall').dialog( "option", {width: 600,height:250, buttons: {}});

$('#aFW_dedit').show();

curStep = 'aFW_dedit';

}

function saveDoor()

{

l    = $('input[name=edit_dfl]').val();

dir  = $('input[name=edit_door_openingDirection]:checked').val();

flashMovie('room_design').doSaveDoor( l, dir, 'save');

$('#actionForWall').dialog('close');			

}

function deleteDoor()

{

if( !confirm('Really delete?') )

return false;

flashMovie('room_design').doSaveDoor( 0, '', 'delete');

$('#actionForWall').dialog('close');			

}

</script>

</tr>

</table>

</div>

<div id="aFW_wedit" style="display:block; overflow:auto">

<table>

<tr>

<td><div align="center" class="ui-widget ui-corner-all dvar d{{$n.IdWindow}}" style="background:#000000; color:#FFFFFF">

<div class="back" style="display:block; width:450px; height:175px; padding-top:5px">

<table width="100%" cellpadding="2" cellspacing="2" style="font-size:10px">

<tr>

<td rowspan="7" align="center" valign="middle">

<strong id="edit_window_name">Name</strong><br />

<img id="edit_window_pic" src="" style="margin-top:5px" /></td>

</tr>

<tr>

<td>Window Height:</td>

<td><span id="edit_window_h">0</span> mm</td>

</tr>

<tr>

<td>Window Width:</td>

<td><span id="edit_window_w">0</span> mm</td>

</tr>

<tr>

<td>Distance from Bottom:</td>

<td><input type="text" name="edit_wfb" value="0" style="width:50px" /> mm</td>

</tr>

<tr>

<td>Distance from Left:</td>

<td><input type="text" name="edit_wfl" value="0" style="width:50px" onkeyup="checkWindowLeft()" /> mm</td>

</tr>

<tr>

<td>Distance from Right:</td>

<td><input type="text" name="edit_wfr" value="0" style="width:50px" onkeyup="checkWindowRight()" /> mm</td>

</tr>

<tr>

<td colspan="2" align="right"><input type="button" value="Save door" onclick="saveWindow()" /> <input type="button" value="Delete door" onclick="deleteWindow()" /></td>

</tr>

</table>

</div>

</div></td>

<script>

function initEditWindow( cwl, l, w, h, b, did )

{

//alert(cwl+'/'+l+'/'+w+'/'+h+'/'+b+'/'+did);

curWallLenght = cwl*10;

w = w*10;

h = h*10;

b = b*10;

l = l;

$('#edit_window_w').html(w);

$('#edit_window_h').html(h);

$('#edit_window_pic').attr('src',$('#window_pic_'+did).attr('src'));

$('#edit_window_name').html($('#window_name_'+did).html());

$('input[name=edit_wfl]').val(l);

$('input[name=edit_wfr]').val(curWallLenght-w-l);

$('input[name=edit_wfb]').val(b);

$('#actionForWall').dialog('open');

$('#actionForWall').find('div[id^=aFW_]').css('opacity',1).hide();

$('#actionForWall').dialog( "option", {width: 600,height:250, buttons: {}});

$('#aFW_wedit').show();

curStep = 'aFW_wedit';

}

function saveWindow()

{

l    = $('input[name=edit_wfl]').val();

b    = $('input[name=edit_wfb]').val();

flashMovie('room_design').doSaveWindow( l, b, 'save');

$('#actionForWall').dialog('close');			

}

function deleteWindow()

{

if( !confirm('Really delete?') )

return false;

flashMovie('room_design').doSaveWindow( 0, 0, 'delete');

$('#actionForWall').dialog('close');			

}

</script>

</tr>

</table>

</div>

</div>

</div>

<script>

function initDialogsEW(){

$('#actionForInnerWall').dialog('destroy');

$('#actionForInnerWall').dialog({

autoOpen: false,

height: 250,

minHeight:250,

minWidth:400,

width: 400,

modal: true,

draggable: false,

resizable: false,

close:function(event,ui){

setTimeout('initDialogsEW()',10);

}

});

}

function initDialogs(){

$('#actionForWall').dialog('destroy');

$('#actionForWall').dialog({

autoOpen: false,

height: 250,

minHeight:250,

minWidth:400,

width: 400,

modal: true,

draggable: false,

resizable: false,

close:function(event,ui){

setTimeout('initDialogs()',10);

}

});

}

var curWallLenght = 0;

var curWallHeight = 0;

function checkDoorLeft( did )

{

if( typeof did == "undefined" )

{

dfl = $('[name="edit_dfl"]');

dfr = $('[name="edit_dfr"]');

dw  = Number($('#edit_door_w').html());

}

else

{

dfl = $('[name="dfl_'+did+'"]');

dfr = $('[name="dfr_'+did+'"]');

dw  = $('[name="door_w_'+did+'"]').val();

}

if( $(dfl).val() < 0 ) $(dfl).val(0);

if( $(dfl).val() > curWallLenght-door_set_width )

$(dfl).val(curWallLenght-door_set_width);

vdfr = curWallLenght - dw - $(dfl).val();

$(dfr).val(vdfr);

}

function checkWindowLeft( did )

{

if( typeof did == "undefined" )

{

dfl = $('[name="edit_wfl"]');

dfr = $('[name="edit_wfr"]');

dw  = Number($('#edit_window_w').html());

}

else

{

dfl = $('[name="wfl_'+did+'"]');

dfr = $('[name="wfr_'+did+'"]');

dw  = $('[name="window_w_'+did+'"]').val();

}

if( $(dfl).val() < 0 ) $(dfl).val(0);

if( $(dfl).val() > curWallLenght-window_set_width )

$(dfl).val(curWallLenght-window_set_width);

vdfr = curWallLenght - dw - $(dfl).val();

$(dfr).val(vdfr);

}

function checkDoorRight( did )

{

if( $('[name="dfr_'+did+'"]').val() < 0 ) $('[name="dfr_'+did+'"]').val(0);

if( $('[name="dfr_'+did+'"]').val() > curWallLenght-door_set_width )

$('[name="dfr_'+did+'"]').val(curWallLenght-door_set_width);

vdfl = curWallLenght - $('[name="door_w_'+did+'"]').val()-$('[name="dfr_'+did+'"]').val();

$('[name="dfl_'+did+'"]').val(vdfl);

}

function checkWindowRight( did )

{

if( $('[name="wfr_'+did+'"]').val() < 0 ) $('[name="wfr_'+did+'"]').val(0);

if( $('[name="wfr_'+did+'"]').val() > curWallLenght-window_set_width )

$('[name="wfr_'+did+'"]').val(curWallLenght-window_set_width);

vdfl = curWallLenght - $('[name="window_w_'+did+'"]').val()-$('[name="wfr_'+did+'"]').val();

$('[name="wfl_'+did+'"]').val(vdfl);

}

$(document).ready(function(){

initDialogsEW();

initDialogs();

$('#aFW_dc').find('[name="door_h_0"]').keyup(function(){

if( $('#aFW_dc').find('[name="door_h_0"]').val() > curWallHeight )

$('#aFW_dc').find('[name="door_h_0"]').val(curWallHeight);

});

$('#aFW_dc').find('[name="door_w_0"]').keyup(function(){

if( $('#aFW_dc').find('[name="door_w_0"]').val() > curWallLenght )

$('#aFW_dc').find('[name="door_w_0"]').val(curWallLenght);	

dfl = dfr = (curWallLenght-$('#aFW_dc').find('[name="door_w_0"]').val())/2;

$('#aFW_dc').find('[name="dfl_0"]').val(dfl);

$('#aFW_dc').find('[name="dfr_0"]').val(dfr);

});

$('#aFW_dc').find('[name="dfl_0"]').keyup(function(){

if( $('#aFW_dc').find('[name="dfl_0"]').val() < 0 ) $('#aFW_dc').find('[name="dfl_0"]').val(0);

if( $('#aFW_dc').find('[name="dfl_0"]').val() > curWallLenght-$('#aFW_dc').find('[name="door_w_0"]').val() )

$('#aFW_dc').find('[name="dfl_0"]').val(curWallLenght-$('#aFW_dc').find('[name="door_w_0"]').val());

dfr = curWallLenght - $('#aFW_dc').find('[name="door_w_0"]').val()-$('#aFW_dc').find('[name="dfl_0"]').val();

$('#aFW_dc').find('[name="dfr_0"]').val(dfr);

});

$('#aFW_dc').find('[name="dfr_0"]').keyup(function(){

if( $('#aFW_dc').find('[name="dfr_0"]').val() < 0 ) $('#aFW_dc').find('[name="dfr_0"]').val(0);

if( $('#aFW_dc').find('[name="dfr_0"]').val() > curWallLenght-$('#aFW_dc').find('[name="door_w_0"]').val() )

$('#aFW_dc').find('[name="dfr_0"]').val(curWallLenght-$('#aFW_dc').find('[name="door_w_0"]').val());

dfl = curWallLenght - $('#aFW_dc').find('[name="door_w_0"]').val()-$('#aFW_dc').find('[name="dfr_0"]').val();

$('#aFW_dc').find('[name="dfl_0"]').val(dfl);

});

$('#aFW_wc').find('[name="window_w_0"]').keyup(function(){

if( $('#aFW_wc').find('[name="window_w_0"]').val() > curWallLenght )

$('#aFW_wc').find('[name="window_w_0"]').val(curWallLenght);	

dfl = dfr = (curWallLenght-$('#aFW_wc').find('[name="window_w_0"]').val())/2;

$('#aFW_wc').find('[name="wfl_0"]').val(dfl);

$('#aFW_wc').find('[name="wfr_0"]').val(dfr);

});

$('#aFW_wc').find('[name="wfl_0"]').keyup(function(){

if( $('#aFW_wc').find('[name="wfl_0"]').val() < 0 ) $('#aFW_wc').find('[name="wfl_0"]').val(0);

if( $('#aFW_wc').find('[name="wfl_0"]').val() > curWallLenght-$('#aFW_wc').find('[name="window_w_0"]').val() )

$('#aFW_wc').find('[name="wfl_0"]').val(curWallLenght-$('#aFW_wc').find('[name="window_w_0"]').val());

dfr = curWallLenght - $('#aFW_wc').find('[name="window_w_0"]').val()-$('#aFW_wc').find('[name="wfl_0"]').val();

$('#aFW_wc').find('[name="wfr_0"]').val(dfr);

});

$('#aFW_wc').find('[name="wfr_0"]').keyup(function(){

if( $('#aFW_wc').find('[name="wfr_0"]').val() < 0 ) $('#aFW_dc').find('[name="wfr_0"]').val(0);

if( $('#aFW_wc').find('[name="wfr_0"]').val() > curWallLenght-$('#aFW_wc').find('[name="window_w_0"]').val() )

$('#aFW_wc').find('[name="wfr_0"]').val(curWallLenght-$('#aFW_wc').find('[name="window_w_0"]').val());

dfl = curWallLenght - $('#aFW_wc').find('[name="window_w_0"]').val()-$('#aFW_wc').find('[name="wfr_0"]').val();

$('#aFW_wc').find('[name="wfl_0"]').val(dfl);

});

});

var flashvars = {};

var params = {allowScriptAccess:"sameDomain", wmode: "transparent"};

var attributes = {wmode:"transparent", name:"swfHolder",id:"room_design",name:"room_design"};

t = ($(window).height()-$('#loading').height())/2;

l = ($(window).width()-$('#loading').width())/2;

$('#loading').css('top',t);

$('#loading').css('left',l);

function saveData( theData ){

	$.post('ajax/data_handler.php',{action:'save_room_design',data:theData},function(data){

		window.location='{{$smarty.const.WEBSITE_URL}}room-planner.html';

	})

}

function flashMovie(movieName)

{

	if(window.document[movieName])

	{

		return window.document[movieName];

	}

	else

	{

		return document.getElementById(movieName);

	}

}

function saveRoom( thedata ){

	$.post('{{$smarty.const.WEBSITE_URL}}ajax/data_handler.php',{action:'save_room_holder',data:thedata},function(data){

	window.location = '{{$smarty.const.WEBSITE_URL}}design-room.html';

	})

}

function doInitMe(){

	$.post('{{$smarty.const.WEBSITE_URL}}ajax/data_handler.php',{action:'get_room_holder'},function(data){

		flashMovie('room_design').init(data);
			$('#swfHolderH>object').css('opacity',1);

	})

}

var curStep = '';

function optiuniPereteStatic( l, h )

{

	$('#actionForWall').dialog('open');

	$('#actionForWall').find('div[id^=aFW_]').css('opacity',1).hide();

	$('#actionForWall').dialog( "option", {width: 400,height:250, buttons: {}});

	$('#aFW_first').show();

	curWallLenght = l*10;

	curWallHeight = h*10;

	curStep = 'aFW_first';

}

function showDoorsStep1(){

	$('#actionForWall').dialog('option','title','Add Door Options');

	$('#'+curStep).animate({opacity:0},250,function(){

	$('#'+curStep).hide();

	$('#aFW_ds1').show().css('opacity',0).animate({opacity:1},250);

	curStep = 'aFW_ds1';

	$( "#actionForWall" ).dialog( "option", "buttons", { "Back":function(){

		$('#'+curStep).animate({opacity:0},250,function(){

			$('#'+curStep).hide();

			$('#aFW_first').show().css('opacity',0).animate({opacity:1},250);

			curStep = 'aFW_first';

			$( "#actionForWall" ).dialog( "option", "buttons", { });

			});

		}});

	});

}

function showWindowsStep1(){

	$('#actionForWall').dialog('option','title','Add Window Options');

	$('#'+curStep).animate({opacity:0},250,function(){

	$('#'+curStep).hide();

	$('#aFW_ws1').show().css('opacity',0).animate({opacity:1},250);

	curStep = 'aFW_ws1';

	$( "#actionForWall" ).dialog( "option", "buttons", { "Back":function(){

		$('#'+curStep).animate({opacity:0},250,function(){

			$('#'+curStep).hide();

			$('#aFW_first').show().css('opacity',0).animate({opacity:1},250);

			curStep = 'aFW_first';

			$( "#actionForWall" ).dialog( "option", "buttons", { });

			});

		}});

	});

}

function showPredefinedDoors(){

	var dlg = $("#actionForWall").parents(".ui-dialog:first");

	w = 600;

	l = ($(document).width()-600)/2;	

	dlg.animate({ width: w, left: l },500);

	$('#actionForWall').dialog('option','title','Select Door Model');

	$('#'+curStep).animate({opacity:0},250,function(){

	$('#'+curStep).hide();

	$('#aFW_dp').show().css('opacity',0).animate({opacity:1},250);

	curStep = 'aFW_dp';

	$( "#actionForWall" ).dialog( "option", "buttons", { "Back":function(){

	var dlg = $("#actionForWall").parents(".ui-dialog:first");

	l = ($(document).width()-400)/2;

	dlg.animate({ width: 400, left: l },500);

	showDoorsStep1();

	}});

	});

}

function showPredefinedWindows(){

	var dlg = $("#actionForWall").parents(".ui-dialog:first");

	w = 600;

	l = ($(document).width()-600)/2;	

	dlg.animate({ width: w, left: l },500);

	$('#actionForWall').dialog('option','title','Select Window Model');

	$('#'+curStep).animate({opacity:0},250,function(){

	$('#'+curStep).hide();

	$('#aFW_wp').show().css('opacity',0).animate({opacity:1},250);

	curStep = 'aFW_wp';

	$( "#actionForWall" ).dialog( "option", "buttons", { "Back":function(){

	var dlg = $("#actionForWall").parents(".ui-dialog:first");

	l = ($(document).width()-400)/2;

	dlg.animate({ width: 400, left: l },500);

	showWindowsStep1();

	}});

	});

}

var door_set_width = 0;

var door_set_height = 0;

function showDoorsVariations( did, dw, dh ){

	door_set_width  = dw;

	door_set_height = dh;

	var dlg = $("#actionForWall").parents(".ui-dialog:first");

	w = 600;

	l = ($(document).width()-600)/2;	

	dlg.animate({ width: w, left: l },500);

	$('#actionForWall').dialog('option','title','Door Settings');

	$('#aFW_dv').find('.dvar').hide();

	$('#aFW_dv').find('.d'+did).show();

	$('#'+curStep).animate({opacity:0},250,function(){

	$('#'+curStep).hide();

	$('#aFW_dv').show().css('opacity',0).animate({opacity:1},250);

	curStep = 'aFW_dv';

	$( "#actionForWall" ).dialog( "option", "buttons", { "Back":function(){

	showPredefinedDoors();

	}});

	});

}

var window_set_width = 0;

var window_set_height = 0;

function showWindowsVariations( did, dw, dh ){

	window_set_width  = dw;

	window_set_height = dh;

	var dlg = $("#actionForWall").parents(".ui-dialog:first");

	w = 600;

	l = ($(document).width()-600)/2;	

	dlg.animate({ width: w, left: l },500);

	$('#actionForWall').dialog('option','title','Window Settings');

	$('#aFW_wv').find('.dvar').hide();

	$('#aFW_wv').find('.d'+did).show();

	$('#'+curStep).animate({opacity:0},250,function(){

	$('#'+curStep).hide();

	$('#aFW_wv').show().css('opacity',0).animate({opacity:1},250);

	curStep = 'aFW_wv';

	$( "#actionForWall" ).dialog( "option", "buttons", { "Back":function(){

	showPredefinedWindows();

	}});

	});

}

function showCustomizeDoor(){

	$('#actionForWall').dialog('option','title','Add Customizable Door');

	$('#'+curStep).animate({opacity:0},250,function(){

	$('#'+curStep).hide();

	$('#aFW_dc').show().css('opacity',0).animate({opacity:1},250);

	curStep = 'aFW_dc';

	});

	w = $('#aFW_dc').find('[name="door_w_0"]').val();

	h = $('#aFW_dc').find('[name="door_h_0"]').val();

	if( curWallLenght < w )

	$('#aFW_dc').find('[name="door_w_0"]').val(curWallLenght);

	if( curWallHeight < h )

	$('#aFW_dc').find('[name="door_h_0"]').val(curWallHeight);

	dfl = dfr = (curWallLenght-w)/2;

	$('#aFW_dc').find('[name="dfl_0"]').val(dfl);

	$('#aFW_dc').find('[name="dfr_0"]').val(dfr);

	$( "#actionForWall" ).dialog( "option", "buttons", { "Add door": function() {

	dswf = 'door_types/swf/normal.swf';

	w    = $('input[name=door_w_0]').val();

	h    = $('input[name=door_h_0]').val();

	l    = $('input[name=dfl_0]').val();

	dir  = $('input[name=door_openingDirection_0]:checked').val();

	flashMovie('room_design').doAddDoor(dswf, w, h, l, dir, 0,[]);	

	$('#actionForWall').dialog('close');	

	},

	"Back":function(){

	showDoorsStep1();

	}});

}

function showCustomizeWindow(){

	$('#actionForWall').dialog('option','title','Add Customizable Window');

	$('#'+curStep).animate({opacity:0},250,function(){

	$('#'+curStep).hide();

	$('#aFW_wc').show().css('opacity',0).animate({opacity:1},250);

		curStep = 'aFW_wc';

	});

	w = $('#aFW_wc').find('[name="window_w_0"]').val();

	h = $('#aFW_wc').find('[name="window_h_0"]').val();

	if( curWallLenght < w )

	$('#aFW_wc').find('[name="window_w_0"]').val(curWallLenght);

	if( curWallHeight < h )

	$('#aFW_wc').find('[name="window_h_0"]').val(curWallHeight);

	dfl = dfr = (curWallLenght-w)/2;

	$('#aFW_wc').find('[name="wfl_0"]').val(dfl);

	$('#aFW_wc').find('[name="wfr_0"]').val(dfr);

	$( "#actionForWall" ).dialog( "option", "buttons", { "Add window": function() {

	dswf = 'door_types/swf/normal.swf';

	b    = $('input[name=wfb_0]').val();

	w    = $('input[name=window_w_0]').val();

	h    = $('input[name=window_h_0]').val();

	l    = $('input[name=wfl_0]').val();

	flashMovie('room_design').doAddWindow(w, h, l, b, 0,[]);	

		$('#actionForWall').dialog('close');	

	},

	"Back":function(){

		showWindowsStep1();

	}});

}

function loadFlash()

{

	swfobject.embedSWF("{{$smarty.const.WEBSITE_URL}}flash/step2.swf?r="+Math.random(), "swfHolder", $(window).width(), $(window).height()-20, "10.0.0", "expressInstall.swf", flashvars, params, attributes);
			$('#swfHolderH>object').css('opacity',0);

}

$(document).ready(function(){

	$('#loading').hide();

	$('#pageHolder').show();

	$('#pageHolder').height($(window).height());

	$('.fullWidth').width($(window).width()-300);

	$('.helpLink').fancybox();

	$('#swfHolderH').css('top',20);

	$('#swfHolderH').css('left',0);

	setTimeout('loadFlash()',1000);

});

</script>