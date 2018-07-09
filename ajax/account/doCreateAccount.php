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
	
	//check securit code
	if( empty($_POST['Terms']) || $_POST['Terms'] != "yes" )
	{
		$data = array();
		$data['msg'] = 'Must agree to the Terms of Use and Privacy Policy!';
		$data['action'] = 'error';
		echo json_encode($data);	
		die();
	}
	
	$tc = array('Name','Gender','State','PostalCode'/*,'DateOfBirth'*/,'Email','Password','Terms','SecurityCode');
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
	
	//check security code
	if( strtolower($_POST['SecurityCode']) != strtolower($_SESSION['code']) )
	{
		$data = array();
		$data['msg'] = 'Security code is incorrect!';
		$data['action'] = 'error';
		echo json_encode($data);	
		die();
	}
	
	//verify if emaile exists
	
	$list = new DbList('select * from users where Email="'.$_POST['Email'].'"');
	if( $list->Size() > 0 )
	{
		$data = array();
		$data['msg'] = 'Email exists in the database! Please use another email!';
		$data['action'] = 'error';
		echo json_encode($data);	
		die();
	}
	
	$item = new DbUser();
	$item->setFromArray($_POST);
	/*$item->set('DateOfBirth',date('Y-m-d',strtotime($_POST['DateOfBirth'])));
	$item->set('DateCreation',date('Y-m-d'));
	$item->set('DateLastLogin',date('Y-m-d H:i:s'));*/
	$item->CreateNew();
	//do login
	
	$list = new DbList('select * from users where Email="'.$_POST['Email'].'"');
	$_SESSION['logged'] = $list->Get(0);
	
	$data = array();
	$data['msg'] = 'Account created!';
	$data['action'] = 'login';
	echo json_encode($data);
	
	mysql_close();
	/////////////////////////////
?>