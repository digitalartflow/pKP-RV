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
	if( empty($_POST['id']) && empty($_POST['name']) )
	{
		$data = array();
		$data['msg'] = 'You must enter a name!';
		$data['resp'] = 'error';
		echo json_encode($data);	
		die();
	}
	
	$ow = false;
	if( !empty($_POST['id']) )
	{
		$list = new DbList('select * from room_designs where IdUser="'.$_SESSION['logged']['Id'].'" and Id="'.$_POST['id'].'"');
		if( $list->Size() > 0 )
			$ow = $list->Get(0);
	}
	
	$item = new DbSavedRoomDesign();
	if( $ow ){
		$item->fromId($ow['Id']);	
		$nid = $ow['Id'];
	}else{
		$nid = $item->getNextId();
	}
	$item->set('IdUser',$_SESSION['logged']['Id']);
	if( !$ow )
		$item->set('Name',$_POST['name']);
	$item->set('Data',$_SESSION['roomDesignSavedData']);
	$item->set('CustomStyle',json_encode($_SESSION['roomDesignSavedStyleData']));
	if( !$ow )
		$item->set('CreationDate',date('Y-m-d H:i:s'));
	$item->set('SaveDate',date('Y-m-d H:i:s'));
	if( $ow )
		$item->Update();
	else
		$item->CreateNew();
	$_SESSION['last_saved_room_id'] = $nid;
	//do login
	
	$data = array();
	$data['msg'] = 'Room design saved!';
	$data['resp'] = 'ok';
	echo json_encode($data);
	
	mysql_close();
	/////////////////////////////
?>