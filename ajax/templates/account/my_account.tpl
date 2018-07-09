<style>
.menuAccount h1{
	padding:0px;
	margin:0px
}
.menuAccount{
	border-right:1px solid #333333
}
.menuAccount a{
	display:block;
	text-decoration:none;
	padding:4px;
	text-align:right;
	margin-bottom:1px
}
.menuAccount a:hover{
	background:#333333
}
.menuAccount a.btnon{
	display:block;
	text-decoration:none;
	padding:4px;
	text-align:left;
	background:#333333;
	margin-bottom:1px
}
#myAccountPgHolder{
	padding:0px 0px 5px 5px
}
#myAccountPgHolder h1{
	background:#333333;
	padding:4px;
	margin:2px 0px 2px 0px;
	font-size:12px
}
</style>
<div class="account">
<table width="100%" cellpadding="2" cellspacing="1">
<tr>
	<td width="25%" class="menuAccount" valign="top">
    <a href="javascript:void(0)" id="btn_myaccount" onclick="loadMyAccount('myaccount')">My Account</a>
    <a href="javascript:void(0)" id="btn_info" onclick="loadMyAccount('info')">My Info</a>
    <a href="javascript:void(0)" id="btn_ch_pass" onclick="loadMyAccount('ch_pass')">Change Password</a>
    <a href="javascript:void(0)" id="btn_saved_rooms" onclick="loadMyAccount('saved_rooms')">Saved Rooms</a>
    <a href="javascript:void(0)" id="btn_orders" onclick="loadMyAccount('orders')">My Orders</a>
    <a href="products-list.html">Product listing</a>
    </td>
    <td width="75%" valign="top" align="left" id="myAccountPgHolder"></td>
</tr>
</table>
</div>
<script>
function loadMyAccount( pg )
{
	$('.menuAccount').find('a').removeClass('btnon');
	$('#myAccountPgHolder').html('loading...');
	$.get('ajax/myaccount/'+pg+'.php',function(data){
		$('.menuAccount').find('#btn_'+pg+'').addClass('btnon');
		$('#myAccountPgHolder').html(data);
	});
}
loadMyAccount( 'myaccount' );
</script>