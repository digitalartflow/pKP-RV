<?php
	error_reporting(E_ALL);//initialize error reporting to show all errors
	ini_set('upload_max_filesize','4M');
	ini_set('display_errors', '1');//set to show error
	session_start();//start the session
	include ("includes.php");//include includes.php
	
	$start = time();
	//connect to the database
	mysql_connect  ( DB_HOST, DB_USER, DB_PASS ) or die ( "EROARE LA CONEXIUNE".mysql_error() );
	mysql_select_db( DB_DATABASE );
	/////////////////////////
	CleanPostAndGet();
	
	
	
	$output = "uploads/renderings/unit_u".$_GET['u']."_h".$_GET['h']."_t".$_GET['t']."_a".$_GET['a'].".png";
	//if( file_exists($output) ) unlink($output);
	
	if( !file_exists($output) )
	{
		
		//gaseste pozele unitului
		$list = new DbList('select * from unit_variations where Id="'.$_GET['u'].'"');
		$uv    = $list->Get(0);
		$images = array("uploads/unit_variations/".$uv['Image'.$_GET['a']]);
		//gaseste date unit
		$list = new DbList('select * from units where Id="'.$uv['IdUnit'].'"');
		$u    = $list->Get(0);
		//gaseste handle
		$list = new DbList('select * from units_handles where IdUnit="'.$uv['IdUnit'].'" and IdHandle="'.$_GET['h'].'"');
		if( $list->Size() > 0 )
		{
			$uh    = $list->Get(0);
			if( $_GET['a'] >= 180  )
				$images = array("uploads/unit_handles/".$uh['Image'.$_GET['a']], "uploads/unit_variations/".$uv['Image'.$_GET['a']]);
			else
				array_push($images, "uploads/unit_handles/".$uh['Image'.$_GET['a']]);
		}
		//get image size
		list($tw, $th) = getimagesize("uploads/unit_variations/".$uv['Image'.$_GET['a']]);
		//gaseste top
		//$list = new DbList('select ut.*, t.Height as TH from units_tops as ut, tops as t where ut.IdUnit="'.$uv['IdUnit'].'" and t.Id=ut.IdTop');
		//$list = new DbList('select ut.*, t.Height as TH from units_tops as ut, tops as t where ut.IdUnit="'.$uv['IdUnit'].'" and t.Id=ut.IdTop and t.Id="'.$_GET['t'].'"');
		$list = new DbList('select ut.*, t.Height as TH from units_tops as ut, tops as t where ut.IdUnit="'.$uv['IdUnit'].'" and t.Id=ut.IdTop and ut.Id="'.$_GET['t'].'"');
		if( $list->Size() > 0 )
		{
			$ut    = $list->Get(0);
			$th    += $ut['TH']/5;
			array_push($images, "uploads/unit_tops/".$ut['Image'.$_GET['a']]);
			list($ttw, $tth) = getimagesize("uploads/unit_tops/".$ut['Image'.$_GET['a']]);
			if( $ttw > $tw ) $tw = $ttw;
		}
	
		$pozFirst = "BOTTOMLEFT";
		if( $_GET['a'] == 90 || $_GET['a'] == 180 )
			$pozFirst = "BOTTOMRIGHT";
		
		$nir = new NeoImageResizer();
		$nir->OverlayAddAndSave
		( 
			array($images[0],$images[1]),
			$tw,$th,   	//dimensiunea imaginii finale
			$pozFirst,  	//pozitionarea
			15, 		//quality
			$output //output
		);
		if( count( $images ) > 2 )
			for( $i = 2; $i< count($images); $i++ )
			{
				$nir = new NeoImageResizer();
				$nir->OverlayAddAndSave
				( 
					array($output,$images[$i]),
					$tw,$th,   	//dimensiunea imaginii finale
					"TOPLEFT",  	//pozitionarea
					15, 		//quality
					$output //output
				);
			}
		exec('convert '.$output.' -trim '.$output);
	}
	
	
	header('Content-type: image/png');
	echo file_get_contents($output);
	
	
	//disconect from the database
	mysql_close();
	/////////////////////////////
?>