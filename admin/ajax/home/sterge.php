<?php
	include("../includes.php" );
	//
	$id    = $_POST["id"];
        echo "id=".$id;
	//
	$p              = new DbDoor($id);
        //sterge toate pozele din ea
        $lst            = new DbList("SELECT * FROM room_doors_pics WHERE IdDoor=".$id);
        foreach( $lst as $poza )
        {
            unlink("../../../uploads/door_variation/".$poza["Picture"]);
            unlink("../../../uploads/door_variation/".$poza["Render0"]);
            unlink("../../../uploads/door_variation/".$poza["Render90"]);
            unlink("../../../uploads/door_variation/".$poza["Render180"]);
            unlink("../../../uploads/door_variation/".$poza["Render270"]);
        }
        DbList::ExecNoneQuery("DELETE FROM room_doors_pics WHERE IdDoor=".$id);
	$p->Delete();

?>