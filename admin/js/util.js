var current_ed;
//mode             = simple sau full
//swf_upload_url   = "../ajax/tiny/upload_swf.php"
//get_swf_size_url = "ajax/tiny/get_swf_size.php"
jQuery.fn.TinyAdd = function( settings )
{
    return this.each
    (
        function()
        {
            if( settings["mode"] == "simple" )
                initTinyMceSimple();
            else
                initTinyMceFull(settings["swf_upload_url"], settings["get_swf_size_url"]);
            
            id = $(this).attr("id");
            if( !id )
            {
                var now      = new Date();
                var seconds  = now.getSeconds()
                var mseconds = now.getMilliseconds();
                new_id       = "_" + seconds + mseconds;
                $(this).attr("id", new_id);
                addWysiwyg(new_id);
            }
            else
            {
                addWysiwyg(id);
            }
        }
    );
};

jQuery.fn.TinyGet = function()
{
    id  = $(this).attr("id");
    ret = tinyMCE.getInstanceById(id).getContent().toString();
    return ret;
};

jQuery.fn.TinySet = function(content)
{
    id = $(this).attr("id");
    tinyMCE.getInstanceById(id).setContent(content);
        
};

function countJSON( lst )
{
    var objCount=0;
    for(_obj in lst) objCount++;
    return objCount;
}

function initTinyMceSimple()
{
    tinyMCE.init({
            mode : "none",
            theme : "simple",
            skin : "o2k7"
    });
}

function initTinyMceFull(swf_upload_url,get_swf_size_url)
{
    //adauga codul pt upload swf
    
    if( $("#dialog-modal").length == 0 )
    {
        $(document).find("body").append
        (
            '<div id="dialog-modal" title="Flash upload" style="display:none">' +
            '<p style="text-align:center">' +
            '<input type="file" id="TxtUploadSwf"/>' +
            '</p>' +
            '<p style="text-align:center">' +
            'W : <input type="text" id="TxtSwfWidth" value="300" style="width:100px" />' +
            'H : <input type="text" id="TxtSwfHeight" value="500" style="width:100px"/>' +
            '</p>' +
            '<p style="text-align:center">'+
            '<input type="button" value="Ok" class="ui-widget-header ui-corner-all" onclick="addTinySwf()"/>' +
            '</p>' +
            '</div>'
        );
    
        tinyMCE.init({
            mode : "none",
            theme : "advanced",
            skin : "o2k7",
            plugins : "phpimage,safari,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",
            theme_advanced_buttons1 : "swfupload, bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,fontselect,fontsizeselect",
            theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,phpimage,cleanup,code,|,forecolor,backcolor",
            theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,|,sub,sup,|,charmap,emotions,media,|,ltr,rtl,|,fullscreen",
            theme_advanced_disable: "image,advimage",
            theme_advanced_toolbar_location   : "top",
            theme_advanced_toolbar_align      : "left",
            theme_advanced_statusbar_location : "bottom",
            setup : function(ed) {
                // Add a custom button
                ed.addButton('swfupload', {
                    title : 'Upload swf',
                    image : 'images/swf.gif',
                    onclick : function()
                    {
                        current_ed = ed;
                        // Add you own code to execute something on click
                        //ed.focus();
                        //ed.selection.setContent('<strong>Hello world!</strong>');
                        $("#dialog-modal").dialog({height: 200, width:450, modal: true});
                        $("#dialog-modal").dialog('open');
                        $("#TxtUploadSwf").makeAsyncUploader
                        (
                            {
                                upload_url      : swf_upload_url,
                                flash_url       : 'flash/swfupload.swf',
                                button_image_url: 'images/blankButton.png',
                                button_text     : "Alege SWF",
                                upload_complete : function()
                                {
                                    //upload('Ro');
                                    //gaseste dimensiunile swfului
                                    $.post
                                    (
                                        get_swf_size_url,
                                        {
                                            "file" : $("[name='TxtUploadSwf_filename']").val()
                                        },
                                        function(data)
                                        {
                                            parts = data.split("~");
                                            $("#TxtSwfWidth" ).val( parts[0] );
                                            $("#TxtSwfHeight").val( parts[1] );
                                        }
                                    );
                                }
                            }
                        );
                    }
                });
            }
    });
    }
}

function addTinySwf()
{
    $("#dialog-modal").dialog('close');
    _width  = $("#TxtSwfWidth" ).val();
    _height = $("#TxtSwfHeight").val();
    file = $("[name='TxtUploadSwf_filename']").val();
    if( file )
    {
        url  = location.href.toString();
        url  = url.toString().substr(0, url.toString().indexOf("admin"));
        code = '<object wmode="transparent" data="' + url + 'images/uploads/'+file+'" type="application/x-shockwave-flash" width="'+_width+'" height="'+_height+'">';
        code+= '<param value="transparent" name="wmode"><param value="always" name="allowScriptAccess"><param value="all" name="allowNetworking">';
        code+= '<param value="true" name="allowFullScreen"></object>';
        //seteaza codul nou
        current_ed.focus();
        current_ed.selection.setContent(code);
        //sa dispara fisierul uploadat
        $("#TxtUploadSwf_completedMessage").hide();
    }

}


Date.prototype.getDayName = function() 
{
	var d = ['Duminica','Luni','Marti','Miercuri', 'Joi','Vineri','Sambata'];
	return d[this.getDay()];
}

String.prototype.trim = function() {
	return this.replace(/^\s+|\s+$/g,"");
}

function Redirect( url )
{
	window.location = url;
}

function addWysiwyg( id )
{
	if (tinyMCE.getInstanceById(id) == null)
		tinyMCE.execCommand('mceAddControl', false, id );
}


function MessageBox( msg, ok_func )
{
	$("#dialog-wrapper").html('<div id="dialog-logout" title="Mesaj" style="display:none"><p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>' + msg + '</p></div>');
	$("#dialog-logout").dialog(
		{
			bgiframe: true,
			resizable: false,
			modal: true,
			buttons: 
			{
				Ok: function()
				{
					$(this).dialog('close');
					if( ok_func != null ) ok_func();
				}
			}
		}
	);
}

function InputBox( msg, ok_func, cancel_func )
{
	$("#dialog-wrapper").html('<div id="dialog-logout" title="Intrebare" style="display:none"><p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>' + msg + '</p></div>');
		$("#dialog-logout").dialog({
			bgiframe: true,
			resizable: false,
			height:140,
			modal: true,
			overlay: {
				backgroundColor: '#000',
				opacity: 0.5
			},
			buttons: {
				'Yes': function() 
				{
					$(this).dialog('close');
					if( ok_func != null) ok_func();
				},
				Cancel: function() 
				{
					$(this).dialog('close');
					if( cancel_func != null) cancel_func();
				}
			}
		});
}

jQuery.fn.outerHTML = function(s) 
{
	return (s)
		? this.before(s).remove()
		: jQuery("<p>").append(this.eq(0).clone()).html();
}


function MyAdminGrid( instanceName, table_id, loading_div, template_row ) 
{
	this.pagination              = true;
	this.template_row            = template_row;
	this.instanceName            = instanceName;
	this.nr_randuri_pe_pagina    = 10;
	this.nr_pagini               = 0;
	this.nr_pagina_curenta       = 1;
	this.table_div_wrapper       = table_id + "_div_wrapper";
	this.navigare_div_id         = "navigare-" + table_id;
	this.table_id                = table_id;
	//constructor:
	//TODO: construieste div-wrapper pt table
	$("#"+table_id).wrap("<div id='" + this.table_div_wrapper + "' style='overflow-x: hidden; overflow-y: auto;'></div>");
	//TODO: construieste zona de paginare
	$("#" + table_id).before('<table border="0" cellspacing="0" cellpadding="0" class="pagination-generated-table">'+
							 '<tr>'+
							  '<td class="navigare"><a onClick="' + this.instanceName + '.ChangePage(1);"> |&lt; </a></td>'+
							  '<td class="navigare"><a onClick="' + this.instanceName + '.NavigateLeft();">&lt;&lt;</a></td>'+
							  '<td><div id="navigare-' + table_id + '" class="navigare" style="padding:5px;"></div></td>'+
							  '<td class="navigare"><a onClick="' + this.instanceName + '.NavigateRight();"> &gt;&gt; </a></td>'+
							  '<td class="navigare"><a onClick="' + this.instanceName + '.ChangePage(' + this.instanceName + '.nr_pagini);"> &gt;| </a>'+
							  '</td></tr>'+
							  '</table>');
	
	
	//functions
	this.RefreshPage = function()
	{
		this.ChangePage( this.nr_pagina_curenta );
	}
	
	this.ChangePage  = function( page_nr )
	{
		this.nr_pagina_curenta = page_nr;
		this.ShowRecords();
		this.RemakePagination();
	}
	
	this.NavigateLeft = function()
	{
		//cu 10 pagini mai la stanga
		if( this.nr_pagina_curenta > 10 )
			this.ChangePage( this.nr_pagina_curenta - 10 );
		else
			this.ChangePage( 1 );
	}
	
	this.NavigateRight = function()
	{
		//cu 10 pagini mai la stanga
		if( this.nr_pagina_curenta + 10 <= this.nr_pagini )
			this.ChangePage( this.nr_pagina_curenta + 10 );
		else
			this.ChangePage( this.nr_pagini );
	}
	
	this.RemakePagination = function()
	{
		if( this.pagination )
		{
			html  = this.nr_pagini + " Pagini ";
			start = 0;
			//
			if( this.nr_pagina_curenta > start ) start = this.nr_pagina_curenta;
			if( this.nr_pagina_curenta > 0     ) start = this.nr_pagina_curenta - 2;
			if( start == -1 ) start = 0;
			end        = start + 15;
			if( end > this.nr_pagini ) end = this.nr_pagini;
			//
			for( i = start; i < end; i++ )
			{
				nr    = i + 1;
				if( nr  == this.nr_pagina_curenta )
					html += '<span class="span-pagination">'+ nr + '</span>';
				else
					html += '<a onclick="' + this.instanceName + '.ChangePage(' + nr + ');" class="pagination">' + nr + '</a>';
			}
			$("#" + this.navigare_div_id ).html( html );
		}
		else
		{
			$(".pagination-generated-table" ).hide();
		}
	}
	
	this.ClearRows = function()
	{
		$("#tabel-intrari").find("TR[id!='header']").remove();
	}
	
	//functia de AddRow - de overrideuit
	this.AddRow      = null;
	
	this.HideLoading = function()
	{
		$("#loading_div").fadeOut("slow");
	}
	
	this.ShowLoading = function()
	{
		offset  = $("#grid_wrapper").offset();
		_left   = offset.left;
		_top    = offset.top;
		width   = $("#grid_wrapper").width();
		height  = $("#grid_wrapper").height();
		//
		d_width  = $("#loading_div").width();
		d_height = $("#loading_div").height();
		//
		new_top  = _top  + 20;
		new_left = _left + ( width  / 2 ) - ( d_width  / 2 );
		//
		$("#loading_div").css("top" , new_top  + "px" );
		$("#loading_div").css("left", new_left + "px" );
		$("#loading_div").fadeIn("slow");
	}
	//functia de overeiduit
	this.ShowRecords = null;
	
	this.RemakePagination();
}