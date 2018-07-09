<?php
        global $smarty;
	//
        $cmd  = $_GET["cmd"];
        $smarty->Assign ( "cmd", $cmd );
        if( $cmd == "edit" )
        {
            $d    = new DbDoor( $_GET["id"] );
            $smarty->assign("d", $d);
            //
            $lst = DbList::Select("*", "room_doors_pics", "IdDoor='".$d["Id"]."'");
            $smarty->assign("poze", $lst);
        }
	//
        $lst = DbList::Select("*", "room_doors_types");
        $smarty->assign("types", $lst);
        //
	$smarty->Display( "addeditd.tpl" );
?>