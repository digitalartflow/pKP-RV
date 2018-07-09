<?php
	include("../includes.php" );
	//
	$p                   = new DbDoorPic( $_POST["id"] );
        $p["Name"]           = $_POST["name"];
	$p->Update();
?>