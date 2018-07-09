<?php
	//seteaza afisarea de erori
	error_reporting(E_ALL);
	ini_set('display_errors', true);
	ini_set('html_errors', false);
	///////////////////////////
	session_start();
	
	include ("includes.php");
	
	##################### SMARTY #####################
	//global $smarty;
	$smarty                  = new Smarty();
	$smarty->left_delimiter  = "{{";
	$smarty->right_delimiter = "}}";
	$smarty->caching = false;
	$smarty->cache_lifetime = 120;
	$smarty->template_dir = 'templates/';
	$smarty->compile_dir  = 'tmp/templates_c/';
	$smarty->cache_dir    = 'tmp/cache/';
	//seteaza register_modifier
	$smarty->registerPlugin( "modifier", "apachelink", array("Util","apachelink"));
	##################################################
	
	$core = array();
	$list = new DbList('select * from options');
	$db_options = array();
	foreach( $list as $row ){
		$db_options[$row['var']] = $row['value'];
	}
	$config['ofd'] = $config['options_from_db'] = $db_options;
	
	$smarty->Assign('config',$config);
	$meta = array(
		'title' => 'Admin',
		'description' => 'Admin',
		'keywords' => ''
	);
	
	
	$page = !empty( $_GET['page'] ) ? $_GET['page'] : "home";
	$smarty->Assign('curpage',$page);
	
	if( !isset( $_SESSION['admin_logged'] ) )
		$_SESSION['admin_logged'] = false;
		
	if( $_SESSION['admin_logged'] === false && $page != 'login'  )
	{
		Util::Redirect('?page=login');
	}
	
	require_once "body.php";
	
	$smarty->Assign('meta',$meta);
	
	$alert_srv = alert::show();
	$smarty->assign('alert_srv',$alert_srv);
	
	if( isset( $core['template'] ) && !empty( $core['template'] ) )
		$smarty->display($core['template']);
?>