<img id="loading" style="position:absolute" src="images/loading.gif" />

<div id="pageHolder" style="display:none; overflow:auto">



<div id="innerData" style="margin:100px 0px 0px 10px">

<div id="swfHolderH" style="position:fixed">

<div id="swfHolder"></div>

</div>

</div>

</div>

{{$header}}

<script>



var flashvars = {allowScriptAccess:"always"};

var params = {allowScriptAccess:"always",wmode:"transparent"};

var attributes = {wmode:"transparent",

name:"swfHolder",allowScriptAccess:"always"};



t = ($(window).height()-$('#loading').height())/2;

l = ($(window).width()-$('#loading').width())/2;

$('#loading').css('top',t);

$('#loading').css('left',l);

function saveRoom( thedata ){

	//alert(thedata);

	$.post('{{$smarty.const.WEBSITE_URL}}ajax/data_handler.php',{action:'save_room_holder',data:thedata},function(data){

		window.location = '{{$smarty.const.WEBSITE_URL}}design-room.html';

	})

}

$(document).ready(function(){

	$('#loading').hide();

	$('#pageHolder').show();

	$('#pageHolder').height($(window).height());

	$('.fullWidth').width($(window).width()-300);

	$('.helpLink').fancybox();

	

	$('#swfHolderH').css('top',20);

	$('#swfHolderH').css('left',0);

	$('.helpLink').fancybox();

	

	swfobject.embedSWF("flash/step1.swf?r="+Math.random(), "swfHolder", $(window).width(), $(window).height()-20, "9.0.0", "expressInstall.swf", flashvars, params, attributes);

});

</script>