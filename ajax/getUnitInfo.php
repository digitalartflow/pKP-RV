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
	CleanPostAndGet();
	
	$list = new DbList('select * from unit_variations where Id="'.$_POST['u'].'"');
	$uv = $list->Get(0);
	$smarty->assign('uv',$uv);
	$list = new DbList('select * from units where Id="'.$uv['IdUnit'].'"');
	$u = $list->Get(0);
	$smarty->assign('u',$u);
	$price  = $u['Price'];
	$price += $uv['PriceDiff'];
	
	$list = new DbList('select * from units_handles where IdUnit="'.$u['Id'].'" and IdHandle="'.$_SESSION['getUnitsPost']['h'].'" limit 1');
	if( $list->Size() > 0 )
	{
		$uh = $list->Get(0);
		$price += $uh['PriceDiff'];
		$smarty->assign('uh',$uh);
	}
	$list = new DbList('select * from units_tops where IdUnit="'.$u['Id'].'" and IdTop="'.$_SESSION['getUnitsPost']['to'].'" limit 1');
	if( $list->Size() > 0 )
	{
		$ut = $list->Get(0);
		$price += $ut['PriceDiff'];
		$smarty->assign('ut',$ut);
	}
	
	$smarty->assign('price',$price);
	
	$list = new DbList('select * from manufacturers where Id="'.$_SESSION['getUnitsPost']['m'].'"');
	$smarty->assign('manuf',$list->Get(0));
	
	
	//print_r($items);
	
	$smarty->display('getUnitInfo.tpl');
	
	mysql_close();
	/////////////////////////////
?>