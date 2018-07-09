<?php
	error_reporting(E_ALL);//initialize error reporting to show all errors
	ini_set('upload_max_filesize','4M');
	ini_set('display_errors', '1');//set to show error
	session_start();//start the session
	include ("../includes.php");//include includes.php
	########################## CONFIGURE SMARTY #################################
	$smarty                  = new Smarty();
	$smarty->left_delimiter  = "{{";
	$smarty->right_delimiter = "}}";
	$_SESSION["smarty"]      = $smarty;
	$smarty->template_dir    = "templates/";
	$smarty->compile_dir     = "templates_c/";
	#############################################################################
	
	$start = time();
	//connect to the database
	mysql_connect  ( DB_HOST, DB_USER, DB_PASS ) or die ( "EROARE LA CONEXIUNE".mysql_error() );
	mysql_select_db( DB_DATABASE );
	/////////////////////////
	//CleanPostAndGet();
	
	$total = 0;
	$items = array();
	$_SESSION['shoppingCart'] = array();
	/*echo "<pre>";
	print_r($_POST);
	echo "</pre>";*/
	if( !empty( $_POST['u'] ) )
	{
		$_SESSION['shoppingCart'] = $_POST;
		foreach( $_POST['u'] as $u => $nr )
		{
			$item = array();
			$list = new DbList('select uv.Id, uv.IdUnit, uv.Code, uv.PriceDiff, u.Name, u.Price from
			unit_variations as uv, 
			units as u 
			where uv.Id="'.$u.'" and uv.IdUnit=u.Id');
			$uv   = $list->Get(0);
			$item['Id'] 			= $uv['Id'];
			$item['Name'] 			= $uv['Name'];
			$item['Code'] 			= $uv['Code'];
			$item['Nr'] 			= $nr;
			$item['Price'] 			= $uv['Price']+$uv['PriceDiff'];	
			$list = new DbList('select * from units_handles where IdUnit="'.$uv['IdUnit'].'" and IdHandle="'.$_POST['sd']['h'].'" limit 1');
			if( $list->Size() > 0 )
			{
				$uh = $list->Get(0);
				//echo $uh['PriceDiff']."<br>";
				$item['Price'] += $uh['PriceDiff'];
			}
			$list = new DbList('select * from units_tops where IdUnit="'.$uv['IdUnit'].'" and IdTop="'.$_POST['sd']['to'].'" limit 1');
			if( $list->Size() > 0 )
			{
				$ut = $list->Get(0);
				$item['IdTop'] = $ut['Id'];
				//echo $ut['PriceDiff']."<br>";
				$item['Price'] += $ut['PriceDiff'];
			}
			$item['TotalPrice'] 	= $item['Price']*$nr;
			$total					+= $item['TotalPrice'];
			array_push($items,$item);
		}
	}
	$smarty->assign('items',$items);
	$smarty->assign('total',$total);
	
	//print_r($items);
	
	$smarty->display('getShoppingCart.tpl');
	
	mysql_close();
	/////////////////////////////
?>