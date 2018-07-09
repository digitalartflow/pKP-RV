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
	
	$tc = array('Name','Gender','State','PostalCode'/*,'DateOfBirth'*/,'Email');
	$error = false;
	foreach( $tc as $t )
		if( empty( $_POST[$t] ) ) $error = true;
	if( $error )
	{
		$data = array();
		$data['msg'] = 'All the fields are required!';
		$data['action'] = 'error';
		echo json_encode($data);	
		die();
	}
	
	$item = new DbUser();
	$item->fromId($_SESSION['logged']['Id']);
	$item->setFromArray($_POST,array('Email'));
	//$item->set('DateOfBirth',date('Y-m-d',strtotime($_POST['DateOfBirth'])));
	$item->Update();
	//do login
	
	$list = new DbList('select * from users where Email="'.$_POST['Email'].'"');
	$_SESSION['logged'] = $list->Get(0);
	
	$data = array();
	$data['msg'] = 'Account modified!';
	echo json_encode($data);
	
	mysql_close();
	/////////////////////////////
?>