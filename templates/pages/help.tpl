<img id="loading" style="position:absolute" src="images/loading.gif" />
<div id="pageHolder" style="display:none; background:url(images/help_image.png) center no-repeat; overflow:auto">
{{$header}}
<div id="innerData" style="margin:100px 0px 0px 10px">
{{foreach from=$pages item=n}}
<h1><a href="show-page/{{$n.Link}}" class="helpLink" style="color:#FFFFFF; text-decoration:none; font-weight:normal">{{$n.Name}}</a></h1>
{{/foreach}}
<a href="where-to.html" class="large_red_btn btri"><span><strong>BACK</strong></span></a>
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
	$('.helpLink').fancybox();
	
	//$('#innerData').css('top',($(window).height()-$('#innerData').height())/2);
	//$('#innerData').css('left',0);
});
</script>