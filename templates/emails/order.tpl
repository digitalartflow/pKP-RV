<div style="width:700px; margin:auto; font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#333; padding:0px 0px 10px 0px">



<div align="left">



<img src="{{$smarty.const.WEBSITE_URL}}images/email_header.png"/>



</div>







<h1>Delivery Information</h1>



<table width="100%" cellpadding="4" cellspacing="1" bgcolor="#CCC">



<tr>



    <td width="25%" bgcolor="#F4F4F4">Name:</td>



    <td width="75%" bgcolor="#FFFFFF">{{$smarty.session.logged.Name}}</td>



</tr>



<tr>



    <td valign="top" bgcolor="#F4F4F4">State:</td>



    <td bgcolor="#FFFFFF">{{foreach from=$states item=s}}

    {{if $smarty.session.logged.State==$s.Id}}{{$s.name}}{{/if}}



    {{/foreach}}</td>



</tr>





<tr>



    <td valign="top" bgcolor="#F4F4F4">Postal code:</td>



    <td bgcolor="#FFFFFF">{{$smarty.session.logged.PostalCode}}</td>



</tr>



<tr>



    <td valign="top" bgcolor="#F4F4F4">Email:</td>



    <td bgcolor="#FFFFFF">{{$smarty.session.logged.Email}}</td>



</tr>



</table>







<h1>Details</h1>

<table width="100%" cellpadding="4" cellspacing="1" bgcolor="#CCC">

<tr>

    <td width="25%" bgcolor="#F4F4F4">Your physical address:</td>

    <td width="75%" bgcolor="#FFFFFF">{{$smarty.post.Adress}}</td>

</tr>

<tr>

    <td bgcolor="#F4F4F4">At what phone number can we call you on?</td>

    <td bgcolor="#FFFFFF">{{$smarty.post.Phone}}</td>

</tr>

<tr>

    <td bgcolor="#F4F4F4">When can we contact you?</td>

    <td bgcolor="#FFFFFF">{{$smarty.post.ContactHours}}</td>

</tr>

<tr>

    <td bgcolor="#F4F4F4">Extra info</td>

    <td bgcolor="#FFFFFF">{{$smarty.post.ExtraInfo}}</td>

</tr>

</table>



<h1>Shopping Cart</h1>



{{if $items|@count > 0}}



<table width="100%" cellpadding="4" cellspacing="1" bgcolor="#CCC">



<tr bgcolor="#CCC" style="font-weight:bold">



	<td align="center">Image</td>



    <td width="100%%">Name</td>



    <td align="center">Qty</td>



    <td align="center">Price</td>



    <td align="center">Total</td>



</tr>



{{foreach from=$items item=n}}



<tr bgcolor="{{cycle values='#F4F4F4,#FFFFFF'}}">



	<td valign="top" align="center"><img src="{{$smarty.const.WEBSITE_URL}}uploads/unit_u{{$n.Id}}_h{{$smarty.session.shoppingCart.sd.h}}_t{{$n.IdTop}}_a0.png" height="50" /></td>



    <td valign="middle"><strong>{{$n.Name}}</strong><br />



                <em>{{$n.Code}}</em><br />



    {{foreach from=$n.Numbers item=nr name=numbers}}



    <span style="display:block;	float:left;	background:#666; margin:1px; color:#FFF; font-weight:bold;	padding:5px 10px 5px 10px; border-radius:50px;">{{$nr}}</span>



    {{/foreach}}</td>



    <td align="center">{{$n.Nr}}</td>



    <td align="right" nowrap="nowrap">$ {{$n.Price}}</td>



    <td align="right" nowrap="nowrap">$ {{$n.TotalPrice}}</td>



</tr>



{{/foreach}}





<tr>



    <td align="right" colspan="4"><strong>Total</strong></td>



    <td align="center" nowrap="nowrap"><strong>$ {{$total}}</strong></td>



</tr>



</table>



<h1>2D renderings</h1>



<div style="float:left; width:350px">



<strong>2D rendering of floor units</strong>



<a href="{{$smarty.const.WEBSITE_URL}}uploads/flash_renders/{{$flashRenders.pics.4_base}}" target="_blank"><img src="{{$smarty.const.WEBSITE_URL}}uploads/flash_renders/{{$flashRenders.pics.4_base}}" width="350" height="300" /></a>



</div>



<div style="float:left; width:350px">



<strong>2D rendering of floating units</strong>



<a href="{{$smarty.const.WEBSITE_URL}}uploads/flash_renders/{{$flashRenders.pics.4_floating}}" target="_blank"><img src="{{$smarty.const.WEBSITE_URL}}uploads/flash_renders/{{$flashRenders.pics.4_floating}}" width="350" height="300" /></a>



</div>



<br clear="all" />



<h1 style="margin-top:10px">3D Render Plans (click on image to view larger)</h1>



{{if isset($flashRenders.pics.0)}}



<div style="float:left; margin:5px; width:340px; height:350px; overflow:hidden">



    <h2>0&deg; angle</h2>



    <a href="{{$smarty.const.WEBSITE_URL}}uploads/flash_renders/{{$flashRenders.pics.0}}" target="_blank"><img src="{{$smarty.const.WEBSITE_URL}}uploads/flash_renders/{{$flashRenders.pics.0}}" width="340" height="300" /></a>



</div>



{{/if}}



{{if isset($flashRenders.pics.1)}}



<div style="float:left; margin:5px; width:340px; height:350px; overflow:hidden">



    <h2>90&deg; angle</h2>



    <a href="{{$smarty.const.WEBSITE_URL}}uploads/flash_renders/{{$flashRenders.pics.1}}" target="_blank"><img src="{{$smarty.const.WEBSITE_URL}}uploads/flash_renders/{{$flashRenders.pics.1}}" width="340" height="300" /></a>



</div>



{{/if}}



{{if isset($flashRenders.pics.2)}}



<div style="float:left; margin:5px; width:340px; height:350px; overflow:hidden">



    <h2>180&deg; angle</h2>



    <a href="{{$smarty.const.WEBSITE_URL}}uploads/flash_renders/{{$flashRenders.pics.2}}" target="_blank"><img src="{{$smarty.const.WEBSITE_URL}}uploads/flash_renders/{{$flashRenders.pics.2}}" width="340" height="300" /></a>



</div>



{{/if}}



{{if isset($flashRenders.pics.3)}}



<div style="float:left; margin:5px; width:340px; height:350px; overflow:hidden">



    <h2>270&deg; angle</h2>



    <a href="{{$smarty.const.WEBSITE_URL}}uploads/flash_renders/{{$flashRenders.pics.3}}" target="_blank"><img src="{{$smarty.const.WEBSITE_URL}}uploads/flash_renders/{{$flashRenders.pics.3}}" width="340" height="300" /></a>



</div>



{{/if}}



<br clear="all" />



{{else}}



No items in the shopping cart!



{{/if}}



</div>
</br>
</br>
<Strong>This email is for: {{$smarty.session.logged.Name}} sent to: {{$smarty.session.logged.Email}}.</Strong>

</div>