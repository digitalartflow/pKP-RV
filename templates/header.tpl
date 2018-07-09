<div id="header">
	<a class="logo" href="{{$smarty.const.WEBSITE_URL}}">logo</a>
    <div id="loginBar" class="login-bar" align="center" color:#A84C30><a href="javascript:void(0)" onclick="showAccount('login')">Login</a> | <a href="javascript:void(0)" onclick="showAccount('create_account')">Create an account</a></div>
    <a href="javascript:void(0)" onclick="$('#helpDiv').slideToggle()" class="helpBtn">User Guide</a>
    <div id="helpDiv">
    {{foreach from=$helpPages item=n}}
    <a href="show-page/{{$n.Link}}" >{{$n.Name}}</a>
    {{/foreach}}
    </div>
</div>
<div id="accountDataDiv" title=""></div>
<div id="spc_dialog" style="display:block; overflow:auto" title="Please specify State and Postal Code">
<table width="100%" cellpadding="2" cellspacing="2" style="font-size:10px">
    <td>State:</td>
    <td>{{$ceva}}<select id="spc_State">
    <option value="0">--Please Select</option>
    {{foreach from=$states item=n}}
    	<option value="{{$n.Id}}">{{$n.name}}</option>
    {{/foreach}}
    </select></td>
</tr>
<tr>
    <td>Postal code:</td>
    <td><input type="text" id="spc_postal_code" value="0" style="width:50px" /></td>
</tr>
</table>
</div>
<script>
var has_spc = true;
$('#spc_dialog').dialog({
	autoOpen: false,
	height: 250,
	minHeight:250,
	minWidth:400,
	width: 400,
	modal: true,
	draggable: false,
	resizable: false,
	buttons: {
		"Save": function() {
		  $.post('ajax/doAction.php',{a:'save_spc','State':$('#spc_State').val(),'PostalCode':$('#spc_postal_code').val()},function(data){
			  if( data.error == false ){
				  has_spc = true;
				  window.location=window.location;
			  }else{
				  alert(data.error);
			  }
		  },'json');
		}
	},
	beforeclose : function() { return has_spc; },
	closeOnEscape: false,
});
var cpg = '{{$smarty.get.page|default:""}}';
$('#helpDiv>a').fancybox();
$('#header').width($(window).width());
$( "#accountDataDiv" ).dialog({
	autoOpen: false,
	modal:true,
	height: 400,
	width: 800
});
function showAccount( pg )
{
	$('#accountDataDiv').html('loading...');
	$('#accountDataDiv').dialog('open');
	$.get('ajax/account/'+pg+'.php',function(data){
		$('#accountDataDiv').html(data);
	});
}
function refreshLogIn()
{
	$('#loginBar').html('loading...');
	$.post('ajax/account/getLoginBar.php',{page:cpg},function(data){
		$('#loginBar').html(data.html);
		if( cpg == 'room-planner' ){
			if( data.error_state_postalcode )
				showRequestStatePostalCode();
		}
		if( cpg == 'checkout' ){
			//window.location = window.location;
		}
	},'json');
}
function logout()
{
	$.post('ajax/account/doLogOut.php',function(data){
		if( cpg == 'checkout' ){
			window.location = window.location;
		}else{
			refreshLogIn();
		}
	});
}
function showRequestStatePostalCode(){
	//$('#spc_dialog').dialog('open');
	//has_spc = false;
}
refreshLogIn();
</script>

