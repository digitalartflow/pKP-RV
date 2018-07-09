{{$header}}
<style>
h1, h2{
	padding:0px;
	margin:5px
}
a{
	color:#F90
}
#shoppingCart{
	width:700px;
	position:absolute;
	top:50px;
	color:#333;
	padding:10px;
	background:#FFF
}
#shoppingCart .price{
	padding:10px 0px 10px 0px
}
#shoppingCart .price sup{
	font-size:12px;
	color:#FF9900
}
#shoppingCart .price strong{
	font-size:22px;
	color:#FFCC00
}
</style>
<img id="loading" style="position:absolute" src="images/loading.gif" />
<div id="pageHolder" style="display:none">
<div id="shoppingCart">
<h1>Order 3D Photorealistic Renders</h1>
{{if $items|@count > 0}}
<table width="100%" id="shoppingCartTable" cellpadding="4" cellspacing="2">
<tr bgcolor="#999999" style="font-weight:bold">
    <td width="80%">Render</td>
    <td align="center" width="10%">No</td>
    <td align="center" width="10%">Yes</td>
</tr>
<tr bgcolor="{{cycle values='#CCC,#F4F4F4'}}">
    <td valign="middle">Render NV corner</td>
    <td align="center"><input type="radio" name="RenderNV" value="no" onclick="checkTotal()" /></td>
    <td align="center"><input type="radio" name="RenderNV" checked="checked" onclick="checkTotal()" value="yes" /></td>
</tr>
<tr bgcolor="{{cycle values='#CCC,#F4F4F4'}}">
    <td valign="middle">Render NE corner</td>
    <td align="center"><input type="radio" name="cRenderNE" value="no" onclick="checkTotal()" /></td>
    <td align="center"><input type="radio" name="cRenderNE" checked="checked" onclick="checkTotal()" value="yes" /></td>
</tr>
<tr bgcolor="{{cycle values='#CCC,#F4F4F4'}}">
    <td valign="middle">Render SV corner</td>
    <td align="center"><input type="radio" name="cRenderSV" value="no" onclick="checkTotal()" /></td>
    <td align="center"><input type="radio" name="cRenderSV" checked="checked" onclick="checkTotal()" value="yes" /></td>
</tr>
<tr bgcolor="{{cycle values='#CCC,#F4F4F4'}}">
    <td valign="middle">Render SE corner</td>
    <td align="center"><input type="radio" name="cRenderSE" value="no" onclick="checkTotal()" /></td>
    <td align="center"><input type="radio" name="cRenderSE" checked="checked" onclick="checkTotal()" value="yes" /></td>
</tr>
<tr>
    <td align="right"><h2>Total</h2></td>
    <td align="center" colspan="2"><h2><span id="total">80</span> $</h2></td>
</tr>
</table>
<script>
function checkTotal()
{
	total = 0;
	$('input[name=RenderNE]').val($('input[name=cRenderNE]:checked').val());
	$('input[name=RenderNV]').val($('input[name=cRenderNV]:checked').val());
	$('input[name=RenderSE]').val($('input[name=cRenderSE]:checked').val());
	$('input[name=RenderSV]').val($('input[name=cRenderSV]:checked').val());
	if( $('input[name=cRenderNE]:checked').val() == "yes"  ) total += 20;
	if( $('input[name=cRenderNV]:checked').val() == "yes"  ) total += 20;
	if( $('input[name=cRenderSE]:checked').val() == "yes"  ) total += 20;
	if( $('input[name=cRenderSV]:checked').val() == "yes"  ) total += 20;
	$('#total').html(total);
	$('input[name=Total]').val(total);
}
</script>
<h1>Delivery Information</h1>
{{if $smarty.session.logged}}
<form method="post">
<input type="hidden" name="action" value="checkout" />
<input type="hidden" name="Total" value="80" />
<input type="hidden" name="RenderNV" value="yes" />
<input type="hidden" name="RenderNE" value="yes" />
<input type="hidden" name="RenderSV" value="yes" />
<input type="hidden" name="RenderSE" value="yes" />
<h2>Please  write us aditional notes related to your requested photorealistic renders</h2>
<textarea style="width:500px; height:100px; margin-left:5px" name="Adress"></textarea>
<h2>Please write us your email address</h2>
<input type="text" style="width:500px; margin-left:5px" name="Phone" />
<h2>Please write us your phone number</h2>
<input type="text" style="width:500px; margin-left:5px" name="ContactHours" />
<div align="center" style="padding:10px 0px 0px 0px"><input class="btnMode" type="submit" value="Checkout" /></div>
</form>
{{else}}

<table width="100%" cellpadding="4" cellspacing="2">

<tr>

	<td width="50%" align="center" style="cursor:pointer; background:#F4F4F4"><input class="btnMode" type="button" value="Login" onclick="showAccount('login')" /></td>

	<td width="50%" align="center" style="cursor:pointer; background:#F4F4F4"><input class="btnMode" type="button" value="Create account" onclick="showAccount('create_account')" /></td>

</tr>

</table>

{{/if}}

{{else}}

No items in the shopping cart!

{{/if}}

</div>

</div>

<form name="formToSubmit" method="post"></form>


<script>
function doLogin()
{
	$('form[name=formToSubmit]').html('<input type="hidden" name="action" value="login" /><input type="hidden" name="Email" value="'+$('#LoginEmail').val()+'" /><input type="hidden" name="Password" value="'+$('#LoginPassword').val()+'" />');
	document.formToSubmit.submit();
}
function addRender( c )
{
	$('form[name=formToSubmit]').html('<input type="hidden" name="action" value="add_render" /><input type="hidden" name="corner" value="'+c+'" />');
	document.formToSubmit.submit();
}
function deleteRender( c )
{
	$('form[name=formToSubmit]').html('<input type="hidden" name="action" value="delete_render" /><input type="hidden" name="corner" value="'+c+'" />');
	document.formToSubmit.submit();
}
t = ($(window).height()-$('#loading').height())/2;
l = ($(window).width()-$('#loading').width())/2;
$('#loading').css('top',t);
$('#loading').css('left',l);
$(document).ready(function(){
	$( "input[type=button],input[type=submit]" ).button();
	$('#loading').hide();
	$('#pageHolder').show();
	$('#pageHolder').height($(window).height());
	$('.fullWidth').width($(window).width());
	$('#shoppingCart').css('left',($(window).width()-600)/2);
});
</script>