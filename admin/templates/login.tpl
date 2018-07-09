<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>php Kitchen Planner Admin Panel Login</title>

<link type="text/css" href="{{$config.static_admin.css}}default.css" media="screen" rel="stylesheet" />

<link type="text/css" href="{{$config.static_admin.css}}cupertino/jquery-ui-1.8.16.custom.css" media="screen" rel="stylesheet" />

<script src="{{$config.static_admin.js}}jquery.js" type="text/javascript"></script>

<script src="{{$config.static_admin.js}}jquery-ui-1.8.16.custom.min.js" type="text/javascript"></script>

<script src="{{$config.static_admin.js}}functions.js" type="text/javascript"></script>

</head>

<body>

<div id="loginh" style="background:#F7F7F7">

<form method="post">

<input type="hidden" name="action" value="login"/>

<table width="300" cellpadding="0" cellspacing="2">

<tr>

<img src="../admin/templates/images/admin.png" td colspan="2" align="middle"></td>

</tr>

<tr>
    
    <td colspan="2" align="center" style="font-size:20px" width="25%"><strong>Log In to Admin Panel</strong></td>

</tr>

<tr>

	<td width="25%"><strong>User Name:</strong></td>

	<td width="75%"><input type="text" name="user" value="" /></td>

</tr>

<tr>

	<td><strong>Password:</strong></td>

	<td><input type="password" name="pass" value="" /></td>

</tr>

<tr>

	<td colspan="2" align="center" style="padding-top:20px"><input type="submit" value="Login" /></td>

</tr>

</table>

</form>

<table width="300" cellpadding="0" cellspacing="2">

<tr>
    
    <td colspan="2" align="center" style="font-size:10px" width="25%" >A solution from <a href="http://www.digitalartflow.com">Digital Artflow</a></td>

</tr>

</table>

</div>

<script>

$(document).ready(function(){

	t = ($(document).height()-$('#loginh').outerHeight())/2;

	l = ($(document).width()-$('#loginh').outerWidth())/2;

	$('#loginh').css('top',t+'px');

	$('#loginh').css('left',l+'px');

});

</script>

{{if $alert_srv !== false}}

<div id="alert_msg">

{{foreach $alert_srv as $n}}

{{if $n.type == 'error'}}

<div style="color:red; font-size:12px; text-align:center; padding:2px">{{$n.msg}}</div>

{{else}}

<div style="color:red; font-size:12px; text-align:center; padding:2px">{{$n.msg}}</div>

{{/if}}

{{/foreach}}

</div>

<script>

$(document).ready(function() {

	$("#alert_msg").dialog({show: "slide"});

});

setTimeout("$('#alert_msg').dialog('close');",5000);

</script>	

{{/if}}

</body>

</html>

