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
	echo '<categories>'."\r\n";
		
	foreach($list->GetCollection() as $categ)
	{
		echo '	<category name="'.$categ['Name'].'" id="'.$categ['Id'].'">'."\r\n";
		echo '		<subcategory id="0">All '.strtolower($categ['Name']).'</subcategory>'."\r\n";
		$lst = new DbList('select * from units_categories where IdParent="'.$categ['Id'].'" order by Name ASC');
		foreach($lst->GetCollection() as $subcat)
		{
			echo '		<subcategory id="'.$subcat['Id'].'">'.$subcat['Name'].'</subcategory>'."\r\n";
		}
		echo '	</category>'."\r\n";
	}
	
	echo '</categories>'."\r\n";
	
	mysql_close();
	/////////////////////////////
?>