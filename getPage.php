<?php
	//error_reporting(E_ALL);//initialize error reporting to show all errors
	ini_set('upload_max_filesize','4M');
	//ini_set('display_errors', '1');//set to show error
	session_start();//start the session
	include ("includes.php");//include includes.php
	########################## CONFIGURE SMARTY #################################
	$smarty                  = new Smarty();
	$smarty->left_delimiter  = "{{";
	$smarty->right_delimiter = "}}";
	$_SESSION["smarty"]      = $smarty;
	#############################################################################
	
	//connect to the database
	mysql_connect  ( DB_HOST, DB_USER, DB_PASS ) or die ( "EROARE LA CONEXIUNE".mysql_error() );
	mysql_select_db( DB_DATABASE );
	/////////////////////////
	CleanPostAndGet();
	
	
	$list = new DbList('select * from html_pages where Link="'.$_GET['page'].'"');
	$smarty->assign('page',$list->Get(0));
	
	
	$smarty->assign('content',htmlspecialchars_decode(implode(file('html_pages/'.$_GET['page']))));

	$smarty->display('getPage.tpl');
	//disconect from the database
	mysql_close();
	/////////////////////////////
?>