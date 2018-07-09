<img id="loading" style="position:absolute" src="images/loading.gif" />
<div id="pageHolder" style="display:none">
{{$header}}
<div align="center" style="width:500px; height:250px; position:fixed;" class="ui-dialog ui-widget ui-widget-content ui-corner-all  ui-draggable ui-resizable" id="innerData">
<h1 class="ui-dialog-titlebar ui-widget-header ui-corner-all title" style="font-size:16px; margin-bottom:10px">Please Specify State and Postal Code</h1>
<form method="post" id="formChooseState">
<input type="hidden" name="action" value="choose_state" />
<table width="100%" cellpadding="2" cellspacing="10" style="font-size:14px">
    <td>State:</td>
    <td><select name="state">
    <option value="0">--Please Select</option>
    {{foreach from=$states item=n}}
    	<option value="{{$n.Id}}">{{$n.name}}</option>
    {{/foreach}}
    </select></td>
</tr>
<tr>
    <td>Postal Code:</td>
    <td><input type="text" name="postal_code" value="90250" style="width:50px" /></td>
</tr>
</table>
</form>
<a href="javascript: void(0)" onclick="$('#formChooseState').submit()" class="large_red_btn w300" style="position:absolute; bottom:10px; right:10px"><span><strong>Continue</strong></span></a>
</div>
</div>
<script>
{{if $errors}}
alert('{{$errors}}');
{{/if}}
t = ($(window).height()-$('#loading').height())/2;
l = ($(window).width()-$('#loading').width())/2;
$('#loading').css('top',t);
$('#loading').css('left',l);
$(document).ready(function(){
	$('#loading').hide();
	$('#pageHolder').show();
	$('#pageHolder').height($(window).height());
	$('.fullWidth').width($(window).width());
	$('#innerData').css('top',($(window).height()-500)/2);
	$('#innerData').css('opacity',0);
	$('#innerData').css('left',($(window).width()-500)/2);
	$('#innerData').animate({
		top:($(window).height()-250)/2,
		opacity: 1
		},500);
});
</script>