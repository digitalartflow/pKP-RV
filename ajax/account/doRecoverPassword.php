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
	
	
	$tc = array('email');
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
	
	
	//verify if emaile exists
	
	$list = new DbList('select * from users where Email="'.$_POST['email'].'"');
	if( $list->Size() == 0 )
	{
		$data = array();
		$data['msg'] = 'The email is not registered in our database!';
		$data['action'] = 'error';
		echo json_encode($data);	
		die();
	}
	$info = $list->Get(0);
	$header = "From: ".WEBSITE_NOREPLY_EMAIL."\r\n"; 
	$header.= "MIME-Version: 1.0\r\n"; 
	$header.= "Content-Type: text/html; charset=utf-8\r\n"; 
	$header.= "X-Priority: 1\r\n"; 
	$msg = '
	Listed below are the login information for '.WEBSITE_URL.':<br />
	<br />
	<strong>Email:</strong> '.$info['Email'].'<br />
	<strong>Password:</strong> '.$info['Password'].'<br />
	<strong>Login link:</strong> <a href="'.WEBSITE_URL.'">'.WEBSITE_URL.'</a><br />
	<br />
	Best regards,<br />
	'.WEBSITE_URL.' team
	';
	mail($info['Email'],'Login information for '.WEBSITE_URL,$msg,$header);
	
	$data = array();
	$data['msg'] = 'An email with login information has been sent to the provided e-mail!';
	$data['action'] = 'ok';
	echo json_encode($data);
	
	mysql_close();
	/////////////////////////////
?>