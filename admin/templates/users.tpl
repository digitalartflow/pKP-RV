{{include file='main_pieces/header.tpl'}}

<div id="listItems" class="pagePieces">

<h1>Accounts</h1>

<fieldset style="margin-bottom:5px">

<legend><strong>Search:</strong></legend>

<form method="get">

<input type="hidden" name="page" value="{{$smarty.get.page}}" />

<table width="100%" cellpadding="5" cellspacing="1">

<tr>

	<td><strong>Expression:</strong></td>

	<td><input type="text" name="expression" value="{{$smarty.get.expression|default:''}}" /></td>

</tr>

<tr>

	<td align="center" colspan="4"><input type="submit" value="Search" /> <input type="button" value="Reset" onclick="window.location='?page={{$smarty.get.page}}'" /></td>

</tr>

</table>

</form>

</fieldset>

<div class="paginare">

Pages: {{section loop=$pagini name=pagini}} <a href="{{$linkwcp}}&pg={{$smarty.section.pagini.iteration}}"{{if $curpag==$smarty.section.pagini.iteration}} class="on"{{/if}}>{{$smarty.section.pagini.iteration}}</a>{{/section}}

</div>

<table width="100%" cellpadding="5" cellspacing="1">

<tr bgcolor="#000000" style="color:#FFF">

	<th align="center">#</th>

	<th align="left">Name</th>

	<th align="left" width="100%">Email</th>

	<th align="center">State, Postal code</th>

	<th align="center">Found us</th>

	<th align="center">Actions</th>

</tr>

{{foreach $items as $n}}

<tr bgcolor="{{cycle values='#EEE,#CCC'}}">

	<td>{{$n.Id}}</td>

	<td nowrap="nowrap"><strong>{{$n.Name}}</strong></td>

	<td nowrap="nowrap">{{$n.Email}}</td>

	<td align="left" nowrap="nowrap">{{foreach from=$states item=s}}{{if $n.State==$s.Id}}{{$s.name}}{{/if}}{{/foreach}}, {{$n.PostalCode|default:'-'}}</td>

	<td align="left" nowrap="nowrap">{{$n.found_us}}{{if strlen($n.found_us_extra) > 0 }}:{{/if}}<br />{{$n.found_us_extra}}</td>

    <td align="center"><input type="button" value="Edit" onclick="modifyItem({{$n.Id}})" /><br /><form id="form_{{$n.Id}}" method="post"><input type="hidden" name="action" value="delete" /><input type="hidden" name="Id" value="{{$n.Id}}" /><input type="button" onclick="del({{$n.Id}})" value="Delete" style="margin-top:2px; background:#900" />

</form></td>

</tr>

{{/foreach}}

</table

>

<div class="paginare">

Pages: {{section loop=$pagini name=pagini}} <a href="{{$linkwcp}}&pg={{$smarty.section.pagini.iteration}}"{{if $curpag==$smarty.section.pagini.iteration}} class="on"{{/if}}>{{$smarty.section.pagini.iteration}}</a>{{/section}}

</div>

</div>

{{include file='main_pieces/footer.tpl'}}