<style>
    a.cat
    {
        cursor: pointer;
        text-decoration: underline;
        color:fuchsia;
    }
    a.cat:hover
    {
       color:blue;
    }

    div.variations
    {
        border: 1px dotted #3399ff;
        height:300px;
        padding:5px;
    }

    div.variation
    {
        border: 1px solid #3399ff;
        height: 125px;
    }

</style>
<script language="javascript">
    var cmd        = "{{$cmd}}";
    var current_id = -1;

    $(document).ready
    (

        function()
        {
            $(".handle").makeAsyncUploader
            (
                {
                    upload_url      : "../ajax/units/upload_handle.php",
                    flash_url       : 'flash/swfupload.swf',
                    button_image_url: 'images/blankButton.png',
                    button_text     : "Upload Picture",
                    upload_complete : function()
                    {
                    }
                }
            );
            $(".top").makeAsyncUploader
            (
                {
                    upload_url      : "../ajax/units/upload_top.php",
                    flash_url       : 'flash/swfupload.swf',
                    button_image_url: 'images/blankButton.png',
                    button_text     : "Upload Picture",
                    upload_complete : function()
                    {
                    }
                }
            );
            $(".variation").makeAsyncUploader
            (
                {
                    upload_url      : "../ajax/units/upload_variation.php",
                    flash_url       : 'flash/swfupload.swf',
                    button_image_url: 'images/blankButton.png',
                    button_text     : "Upload Picture",
                    upload_complete : function()
                    {
                    }
                }
            );
            //
            $(".checkbox").button();
            $("#TxtDescription").TinyAdd({"mode":"simple"});
            //
            $("#TxtSwf").makeAsyncUploader
            (
                {
                    upload_url      : "../ajax/units/upload_swf.php",
                    flash_url       : 'flash/swfupload.swf',
                    button_image_url: 'images/blankButton.png',
                    button_text     : "Upload SWF",
                    upload_complete : function()
                    {
                        //
                    }
                }
            );
            $("#TxtIcon").makeAsyncUploader
            (
                {
                    upload_url      : "../ajax/units/upload_icon.php",
                    flash_url       : 'flash/swfupload.swf',
                    button_image_url: 'images/blankButton.png',
                    button_text     : "Upload Icon",
                    upload_complete : function()
                    {
                        icon = "../uploads/units/" + $("[name='TxtIcon_filename']").val();
                        $("#IconPreview").attr("src", icon  );
                        $("#IconPreview").fadeIn("slow");
                    }
                }
            );
            if( cmd == "edit" )
            {
                //adauga categoriile
                {{foreach from=$categories item=c}}
                id   = '{{$c}}';
                name = $("#CmbType").find("option[value='" + id + "']").text();
                name = $.trim(name.replace("&nbsp;",""));
                add_cat(id,name);
                {{/foreach}}
                //attaching
                $("#CmbAttaching").val('{{$d.Attaching}}');
                //show icon
                icon = "../uploads/units/{{$d.Icon}}" ;
                $("#IconPreview").attr("src", icon );
                $("#IconPreview").fadeIn("slow");
                //
                $("#CmbManufacturer").val( '{{$d.IdManufacturer}}' );
                current_id = '{{$d.Id}}';
                refresh_dtc();
                //adauga variatiile si handleurile
                {{foreach from=$handles item=h}}
                    add_handle_row( '{{$h.Id}}', '{{$h.PriceDiff}}', '{{$h.Image0}}', '{{$h.Image90}}', '{{$h.Image180}}', '{{$h.Image270}}' )
                {{/foreach}}
                {{foreach from=$variations item=v}}
                    add_variation_row( '{{$v.Id}}', '{{$v.PriceDiff}}', '{{$v.Image0}}', '{{$v.Image90}}', '{{$v.Image180}}', '{{$v.Image270}}', '{{$v.DoorName}}', '{{$v.TextureName}}', '{{$v.CarcassName}}' );
                {{/foreach}}
                {{foreach from=$tops item=v}}
                    add_top_row( '{{$v.Id}}', '{{$v.PriceDiff}}', '{{$v.Image0}}', '{{$v.Image90}}', '{{$v.Image180}}', '{{$v.Image270}}');
                {{/foreach}}
                $("#BtnOk1").hide();
            }
            else
            {
                $("#step2").hide();
            }

        }
    );

    function add_category()
    {
        categorie_id   = $("#CmbType").val();
        categorie_name = $("#CmbType option:selected").text();
        categorie_name = $.trim(categorie_name.replace("&nbsp;",""));
        //cauta sa nu mai am deja aceasta categorie
        nr = $("#Categorii").find("a.cat[_id='" + categorie_id + "']").length;
        //
        if( nr == 0 )
        {
            //adauga noua categorie
            add_cat( categorie_id, categorie_name );
        }
    }

    function add_cat(id,name)
    {
        //scoate mesajul de empty daca exista
        $("#Categorii").find("span.empty-msg").remove();
        //adauga categoria
        $("#Categorii").append("<a onclick='javascript:remove_cat(this)' class='cat' _id=" + id + ">" + name + "<br/></a>");
    }

    function remove_cat(sender)
    {
        $(sender).remove();
        //daca e goala Categorii atunci arata spanul gri
        if( $("#Categorii").find("a.cat").length == 0 )
        {
            $("#Categorii").append('<span class="empty-msg" style="color:gray; font-style: italic">Category list empty</span>');
        }
    }

    function get_selected_categories()
    {
        ret = "";
        $("#Categorii").find("a.cat").each
        (
            function()
            {
                ret += "{" + $(this).attr("_id") + "}";
            }
        );
        if( ret == "" )
        {
            //adauga automat primul id din cmbTypes
            ret = "{" + $("#CmbType").val() + "}";
        }
        return ret;
    }

    function ok()
    {
        _cats    = get_selected_categories();
        _name    = $( "#TxtName"      ).val();
        _swf     = $( "[name='TxtSwf_filename']" ).val();
        _att     = $( "#CmbAttaching" ).val();
        _icon    = $( "[name='TxtIcon_filename']" ).val();
        _descr   = $( "#TxtDescription"    ).TinyGet();
        _hasapp   = $( "#HasAppliance"    ).val();
        _appname   = $( "#TxtApplianceName"    ).val();
        _appdescr   = $( "#TxtApplianceDescription"    ).val();
        _manuf   = $( "#CmbManufacturer"   ).val();
        _price   = $( "#TxtPrice"          ).val();
		_width   = $( "#TxtWidth"          ).val();
		_height   = $( "#TxtHeight"          ).val();
		_depth   = $( "#TxtDepth"          ).val();
		_distfb   = $( "#TxtDistanceFromBottom"          ).val();
		_hasw   = $( "#CmbHasWorktop"          ).val();
        //
        $("#ImgLoading").show();
        //
        if( cmd == "add" )
        {
            $.post
            (
                "ajax/units/adauga.php",
                {
                    "cats"   : _cats,
                    "name"   : _name,
                    "descr"  : _descr,
                    "swf"    : _swf,
                    "att"    : _att,
                    "icon"   : _icon,
                    "manuf"  : _manuf,
                    "price"  : _price,
                    "width"  : _width,
                    "height"  : _height,
                    "depth"  : _depth,
                    "distfb"  : _distfb,
                    "hasw"  : _hasw,
                    "hasapp"  : _hasapp,
                    "appname"  : _appname,
                    "appdescr"  : _appdescr
                },
                function(data)
                {
                    $("#ImgLoading").hide();
                    current_id = $.trim(data);
					window.location = 'index.php?page=addeditu&cmd=edit&id='+current_id;
					return false;
                    //
                    $("#Tbl1").hide();
                    $("#step2").show();
                    //
                    refresh_dtc();
                    //window.location='index.php?page=units';
                }
            );
        }
        else
        {
            id = '{{$d.Id}}';
            $.post
            (
                "ajax/units/modifica.php",
                {
                    "id"     : id,
                    "cats"   : _cats,
                    "name"   : _name,
                    "descr"  : _descr,
                    "swf"    : _swf,
                    "att"    : _att,
                    "icon"   : _icon,
                    "manuf"  : _manuf,
                    "price"  : _price,
                    "width"  : _width,
                    "height"  : _height,
                    "depth"  : _depth,
                    "distfb"  : _distfb,
                    "hasw"  : _hasw,
                    "hasapp"  : _hasapp,
                    "appname"  : _appname,
                    "appdescr"  : _appdescr
                },
                function(data)
                {
                    $("#ImgLoading").hide();
                    window.location='index.php?page=units';
                }
            );
        }
    }

</script>

<h1 class="admin-title">
	<img src="images/edit.jpg" alt="d" align="absmiddle" />
            {{if $cmd eq 'add'}}
		Add a new unit
            {{else}}
                Edit unit
            {{/if}}
</h1>

<br />

<div align="center">
  <table id="Tbl1" border="0" cellspacing="2" cellpadding="2" class="nice-round-table" style="width:98%">
  <tr style="background-image:url(images/gray-grad.png); height:31px;">
    <td align="left">
        <strong> Unit </strong>
		<img src="images/loading.gif" alt="loading" id="img-loading" style="display:none" width="15" height="15" />
	</td>
  </tr>
  <tr height="40">
    <td>
        <table width="100%" border="0" cellpadding="3" cellspacing="3">
            <tr>
                <td align="left" >
                    <table style="width:100%">
                        <tr>
                            <td style="width:150px">Category: </td>
                            <td valign="top">
                                <select id="CmbType">
                                    {{foreach from=$types item=t}}
                                        {{if $t.IdParent eq 0}}
                                            <option value="{{$t.Id}}"  style="color: teal">{{$t.Name}}</option>
                                            {{foreach from=$types item=c}}
                                                {{if $c.IdParent eq $t.Id}}
                                                    <option value="{{$c.Id}}" style="color: blue"> &nbsp;&nbsp;&nbsp; {{$c.Name}}</option>
                                                {{/if}}
                                            {{/foreach}}
                                        {{/if}}
                                    {{/foreach}}
                                </select>
                                <input type="button" class="ui-widget-header ui-corner-all" value="+" onclick="add_category()"/>
                                <span style="color:gray">(click on a category to remove'it from list)</span>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                                <div id="Categorii" style="width:405px; border: 1px dotted gray; height: 50px; overflow: auto">
                                    <span class="empty-msg" style="color:gray; font-style: italic">Category list empty</span>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Name: </td>
                            <td valign="top">
                                <input type="text" name="TxtName" id="TxtName" style="width:400px" value="{{$d.Name}}" />
                            </td>
                        </tr>
                        
                        <tr>
                            <td>Description: </td>
                            <td valign="top">
                                <textarea id="TxtDescription" style="width:600px; height:500px">{{$d.Description}}</textarea>
                            </td>
                        </tr>
                        <tr>
                            <td valign="top">Has appliance: </td>
                            <td valign="top">
                                <select name="HasAppliance" id="HasAppliance" onchange="$('#applianceData').toggle()">
                                <option value="no"{{if $d.HasAppliance=="no"}} selected="selected"{{/if}}>no</option>
                                <option value="yes"{{if $d.HasAppliance=="yes"}} selected="selected"{{/if}}>yes</option>
                                </select>
                                <div id="applianceData"{{if $d.HasAppliance=="no" || $cmd!='add'}} style="display:none"{{/if}}>
                                <table width="100%">
                                <tr>
                                    <td valign="top">Appliance name: </td>
                                    <td valign="top"><input type="text" id="TxtApplianceName" value="{{$d.ApplianceName}}" /></td>
                                </tr>
                                <tr>
                                    <td valign="top">Appliance description: </td>
                                    <td valign="top">
                                        <textarea id="TxtApplianceDescription" style="width:405px">{{$d.ApplianceDescription}}</textarea>
                                    </td>
                                </tr>
                                </table>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Price: </td>
                            <td valign="top">
                                <input type="text" name="TxtPrice" id="TxtPrice" style="width:400px" value="{{$d.Price}}" />
                            </td>
                        </tr>
                        <tr>
                            <td>Width: </td>
                            <td valign="top">
                                <input type="text" name="TxtWidth" id="TxtWidth" style="width:100px" value="{{$d.Width}}" /> mm
                            </td>
                        </tr>
                        <tr>
                            <td>Height: </td>
                            <td valign="top">
                                <input type="text" name="TxtHeight" id="TxtHeight" style="width:100px" value="{{$d.Height}}" /> mm
                            </td>
                        </tr>
                        <tr>
                            <td>Depth: </td>
                            <td valign="top">
                                <input type="text" name="TxtDepth" id="TxtDepth" style="width:100px" value="{{$d.Depth}}" /> mm
                            </td>
                        </tr>
                        <tr>
                            <td>Distance from bottom: </td>
                            <td valign="top">
                                <input type="text" name="TxtDistanceFromBottom" id="TxtDistanceFromBottom" style="width:100px" value="{{$d.DistanceFromBottom}}" /> mm
                            </td>
                        </tr>
                        <tr>
                            <td>Has worktop:</td>
                            <td valign="top">
                                <select name="CmbHasWorktop" id="CmbHasWorktop">
                                        <option value="yes"{{if $d.HasWorktop=="yes"}} selected="selected"{{/if}}>yes</option>
                                        <option value="no"{{if $d.HasWorktop=="no"}} selected="selected"{{/if}}>no</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>Manufacturer:</td>
                            <td valign="top">
                                <select name="CmbManufacturer" id="CmbManufacturer">
                                    {{foreach from=$manufacturers item=m}}
                                        <option value="{{$m.Id}}">{{$m.Name}}</option>
                                    {{/foreach}}
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>Upload SWF:</td>
                            <td valign="top">
                                <input type="file" id="TxtSwf"/>
                            </td>
                        </tr>
                        <tr>
                            <td>Attaching:</td>
                            <td valign="top">
                                <select id="CmbAttaching">
                                    <option value="1">Normal</option>
                                    <option value="2">Corner</option>
                                </select>
                            </td>
                        </tr>
                        <!--
                        <tr>
                            <td>
                                Icon:<br/>
                                <img id="IconPreview" src="" style="display:none"/>
                            </td>
                            <td valign="top">
                                <input type="file" id="TxtIcon"/>
                            </td>
                        </tr>-->
                        <tr>
                            <td colspan="2" align="center">
                                <img src="images/loading.gif" style="width:15px; height: 15px; display:none" id="ImgLoading"/>
                                <input id="BtnOk1" type="button" value="Ok" class="ui-widget-header ui-corner-all" style="width:100px" onclick="ok();" />
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>


    </td>
  </tr>
</table>
</div>
<br/>


<div id="step2">
    <table id="Tbl1" border="0" cellspacing="2" cellpadding="2" class="nice-round-table" style="width:98%">
  <tr style="background-image:url(images/gray-grad.png); height:31px;">
    <td align="left">
        <input type="button" value="+" class="ui-widget-header ui-corner-all" onclick="show_add_handle();" />
        <strong> Handles </strong>
		<img src="images/loading.gif" alt="loading" id="img-loading" style="display:none" width="15" height="15" />
	</td>
  </tr>
  <tr height="40">
    <td>
        <table width="100%" border="0" cellpadding="3" cellspacing="3">
        <tr>
            <td colspan="2">
                <div id="lst-handles" style="border:1px dotted #2191c0; overflow: auto; width: 99%; height:100px">
                </div>
            </td>
        </tr>
    </table>
    </td>
  </tr>
    </table>

<br/>
    <table border="0" cellspacing="2" cellpadding="2" class="nice-round-table" style="width:98%">
  <tr style="background-image:url(images/gray-grad.png); height:31px;">
    <td align="left">
        <input type="button" value="+" class="ui-widget-header ui-corner-all" onclick="show_add_top();" />
        <strong> Tops </strong>
		<img src="images/loading.gif" alt="loading" id="img-loading" style="display:none" width="15" height="15" />
	</td>
  </tr>
  <tr height="40">
    <td>
        <table width="100%" border="0" cellpadding="3" cellspacing="3">
        <tr>
            <td colspan="2">
                <div id="lst-tops" style="border:1px dotted #2191c0; overflow: auto; width: 99%; height:100px">
                </div>
            </td>
        </tr>
    </table>
    </td>
  </tr>
    </table>

<br/>
    <table border="0" cellspacing="2" cellpadding="2" class="nice-round-table" style="width:98%">
  <tr style="background-image:url(images/gray-grad.png); height:31px;">
    <td align="left">
        <input type="button" value="+" class="ui-widget-header ui-corner-all" onclick="show_add_variation();" />
        <strong> Variations </strong>
		<img src="images/loading.gif" alt="loading" id="img-loading" style="display:none" width="15" height="15" />
	</td>
  </tr>
  <tr height="40">
    <td>
        <table width="100%" border="0" cellpadding="3" cellspacing="3">
        <tr>
            <td colspan="2">
                <div id="lst-variations" style="border:1px dotted #2191c0; overflow: auto; width: 99%; height:100px">
                </div>
            </td>
        </tr>
    </table>
    </td>
  </tr>
    </table>
<br/>
<div align="center">
    <input id="BtnOk2" type="button" value="Ok" class="ui-widget-header ui-corner-all" style="width:100px" onclick="ok2();" />
</div>
<br/>
</div>

<div id="DlgAddHandle" style="display:none">
    <table style="width:100%">
            <tr>
                <td>Picture 0&deg;:</td>
                <td> <input type="file" class="handle" id="AddHandlePicture1" /></td>
            </tr>
            <tr>
                <td>Picture 90&deg;:</td>
                <td> <input type="file" class="handle"  id="AddHandlePicture2" /></td>
            </tr>
            <tr>
                <td>Picture 180&deg;:</td>
                <td> <input type="file" class="handle"  id="AddHandlePicture3" /></td>
            </tr>
            <tr>
                <td>Picture 270&deg;:</td>
                <td> <input type="file" class="handle"  id="AddHandlePicture4" /></td>
            </tr>
            <tr>
                <td>Price diff:</td>
                <td>  + <input type="text" id="TxtHandlePriceDiff" style="width:90px" value="0" /></td>
            </tr>
            <tr>
                <td>Handle:</td>
                <td><select id="TxtHandleId">
                {{foreach from=$latches item=n}}
                <option value="{{$n.Id}}">{{$n.Name}}</option>
                {{/foreach}}
                </select></td>
            </tr>
            <tr>
                <td colspan="2" align="center" valign="bottom" height="100">
                    <input type="button" value="Cancel" class="ui-widget-header ui-corner-all" style="width:100px" onclick="cancel_handle();" />
                    <input type="button" value="Ok" class="ui-widget-header ui-corner-all" style="width:100px" onclick="ok_handle();" />
                </td>
            </tr>
    </table>
</div>

<div id="template-handle-row" style="display:none">
    <table width="650px" id="handle-cid">
        <tr>
            <td width="60"><img  src="../uploads/unit_handles/cimg1" style="width:50px; height:50px; border:1px double #666699"/></td>
            <td width="60"><img  src="../uploads/unit_handles/cimg2" style="width:50px; height:50px; border:1px double #666699"/></td>
            <td width="60"><img  src="../uploads/unit_handles/cimg3" style="width:50px; height:50px; border:1px double #666699"/></td>
            <td width="60"><img  src="../uploads/unit_handles/cimg4" style="width:50px; height:50px; border:1px double #666699"/></td>
            <td width="160" align="right"><span style="font-weight: bold">+chandlepricediff</span></td>
            <td width="250" align="right">
                <input type="button" value="Delete" class="ui-widget-header ui-corner-all" style="width:100px" onclick="delete_handle('cid');" />
            </td>
        </tr>
    </table>
</div>

<div id="DlgAddTop" style="display:none">
    <table style="width:100%">
            <tr>
                <td>Picture 0&deg;:</td>
                <td> <input type="file" class="top" id="AddTopPicture1" /></td>
            </tr>
            <tr>
                <td>Picture 90&deg;:</td>
                <td> <input type="file" class="top"  id="AddTopPicture2" /></td>
            </tr>
            <tr>
                <td>Picture 180&deg;:</td>
                <td> <input type="file" class="top"  id="AddTopPicture3" /></td>
            </tr>
            <tr>
                <td>Picture 270&deg;:</td>
                <td> <input type="file" class="top"  id="AddTopPicture4" /></td>
            </tr>
            <tr>
                <td>Price diff:</td>
                <td>  + <input type="text" id="TxtTopPriceDiff" style="width:90px" value="0" /></td>
            </tr>
            <tr>
                <td>Top texture:</td>
                <td>
                    <select id="CmbTopVariation">
                        <option value="1">top texture</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td colspan="2" align="center" valign="bottom" height="100">
                    <input type="button" value="Cancel" class="ui-widget-header ui-corner-all" style="width:100px" onclick="cancel_top();" />
                    <input type="button" value="Ok" class="ui-widget-header ui-corner-all" style="width:100px" onclick="ok_top();" />
                </td>
            </tr>
    </table>
</div>


<div id="template-top-row" style="display:none">
    <table width="650px" id="top-cid">
        <tr>
            <td width="60"><img  src="../uploads/unit_tops/cimg1" style="width:50px; height:50px; border:1px double #666699"/></td>
            <td width="60"><img  src="../uploads/unit_tops/cimg2" style="width:50px; height:50px; border:1px double #666699"/></td>
            <td width="60"><img  src="../uploads/unit_tops/cimg3" style="width:50px; height:50px; border:1px double #666699"/></td>
            <td width="60"><img  src="../uploads/unit_tops/cimg4" style="width:50px; height:50px; border:1px double #666699"/></td>
            <td width="160" align="right"><span style="font-weight: bold">+chandlepricediff</span></td>
            <td width="250" align="right">
                <input type="button" value="Delete" class="ui-widget-header ui-corner-all" style="width:100px" onclick="delete_top('cid');" />
            </td>
        </tr>
    </table>
</div>



<div id="DlgAddVariation" style="display:none">
    <table style="width:100%">
            <tr>
                <td>Picture 0&deg;:</td>
                <td> <input type="file"  class="variation" id="AddVariationPicture1" /></td>
            </tr>
            <tr>
                <td>Picture 90&deg;:</td>
                <td> <input type="file"  class="variation" id="AddVariationPicture2" /></td>
            </tr>
            <tr>
                <td>Picture 180&deg;:</td>
                <td> <input type="file" class="variation"  id="AddVariationPicture3" /></td>
            </tr>
            <tr>
                <td>Picture 270&deg;:</td>
                <td> <input type="file"  class="variation" id="AddVariationPicture4" /></td>
            </tr>
            <tr>
                <td>Price diff:</td>
                <td>  + <input type="text" id="TxtVariationPriceDiff" style="width:90px" value="0" /></td>
            </tr>
            <tr>
                <td>Door:</td>
                <td>
                    <select id="CmbDoorVariation">
                        <option value="1">usa</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Texture:</td>
                <td>
                    <select id="CmbTextureVariation">
                        <option value="1">textura</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Carcass:</td>
                <td>
                    <select id="CmbCarcassVariation">
                        <option value="1">carcass</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td colspan="2" align="center" valign="bottom" height="100">
                    <input type="button" value="Cancel" class="ui-widget-header ui-corner-all" style="width:100px" onclick="cancel_variation();" />
                    <input type="button" value="Ok" class="ui-widget-header ui-corner-all" style="width:100px" onclick="ok_variation();" />
                </td>
            </tr>
    </table>
</div>


<div id="template-variation-row" style="display:none">
    <table width="650px" id="variation-cid">
        <tr>
            <td width="50"><img  src="../uploads/unit_variations/cimg1" style="width:50px; height:50px; border:1px double #666699"/></td>
            <td width="50"><img  src="../uploads/unit_variations/cimg2" style="width:50px; height:50px; border:1px double #666699"/></td>
            <td width="50"><img  src="../uploads/unit_variations/cimg3" style="width:50px; height:50px; border:1px double #666699"/></td>
            <td width="50"><img  src="../uploads/unit_variations/cimg4" style="width:50px; height:50px; border:1px double #666699"/></td>
            <td width="50" align="right"><span style="font-weight: bold">+chandlepricediff</span></td>
            <td width="100" align="right"><span style="font-weight: bold">cDoor</span></td>
            <td width="100" align="right"><span style="font-weight: bold">cTexture</span></td>
            <td width="100" align="right"><span style="font-weight: bold">cCarcass</span></td>
            <td width="50" align="right">
                <input type="button" value="Delete" class="ui-widget-header ui-corner-all" style="width:100px" onclick="delete_variation('cid');" />
            </td>
        </tr>
    </table>
</div>


<script language="javascript">
    
    //refresh list of doors, textures and carcasses according to id manufacturer
    function refresh_dtc()
    {
        $.post
        (
            "ajax/units/get_dtc.php",
            { "id" : $("#CmbManufacturer").val() },
            function(data)
            {
                parts     = data.split("~");
                doors     = eval( "(" + parts[0] + ")" );
                
                textures  = eval( "(" + parts[1] + ")" );
                carcasses = eval( "(" + parts[2] + ")" );
                tops = eval( "(" + parts[3] + ")" );
                //umple comboboxurile
                $("#CmbDoorVariation option"   ).remove();
                $("#CmbTextureVariation option").remove();
                $("#CmbCarcassVariation option").remove();
                $("#CmbTopVariation option").remove();
                //adauga
                for( var i = 0; i < countJSON(doors); i++ )
                {
                    key = doors[i]["Id"];
                    val = doors[i]["Name"];
                    $("#CmbDoorVariation").append($("<option></option>").attr("value",key).text(val));
                }
                for( var i = 0; i < countJSON(textures); i++ )
                {
                    key = textures[i]["Id"];
                    val = textures[i]["Name"];
                    $("#CmbTextureVariation").append($("<option></option>").attr("value",key).text(val));
                }
                for( var i = 0; i < countJSON(carcasses); i++ )
                {
                    key = carcasses[i]["Id"];
                    val = carcasses[i]["Name"];
                    $("#CmbCarcassVariation").append($("<option></option>").attr("value",key).text(val));
                }
                for( var i = 0; i < countJSON(tops); i++ )
                {
                    key = tops[i]["Id"];
                    val = tops[i]["Name"];
                    $("#CmbTopVariation").append($("<option></option>").attr("value",key).text(val));
                }
            }
        );
    }

    function ok_variation()
    {
        //posteaza informatiile
        price_diff = $("#TxtVariationPriceDiff").val();
        img1 = $("[name='AddVariationPicture1_filename']").val();
        img2 = $("[name='AddVariationPicture2_filename']").val();
        img3 = $("[name='AddVariationPicture3_filename']").val();
        img4 = $("[name='AddVariationPicture4_filename']").val();
        id_door    = $("#CmbDoorVariation"   ).val();
        door       = $("#CmbDoorVariation option:selected").text();
        id_texture = $("#CmbTextureVariation").val();
        texture    = $("#CmbTextureVariation option:selected").text();
        id_carcass = $("#CmbCarcassVariation").val();
        carcass    = $("#CmbCarcassVariation option:selected").text();
        $.post
        (
            "ajax/units/add_variation.php",
            {
                "id_unit"    : current_id,
                "price_diff" : price_diff,
                "img0"       : img1,
                "img1"       : img2,
                "img2"       : img3,
                "img3"       : img4,
                "id_door"    : id_door,
                "id_texture" : id_texture,
                "id_carcass" : id_carcass
            },
            function(data)
            {
                add_variation_row( data, price_diff, img1, img2, img3, img4, door, texture, carcass );
            }
        );
        //
        //adauga randul nou
        $("#DlgAddVariation").dialog('close');
    }

    function add_variation_row( id, price_diff, img1, img2, img3, img4, door, texture, carcass )
    {
        html = $("#template-variation-row").html();
        html = html.toString().replace("cid"  , id  , "gim");
        html = html.toString().replace("cimg1", img1, "gim");
        html = html.toString().replace("cimg2", img2, "gim");
        html = html.toString().replace("cimg3", img3, "gim");
        html = html.toString().replace("cimg4", img4, "gim");
        //
        html = html.toString().replace("cDoor"   , door   , "gim");
        html = html.toString().replace("cTexture", texture, "gim");
        html = html.toString().replace("cCarcass", carcass, "gim");
        //
        html = html.toString().replace("chandlepricediff", price_diff, "gim");

        $("#lst-variations").append(html);
    }

    function ok_handle()
    {
        //posteaza informatiile
        price_diff = $("#TxtHandlePriceDiff").val();
        handleid = $("#TxtHandleId").val();
        img1 = $("[name='AddHandlePicture1_filename']").val();
        img2 = $("[name='AddHandlePicture2_filename']").val();
        img3 = $("[name='AddHandlePicture3_filename']").val();
        img4 = $("[name='AddHandlePicture4_filename']").val();
        $.post
        (
            "ajax/units/add_handle.php",
            {
                "id_unit"    : current_id,
                "price_diff" : price_diff,
                "handleid" : handleid,
                "img0" : img1,
                "img1" : img2,
                "img2" : img3,
                "img3" : img4
            },
            function(data)
            {
                add_handle_row( data, price_diff, img1, img2, img3, img4 );
            }
        );
        //
        //adauga randul nou
        $("#DlgAddHandle").dialog('close');
    }
	
	function ok_top()
    {
        //posteaza informatiile
        price_diff = $("#TxtTopPriceDiff").val();
        img1 = $("[name='AddTopPicture1_filename']").val();
        img2 = $("[name='AddTopPicture2_filename']").val();
        img3 = $("[name='AddTopPicture3_filename']").val();
        img4 = $("[name='AddTopPicture4_filename']").val();
        idtop = $("#CmbTopVariation").val();
        $.post
        (
            "ajax/units/add_top.php",
            {
                "id_unit"    : current_id,
                "price_diff" : price_diff,
                "img0" : img1,
                "img1" : img2,
                "img2" : img3,
                "img3" : img4,
                "idtop" : idtop
            },
            function(data)
            {
                add_top_row( data, price_diff, img1, img2, img3, img4 );
				//window.location = window.location;
            }
        );
        //
        //adauga randul nou
        $("#DlgAddTop").dialog('close');
    }

    function add_handle_row( id, price_diff, img1, img2, img3, img4 )
    {
        html = $("#template-handle-row").html();
        html = html.toString().replace("cid"  , id  , "gim");
        html = html.toString().replace("cimg1", img1, "gim");
        html = html.toString().replace("cimg2", img2, "gim");
        html = html.toString().replace("cimg3", img3, "gim");
        html = html.toString().replace("cimg4", img4, "gim");
        html = html.toString().replace("chandlepricediff", price_diff, "gim");
        $("#lst-handles").append(html);
    }

    function add_top_row( id, price_diff, img1, img2, img3, img4 )
    {
        html = $("#template-top-row").html();
        html = html.toString().replace("cid"  , id  , "gim");
        html = html.toString().replace("cimg1", img1, "gim");
        html = html.toString().replace("cimg2", img2, "gim");
        html = html.toString().replace("cimg3", img3, "gim");
        html = html.toString().replace("cimg4", img4, "gim");
        html = html.toString().replace("chandlepricediff", price_diff, "gim");
        $("#lst-tops").append(html);
    }

    function delete_variation(id)
    {
        InputBox("Are you sure?",
            function()
            {
                $.post( "ajax/units/sterge_variation.php",
                    {
                        "id"  : id
                    },
                    function(data)
                    {
                        $("#variation-"+id ).fadeOut();
                    }
                );
            }
        );
    }

    function delete_handle(id)
    {
        InputBox("Are you sure?",
            function()
            {
                $.post( "ajax/units/sterge_handle.php",
                    {
                        "id"  : id
                    },
                    function(data)
                    {
                        $("#handle-"+id ).fadeOut();
                    }
                );
            }
        );
    }

    function delete_top(id)
    {
        InputBox("Are you sure?",
            function()
            {
                $.post( "ajax/units/sterge_top.php",
                    {
                        "id"  : id
                    },
                    function(data)
                    {
                        $("#top-"+id ).fadeOut();
                    }
                );
            }
        );
    }

    function cancel_handle()
    {
        $("#DlgAddHandle").dialog('close');
    }
    function cancel_top()
    {
        $("#DlgAddTop").dialog('close');
    }

    function cancel_variation()
    {
        $("#DlgAddVariation").dialog('close');
    }
    
    function show_add_handle()
    {
        $("#DlgAddHandle").dialog({autoOpen: false, height: 320, width:750, modal: true});
        $("#DlgAddHandle").dialog('open');
    }
    
    function show_add_top()
    {
        $("#DlgAddTop").dialog({autoOpen: false, height: 320, width:750, modal: true});
        $("#DlgAddTop").dialog('open');
    }

    function show_add_variation()
    {
        $("#DlgAddVariation").dialog({autoOpen: false, height: 420, width:750, modal: true});
        $("#DlgAddVariation").dialog('open');
    }

    function ok2()
    {
        if( cmd == "edit" ) ok();
        //
       // window.location = 'index.php?page=units';
    }
</script>