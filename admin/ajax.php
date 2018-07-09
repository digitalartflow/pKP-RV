<?php
	//seteaza afisarea de erori
	error_reporting(E_ALL);
	ini_set('display_errors', true);
	ini_set('html_errors', false);
	///////////////////////////
	session_start();
	
	function autoloadclass($class_name) {
		$file = '/home/negosio2/public_html/classes/lib/'.$class_name.'.class.php';
		require_once $file;
	}
	
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
	
	$smarty->Assign('config',$config);
	$core = array();
	if( !isset( $_GET['page'] ) || empty( $_GET['page'] ) ) die();
	$page = $_GET['page'];
	$spage = str_replace('-','_',$page);
	$spage = 'pages/ajax/'.str_replace('__','/',$spage).'.php';
	if( is_file( $spage ) )
	{
		require_once $spage;
	}
	
	if( isset( $core['template'] ) && !empty( $core['template'] ) )
		$smarty->display($core['template']);
?>