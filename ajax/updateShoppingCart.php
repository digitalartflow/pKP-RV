<?php
	error_reporting(E_ALL);//initialize error reporting to show all errors
	ini_set('upload_max_filesize','4M');
	ini_set('display_errors', '1');//set to show error
	session_start();//start the session
	include ("../includes.php");//include includes.php
	
	$start = time();
	//connect to the database
	mysql_connect  ( DB_HOST, DB_USER, DB_PASS ) or die ( "EROARE LA CONEXIUNE".mysql_error() );
	mysql_select_db( DB_DATABASE );
	/////////////////////////
	CleanPostAndGet();
	if( !empty( $_POST['unitsCountData'] ) ){
		$items = json_decode(htmlspecialchars_decode($_POST['unitsCountData']),true);
		foreach( $items as $item ){
			$_SESSION['shoppingCart']['u_nr'][$item['uData']['uvid']][] = $item['unitCountNr'];
		}
	}
	
	mysql_close();
	/////////////////////////////
?>