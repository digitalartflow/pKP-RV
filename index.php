<?php

	error_reporting(E_ALL);//initialize error reporting to show all errors
	ini_set('upload_max_filesize','4M');
	ini_set('display_errors', '1');//set to show error
	ini_set('memory_limit','32M');
	session_start();//start the session
	include ("includes.php");//include includes.php
	########################## CONFIGURE SMARTY #################################
	$smarty                  = new Smarty();
	$smarty->left_delimiter  = "{{";
	$smarty->right_delimiter = "}}";
	$_SESSION["smarty"]      = $smarty;
	#############################################################################
	
	$start = time();
	//connect to the database
	mysql_connect  ( DB_HOST, DB_USER, DB_PASS ) or die ( "EROARE LA CONEXIUNE".mysql_error() );
	mysql_select_db( DB_DATABASE );
	/////////////////////////
	CleanPostAndGet();
	
	
	$page = ( !empty($_GET['page']) ) ? ( $_GET['page'] ) : ( "home" );	
	
	
	
	$list = new DbList('select * from html_pages where Zone="help" order by `Order` ASC');
	$smarty->assign('helpPages',$list->GetCollection());
	
	$list = new DbList('select * from states order by Name ASC');
	$states = $list->GetCollection();
	$smarty->Assign('states',$states);
	
	
	$smarty->Assign('header',$smarty->fetch('header.tpl'));
	
	include "body.php";
	
	
	$end = time();
	$time = $end-$start;
	$smarty->Assign('timeToGeneratePage',$time);

	$smarty->display('index.tpl');
	//disconect from the database
	mysql_close();
	/////////////////////////////
?>