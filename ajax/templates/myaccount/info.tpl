<style>
input[type=text], input[type=password], select
{
	border:1px solid #333333;
	background:#FFFFFF;
	color:#333333;
	padding:2px;
}
</style>
<div id="divLoadingModifyAccount" align="center" style="display:none">
<img src="images/loading.gif" />
</div>
<div align="center" id="divHolderModifyAccount">
<form method="post" id="formCreateAccount" onsubmit="return doModifyAccount()">
<table width="100%" cellpadding="2" cellspacing="1">
<tr>
	<td colspan="2"><h1>Edit Account Information</h1></td>
</tr>
<tr>
	<td width="25%"><strong>Name:</strong></td>
	<td width="75%"><input type="text" name="Name" value="{{$smarty.session.logged.Name}}" /></td>
</tr>
<tr>
	<td><strong>Gender:</strong></td>
	<td><select name="Gender">
    	<option value="m"{{if $smarty.session.logged.Gender=="m"}} selected="selected"{{/if}}>m</option>
    	<option value="f"{{if $smarty.session.logged.Gender=="f"}} selected="selected"{{/if}}>f</option>
    </select></td>
</tr>
<tr>
	<td><strong>State:</strong></td>
	<td><select name="State">
    {{foreach from=$states item=n}}
    	<option value="{{$n.Id}}"{{if $smarty.session.logged.State==$n.Id}} selected="selected"{{/if}}>{{$n.name}}</option>
    {{/foreach}}
    </select></td>
</tr>
<tr>
	<td><strong>Postal Code:</strong></td>
	<td><input type="text" name="PostalCode" value="{{$smarty.session.logged.PostalCode}}" /></td>
</tr>
<tr>
	<td><strong>Date of Birth:</strong></td>
	<td id="dob"><input type="hidden" name="DateOfBirth" id="DateOfBirth" value="{{$smarty.session.logged.DateOfBirth}}" /></td>
</tr>
<tr>
	<td><strong>Email:</strong></td>
	<td><input type="text" readonly="readonly" name="Email" value="{{$smarty.session.logged.Email}}" /></td>
</tr>
<tr>
	<td colspan="2" align="center"><input class="btnMode" type="submit" value="Modify" /></td>
</tr>
</table>
</form>
</div>
<script>
$('.btnMode').button();
$(document).ready(function(){
        $("#dob").birthdaypicker({defaultDate:"{{$smarty.session.logged.DateOfBirth|date_format:'%m-%d-%Y'}}"});
});
function doModifyAccount()
{
	$('#DateOfBirth').val($('#dob .birth-year').val()+'-'+$('#dob .birth-month').val()+'-'+$('#dob .birth-day').val());
	$('#dob .birthday-picker').remove();
	obj = Object();
	tc  = $('#formCreateAccount').find('input[type=text],input[type=password],input[type=hidden],input[type=checkbox]:checked,select');
	for( i=0; i<tc.length; i++ )
	{
		eval('obj.'+$(tc[i]).attr('name')+'="'+$(tc[i]).val()+'"');
	}
	$('#divLoadingModifyAccount').toggle();
	$('#divHolderModifyAccount').toggle();
	$.post('ajax/account/doModifyAccount.php',obj,function(data){
		$('#divLoadingModifyAccount').toggle();
		$('#divHolderModifyAccount').toggle();
		alert(data.msg);
		loadMyAccount('info');
	},'json');
	return false;
}
</script>