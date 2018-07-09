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
	
	$action = !empty( $_POST['a'] ) ? $_POST['a'] : '';
	$ret = array('error'=>false);
	switch( $action ){
		case 'save_spc':
			if( !isset( $_POST['State'] ) || empty( $_POST['State'] ) )
				$ret['error'] = 'Please select state!'."\n";
			if( !isset( $_POST['PostalCode'] ) || empty( $_POST['PostalCode'] ) )
				$ret['error'] = 'Please insert postal code!'."\n";
			if( !$ret['error'] ){
				$_SESSION['state_postalcode'] = array('State'=>$_POST['State'], 'PostalCode'=>$_POST['PostalCode']);
				if( isset( $_SESSION['logged'] ) && !empty( $_SESSION['logged'] ) ){
					$item = new DbUser();
					$item->fromId($_SESSION['logged']['Id']);
					$item->setFromArray($_POST,array('action'));
					$item->Update();
				}
			}
			break;
		default:
			$ret['error'] = 'No action found!';
	}
	echo json_encode($ret);
	
	mysql_close();
	/////////////////////////////
?>