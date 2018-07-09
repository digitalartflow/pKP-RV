<img id="loading" style="position:absolute" src="images/loading.gif" />
<div id="pageHolder" style="display:none">
{{$header}}
<div align="center" style="width:900px; height:500px; position:fixed;" class="ui-dialog ui-widget ui-widget-content ui-corner-all  ui-draggable ui-resizable" id="innerData">
<h1 class="ui-dialog-titlebar ui-widget-header ui-corner-all title" style="font-size:16px; margin-bottom:10px">Please Select Products/Brands</h1>
{{foreach from=$types item=n}}
<a href="start-planning.html?type={{$n.Id}}" style="margin:5px; padding:5px; float:left; width:100px; height:100px; overflow:hidden; border:1px solid #333; background:#000; position:relative; display:block">
	<img src="uploads/manufacturers/{{$n.Logo}}" />
    <strong style="display:block; position:absolute; bottom:5px; left:0px; width:100px; text-align:center">{{$n.Name}}</strong>
</a>
{{/foreach}}
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
	$('#innerData').css('top',0);
	$('#innerData').css('opacity',0);
	$('#innerData').css('left',($(window).width()-900)/2);
	$('#innerData').animate({
		top:($(window).height()-500)/2,
		opacity: 1
		},500);
});
</script>