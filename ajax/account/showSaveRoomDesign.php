<?php
	error_reporting(E_ALL);//initialize error reporting to show all errors
	ini_set('upload_max_filesize','4M');
	ini_set('display_errors', '1');//set to show error
	session_start();//start the session
	include ("../../includes.php");//include includes.php
	########################## CONFIGURE SMARTY #################################
	$smarty                  = new Smarty();
	$smarty->left_delimiter  = "{{";
	$smarty->right_delimiter = "}}";
	$_SESSION["smarty"]      = $smarty;
	$smarty->template_dir    = "../templates/";
	$smarty->compile_dir     = "../templates_c/";
	#############################################################################
	
	$start = time();
	//connect to the database
	mysql_connect  ( DB_HOST, DB_USER, DB_PASS ) or die ( "EROARE LA CONEXIUNE".mysql_error() );
	mysql_select_db( DB_DATABASE );
	/////////////////////////
	CleanPostAndGet();
	
	//find if he is logged in
	if( !isset( $_SESSION['logged'] ) || empty( $_SESSION['logged'] ) )
	{
		die('You must be logged in!');
	}
	
	$list = new DbList('select * from room_designs where IdUser="'.$_SESSION['logged']['Id'].'" order by CreationDate ASC');
	$smarty->assign('rd',$list->GetCollection());
	
	$smarty->display('my_account/showSaveRoomDesign.tpl');
	
	mysql_close();
	/////////////////////////////
?>