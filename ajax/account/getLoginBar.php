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
	
	$data = array();
	$data['error_state_postalcode'] = false;
	$data['html'] = $smarty->fetch('account/getLoginBar.tpl');
	if( isset( $_SESSION['logged'] ) && !empty( $_SESSION['logged'] ) ){
		if( empty( $_SESSION['logged']['State'] ) || empty( $_SESSION['logged']['PostalCode'] ) )
			$data['error_state_postalcode'] = true;
	}else{
		if( !isset( $_SESSION['state_postalcode'] ) || empty( $_SESSION['state_postalcode']['State'] ) || empty( $_SESSION['state_postalcode']['PostalCode'] ) )
			$data['error_state_postalcode'] = true;
	}
	echo json_encode($data);
	
	mysql_close();
	/////////////////////////////
?>