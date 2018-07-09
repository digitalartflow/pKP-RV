<script src="js/colorpicker/js/colorpicker.js" type="text/javascript"></script>



<img id="loading" style="position:absolute" src="images/loading.gif" />



<div id="pageHolder" style="display:none; overflow:auto;">



	<div id="innerData" style="margin:100px 0px 0px 10px">



		<div id="swfHolderH" style="position:fixed; background:url({{$smarty.const.WEBSITE_URL}}images/rendering_loader.gif) no-repeat center">



			<div id="swfHolder"></div>



		</div>



	</div>



</div>



</div>



{{$header}}



<div id="shoppingCartHolder" style="position:fixed; right:500px; font-size:18px; top:0px; border:0px; color:#fff; padding:3px; cursor:pointer;" align="center" onclick="showShoppingCart()">Cart (<span id="scCounter" style="color:#A06F0F">0</span>) Items <img src="images/shoopingCart.png" height="30" align="center"/></div>



<div id="bottomToolbar" style="position:fixed; left:0px; top:36px; width:200px; background:#222222; padding:5px; border-right:1px solid #333333" align="left">



	<div style="overflow:hidden">



		<a onclick="$('#btName').toggle()" class="btnRed">Show/Hide Filters</a>

		{{if $showChooseStyle}}

		<a href="javascript:void(0)" onClick="initChooseStyle()" class="btnRed">Change Style</a>

        {{else}}

		<a href="{{$smarty.const.WEBSITE_URL}}products-list.html" target="_blank" class="btnRed">Product Listing</a>

        {{/if}}

        



	</div>



	<div id="btName" style="padding:5px; color:#FFFFFF; font-size:12px; margin:0px; overflow:hidden; display:none">



		<div style="float:left; margin:0px 4px 0px 0px">



        



    



			Units <img src="images/refresh.png" style="cursor:pointer" onclick="showUnits()" />



			<div>



				Categories:



				<select onchange="changeUnitsCat()" style="border:0px;" id="unitCategs">



					{{foreach from=$cats item=n}}



					<option value="{{$n.Id}}">{{$n.Name}}</option>



					{{/foreach}}



				</select>



			</div>



			<div>



				Subcategories



				<select onchange="showUnits()" id="unitSCategs" style="border:0px;">



					<option value="0">Select category first!</option>



				</select>



			</div>



			<div>



				<select onchange="showUnits()" id="showUA" style="border:0px;">



					<option value="0">Show units and appliances</option>



					<option value="1">Show units only</option>



					<option value="2">Show appliances only</option>



				</select>



			</div>



			<div>



				Order by 



				<select onchange="showUnits()" id="orderUnits" style="border:0px;">



					<option value="name-asc">name ascending</option>



					<option value="name-desc">name descending</option>



					<option value="price-asc">price ascending</option>



					<option value="price-desc">price descending</option>



				</select>



			</div>



			<div>



				Search:



				<input type="text" id="unitSearch" style="padding:0px; margin:0px" value="E.g: white chair" /><input type="button" value="Search" onclick="showUnits(true)" />



			</div>



		</div>



	</div>



	<div id="contentBottom" style="overflow:hidden">



		{{*



		<button onclick="$('#styles_holder').toggle()" style="width:160px; height:160px; font-size:24px; font-weight:bold; border:0px; background:#333333; border-radius:20px; margin:5px; cursor:pointer; color:#FFF">Change style</button>



	</div>



	*}}



	<div id="contentBottomUnitsHolder" style="overflow:auto">



		loading units here



	</div>



</div>



{{*



<div id="bottomToolbarInit" style="position:fixed; left:0px; top:36px; width:200px; background:#000000; padding:5px; border-right:1px solid #333333" align="center">



	<h2 style="color:#FFF; padding:0px; margin:0px 0px 5px 0px">Please select a style from the following:</h2>



	<div style="float:left; overflow:hidden; width:180px">



		<button onclick="showFirstPredefinedStyle(0)" style="width:160px; height:160px; font-size:24px; font-weight:bold; border:0px; background:#333333; border-radius:20px; margin:5px; cursor:pointer; color:#FFF">Custom Style</button>



	</div>



	<div>



		<div style="color:#FFF">



			Made material: 



			<select id="ps_filter_made_materials" onchange="filterPS()">



				<option value="0"> all </option>



				{{foreach from=$ps_made_materials item=n}}



				<option value="{{$n.Id}}">{{$n.name}}</option>



				{{/foreach}}



			</select>



			Style: 



			<select id="ps_filter_style" onchange="filterPS()">



				<option value="0"> all </option>



				{{foreach from=$ps_styles item=n}}



				<option value="{{$n.Id}}">{{$n.name}}</option>



				{{/foreach}}



			</select>



			Order: 



			<select id="ps_filter_order" onchange="changeOrderPS()">



				<option value="1">prices low to high</option>



				<option value="2">prices high to low</option>



			</select>



		</div>



		<div id="ps_predefined_styles">



			{{foreach from=$predefined_styles item=n}}



			<a href="javascript:void(0)" class="predef_style{{foreach from=$n.made_materials item=s}} mm_{{$s}}{{/foreach}}{{foreach from=$n.styles item=s}} s_{{$s}}{{/foreach}}" onclick="showFirstPredefinedStyle({{$n.Id}})">



			<span style="background-image:url(uploads/predefined_styles/small/{{$n.pic}})"></span>



			<strong>{{$n.name}}</strong>



			</a>



			{{/foreach}}



		</div>



	</div>



	*}}



	<div id="styles_holder">



		<div>



			<div id="predefined_style_0" style="display:none; position:relative">



				<h3>Create Your Custom Style<a href="javascript: void(0)" onclick="$('#predefined_style_0').hide(); $('#styles_menu').show()" class="ps_btn_back">Back</a></h3>



				<div style="overflow:auto;" class="inner">



					<h4>Carcasse ({{$carcasses|@count}} available)</h4>



					<div class="slider_holder">



						<div class="slides_holder">



							{{foreach from=$carcasses item=i}}



							<a href="javascript: void(0)">



								<div class="img_holder" style="background:url(uploads/carcasses/{{$i.Picture}}) center no-repeat"></div>



								<strong>{{$i.Name}}</strong><b></b><input type="hidden" value="{{$i.Id}}" />



							</a>



							{{/foreach}}



						</div>



						<a class="arrow left">&laquo;</a>



						<a class="arrow right">&raquo;</a>



					</div>



					<h4>Doors ({{$doors|@count}} available)</h4>



					<div class="slider_holder">



						<div class="slides_holder">



							{{foreach from=$doors item=i}}



							<a href="javascript: void(0)">



								<div class="img_holder" style="background:url(uploads/unit_doors/{{$i.Picture}}) center no-repeat"></div>



								<strong>{{$i.Name}}</strong><b></b><input type="hidden" value="{{$i.Id}}" />



							</a>



							{{/foreach}}



						</div>



						<a class="arrow left">&laquo;</a>



						<a class="arrow right">&raquo;</a>



					</div>



					<h4>Handles ({{$handles|@count}} available)</h4>



					<div class="slider_holder">



						<div class="slides_holder">



							{{foreach from=$handles item=i}}



							<a href="javascript: void(0)">



								<div class="img_holder" style="background:url(uploads/latches/{{$i.Picture}}) center no-repeat"></div>



								<strong>{{$i.Name}}</strong><b></b><input type="hidden" value="{{$i.Id}}" />



							</a>



							{{/foreach}}



						</div>



						<a class="arrow left">&laquo;</a>



						<a class="arrow right">&raquo;</a>



					</div>



					<h4>Worktop ({{$tops|@count}} available)</h4>



					<div class="slider_holder">



						<div class="slides_holder">



							{{foreach from=$tops item=i}}



							<a href="javascript: void(0)">



								<div class="img_holder" style="background:url(uploads/top_textures/{{$i.Picture}}) center no-repeat"></div>



								<strong>{{$i.Name}}</strong><b></b><input type="hidden" value="{{$i.Id}}" />



							</a>



							{{/foreach}}



						</div>



						<a class="arrow left">&laquo;</a>



						<a class="arrow right">&raquo;</a>



					</div>



					<h4>Texture ({{$textures|@count}} available)</h4>



					<div class="slider_holder">



						<div class="slides_holder">



							{{foreach from=$textures item=i}}



							<a href="javascript: void(0)">



								<div class="img_holder" style="background:url(uploads/textures/{{$i.Picture}}) center no-repeat"></div>



								<strong>{{$i.Name}}</strong><b></b><input type="hidden" value="{{$i.Id}}" />



							</a>



							{{/foreach}}



						</div>



						<a class="arrow left">&laquo;</a>



						<a class="arrow right">&raquo;</a>



					</div>



				</div>



				<div class="ps_btn_holder">



					{{*<a href="javascript: void(0)" class="preview" onclick="previewStyle('predefined_style_0')">Preview</a>



					<a href="javascript: void(0)" class="cancel_preview" style="display:none" onclick="cancelPreview('predefined_style_0')">Cancel Preview</a>*}}



					<a href="javascript: void(0)" class="apply">Apply</a>



					<a href="javascript: void(0)" class="select_style" style="display:none" onclick="applyStyle(0)">Select style</a>



				</div>



			</div>



			<div id="predefined_styles_holder" style="display:none">



				<h3>Choose a predefined style</h3>



				{{foreach from=$predefined_styles item=n}}



				<a href="javascript:void(0)" onclick="showPredefinedStyle({{$n.Id}})">



				<span style="background-image:url(uploads/predefined_styles/small/{{$n.pic}})"></span>



				<strong>{{$n.name}}</strong>



				</a>



				{{/foreach}}



			</div>



			{{foreach from=$predefined_styles item=n}}



			<div id="predefined_style_{{$n.Id}}" style="display:none; position:relative">



				<h3>{{$n.name}}<a href="javascript: void(0)" onclick="$('#predefined_style_{{$n.Id}}').hide(); $('#predefined_styles_holder').show()" class="ps_btn_back">Back</a></h3>



				<div style="overflow:auto;" class="inner">



					<div class="imgHolder"><img src="uploads/predefined_styles/small/{{$n.pic}}" /></div>



					<h4>Carcasse ({{$n.carcasses|@count}} available)</h4>



					<div class="slider_holder">



						<div class="slides_holder">



							{{foreach from=$n.carcasses item=i}}



							<a href="javascript: void(0)">



								<div class="img_holder" style="background:url(uploads/carcasses/{{$i.Picture}}) center no-repeat"></div>



								<strong>{{$i.Name}}</strong><b></b><input type="hidden" value="{{$i.Id}}" />



							</a>



							{{/foreach}}



						</div>



						<a class="arrow left">&laquo;</a>



						<a class="arrow right">&raquo;</a>



					</div>



					<h4>Doors ({{$n.doors|@count}} available)</h4>



					<div class="slider_holder">



						<div class="slides_holder">



							{{foreach from=$n.doors item=i}}



							<a href="javascript: void(0)">



								<div class="img_holder" style="background:url(uploads/unit_doors/{{$i.Picture}}) center no-repeat"></div>



								<strong>{{$i.Name}}</strong><b></b><input type="hidden" value="{{$i.Id}}" />



							</a>



							{{/foreach}}



						</div>



						<a class="arrow left">&laquo;</a>



						<a class="arrow right">&raquo;</a>



					</div>



					<h4>Handles ({{$n.handles|@count}} available)</h4>



					<div class="slider_holder">



						<div class="slides_holder">



							{{foreach from=$n.handles item=i}}



							<a href="javascript: void(0)">



								<div class="img_holder" style="background:url(uploads/latches/{{$i.Picture}}) center no-repeat"></div>



								<strong>{{$i.Name}}</strong><b></b><input type="hidden" value="{{$i.Id}}" />



							</a>



							{{/foreach}}



						</div>



						<a class="arrow left">&laquo;</a>



						<a class="arrow right">&raquo;</a>



					</div>



					<h4>Worktop ({{$n.top_textures|@count}} available)</h4>



					<div class="slider_holder">



						<div class="slides_holder">



							{{foreach from=$n.top_textures item=i}}



							<a href="javascript: void(0)">



								<div class="img_holder" style="background:url(uploads/top_textures/{{$i.Picture}}) center no-repeat"></div>



								<strong>{{$i.Name}}</strong><b></b><input type="hidden" value="{{$i.Id}}" />



							</a>



							{{/foreach}}



						</div>



						<a class="arrow left">&laquo;</a>



						<a class="arrow right">&raquo;</a>



					</div>



					<h4>Texture ({{$n.textures|@count}} available)</h4>



					<div class="slider_holder">



						<div class="slides_holder">



							{{foreach from=$n.textures item=i}}



							<a href="javascript: void(0)">



								<div class="img_holder" style="background:url(uploads/textures/{{$i.Picture}}) center no-repeat"></div>



								<strong>{{$i.Name}}</strong><b></b><input type="hidden" value="{{$i.Id}}" />



							</a>



							{{/foreach}}



						</div>



						<a class="arrow left">&laquo;</a>



						<a class="arrow right">&raquo;</a>



					</div>



				</div>



				<div class="ps_btn_holder">



					{{* <a href="javascript: void(0)" class="preview" onclick="previewStyle('predefined_style_{{$n.Id}}')">Preview</a>



					<a href="javascript: void(0)" class="cancel_preview" style="display:none" onclick="cancelPreview('predefined_style_{{$n.Id}}')">Cancel Preview</a>*}}



					<a href="javascript: void(0)" class="apply">Apply</a>



					<a href="javascript: void(0)" class="select_style" style="display:none" onclick="applyStyle({{$n.Id}})">Select style</a>



				</div>



			</div>



			{{/foreach}}



		</div>



	</div>



	<style>



		a.btnCustomStyles{



		background:url(images/room_planner/custom_furniture_off.png);



		width:80px;



		height:99px;



		overflow:hidden;



		display:block;



		text-indent:-9999px



		}



		a:hover.btnCustomStyles{



		background:url(images/room_planner/custom_furniture_on.png);



		}



		a.btnPredefinedStyles{



		background:url(images/room_planner/predefined_furniture_off.png);



		width:80px;



		height:99px;



		overflow:hidden;



		display:block;



		text-indent:-9999px



		}



		a:hover.btnPredefinedStyles{



		background:url(images/room_planner/predefined_furniture_on.png);



		}



		.half_float{



		float:left;



		overflow:hidden;



		width:300px



		}



	</style>



	<div id="chooseStyle" title="Choose an Option">



		<table width="100%" cellpadding="2" cellspacing="2">



			<tr>



				<td width="50%" align="center" valign="bottom">



					<a href="javascript:void(0)" class="btnCustomStyles" onclick="dialogBackFunction = 'initChooseStyle()'; showStyleCustomiser('custom')">Custom Style</a>



					<strong>Custom Style</strong>



				</td>



				<td width="50%" align="center" valign="bottom">



					<a href="javascript:void(0)" class="btnPredefinedStyles" onclick="dialogBackFunction = 'initChooseStyle()'; showPredefinedStylesList()">Predefined Style</a>



					<strong>Predefined Style</strong>



				</td>



			</tr>



			<tr style="font-size:11px; color:#999">



				<td valign="top" align="left">Create your custom style, just the way you like it</td>



				<td valign="top" align="left">Choose from predefined styles the one that you like</td>



			</tr>



		</table>



	</div>



	<div id="styleCustomizer_custom" title="Create Your Custom Style">



		<div class="styleChooserHolder">



			<div style="overflow:auto;" class="inner">



				<div class="half_float">



					<h4>Carcasse ({{$carcasses|@count}} available)</h4>



					<div class="slider_holder carcasse" title="Please choose a carcasse!">



						<div class="slides_holder">



							{{foreach from=$carcasses item=i}}



							<a href="javascript: void(0)">



								<div class="img_holder" style="background:url(uploads/carcasses/{{$i.Picture}}) center no-repeat"></div>



								<strong>{{$i.Name}}</strong><b></b><input type="hidden" value="{{$i.Id}}" />



							</a>



							{{/foreach}}



						</div>



						<a class="arrow left">&laquo;</a>



						<a class="arrow right">&raquo;</a>



					</div>



				</div>



				<div class="half_float">



					<h4>Doors ({{$doors|@count}} available)</h4>



					<div class="slider_holder doors" title="Please choose a door!">



						<div class="slides_holder">



							{{foreach from=$doors item=i}}



							<a href="javascript: void(0)">



								<div class="img_holder" style="background:url(uploads/unit_doors/{{$i.Picture}}) center no-repeat"></div>



								<strong>{{$i.Name}}</strong><b></b><input type="hidden" value="{{$i.Id}}" />



							</a>



							{{/foreach}}



						</div>



						<a class="arrow left">&laquo;</a>



						<a class="arrow right">&raquo;</a>



					</div>



				</div>



				<div class="half_float">



					<h4>Handles ({{$handles|@count}} available)</h4>



					<div class="slider_holder handles" title="Please choose a handle!">



						<div class="slides_holder">



							{{foreach from=$handles item=i}}



							<a href="javascript: void(0)">



								<div class="img_holder" style="background:url(uploads/latches/{{$i.Picture}}) center no-repeat"></div>



								<strong>{{$i.Name}}</strong><b></b><input type="hidden" value="{{$i.Id}}" />



							</a>



							{{/foreach}}



						</div>



						<a class="arrow left">&laquo;</a>



						<a class="arrow right">&raquo;</a>



					</div>



				</div>



				<div class="half_float">



					<h4>Worktop ({{$tops|@count}} available)</h4>



					<div class="slider_holder top_textures" title="Please choose a worktop!">



						<div class="slides_holder">



							{{foreach from=$tops item=i}}



							<a href="javascript: void(0)">



								<div class="img_holder" style="background:url(uploads/top_textures/{{$i.Picture}}) center no-repeat"></div>



								<strong>{{$i.Name}}</strong><b></b><input type="hidden" value="{{$i.Id}}" />



							</a>



							{{/foreach}}



						</div>



						<a class="arrow left">&laquo;</a>



						<a class="arrow right">&raquo;</a>



					</div>



				</div>



				<div class="half_float">



					<h4>Texture ({{$textures|@count}} available)</h4>



					<div class="slider_holder textures" title="Please choose a texture!">



						<div class="slides_holder">



							{{foreach from=$textures item=i}}



							<a href="javascript: void(0)">



								<div class="img_holder" style="background:url(uploads/textures/{{$i.Picture}}) center no-repeat"></div>



								<strong>{{$i.Name}}</strong><b></b><input type="hidden" value="{{$i.Id}}" />



							</a>



							{{/foreach}}



						</div>



						<a class="arrow left">&laquo;</a>



						<a class="arrow right">&raquo;</a>



					</div>



				</div>



			</div>



		</div>



	</div>



	<div id="styleCustomizer_predefined" title="">



		<div class="styleChooserHolder">



			{{foreach from=$predefined_styles item=n}}



			<div id="styleCustomizer_predefined_{{$n.Id}}" style="overflow:auto; display:none" class="inner">



				<div class="half_float">



					<h4>Carcasse ({{$n.carcasses|@count}} available)</h4>



					<div class="slider_holder carcasse" title="Please choose a carcasse!">



						<div class="slides_holder">



							{{foreach from=$n.carcasses item=i}}



							<a href="javascript: void(0)">



								<div class="img_holder" style="background:url(uploads/carcasses/{{$i.Picture}}) center no-repeat"></div>



								<strong>{{$i.Name}}</strong><b></b><input type="hidden" value="{{$i.Id}}" />



							</a>



							{{/foreach}}



						</div>



						<a class="arrow left">&laquo;</a>



						<a class="arrow right">&raquo;</a>



					</div>



				</div>



				<div class="half_float">



					<h4>Doors ({{$n.doors|@count}} available)</h4>



					<div class="slider_holder doors" title="Please choose a door!">



						<div class="slides_holder">



							{{foreach from=$n.doors item=i}}



							<a href="javascript: void(0)">



								<div class="img_holder" style="background:url(uploads/unit_doors/{{$i.Picture}}) center no-repeat"></div>



								<strong>{{$i.Name}}</strong><b></b><input type="hidden" value="{{$i.Id}}" />



							</a>



							{{/foreach}}



						</div>



						<a class="arrow left">&laquo;</a>



						<a class="arrow right">&raquo;</a>



					</div>



				</div>



				<div class="half_float">



					<h4>Handles ({{$n.handles|@count}} available)</h4>



					<div class="slider_holder handles" title="Please choose a handle!">



						<div class="slides_holder">



							{{foreach from=$n.handles item=i}}



							<a href="javascript: void(0)">



								<div class="img_holder" style="background:url(uploads/latches/{{$i.Picture}}) center no-repeat"></div>



								<strong>{{$i.Name}}</strong><b></b><input type="hidden" value="{{$i.Id}}" />



							</a>



							{{/foreach}}



						</div>



						<a class="arrow left">&laquo;</a>



						<a class="arrow right">&raquo;</a>



					</div>



				</div>



				<div class="half_float">



					<h4>Worktop ({{$n.top_textures|@count}} available)</h4>



					<div class="slider_holder top_textures" title="Please choose a worktop!">



						<div class="slides_holder">



							{{foreach from=$n.top_textures item=i}}



							<a href="javascript: void(0)">



								<div class="img_holder" style="background:url(uploads/top_textures/{{$i.Picture}}) center no-repeat"></div>



								<strong>{{$i.Name}}</strong><b></b><input type="hidden" value="{{$i.Id}}" />



							</a>



							{{/foreach}}



						</div>



						<a class="arrow left">&laquo;</a>



						<a class="arrow right">&raquo;</a>



					</div>



				</div>



				<div class="half_float">



					<h4>Texture ({{$n.textures|@count}} available)</h4>



					<div class="slider_holder textures" title="Please choose a texture!">



						<div class="slides_holder">



							{{foreach from=$n.textures item=i}}



							<a href="javascript: void(0)">



								<div class="img_holder" style="background:url(uploads/textures/{{$i.Picture}}) center no-repeat"></div>



								<strong>{{$i.Name}}</strong><b></b><input type="hidden" value="{{$i.Id}}" />



							</a>



							{{/foreach}}



						</div>



						<a class="arrow left">&laquo;</a>



						<a class="arrow right">&raquo;</a>



					</div>



				</div>



			</div>



			{{/foreach}}



		</div>



	</div>



	<div id="predefinedStylesList" title="Predefined Styles">



		<div style="color:#FFF">



			Made material: 



			<select id="ps_filter_made_materials" onchange="filterPS()">



				<option value="0"> all </option>



				{{foreach from=$ps_made_materials item=n}}



				<option value="{{$n.Id}}">{{$n.name}}</option>



				{{/foreach}}



			</select>



			Style: 



			<select id="ps_filter_style" onchange="filterPS()">



				<option value="0"> all </option>



				{{foreach from=$ps_styles item=n}}



				<option value="{{$n.Id}}">{{$n.name}}</option>



				{{/foreach}}



			</select>



			Order: 



			<select id="ps_filter_order" onchange="changeOrderPS()">



				<option value="1">prices low to high</option>



				<option value="2">prices high to low</option>



			</select>



		</div>



		<div id="ps_predefined_styles">



			{{foreach from=$predefined_styles item=n}}



			<a href="javascript:void(0)" class="predef_style{{foreach from=$n.made_materials item=s}} mm_{{$s}}{{/foreach}}{{foreach from=$n.styles item=s}} s_{{$s}}{{/foreach}}" onclick="dialogBackFunction = 'showPredefinedStylesList()'; $('#predefinedStylesList').dialog('close'); showStyleCustomiser({{$n.Id}})">



			<span style="background-image:url(uploads/predefined_styles/small/{{$n.pic}})"></span>



			<strong>{{$n.name}}</strong>



			</a>



			{{/foreach}}



		</div>



	</div>



	<script>



		var dialogBackFunction  = false;



		



		var firstStyleChoosed = false;



		



		$('#chooseStyle').dialog({



		



			autoOpen: false,



		



			height: 250,



		



			minHeight:250,



		



			minWidth:400,



		



			width: 400,



		



			modal: true,



		



			draggable: false,



		



			resizable: false



		



		});



		



		$('#predefinedStylesList').dialog({



		



			autoOpen: false,



		



			height: 600,



		



			minHeight:600,



		



			minWidth:800,



		



			width: 800,



		



			modal: true,



		



			draggable: false,



		



			resizable: false



		



		});



		



		function initChooseStyle(){



		



			$('#chooseStyle').dialog('open');



		



		}



		



		function initRoomPlanner(){



		



			{{if $previewMode}}



			$.post('get_data/room_style.txt',{},function(data){



				initFlashSoftware({'previewMode':true});



				showUnits(false);



				$("#saveRoomDesignDiv").html('<div align="center"><img src="images/loading.gif" /></div>');



				$("#saveRoomDesignDiv").dialog({



					title: 'Rendering, please wait a few moments...'	



				});	



				$("#saveRoomDesignDiv").dialog('open');



				firstStyleChoosed = true;



			},'json');



			{{else}}



			$.post('get_data/room_style.txt',{},function(data){



				data = JSON.parse(data);



				if( data ){			



					carcase = data.carcase;



					unitDoorType = data.unitDoorType;



					texture = data.texture;



					toptexture = data.toptexture;



					handle = data.handle;



					initFlashSoftware();



					showUnits(false);



					firstStyleChoosed = true;



				}else{



					{{if $showChooseStyle}}



					initChooseStyle();



					{{else}}



					initFlashSoftware();



					showUnits(false);



					firstStyleChoosed = true;



					{{/if}}



				}



			},'json');



			{{/if}}



		



		}



		



		initRoomPlanner();



		



		



		



		$('#styleCustomizer_custom').dialog({



		



			autoOpen: false,



		



			width: 660,



		



			modal: true,



		



			draggable: false,



		



			resizable: false,



		



			buttons:{



		



				'Back':function() { $( this ).dialog( "close" ); }



		



			}



		



		});



		



		



		



		$('#styleCustomizer_predefined').dialog({



		



			autoOpen: false,



		



			width: 640,



		



			modal: true,



		



			draggable: false,



		



			resizable: false,



		



			buttons:{



		



				'Back':function() { $( this ).dialog( "close" ); }



		



			}



		



		});



		



		function showPredefinedStylesList(){



		



			$('#chooseStyle').dialog('close');



		



			$('#predefinedStylesList').dialog('open');



		



			buttons = {};



		



			buttons['Back'] = function(){



		



				$(this).dialog('close');



		



				eval(dialogBackFunction);



		



			};



		



			$( '#predefinedStylesList' ).dialog( "option", "buttons",buttons);



		



		}



		



		function showStyleCustomiser(h){



			$('#chooseStyle').dialog('close');



		



			hid = h;



		



			if( !isNaN( h ) ){



		



				h = 'predefined';



		



				$('#styleCustomizer_'+h+'>.styleChooserHolder>div').hide();



		



				$('#styleCustomizer_'+h+'_'+hid).show();



		



			}



		



			$('#styleCustomizer_'+h).dialog('open');



		



			$( '#styleCustomizer_'+h ).dialog( "option", "height",$(window).height()-200);



		



			buttons = {};



		



			if( firstStyleChoosed && false ) buttons['Preview'] = function(){



		



				$(this).dialog('close');



		



				if( !isNaN( h ) ){



		



					previewStyle('styleCustomizer_'+h+'_'+hid);



		



				}else{



		



					previewStyle('styleCustomizer_'+h);



		



				}



		



			};



		



			if( firstStyleChoosed ) buttons['Apply'] = function(){



		



				$(this).dialog('close');



		



				if( !isNaN( hid ) ){



		



					applyStyle('styleCustomizer_'+h+'_'+hid);



		



				}else{



		



					applyStyle('styleCustomizer_'+h);



		



				}



		



			};



		



			if( !firstStyleChoosed ) buttons['Select style'] = function(){selectStyle(hid)};



		



			buttons['Back'] = function(){



		



				$(this).dialog('close');



		



				eval(dialogBackFunction);



		



			};



		



			$( '#styleCustomizer_'+h ).dialog( "option", "buttons",buttons);



		



		}



		



		



		



		function selectStyle(h){



			//alert(h);



			//return false;



			hid = h;



		



			tclose = h;



		



			if( !isNaN( h ) ){



		



				h = 'predefined_'+h;



		



				tclose = 'predefined';



		



			}



		



			tocheck = $('#styleCustomizer_'+h+' .slider_holder');



		



			errors = "";



		



			for( i = 0; i<tocheck.length; i++ ){



		



				has_selected = $(tocheck[i]).find('a.selected');



		



				if( has_selected.length != 1 ){



		



					errors += $(tocheck[i]).attr('title')+"\n";



		



				}



		



			}



		



			if( errors.length > 0 ){



		



				alert(errors);



		



				return false;



		



			}



		



			carcase = $('#styleCustomizer_'+h+' .carcasse').find('a.selected input').val();



		



			unitDoorType = $('#styleCustomizer_'+h+' .doors').find('a.selected input').val();



		



			texture = $('#styleCustomizer_'+h+' .textures').find('a.selected input').val();



		



			toptexture = $('#styleCustomizer_'+h+' .top_textures').find('a.selected input').val();



		



			handle = $('#styleCustomizer_'+h+' .handles').find('a.selected input').val();



			



		



			$( '#styleCustomizer_'+tclose ).dialog('close');



		



			initFlashSoftware();



		



			$('#bottomToolbarInit').hide();



		



			$('#bottomToolbar').show();



		



			firstStyleChoosed = true;



		



			showUnits(false);



		



		}



		



		



		function flashReady(){



			$('#swfHolderH>object').css('opacity',1);



		}



		function initFlashSoftware(flashvars,params,attributes){



		



			if( typeof flashvars === "undefined" ) flashvars = {};



		



			if( typeof params === "undefined" ) params = {



		



				allowScriptAccess: "allways",



		



				wmode: "transparent",



				



		



			};



		



			if( typeof attributes === "undefined" ) attributes = {



		



				wmode: "transparent",



		



				name: "swfHolder",



		



				id: "room_planner",



		



				name: "room_planner"



		



			};



			flashvars.cur_domain = window.location.host.substr(4);



			params.allowScriptAccess = "always";



		



			$.post('get_data/room_design.txt');



			ifsSwfHolder = "swfHolder";



			if( swfHolderVersion > 1 ) ifsSwfHolder = ifsSwfHolder+String(swfHolderVersion);	



			params.name = ifsSwfHolder;



			attributes.name = ifsSwfHolder;



		



			swfobject.embedSWF("flash/step3.swf?r=" + Math.random(), ifsSwfHolder, $(window).width()-201, $(window).height() - 30, "10.0.0", "expressInstall.swf", flashvars, params, attributes);



			$('#swfHolderH>object').css('opacity',0);



		



		}



		



		



		



		function get3DAngle( ang ){



		



			



			ifsSwfHolder = "swfHolder";



			if( swfHolderVersion > 1 ) ifsSwfHolder = ifsSwfHolder+String(swfHolderVersion);



			pic = flashMovie(ifsSwfHolder).save3DRenderToImage(ang);



			//pic = flashMovie('room_planner').save3DRenderToImage(ang);



		



			$('#picture3DAngleTest').html('<img src="data:image/png;base64,'+pic+'" />');



		



			$('#picture3DAngleTest').css({width:($(window).width()-250),height:($(window).height()-100)});



		



			$('#picture3DAngleTest').show();



		



		}



		



		/*function applyStyle( nid ){



		



			s = $('#predefined_style_'+nid).find('a.selected');



		



			carcase = $(s[0]).find('input').val();



		



			unitDoorType = $(s[1]).find('input').val();



		



			texture = $(s[4]).find('input').val();



		



			toptexture = $(s[3]).find('input').val();



		



			handle = $(s[2]).find('input').val();



		



			$('#bottomToolbarInit').hide();



		



			$('#bottomToolbar').show();



		



			$('#styles_holder').hide();



		



			$('#styles_holder>div').children().eq(0).show();



		



			$('#predefined_style_'+nid).hide();



		



			showUnits(false);



		



		}*/



		



		function showSM( sid ){



		



			$('#styles_holder>div').children().hide();



		



			$('#'+sid).show();



		



		}



		



		function showPredefinedStyle( nid ){



		



			$('#styles_holder>div').children().hide();



		



			$('#predefined_style_'+nid).show();



		



		}



		



		function showFirstPredefinedStyle( nid ){



		



			$('#styles_holder').show();



		



			$('#styles_holder>div').children().hide();



		



			$('#predefined_style_'+nid).show();



		



			$('#predefined_style_'+nid+' .ps_btn_holder').children().hide();



		



			$('#predefined_style_'+nid+' .ps_btn_holder .select_style').show();



		



		}



		



		$('.slider_holder').each(function(){



		



			var cur_slide = 0;



		



			var slides_holder = $(this).find('.slides_holder');



		



			var nr_slides = $(slides_holder).children().length;



		



			//$(slides_holder).children("a").eq(0).addClass('selected');



		



			$(slides_holder).children("a").each(function(index, element) {



		



		        $(this).click(function(){



		



					$(slides_holder).children("a.selected").removeClass('selected');



		



					$(this).addClass('selected');



		



				});



		



		    });



		



			for( i=2; i<nr_slides; i++){



		



				$(slides_holder).children("a").eq(i).hide();



		



			}



		



			$(this).find('.arrow.left').click(function(){



		



				if( cur_slide > 0 ){



		



					cur_slide--;



		



				}



		



				$(slides_holder).children("a").hide();



		



				$(slides_holder).children("a").eq(cur_slide).show();



		



				$(slides_holder).children("a").eq(cur_slide+1).show();



		



			});



		



			$(this).find('.arrow.right').click(function(){



		



				if( cur_slide < nr_slides-2){



		



					cur_slide++;



		



				}



		



				$(slides_holder).children("a").hide();



		



				$(slides_holder).children("a").eq(cur_slide).show();



		



				$(slides_holder).children("a").eq(cur_slide+1).show();



		



			});



		



		});



		



	</script>



	<style>



		.ps_btn_holder{



		position:absolute;



		bottom:0px;



		left:0px;



		width:290px;



		background:#000;



		height:25px;



		padding:2px



		}



		.ps_btn_holder a{



		float:left;



		display:block;



		overflow:hidden;



		border-radius:5px;



		background:#006699;



		color:#FFFFFF;



		padding:4px 8px 4px 8px;



		font-size:12px;



		text-decoration:none;



		font-weight:bold;



		border-bottom:1px solid #004d71;



		border-top:1px solid #0086c6;



		text-shadow:1px 1px 1px #004d71;



		width:120px;



		text-align:center



		}



		.ps_btn_holder a.preview{



		background:#006600;



		border-bottom:1px solid #004600;



		border-top:1px solid #009d00;



		float:right;



		color:#FFFFFF;



		text-shadow:1px 1px 1px #004600;



		}



		.ps_btn_holder a.preview:hover{



		color:#004600;



		}



		.ps_btn_holder a.cancel_preview{



		background:#990000;



		border-bottom:1px solid #804040;



		border-top:1px solid #FF0000;



		float:right;



		color:#FFFFFF;



		text-shadow:1px 1px 1px #004600;



		}



		.ps_btn_holder a.cancel_preview:hover{



		color:#004600;



		}



		.ps_btn_holder a:hover{



		border-bottom:1px solid #CCCCCC;



		border-top:1px solid #FFFFFF;



		background:#F3F3F3;



		color:#c50000;



		text-shadow:1px 1px 1px #FFFFFF



		}



		a.ps_btn_back{



		position:absolute;



		right:5px;



		top:-5px;



		display:block;



		overflow:hidden;



		border-radius:5px;



		background:#c50000;



		color:#000000;



		padding:4px 8px 4px 8px;



		font-size:12px;



		text-decoration:none;



		font-weight:bold;



		border-bottom:1px solid #910000;



		border-top:1px solid #ff0606;



		text-shadow:1px 1px 1px #ff0606



		}



		a.ps_btn_back:hover{



		border-bottom:1px solid #CCCCCC;



		border-top:1px solid #FFFFFF;



		background:#F3F3F3;



		color:#c50000;



		text-shadow:1px 1px 1px #FFFFFF



		}



		body{



			scrollbar-base-color: #202020;



		}



		::-webkit-scrollbar {



		width: 5px;



		height:5px



		}



		::-webkit-scrollbar-track {



		background:#222222;



		border-radius: 2px;



		}



		::-webkit-scrollbar-thumb {



		border-radius: 2px;



		background:#cc0001;
		



		}



		.unit{



		background:#FFFFFF; display:inline-block; overflow:hidden; margin:5px 0px 0px 0px; width:170px; color:#333333; text-align:left; padding:5px



		}



		@media screen and (-webkit-min-device-pixel-ratio:0) { 



		.unit{width:180px !important;} 



		}



		.slider_holder{



		display:block;



		overflow:hidden;



		position:relative;



		height:126px;



		padding:2px;



		width:275px



		}



		.slider_holder a.arrow{



		display:block;



		overflow:hidden;



		position:absolute;



		top:50px;



		background:#cc0001;



		border-top:1px solid #ff4040;



		border-bottom:2px solid #970000;



		border-radius:5px;



		text-align:center;



		line-height:25px;



		width:25px;



		height:25px;



		cursor:pointer;



		font-size:16px;



		box-shadow:0px 0px 5px #000000



		}



		.slider_holder a.arrow.left{



		left:0px;



		}



		.slider_holder a.arrow.right{



		right:0px;



		}



		.slides_holder{



		display:block;



		overflow:hidden;



		height:120px;



		position:absolute;



		top:0px;



		left:15px;



		width:250px;



		border:1px solid #333;



		border-radius:5px



		}



		.slides_holder a{



		float:left;



		margin:2px 1px 2px 10px;



		padding:0px;



		border:2px solid #1E1E1E;



		display:inline-block;



		overflow:hidden;



		width:96px;



		height:112px;



		color:#FFFFFF;



		text-decoration:none;



		background:#1E1E1E;



		border-radius:5px;



		text-align:center;



		position:relative



		}



		.slides_holder a b{



		display:none;



		position:absolute;



		width:24px;



		height:24px;



		background:url(http://digitalartflow.com/production/pkp/images/room_planner/ok-icon.png) center no-repeat;



		background-size:contain;



		top:4px;



		right:4px;



		}



		.slides_holder a.selected b{



		display:block



		}



		.slides_holder a .img_holder{



		width:96px;



		height:65px;



		display:block;



		border-radius:5px;	



		background-size:contain;



		}



		#predefined_styles_holder a, a.predef_style{



		display:block;



		overflow:hidden;



		height:160px;



		width:130px;



		float:left;



		margin:5px 5px 0px 5px;



		color:#FFFFFF;



		text-align:center;



		font-size:14px;



		text-decoration:none



		}



		#predefined_styles_holder a:hover, a.predef_style:hover{



		color:#FF0000



		}



		#predefined_styles_holder a span, a.predef_style span{



		width:130px;



		height:130px;



		opacity:0.75;



		transition: all 1s;



		-moz-transition: all 1s; 



		-webkit-transition: all 1s; 



		-o-transition: all 1s;



		background-size:130px 130px;



		background-position:center;



		display:block



		}



		#predefined_styles_holder a:hover span, a.predef_style:hover span{



		opacity:1;



		background-size:150px 150px;



		}



		#styles_holder{



		position:absolute;



		top:36px;



		left:0px;



		width:320px;



		background:#000;



		height:500px;



		z-index:9999;



		overflow:hidden;



		color:#FFF;



		display:none



		}



		#styles_holder>div{



		padding:10px;



		overflow:hidden;



		}



		#styles_holder>div>div{



		width:300px



		}



		#styles_holder h3{



		padding:0px;



		margin:0px;



		font-size:16px;



		color:#FFFFFF;



		overflow:hidden



		}



		#styles_menu ul{



		padding:0px;



		margin:5px 0px 0px 0px



		}



		#styles_menu ul li{



		list-style:none;



		overflow:hidden;



		margin-bottom:5px;



		}



		#styles_menu ul li a{



		display:block;



		overflow:hidden;



		border-radius:5px;



		background:#c50000;



		color:#000000;



		padding:4px 8px 4px 8px;



		font-size:16px;



		text-decoration:none;



		font-weight:bold;



		border-bottom:1px solid #910000;



		border-top:1px solid #ff0606;



		text-shadow:1px 1px 1px #ff0606



		}



		#styles_menu ul li a:hover{



		border-bottom:1px solid #CCCCCC;



		border-top:1px solid #FFFFFF;



		background:#F3F3F3;



		color:#c50000;



		text-shadow:1px 1px 1px #FFFFFF



		}



		.btnRed {



		background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #cc0001), color-stop(1, #cc0001) );



		background:-moz-linear-gradient( center top, #cc0001 5%, #cc0001 100% );



		filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#cc0001', endColorstr='#cc0001');



		-moz-border-radius:0px;



		-webkit-border-radius:0px;



		border-radius:0px;



		border:1px solid #000;



		display:inline-block;



		color:#fff;



		font-family:arial;



		font-size:15px;



		font-weight:bold;



		padding:8px;



		text-decoration:none;



		text-shadow:0px 0px 0px #ffffff;



		width:80px;



		display:inline-block;



		overflow:hidden;



		text-align:center;



		cursor:pointer;



		}



		.btnRed:hover {



		background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #f75a5a), color-stop(1, #f75a5a) );



		background:-moz-linear-gradient( center top, #f75a5a 5%, #f75a5a 100% );



		filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#f75a5a', endColorstr='#f75a5a');



		background-color:#f75a5a;

                color:#fff;

		}



	</style>



	<script>



		$(document).ready(function(){



		



			$('#styles_holder').css({height:($(window).height()-36-$('#bottomToolbar').outerHeight())+'px'});



		



			$('#styles_holder>div').css({height:($(window).height()-56-$('#bottomToolbar').outerHeight())+'px'});



		



			$('#styles_holder>div>div').css({height:($(window).height()-56-$('#bottomToolbar').outerHeight())+'px'});



		



			$('#styles_holder>div>div>div.inner').css({height:($(window).height()-116-$('#bottomToolbar').outerHeight())+'px'});



		



		});



		



	</script>



	{{*<script language="javascript" type="text/javascript" src="{{$smarty.const.WEBSITE_URL}}liveadmin/client.php?key={{$smarty.const.LIVE_ADMIN_KEY}}"></script>*}}



	<script type="text/javascript">(function () { var done = false; var script = document.createElement("script"); script.async = true; script.type = "text/javascript"; script.src = "https://www.purechat.com/VisitorWidget/WidgetScript"; document.getElementsByTagName('HEAD').item(0).appendChild(script); script.onreadystatechange = script.onload = function (e) { if (!done && (!this.readyState || this.readyState == "loaded" || this.readyState == "complete")) { var w = new PCWidget({ c: '8f8938b8-d40e-43b2-b609-46aca0f19b92', f: true }); done = true; } }; })();</script>



	<script>



		var ps_ps = $('#ps_predefined_styles').children().clone();



		



		function changeOrderPS(){



		



			$('#ps_predefined_styles').html('');



		



			if( $('#ps_filter_order').val() == 1 ){



		



				for( i in ps_ps ){



		



					$(ps_ps[i]).appendTo('#ps_predefined_styles')



		



				}



		



			}else{



		



				for( i in ps_ps ){



		



					$(ps_ps[i]).prependTo('#ps_predefined_styles')



		



				}



		



			}



		



		}



		



		function filterPS(){



		



			$('#ps_predefined_styles').children().hide();



		



			if( $('#ps_filter_made_materials').val() > 0 ){



		



				$('#ps_predefined_styles').children('.mm_'+$('#ps_filter_made_materials').val()).show();



		



			}



		



			if( $('#ps_filter_style').val() > 0 ){



		



				$('#ps_predefined_styles').children('.mm_'+$('#ps_filter_made_materials').val()).show();



		



			}



		



			if( $('#ps_filter_made_materials').val() == 0 && $('#ps_filter_style').val() == 0 ){



		



				$('#ps_predefined_styles').children().show();



		



			}



		



		}



		



	</script>



</div>



<div id="unitsToolbar" style="display:none">



	<div style="float:left; margin:0px 4px 0px 0px">



		<button class='btn_back' onclick='selectTopTexture(toptexture)'>&laquo; back</button> Units <img src="images/refresh.png" onclick="showUnits()" /> &raquo; 



		<select onchange="changeUnitsCat()" style="border:0px ; background:none" id="unitCategs">



			{{foreach from=$cats item=n}}



			<option value="{{$n.Id}}">{{$n.Name}}</option>



			{{/foreach}}



		</select>



		&raquo; 



		<select onchange="showUnits()" id="unitSCategs" style="border:0px; background:none;">



			<option value="0">Select category first!</option>



		</select>



		| 



		<select onchange="showUnits()" id="showUA" style="border:0px; background:none;">



			<option value="0">Show units and appliances</option>



			<option value="1">Show units only</option>



			<option value="2">Show appliances only</option>



		</select>



		| Order by 



		<select onchange="showUnits()" id="orderUnits" style="border:0px; background:none;">



			<option value="name-asc">name ascending</option>



			<option value="name-desc">name descending</option>



			<option value="price-asc">price ascending</option>



			<option value="price-desc">price descending</option>



		</select>



	</div>



	<div style="float:right; margin:0px 4px 0px 0px">



		<input type="text" id="unitSearch" style="padding:0px; margin:0px" value="E.g: white chair" /><input type="button" value="Search" onclick="showUnits(true)" />



	</div>



</div>



<div id="chatDiv">



	<span id='liveadmin' style="z-index:999999"></span>



</div>



<div id="unitInfoDiv" title="Item Information">



</div>



<div id="shoppingCartDiv" title="Cart (0) Items">



</div>



<div id="saveRoomDesignDiv" title="">



</div>







<div id="holderColorChanger" style="position:absolute; right: 20px; top:100px; background: rgba(255,255,255,0.7); width: 185px; box-shadow: 0px 0px 5px #000;padding: 0px">



<a href="javascript: void(0)" onclick="toggleHWCC()" style="float:left; background:#f97373;color: #FFF;text-decoration: none;padding: 10px 3px 15px 3px;"><span class="close">&raquo;</span><span class="open" style="display:none">&laquo;</span></a>



<div id="colorSelectorWCC"><div style="background-color: #E9E9E9"></div></div>



<button onclick="setHWCC()" id="btnSetWCC" style="float: right; background: #006600;  border: 0px; color: #FFF; padding: 8px 5px; border-radius: 5px; margin: 4px;">Apply wall color</button>



<br clear="all" />



<a href="javascript: void(0)" onclick="toggleHWCC()" style="float:left; background:#f97373;color: #FFF;text-decoration: none;padding: 10px 3px 15px 3px;"><span class="close">&raquo;</span><span class="open" style="display:none">&laquo;</span></a>



<div id="colorSelectorFCC"><div style="background-color: #DFDFDF"></div></div>



<button onclick="setHFCC()" id="btnSetFCC" style="float: right; background: #006600;  border: 0px; color: #FFF; padding: 8px 5px; border-radius: 5px; margin: 4px;">Apply floor color</button>



</div> 







<script>



	var hwcc = 'E9E9E9';



	var hfcc = 'DFDFDF';



	function setHWCC(){



		ifsSwfHolder = "swfHolder";



		if( swfHolderVersion > 1 ) ifsSwfHolder = ifsSwfHolder+String(swfHolderVersion);



		flashMovie(ifsSwfHolder).setWallFillColor('0x'+hwcc,'force');



	}



	function setHFCC(){



		ifsSwfHolder = "swfHolder";



		if( swfHolderVersion > 1 ) ifsSwfHolder = ifsSwfHolder+String(swfHolderVersion);



		flashMovie(ifsSwfHolder).setFloorFillColor('0x'+hfcc,'force');



	}



	function toggleHWCC(){



		r = $('#holderColorChanger').css('width').replace('px','')*1;



		$('#holderColorChanger>div,button').toggle();



		$('#holderColorChanger>a>span').toggle();



		if( r <= 13 ){



			$('#holderColorChanger').css('width',185);



		}else{



			$('#holderColorChanger').css('width',13);



		}



	}



	$('#colorSelectorWCC').ColorPicker({



		color: '#'+hwcc,



		onShow: function (colpkr) {



			$(colpkr).fadeIn(500);



			return false;



		},



		onHide: function (colpkr) {



			$(colpkr).fadeOut(500);



			return false;



		},



		onChange: function (hsb, hex, rgb) {



			hwcc = hex;



			$('#colorSelectorWCC div').css('backgroundColor', '#' + hex);



		}



	});



	$('#colorSelectorFCC').ColorPicker({



		color: '#'+hfcc,



		onShow: function (colpkr) {



			$(colpkr).fadeIn(500);



			return false;



		},



		onHide: function (colpkr) {



			$(colpkr).fadeOut(500);



			return false;



		},



		onChange: function (hsb, hex, rgb) {



			hfcc = hex;



			$('#colorSelectorFCC div').css('backgroundColor', '#' + hex);



		}



	});



	</script>   



<script>



	$("#saveRoomDesignDiv").dialog({



	



	autoOpen: false,



	



	modal: true,



	



	height: 400,



	



	width: 500



	



	});



	



	$("#unitInfoDiv").dialog({



	



	autoOpen: false,



	



	modal: true,



	



	height: 400,



	



	width: 500



	



	});



	



	$("#shoppingCartDiv").dialog({



	



	autoOpen: false,



	



	modal: true,



	



	height: 400,



	



	width: 500,



	



	close: function (event, ui) {



	



	if (navigator.appName == 'Microsoft Internet Explorer') {



	



	$('#room_planner').css({



	



	'position': 'static'



	



	});



	



	}



	



	}



	



	});



	



	function showUnitInfo(uid) {



	



	$.post('ajax/getUnitInfo.php', {



	



	u: uid



	



	}, function (data) {



	



	$('#unitInfoDiv').html(data);



	



	$('#unitInfoDiv').dialog('open');



	



	});



	



	}



	



	/*



	



	function showUnitInfo(uid,uh,ut,um){



	



	$.post( 'ajax/getUnitInfo.php', { u:uid, h:uh, t:ut, m:um }, function(data){



	



	$('#unitInfoDiv').html(data);



	



	$('#unitInfoDiv').dialog('open');



	



	});



	



	}*/



	



	$(document).ready(function () {



	



	fr = ($(window).width() - $('#shoppingCartHolder').width()) / 2;



	



	$('#shoppingCartHolder').css('left', fr);



	



	});



	



	var manufacturer = {{$saved_room_style.manufacturer|default:$smarty.session.ftype|default:0}};



	



	var carcase = {{$saved_room_style.carcase|default:$dps.carcasses.0.Id|default:$carcasses.0.Id|default:0}};



	



	var unitDoorType = {{$saved_room_style.unitDoorType|default:$dps.doors.0.Id|default:$doors.0.Id|default:0}};



	



	var texture = {{$saved_room_style.texture|default:$dps.textures.0.Id|default:$textures.0.Id|default:0}};



	



	var toptexture = {{$saved_room_style.toptexture|default:$dps.top_textures.0.Id|default:$tops.0.Id|default:0}};



	



	var handle = {{$saved_room_style.handle|default:$dps.handles.0.Id|default:$handles.0.Id|default:0}};



	



	var unitCats = [{{foreach from=$scats item=n name=uc}}[{{$n.IdParent}},{{$n.Id}},'{{$n.Name}}']{{if !$smarty.foreach.uc.last}},{{/if}}{{/foreach}}];



	



	function showShoppingCart() {



	



		if (navigator.appName == 'Microsoft Internet Explorer') {



	



			$('#room_planner').css({



	



			'position': 'absolute',



	



			'top': $(window).height()



	



			});



	



		}



	



		obj = Object();



	



		obj['m'] = manufacturer;



	



		obj['c'] = carcase;



	



		obj['d'] = unitDoorType;



	



		obj['t'] = texture;



	



		obj['to'] = toptexture;



	



		obj['h'] = handle;



	



		uids = Object();



	



		nr = 0;



	



		for (var i in units) {



	



		nr += units[i][1];



	



		eval('uids[' + units[i][0] + ']=' + units[i][1] + ';');



	



		}



	



		$('#shoppingCartDiv').dialog("option", "title", 'Shopping Cart (' + nr + ') Items');



	



		$.post('ajax/getShoppingCart.php', {



	



			sd: obj,



	



			u: uids



	



		}, function (data) {



	



			$('#shoppingCartDiv').html(data);



	



			$('#shoppingCartDiv').dialog('open');



	



		});



	



	}



	



	function changeUnitsCat(noEffect) {



	



		$('#unitSCategs').html('');



	



		output = '';



	



		for (i = 0; i < unitCats.length; i++) {



	



		if (unitCats[i][0] == $('#unitCategs').val()) output += '<option value="' + unitCats[i][1] + '">' + unitCats[i][2] + '</option>';



	



		}



	



		$('#unitSCategs').html(output);



	



		if (typeof (noEffect) === null || !noEffect) showUnits();



	



	}



	



	//changeUnitsCat(true);



	



	var btNameStart = $('#btName').html();



	



	var contentBottomStart = $('#contentBottom').html();



	



	function showManufacturers(){



	



		$('#btName').html(btNameStart);



	



		$('#contentBottom').html(contentBottomStart);



	



	}



	



	$("#chatDiv").dialog({



	



		autoOpen: false,



	



		width: 550,



	



		height: 550



	



	});



	



	function startTheChat() {



	



		return false;



	



		//$( "#chatDiv" ).dialog( "open" );



	



		//$('#liveadmin').find('img').attr('onClick');



	



		$('#purechat_btn').click();



	



		//$('#chatDiv').html('<iframe src="{{$smarty.const.WEBSITE_URL}}/chat-front/" width=500 height=500 frameborder="0" />');



	



	}



	



	function showUnits(isSearch) {



	



		obj = Object();



	



		obj['m'] = manufacturer;



	



		obj['c'] = carcase;



	



		obj['d'] = unitDoorType;



	



		obj['t'] = texture;



	



		obj['to'] = toptexture;



	



		obj['h'] = handle;



		//alert(JSON.stringify(obj));



	



		obj['sua'] = $('#showUA').val();



	



		obj['cat'] = $('#unitCategs').val();



	



		obj['scat'] = $('#unitSCategs').val();



	



		obj['ord'] = $('#orderUnits').val();



	



		if (typeof (isSearch) !== null && isSearch) obj['s'] = $('#unitSearch').val();



	



		//alert(JSON.stringify(obj));



	



		$('#contentBottomUnitsHolder').html('');



	



		$('#contentBottomUnitsHolder').css('background', 'url(images/loading.gif) center no-repeat');



	



		$.post('ajax/getUnits.php', obj, function (data) {



	



			$('#contentBottomUnitsHolder').css('background', 'none');



	



			$('#contentBottomUnitsHolder').html(data);



	



		});



	



	}



	



	



	



	//showUnits(false);



	



	



	



	function setCurrentStyle(m,c,udt,t,tt,h){



	



		manufacturer = m;



	



		carcase = c;



	



		unitDoorType = udt;



	



		texture = t;



	



		toptexture = tt;



	



		handle = h;



	



		showUnits(false);



	



	}



	



	



	



	var units = new Array();



	



	function addToShoppingCart(uid) {



	



		found = false;



	



		for (var i in units){



	



			if (units[i][0] == uid) {



	



				units[i][1]++;



	



				found = true;



	



				break;



	



			}



	



		}



	



		if (!found) units.push([uid, 1]);



	



		refreshShoppingCart();



	



	}



	



	function deleteUnit(uid) {



	



		for (var i in units) {



	



			if (units[i][0] == uid) {



	



				units[i][1]--;



	



				if (units[i][1] == 0)



	



					units.splice(i, 1);



	



				break;



	



			}



	



		}



	



		refreshShoppingCart();



	



	}



	



	function refreshShoppingCart() {



	



		nrUnits = 0;



	



		for (var i in units) {



	



			nrUnits += units[i][1];



	



		}



	



		$('#scCounter').html(nrUnits);



	



	}



	



	



	



	function updateShoppingCard( dataJSON ){



	



		data = JSON.parse(dataJSON);



	



		units = [];



	



		for( i in data ){



	



			//console.log(data[i].uvid);



	



			addToShoppingCart(data[i].uvid);



	



		}



	



		refreshShoppingCart();



	



	}



	



	//function addUnit(uid, uh,dfb,f, uswf, data )



	



	function addUnit(uid, data) {



	



		//addToShoppingCart(uid);



	



		//flashMovie('room_planner').doAddUnit( uid, uh,dfb,f, '{{$smarty.const.WEBSITE_URL}}uploads/swf_2d/'+uswf, data);



	



		



		ifsSwfHolder = "swfHolder";



		if( swfHolderVersion > 1 ) ifsSwfHolder = ifsSwfHolder+String(swfHolderVersion);



		//flashMovie('room_planner').doAddUnit(data);



		flashMovie(ifsSwfHolder).doAddUnit(data);



	



	}



	



	var swfHolderVersion = 1;



	var flashvars = {};



	



	var params = {



	



	allowScriptAccess: "sameDomain",



	



	wmode: "transparent"



	



	};



	



	var attributes = {



	



	wmode: "transparent",



	



	name: "swfHolder",



	



	id: "room_planner",



	



	name: "room_planner"



	



	};



	



	t = ($(window).height() - $('#loading').height()) / 2;



	



	l = ($(window).width() - $('#loading').width()) / 2;



	



	$('#loading').css('top', t);



	



	$('#loading').css('left', l);



	



	function saveData(theData) {



	



		$.post('ajax/data_handler.php', {



	



			action: 'save_room_design',



	



			data: theData



	



		}, function () {



	



			window.location = '{{$smarty.const.WEBSITE_URL}}room-planner.html';



	



		})



	



	}



	



	function flashMovie(movieName) {



	



		if (window.document[movieName]) {



	



			return window.document[movieName];



	



		} else {



	



			return document.getElementById(movieName);



	



		}



	



	}



	



	$(document).ready(function () {



	



		$('#loading').hide();



	



		$('#pageHolder').show();



	



		$('#pageHolder').height($(window).height());



	



		$('.fullWidth').width($(window).width() - 300);



	



		$('.helpLink').fancybox();



	



		$('#bottomToolbar').height($(window).height() - 36);



	



		$('#contentBottom').height($(window).height() - 100);



	



		$('#contentBottomUnitsHolder').height($(window).height() - 100);



	



		$('#swfHolderH').css('top', 40);



	



		$('#swfHolderH').css('left', 201);



	



		$('.helpLink').fancybox();



		changeUnitsCat()



	



		



	



	});



	



	var save_preview = false;



	



	var apply_preview = false;



	



	var current_preview = -1;



	var preview_loaded = false;



	var preview_has_loaded = false;



	



	function previewNotLoaded(){



		preview_loaded = false;



	}



	



	function previewLoaded(){



		preview_loaded = true;



		setTimeout('init3DForPreview()',1000);



	}



	function init3DForPreview(){



		if( preview_loaded && !preview_has_loaded ){



			//console.log('init3DForPreview = true');



			



			ifsSwfHolder = "swfHolder";



			if( swfHolderVersion > 1 ) ifsSwfHolder = ifsSwfHolder+String(swfHolderVersion);



			setTimeout("flashMovie('"+ifsSwfHolder+"').generate3DView()",500);



			//setTimeout("flashMovie('room_planner').generate3DView()",500);



			setTimeout("$('#saveRoomDesignDiv').dialog('close')",500);



			preview_has_loaded = true;



		}



	}



	



	function previewStyle( pid ){



	



		save_preview = true;



	



		apply_preview = false;



	



		ifsSwfHolder = "swfHolder";



		if( swfHolderVersion > 1 ) ifsSwfHolder = ifsSwfHolder+String(swfHolderVersion);



		



		flashMovie(ifsSwfHolder).saveRoomDesign();



		//flashMovie('room_planner').saveRoomDesign();



	



		current_preview = pid;



	



	}



	



	function applyStyle( pid ){



		npid = pid.split('_');



		//alert(pid);



		//alert(npid.length);



		//return false;



		if( npid.length > 2 )



			selectStyle(npid[npid.length-2]+'_'+npid[npid.length-1]);



		else



			selectStyle(npid[npid.length-1]);



		//alert(npid[npid.length-1]);



		//return false;



	



		save_preview = false;



	



		apply_preview = true;



	



		ifsSwfHolder = "swfHolder";



		if( swfHolderVersion > 1 ) ifsSwfHolder = ifsSwfHolder+String(swfHolderVersion);



		



		flashMovie(ifsSwfHolder).saveRoomDesign();



		//flashMovie('room_planner').saveRoomDesign();



	



		current_preview = pid;



	



	}



	



	function loadPreview(){



		//console.log('loadPreview');



	



		//s = $('#'+current_preview).find('a.selected');



	



		$.post('ajax/data_handler.php', {



	



			action: 'get_preview',



	



			d: {



	



				carcase : $('#'+current_preview+' .carcasse').find('a.selected input').val(),



	



				unitDoorType : $('#'+current_preview+' .doors').find('a.selected input').val(),



	



				texture : $('#'+current_preview+' .textures').find('a.selected input').val(),



	



				toptexture : $('#'+current_preview+' .top_textures').find('a.selected input').val(),



	



				handle : $('#'+current_preview+' .handles').find('a.selected input').val(),



	



				apply: apply_preview



	



			}



	



		}, function (data) {



			//console.log('set preview_loaded false');



			preview_loaded = false;



			preview_has_loaded = false;



			



			//swfHolderVersion++;



			ifsSwfHolder = "swfHolder";



			if( swfHolderVersion > 1 ) ifsSwfHolder = ifsSwfHolder+String(swfHolderVersion);



	



			$('#swfHolderH').html('<div id="'+ifsSwfHolder+'"></div>');



			window.location='{{$smarty.const.WEBSITE_URL}}room-planner.html?l3d';



			return false;



	



			//$('#'+current_preview).find('a.preview').hide();



	



			//$('#'+current_preview).find('a.cancel_preview').show();



	



			//alert(apply_preview);



	



			if( apply_preview ){



	



				carcase = $('#'+current_preview+' .carcasse').find('a.selected input').val();



	



				unitDoorType = $('#'+current_preview+' .doors').find('a.selected input').val();



	



				texture = $('#'+current_preview+' .textures').find('a.selected input').val();



	



				toptexture = $('#'+current_preview+' .top_textures').find('a.selected input').val();



	



				handle = $('#'+current_preview+' .handles').find('a.selected input').val();



	



				initFlashSoftware({'previewMode':true});



	



				showUnits(false);



	



				//alert('test');



	



			}else{



	



				initFlashSoftware({'ltxt':'room_design_preview','previewMode':true});



	



			}



	



			//swfobject.embedSWF("flash/step3.swf?r=" + Math.random(), "swfHolder", $(window).width(), $(window).height() - 250, "10.0.0", "expressInstall.swf", {'ltxt':'room_design_preview','previewMode':true}, params, attributes);



	



			$("#saveRoomDesignDiv").html('<div align="center"><img src="images/loading.gif" /></div>');



	



			$("#saveRoomDesignDiv").dialog({



	



				title: 'Rendering, please wait a few moments...'



	



			});



	



			$("#saveRoomDesignDiv").dialog('open');



	



			save_preview = false;



	



			apply_preview = false;



	



		},'json');



	



	}



	



	function saveRoomDesign(theData) {



	



		$("#saveRoomDesignDiv").html('<div align="center"><img src="images/loading.gif" /></div>');



	



		$("#saveRoomDesignDiv").dialog({



	



			title: 'Save Design'



	



		});



		/*alert(JSON.stringify({



				'carcase' : carcase,



				'unitDoorType' : unitDoorType,



				'texture' : texture,



				'toptexture' : toptexture,



				'handle' : handle



			}));*/



		$("#saveRoomDesignDiv").dialog('open');



		$.post('ajax/myaccount/showSaveRoomDesign.php', {



	



			d: theData,



			s: {



				'carcase' : carcase,



				'unitDoorType' : unitDoorType,



				'texture' : texture,



				'toptexture' : toptexture,



				'handle' : handle,



				'manufacture' : manufacturer



			},



			p: save_preview || apply_preview



	



		}, function (data) {



			if( save_preview || apply_preview ){



	



				$("#saveRoomDesignDiv").dialog('close');



	



				loadPreview();



	



			}else{



	



				$("#saveRoomDesignDiv").html(data);



	



			}



	



		});



	



	}



	



</script>



<div id="picture3DAngleTest" style="position:absolute; overflow:auto; width:500px; height:500px; display:none; top:0px; right:0px" onclick="$(this).hide()"></div>