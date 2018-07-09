</div>

<div align="center">

  Copyright &copy; 2014 php Kitchen Planner
  
</div>

{{if $alert_srv !== false}}

<div id="alert_msg">

{{foreach $alert_srv as $n}}

{{if $n.type == 'error'}}

<div style="color:red; font-size:12px; text-align:center; padding:2px">{{$n.msg}}</div>

{{else}}

<div style="color:#090; font-size:12px; text-align:center; padding:2px">{{$n.msg}}</div>

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