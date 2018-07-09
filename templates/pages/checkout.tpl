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

<h1>Shopping Cart</h1>

{{if $items|@count > 0}}

<table width="100%" id="shoppingCartTable" cellpadding="4" cellspacing="2">

<tr bgcolor="#999999" style="font-weight:bold">

	<td width="20%" valign="top" align="center">#</td>

    <td width="20%">Name</td>

    <td align="center" width="20%">Items</td>

    <td align="center" width="20%">Price/item</td>

    <td align="center" width="20%">Total price</td>

</tr>

{{foreach from=$items item=n}}

<tr bgcolor="{{cycle values='#CCC,#F4F4F4'}}">

	<td valign="top" align="center"><img src="{{$smarty.const.WEBSITE_URL}}uploads/unit_u{{$n.Id}}_h{{$smarty.session.shoppingCart.sd.h}}_t{{$n.IdTop}}_a0.png" height="50" /></td>

    <td valign="middle">{{$n.Name}}<br />

                <em>{{$n.Code}}</em><br />

					As seen on plan: 

					{{foreach from=$n.Numbers item=nr name=numbers}}

					<strong>{{$nr}}</strong>{{if !$smarty.foreach.numbers.last}}, {{/if}}

					{{/foreach}}</td>

    <td align="center">{{$n.Nr}}</td>

    <td align="center">{{$n.Price}} $</td>

    <td align="center">{{$n.TotalPrice}} $</td>

</tr>

{{/foreach}}

<tr>

    <td align="right" colspan="4"><h2>Total</h2></td>

    <td align="center"><h2>{{$total}} $</h2></td>

</tr>

</table>

		<h1>2D Render Plan base units</h1>

		<div style="background:url({{$smarty.const.WEBSITE_URL}}uploads/flash_renders/{{$flashRenders.pics.4_base}}) center no-repeat; background-size:contain; width:100%; height:300px"></div>

		<h2>2D Render Plan floating units</h2>

		<div style="background:url({{$smarty.const.WEBSITE_URL}}uploads/flash_renders/{{$flashRenders.pics.4_floating}}) center no-repeat; background-size:contain; width:100%; height:300px"></div>

        <h2>3D Render Plans (click on image to view larger)</h2>

        {{if isset($flashRenders.pics.0)}}

        <div style="float:left; margin:5px; width:155px; height:230px; overflow:hidden">

			<h2>0&deg; angle</h2>

			<a href="{{$smarty.const.WEBSITE_URL}}uploads/flash_renders/{{$flashRenders.pics.0}}" target="_blank" style="background:url({{$smarty.const.WEBSITE_URL}}uploads/flash_renders/{{$flashRenders.pics.0}}) center no-repeat; background-size:contain; width:100%; height:200px; display:block"></a>

		</div>

        {{/if}}

        {{if isset($flashRenders.pics.1)}}

        <div style="float:left; margin:5px; width:155px; height:230px; overflow:hidden">

			<h2>90&deg; angle</h2>

			<a href="{{$smarty.const.WEBSITE_URL}}uploads/flash_renders/{{$flashRenders.pics.1}}" target="_blank" style="background:url({{$smarty.const.WEBSITE_URL}}uploads/flash_renders/{{$flashRenders.pics.1}}) center no-repeat; background-size:contain; width:100%; height:200px; display:block"></a>

		</div>

        {{/if}}

        {{if isset($flashRenders.pics.2)}}

        <div style="float:left; margin:5px; width:155px; height:230px; overflow:hidden">

			<h2>180&deg; angle</h2>

			<a href="{{$smarty.const.WEBSITE_URL}}uploads/flash_renders/{{$flashRenders.pics.2}}" target="_blank" style="background:url({{$smarty.const.WEBSITE_URL}}uploads/flash_renders/{{$flashRenders.pics.2}}) center no-repeat; background-size:contain; width:100%; height:200px; display:block"></a>

		</div>

        {{/if}}

        {{if isset($flashRenders.pics.3)}}

        <div style="float:left; margin:5px; width:155px; height:230px; overflow:hidden">

			<h2>270&deg; angle</h2>

			<a href="{{$smarty.const.WEBSITE_URL}}uploads/flash_renders/{{$flashRenders.pics.3}}" target="_blank" style="background:url({{$smarty.const.WEBSITE_URL}}uploads/flash_renders/{{$flashRenders.pics.3}}) center no-repeat; background-size:contain; width:100%; height:200px; display:block"></a>

		</div>

        {{/if}}

		<br clear="all" />

<h1>Contact Information</h1>

{{if $smarty.session.logged}}

<form method="post">

<input type="hidden" name="action" value="checkout" />

<input type="hidden" name="Total" value="{{$total}}" />

<h2>Your physical address:</h2>

<textarea style="width:500px; height:100px; margin-left:5px" name="Adress"></textarea>

<h2>At what phone number can we call you on?</h2>

<input type="text" style="width:500px; margin-left:5px" name="Phone" />

<h2>When can we contact you?</h2>

<input type="text" style="width:500px; margin-left:5px" name="ContactHours" />

<h2>Extra information</h2>

<textarea name="ExtraInfo" style="width:95%; height:150px"></textarea>

<div align="left" style="padding:10px 0px 0px 0px"><a href="{{$smarty.const.WEBSITE_URL}}room-planner.html{{if !empty($smarty.session.last_saved_room_id)}}?lrid={{$smarty.session.last_saved_room_id}}{{/if}}"><input class="btnMode" type="button" value="Back" /></a></div>

<div align="center" style="padding:10px 0px 0px 0px"><input class="btnMode" type="submit" value="Submit" /></div>

</form>

{{else}}

<table width="100%" cellpadding="4" cellspacing="2">

<tr>

    <td width="25%" align="center" style="cursor:pointer; background:#F4F4F4"><a href="{{$smarty.const.WEBSITE_URL}}room-planner.html{{if !empty($smarty.session.last_saved_room_id)}}?lrid={{$smarty.session.last_saved_room_id}}{{/if}}"><input class="btnMode" type="button" value="Back" /></td>


	<td width="25%" align="center" style="cursor:pointer; background:#F4F4F4"><input class="btnMode" type="button" value="Login" onclick="showAccount('login')" /></td>

	<td width="50%" align="center" style="cursor:pointer; background:#F4F4F4"><input class="btnMode" type="button" value="Create account" onclick="showAccount('create_account')" /></td>

</tr>

</table>

{{*

<table width="100%" cellpadding="4" cellspacing="2">

<tr>

	<td width="50%" align="center" style="cursor:pointer; background:#F4F4F4" onclick="$(this).find('input').attr('checked',true); $('#loginForm').toggle(); $('#registerForm').toggle()"><input type="radio" name="ClientType" value="registered" checked="checked" /> I am a registered client</td>

	<td width="50%" align="center" style="cursor:pointer; background:#F4F4F4" onclick="$(this).find('input').attr('checked',true); $('#loginForm').toggle(); $('#registerForm').toggle()"><input type="radio" name="ClientType" value="new" /> I am a new client</td>

</tr>

</table>

<div align="center" id="loginForm" style="background:#F4F4F4; margin:2px">

{{if $msg_login}}

<div align="center" style="border:#900; background:#FFB9B9; padding:10px">{{$msg_login}}</div>

{{/if}}

<table width="100%" cellpadding="4" cellspacing="2">

<tr>

	<td width="25%"><strong>Email:</strong></td>

	<td width="75%"><input type="text" id="LoginEmail" /></td>

</tr>

<tr>

	<td><strong>Password:</strong></td>

	<td><input type="password" id="LoginPassword" /></td>

</tr>

<tr>

	<td colspan="2" align="center"><input class="btnMode" type="button" value="Login" onclick="doLogin()" /></td>

</tr>

</table>

</div>

<div align="center" id="registerForm" style="display:none; background:#F4F4F4; margin:2px">

<table width="100%" cellpadding="4" cellspacing="2">

<tr>

	<td width="25%"><strong>Name:</strong></td>

	<td width="75%"><input type="text" name="Name" /></td>

</tr>

<tr>

	<td><strong>Gender:</strong></td>

	<td><select name="Gender">

    	<option value="m">m</option>

    	<option value="f">f</option>

    </select></td>

</tr>

<tr>

	<td><strong>State:</strong></td>

	<td><select name="State">

    <option value="-">--Please Select</option>

    {{foreach from=$states item=n}}

    	<option value="{{$n.Id}}">{{$n.name}}</option>

    {{/foreach}}

    </select></td>

</tr>

<tr>

	<td><strong>Date of birth:</strong></td>

	<td id="dobc"><input type="hidden" name="DateOfBirth" id="DateOfBirth" value="mm-dd-yyyy" /></td>

</tr>

<tr>

	<td><strong>Email:</strong></td>

	<td><input type="text" name="Email" /></td>

</tr>

<tr>

	<td><strong>Password:</strong></td>

	<td><input type="password" name="Password" /></td>

</tr>

<tr>

	<td colspan="2" align="center"><input type="checkbox" name="Terms" value="yes" /> I have read and agree to the Terms of Use and Privacy Policy.</td>

</tr>

<tr>

<tr>

	<td colspan="2" align="center"><input class="btnMode" type="button" value="Create account" onclick="doCreateAccount()" /></td>

</tr>

</table>

</div>*}}

{{/if}}

{{else}}

No items in the shopping cart!

{{/if}}

</div>

</div>

<form name="formToSubmit" method="post"></form>

<script>

$(document).ready(function(){

        $("#dobc").birthdaypicker({});

});

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