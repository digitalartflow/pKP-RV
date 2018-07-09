<?php /* Smarty version Smarty3-b7, created on 2015-07-27 06:43:58
         compiled from "templates/getShoppingCart.tpl" */ ?>
<?php /*%%SmartyHeaderCode:132878675955b6359e0b7bc0-52709435%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ac456a362fca410733f99a70795cbc3252c522d6' => 
    array (
      0 => 'templates/getShoppingCart.tpl',
      1 => 1438003865,
    ),
  ),
  'nocache_hash' => '132878675955b6359e0b7bc0-52709435',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_function_cycle')) include '/home/content/87/6010387/html/kitchenplanner/demo/libs/plugins/function.cycle.php';
?><style>



#shoppingCartTable p{



	padding:0px;



	margin:0px



}



#unitInfo .price{



	padding:10px 0px 10px 0px



}



#unitInfo .price sup{



	font-size:12px;



	color:#FF9900



}



#unitInfo .price strong{



	font-size:22px;



	color:#FFCC00



}



</style>



<?php if (count($_smarty_tpl->getVariable('items')->value)>0){?>



<table width="100%" id="shoppingCartTable" cellpadding="4" cellspacing="2">



<tr bgcolor="#000000" style="font-weight:bold">



	<td valign="top" align="center">#</td>



    <td>Name</td>



    <td align="center">Items</td>



    <td align="center">Price/Item</td>



    <td align="center">Total price</td>



</tr>



<?php  $_smarty_tpl->tpl_vars['n'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('items')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if (count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['n']->key => $_smarty_tpl->tpl_vars['n']->value){
?>



<tr bgcolor="<?php echo smarty_function_cycle(array('values'=>'#333333,#666666'),$_smarty_tpl->smarty,$_smarty_tpl);?>">



	<td valign="top" align="center"><img src="<?php echo @WEBSITE_URL;?>
uploads/unit_u<?php echo $_smarty_tpl->getVariable('n')->value['Id'];?>
_h<?php echo $_POST['sd']['h'];?>
_t<?php echo $_smarty_tpl->getVariable('n')->value['IdTop'];?>
_a0.png" height="50" /></td>



    <td valign="middle"><?php echo $_smarty_tpl->getVariable('n')->value['Name'];?>
<br /><em><?php echo $_smarty_tpl->getVariable('n')->value['Code'];?>
</em></td>



    <td align="center"><?php echo $_smarty_tpl->getVariable('n')->value['Nr'];?>
</td>



    <td align="center"><?php echo $_smarty_tpl->getVariable('n')->value['Price'];?>
 $</td>



    <td align="center"><?php echo $_smarty_tpl->getVariable('n')->value['TotalPrice'];?>
 $</td>



</tr>



<?php }} ?>



<tr bgcolor="#000000">



    <td align="right" colspan="4"><strong>Total</strong></td>



    <td align="center"><?php echo $_smarty_tpl->getVariable('total')->value;?>
 $</td>



</tr>



<tr>

     <td align="left" colspan="1" style="color:#FF0000">

     <div align="left"><input type="button" value="Back" color:"#FF0000" onClick="$('#shoppingCartDiv').dialog('close');" /></div>

</td>

    <td align="right" colspan="4" style="color:#FF0000" href="javascript: void(0)">

    <div id="shoppingCardSubmitButtons"><input type="button" color:"#FF0000" value="DESIGN NOT SAVED? SAVE IT NOW!" onclick="flashMovie(ifsSwfHolder).saveRoomDesign(); $('#shoppingCartDiv').dialog('close');"/></div>

</td>

</tr>







<tr bgcolor="#006600">







    <td align="center" colspan="5" style="color:#FFF"><strong>Choose 3D views to render</strong><br />







    <input type="checkbox" id="view_0" title="0&deg render" />0&deg; <input type="checkbox" id="view_1" title="90&deg render" />90&deg; <input type="checkbox" id="view_2" title="180&deg render" />180&deg; <input type="checkbox" id="view_3" title="270&deg render" />270&deg;</td>







</tr>







<tr bgcolor="#000000">







    <td align="center" colspan="5"><div id="shoppingCardSubmitButtons"> <input type="button" value="RENDER & SUBMIT DESIGN TO LOCATE THE NEAREST SUPPLIER" onclick="doCheckout()" /></div><div id="shoppingCardSubmitLoading" style="display:none">Loading! Please wait...</div>







    <div id="rendersLoading" style="overflow:hidden; width:350px; float:right">







    </div>







    </td>







</tr>







</table>



<?php }else{ ?>



No items in the shopping cart!



<?php }?>



<script>



function doCheckoutRenders()







{







	//go to checkout







	window.location = "checkout-renders.html";







}



function close_window() {

  if (confirm("Close Window?")) {

    close();

  }

}







var renders = [[4,{'identify':true,'floating':0},'4_base','Generating 2D base units render'],[4,{'identify':true,'floating':1},'4_floating','Generating 2D floating units render']];



//renders=[];







function retrieveRender(rid, first){







	tpl = '<div id="render'+rid+'" style="clear:both"><div style="float:left">'+renders[rid][3]+'</div><div style="float:right"><img class="loading" src="<?php echo @WEBSITE_URL;?>
images/rendering_loader.gif" style="width:50px; margin-top:5px" /><img src="<?php echo @WEBSITE_URL;?>
images/ok.png" style="display:none" class="ok" /></div></div>';







	$('#rendersLoading').append(tpl);



	//$('body').append('<img src="data:image/png;base64,'+flashMovie('room_planner').save3DRenderToImage(renders[rid][0],'png',renders[rid][1])+'" style="position:absolute; top:0px; left:0px; width:500px; height:500px" />');



	//return false;



	picData = flashMovie('room_planner').save3DRenderToImage(renders[rid][0],'png',renders[rid][1]);



	console.log(picData.length);



	objToSend = {'a':renders[rid][2],'resetSession':first};



	objToSend['pic'] = picData;



	/*if( picData.length > 35000 ){



		picDataArray = picData.match(/.{1,29000}/g);



		console.log(picDataArray.length);



		for( i in picDataArray ){



			if( i > 5 ) break;



			objToSend['pic'+i] = picDataArray[i];



		}



	}else{



		objToSend['pic'] = picData;



	}*/



	$.ajax({



		type : "post",



		dataType : 'json',



		contentType: "application/json",



		url:'ajax/saveFlashRenders.php',



		data: JSON.stringify(objToSend),



		success: function(data){



			first = 0;



	



			$('#render'+rid+' .ok').show();



	



			$('#render'+rid+' .loading').hide();



	



			rid++;



	



			if( rid == renders.length ){



	



				window.location = "checkout.html";



	



				//alert('rdy');



	



			} else retrieveRender(rid, first);



		}



	});







	return false;







}







function doCheckout()







{







	$('#shoppingCardSubmitLoading').show();







	$('#shoppingCardSubmitButtons').hide();







	//save room design







	//console.log(flashMovie('room_planner').getUnitsCount(true));



	//renders.push([0,{},0,'Generating 3D '+$('#view_'+0).attr('title')]);



	//retrieveRender(0,1);



	//return false;







	for( i = 0; i<= 3;i++){







		if( $('#view_'+i+':checked').length > 0 ) renders.push([i,{},i,'Generating 3D '+$('#view_'+i).attr('title')]);







	}







	$.post('ajax/updateShoppingCart.php',{'unitsCountData':flashMovie('room_planner').getUnitsCount(true)},function(data){







		retrieveRender(0,1);







	});







}







$(function() {







	$( "input[type='button']" ).button();







});



</script>