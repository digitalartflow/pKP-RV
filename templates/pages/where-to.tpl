<img id="loading" style="position:absolute" src="images/loading.gif" />
<div id="pageHolder" style="display:none">
{{$header}}
<div align="center" style="width:500px; height:250px; position:fixed;" class="ui-dialog ui-widget ui-widget-content ui-corner-all  ui-draggable ui-resizable" id="innerData">
<h1 class="ui-dialog-titlebar ui-widget-header ui-corner-all title">What would you like to do?</h1>
<a href="choose-state.html" class="large_red_btn w300"><span><strong>Start online design</strong></span></a>
<br /><br /><a href="help.html" class="large_red_btn w300"><span><strong>Take a tutorial or get help</strong></span></a>
</div>
</div>
<script>
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