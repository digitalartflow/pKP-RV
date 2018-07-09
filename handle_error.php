<?php
	$is_unit_pic = strpos($_SERVER["REQUEST_URI"],'uploads/unit_u');
	if( $is_unit_pic >= 0 ){
		$uri = substr($_SERVER["REQUEST_URI"],strrpos($_SERVER["REQUEST_URI"],'/'));
		$uri = str_replace('.png','',$uri);
		$pieces = explode('_',$uri);
		$_GET = array(
			'u' => substr($pieces[1],1),
			'h' => substr($pieces[2],1),
			't' => substr($pieces[3],1),
			'a' => substr($pieces[4],1)
		);
		include "getUnitPic.php";
	}
?>