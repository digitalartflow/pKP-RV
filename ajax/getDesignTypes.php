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
	
	header ("content-type: text/xml");
	
	$list = new DbList('select * from units_categories where IdParent=0 order by Name ASC');
	
	echo '<?xml version="1.0" encoding="utf-8"?>'."\r\n";
	echo '<items>'."\r\n";
		
	foreach($list->GetCollection() as $item)
	{
		echo '	<item>'."\r\n";
		echo '		<id>'.$item['Id'].'</id>'."\r\n";
		echo '		<name>'.$item['Name'].'</name>'."\r\n";
		echo '		<description><![CDATA['.$item['Id'].']]></description>'."\r\n";
		echo '		<image_big width="114" height="201">'.$item['Name'].'</image_big>'."\r\n";
		echo '	</item>'."\r\n";
	}
	
	echo '</items>'."\r\n";
	
	mysql_close();
	/////////////////////////////
?>