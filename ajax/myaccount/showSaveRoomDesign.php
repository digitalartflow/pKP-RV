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
	
	$_SESSION['roomDesignSavedData'] = $_POST['d'];
	$_SESSION['roomDesignSavedStyleData'] = $_POST['s'];
	$preview = !empty( $_POST['p'] ) && $_POST['p'] == "true" ? true : false;
	if( $preview ){
		//var_dump(htmlspecialchars_decode($_SESSION['roomDesignSavedData']));
		die('1');
	}
	if( !isset( $_SESSION['logged'] ) || empty( $_SESSION['logged'] ) )
	{
		die('You must be logged in!<br>
		<a href="javascript:void(0)" onclick="$(\'#saveRoomDesignDiv\').dialog(\'close\'); showAccount(\'login\')">Log In</a> | 
		<a href="javascript:void(0)" onclick="$(\'#saveRoomDesignDiv\').dialog(\'close\'); showAccount(\'create_account\')">Create an account</a>');
	}
	$list = new DbList('select * from room_designs where IdUser="'.$_SESSION['logged']['Id'].'" order by CreationDate ASC');
	$smarty->assign('rd',$list->GetCollection());
	
	//$list = new DbList('DESCRIBE `room_designs`');
	//print_r($list->GetCollection());
	
	$smarty->display('myaccount/showSaveRoomDesign.tpl');
	
	mysql_close();
	/////////////////////////////
?>