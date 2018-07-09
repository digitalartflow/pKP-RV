<?php
//var_dump( get_cfg_var('LimitRequestFieldSize'));
//print_r( ini_get_all());
//die();
	error_reporting(E_ALL);//initialize error reporting to show all errors
	ini_set('upload_max_filesize','50M');
	ini_set('post_max_size','50M');
	ini_set('memory_limit','50M');
	ini_set('display_errors', '1');//set to show error
	session_start();//start the session
	include ("../includes.php");//include includes.php
	
	$start = time();
	//connect to the database
	mysql_connect  ( DB_HOST, DB_USER, DB_PASS ) or die ( "EROARE LA CONEXIUNE".mysql_error() );
	mysql_select_db( DB_DATABASE );
	/////////////////////////
	CleanPostAndGet();
	
	$php_input = file_get_contents('php://input');
	if( !empty( $php_input ) ){
		$_POST = json_decode($php_input,true);
	}
	
	if( isset( $_POST['resetSession'] ) && !empty( $_POST['resetSession'] ) && $_POST['resetSession'] == 1 ){
		unset($_SESSION['flashRenders']);
	}

	if( !isset($_SESSION['flashRenders']) ){
		$_SESSION['flashRenders'] = array('pics'=>array());
	}

	if( !isset( $_SESSION['flashRenders']['file_name_base'] ) ){
		$_SESSION['flashRenders']['file_name_base'] = str_replace('.','',uniqid('',true));
	}

	$_SESSION['flashRenders']['pics_raw'][$_POST['a']] = $_POST['pic'];
	$file_name_base = $_SESSION['flashRenders']['file_name_base'];
	$pic = $_POST['pic'];
	$pic = base64_decode($pic);
	$file_name = $file_name_base.'_'.$_POST['a'].'.png';
	$_SESSION['flashRenders']['pics'][$_POST['a']] = $file_name;
	$h = fopen('../uploads/flash_renders/'.$file_name,'w');
	fwrite($h,$pic);
	fclose($h);
		
	mysql_close();
	/////////////////////////////
?>