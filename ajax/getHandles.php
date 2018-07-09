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
	
	
	$list = new DbList('
	select 
		l.* 
	from 
		latches as l,
		units_handles as uh
	where
		l.Manufacturers like "%'.$_POST['m'].'%" and
		uh.IdHandle=l.Id
	group by
		l.Id 
	order by 
		l.Name ASC');
	$smarty->assign('items',$list->GetCollection());
	
	$smarty->display('getHandles.tpl');
	
	mysql_close();
	/////////////////////////////
?>