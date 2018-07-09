<?php
	include("../includes.php" );
	//
	$id    = $_POST["id"];
        echo "id=".$id;
	//
	$p              = new DbUnit($id);
        //sterge iconul
       if( file_exists( "../../../uploads/units/".$p["Icon"] ) ) unlink("../../../uploads/units/".$p["Icon"]);
        //sterge swf-ul
       if( file_exists( "../../../uploads/swf_2d/".$p["Swf2D"] ) )  unlink("../../../uploads/swf_2d/".$p["Swf2D"]);
        //
	$p->Delete();

?>