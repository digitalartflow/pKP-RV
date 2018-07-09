<?php
	include("../includes.php" );
	//
	$p                   = new DbDoorPic();
	$p["Picture"]        = $_POST["image"];
        $p["Name"]           = $_POST["name"];
        $p["IdDoor"]         = $_POST["id"];
        echo $p->getNextId();
	$p->CreateNew();
?>