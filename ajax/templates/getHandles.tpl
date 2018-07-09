{{foreach from=$items item=n}}
	<div style="background:url(uploads/latches/{{$n.Picture}}) no-repeat center #FFFFFF; cursor:pointer; float:left; overflow:hidden; margin:4px; width:70px; height:70px" class="ui-tabs ui-widget ui-widget-content ui-corner-all" onclick="selectHandle({{$n.Id}})">
    </div>
{{/foreach}}