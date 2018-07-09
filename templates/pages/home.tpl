<head>
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
	$('#introPlayer').css('top',($(window).height()-320)/2);
	$('#introPlayer').css('left',($(window).width()-240)/2);
});
</script>
<\head>
<img id="loading" style="position:absolute" src="images/loading.gif" />
<div id="pageHolder" style="display:none">
{{$header}}
<a href="where-to.html" class="large_red_btn btri"><span><strong>SKIP INTRO</strong></span></a>
<div style="margin:100px 250px;">
<object type="application/x-shockwave-flash" style="width:853px; height:480px;" data="http://www.youtube.com/v/k3qhur6XzTw&amp;hl=en_US&amp;fs=1?rel=0">
<param name="movie" value="http://www.youtube.com/v/k3qhur6XzTw&amp;hl=en_US&amp;fs=1?rel=0" />
<param name="wmode" value="transparent"></param></object>
</div>