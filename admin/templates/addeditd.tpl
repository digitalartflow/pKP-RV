<script language="javascript">
    var cmd        = "{{$cmd}}";

    var current_id = {{if $cmd eq 'add'}}-1{{else}}{{$d.Id}}{{/if}};
    $(document).ready
    (

        function()
        {
            //
            if( cmd == "add" )
            {
                $("#TxtWidth" ).val("0");
                $("#TxtHeight").val("0");
                //
                $('#Tbl2').hide();
            }
            else
            {
                $("#BtnOk1").hide();
                //adauga pozele
                {{foreach from=$poze item=p}}
                add_pic( "{{$p.Picture}}", "{{$p.Id}}", "{{$p.Name}}" );
                {{/foreach}}
            }
            $(".variation").makeAsyncUploader
            (
                {
                    upload_url      : "../ajax/home/upload_pic2.php",
                    flash_url       : 'flash/swfupload.swf',
                    button_image_url: 'images/blankButton.png',
                    button_text     : "Upload Picture",
                    upload_complete : function()
                    {
                    }
                }
            );
            
        }
    );
	
    function ShowAddPictureDialog()
    {
        $("#DlgAddDoor").dialog({autoOpen: false, height: 420, width:750, modal: true});
        $("#DlgAddDoor").dialog('open');
    }
	
    function ShowAddPictureDialog2()
    {
        $("#AddPictureDialog").dialog
        (
            {
                height: 150,
                width : 300,
                modal : true
            }
        );
        $("#AddPictureDialog").dialog('open');
        $("#TxtPozaAdd").makeAsyncUploader
        (
            {
                upload_url      : "../ajax/home/upload_pic.php",
                flash_url       : 'flash/swfupload.swf',
                button_image_url: 'images/blankButton.png',
                button_text     : "Upload picture",
                upload_complete : function()
                {
                    //intreaba numele
                    $("#AddPictureDialog").dialog("destroy");

                    $("#AddPictureDialog2").dialog({
                            modal  : true,
                            buttons:
                            {
                                Ok: function()
                                {
                                    //posteaza noua poza si preia idul
                                    image = $("[name='TxtPozaAdd_filename']").val();
                                    name  = $("#TxtPictureName").val();
                                    $.post
                                    (
                                        "ajax/home/add_pic.php",
                                        {
                                            "image" : image,
                                            "name"  : name,
                                            "id"    : current_id
                                        },
                                        function(data)
                                        {
                                            id = data;
                                            $("#TxtPozaAdd_completedMessage").hide();
                                            $("#TxtPictureName").val("");
                                            $("#AddPictureDialog2").dialog('close');
                                            //adauga poza noua in lista
                                            add_pic( image, id, name );
                                        }
                                    );
                                    
                                }
                            }
                    });

                }
            }
        );

    }

    function add_pic( img, id, name )
    {
        html = $("#TemplatePic").html();
        //
        $("#ListaPoze").append(html);
        div  = $("#ListaPoze").children("div:last");
        //
        $(div).find("#ImgPoza"   ).attr("src","../uploads/door_variation/" + img);
        $(div).find("#TxtPicName").val(name);
        $(div).find("#TxtId"     ).val(id);
        //
    }

    function editPic(sender)
    {
        //get parent
        p    = $(sender).parent().parent().parent().parent().parent().parent().parent().parent();
        //get id
        id   = $(p).find("#TxtId").val();
        //get name
        name = $(p).find("#TxtPicName").val();
        //arata loading
        $(p).find("#ImgAddLoading").show();
        //save
        $.post
        (
            "ajax/home/edit_pic.php",
            {
                "name" : name,
                "id"   : id
            },
            function(data)
            {
                $(p).find("#ImgAddLoading").hide();
            }
        );
    }

    function remPic(sender)
    {
        //get parent
        p    = $(sender).parent().parent().parent().parent().parent().parent().parent().parent().parent();
        //get id
        id   = $(p).find("#TxtId").val();
        //save
        $.post
        (
            "ajax/home/rem_pic.php",
            {
                "id"   : id
            },
            function(data)
            {
                $(p).fadeOut();
            }
        );
    }

    function ok2()
    {
        if( cmd == "add" )
        {
            window.location = 'index.php';
        }
        else
        {
            _type   = $( "#CmbType"      ).val();
            _name   = $( "#TxtName"      ).val();
            _width  = $( "#TxtWidth"     ).val();
            _height = $( "#TxtHeight"    ).val();

            //
            $("#ImgLoading").show();
            //
            $.post
            (
                "ajax/home/modifica.php",
                {
                    "type"   : _type,
                    "name"   : _name,
                    "width"  : _width,
                    "height" : _height,
                    "id"     : current_id
                },
                function(data)
                {
                    $("#ImgLoading").hide();
                    window.location = 'index.php';
                }
            );

        }
    }

    function ok()
    {
        _type   = $( "#CmbType"      ).val();
        _name   = $( "#TxtName"      ).val();
        _width  = $( "#TxtWidth"     ).val();
        _height = $( "#TxtHeight"    ).val();
        
        //
        $("#ImgLoading").show();
        //
        if( cmd == "add" )
        {
            $.post
            (
                "ajax/home/adauga.php",
                {
                    "type"   : _type,
                    "name"   : _name,
                    "width"  : _width,
                    "height" : _height
                },
                function(data)
                {
                    current_id = data;
					window.location = 'index.php?page=addeditd&cmd=edit&id='+current_id;
					/*
                    $("#ImgLoading").hide();
                    $('#Tbl1 :input').attr('disabled', true);
                    $('#Tbl2').show("slow");
                    //ascunde primul buton de ok
                    $("#BtnOk1").hide();*/
                }
            );
        }
    }

</script>

<h1 class="admin-title">
	<img src="images/edit.jpg" alt="d" align="absmiddle" />
            {{if $cmd eq 'add'}}
		Add a new door
            {{else}}
                Edit door
            {{/if}}
</h1>

<br />

<div align="center">
  <table id="Tbl1" border="0" cellspacing="2" cellpadding="2" class="nice-round-table" style="width:98%">
  <tr style="background-image:url(images/gray-grad.png); height:31px;">
    <td align="left">
        <strong> Door </strong>
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
                            <td>Door type: </td>
                            <td valign="top">
                                <select id="CmbType">
                                    {{foreach from=$types item=t}}
                                        <option value="{{$t.Id}}">{{$t.Name}}</option>
                                    {{/foreach}}
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>Name: </td>
                            <td valign="top">
                                <input type="text" name="TxtName" id="TxtName" style="width:400px" value="{{$d.Name}}" />
                            </td>
                        </tr>
                        <tr>
                            <td>Width: </td>
                            <td valign="top">
                                <input type="text" name="TxtWidth" id="TxtWidth" style="width:100px" value="{{$d.W}}" />
                            </td>
                        </tr>
                        <tr>
                            <td>Height: </td>
                            <td valign="top">
                                <input type="text" name="TxtHeight" id="TxtHeight" style="width:100px" value="{{$d.H}}" />
                            </td>
                        </tr>
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
    <br/>


     <table  id="Tbl2"  border="0" cellspacing="2" cellpadding="2" class="nice-round-table" style="width:650px">
          <tr style="background-image:url(images/gray-grad.png); height:31px;">
            <td align="left">
                <strong> Pictures </strong>
                <img src="images/loading.gif" alt="loading" id="img-loading" style="display:none" width="15" height="15" />
                <input onclick="ShowAddPictureDialog()" type="button" value="Add picture" class="ui-widget-header ui-corner-all"/>
                </td>
          </tr>
          <tr >
              <td align="center">
                  <div id="ListaPoze" style="width:90%; height:450px; border: 1px dotted gray; overflow: auto; padding:2px">
                    <!-- aici lista de poze -->
                  </div>
              </td>
          </tr>
          <tr style="height:40px">
              <td align="center">
                  <img src="images/loading.gif" style="width:15px; height: 15px; display:none" id="ImgLoading2"/>
                  <input type="button" id="BtnOk2" value="Ok" class="ui-widget-header ui-corner-all" style="width:100px;" onclick="ok2();" />
              </td>
          </tr>
     </table>
</div>

<div id="DlgAddDoor" style="display:none">
    <table style="width:100%">
            <tr>
                <td>Picture poster:</td>
                <td> <input type="file"  class="variation" id="AddDoorPicturePoster" /></td>
            </tr>
            <tr>
                <td>Picture 0&deg;:</td>
                <td> <input type="file"  class="variation" id="AddDoorPicture1" /></td>
            </tr>
            <tr>
                <td>Picture 90&deg;:</td>
                <td> <input type="file"  class="variation" id="AddDoorPicture2" /></td>
            </tr>
            <tr>
                <td>Picture 180&deg;:</td>
                <td> <input type="file" class="variation"  id="AddDoorPicture3" /></td>
            </tr>
            <tr>
                <td>Picture 270&deg;:</td>
                <td> <input type="file"  class="variation" id="AddDoorPicture4" /></td>
            </tr>
            <tr>
                <td>Name:</td>
                <td><input type="text" id="TxtDoorName" style="width:150px" value="" /></td>
            </tr>
            <tr>
                <td colspan="2" align="center" valign="bottom" height="100">
                    <input type="button" value="Cancel" class="ui-widget-header ui-corner-all" style="width:100px" onclick="$('#DlgAddDoor').dialog('close');" />
                    <input type="button" value="Ok" class="ui-widget-header ui-corner-all" style="width:100px" onclick="ok_add();" />
                </td>
            </tr>
    </table>
</div>
<script>
function ok_add()
    {
        //posteaza informatiile
        name = $("#TxtDoorName").val();
        imgp = $("[name='AddDoorPicturePoster_filename']").val();
        img1 = $("[name='AddDoorPicture1_filename']").val();
        img2 = $("[name='AddDoorPicture2_filename']").val();
        img3 = $("[name='AddDoorPicture3_filename']").val();
        img4 = $("[name='AddDoorPicture4_filename']").val();
        $.post
        (
            "ajax/home/add_door.php",
            {
                "imgp"       : imgp,
                "img0"       : img1,
                "img1"       : img2,
                "img2"       : img3,
                "img3"       : img4,
                "name"    : name,
				"id"		: {{$smarty.get.id}}
            },
            function(data)
            {
        	$("#DlgAddDoor").dialog('close');
                window.location=window.location;
            }
        );
    }
</script>
<div id="AddPictureDialog2" title="Choose a name" style="display:none">
	<p>
		<span class="ui-icon ui-icon-circle-check" style="float:left; margin:0 7px 50px 0;"></span>
		Your picture has been uploaded.  <strong>Please choose a name</strong>:
	</p>
	<p>
                <input type="text" id="TxtPictureName"/>
	</p>
</div>


<div id="AddPictureDialog" style="display:none; text-align: center">
    <h1 class="admin-title"> Choose picture </h1>
    <input type="file" id="TxtPozaAdd" />
    
</div>


<div id="TemplatePic" style="display:none">
    <div class="ui-state-highlight ui-corner-all" style="border-color:gray;margin:2px; width:250px; height:200px; padding: 10px; float:left">
        <table cellpadding="1" cellspacing="0" style="width:100%">
            <tr>
                <td align="center" colspan="2" height="16">
                    <img style="display:none" id="ImgAddLoading" src="images/loading.gif" width="15" height="15"/>
                </td>
            </tr>
            <tr>
                <td height="150" colspan="2" align="center">
                    <div class="ui-state-highlight ui-corner-all" style="height:150px; overflow:hidden">
                        <img id="ImgPoza" src="../uploads/door_variation/20100611112825_.jpg" border="0" />
                    </div>
                </td>
            </tr>
            <tr>
                <td width="180">
                    <input class="ui-corner-all" id="TxtPicName" type="text" style="width:180px"/>
                </td>
                <td>
                    <input type="hidden" value="-1" id="TxtId"/>
                    <table>
                        <tr>
                            <td>
                                <input type="button" onclick="editPic(this)" value="" class="ui-icon ui-icon-check" style="width:20px; height:20px" />
                            </td>
                            <td>
                                <input type="button" onclick="remPic(this)" value="" class="ui-icon ui-icon-trash" style="width:20px; height:20px" />
                            </td>
                    </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>

</div>