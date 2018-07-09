{{foreach from=$items item=n}}
	<div style="background:url(uploads/carcasses/{{$n.Picture}}) no-repeat center #FFFFFF; cursor:pointer; float:left; overflow:hidden; margin:4px; width:70px; height:70px" class="ui-tabs ui-widget ui-widget-content ui-corner-all" onclick="selectCarcass({{$n.Id}})">
    </div>
{{/foreach}}