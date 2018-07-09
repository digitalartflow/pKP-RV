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
	
	if( !isset( $_SESSION['kitchen'] ) ) $_SESSION['kitchen'] = array();
	
	if( !empty( $_POST['action'] ) )
	{
		if( $_POST['action'] == "save_room_holder" )
		{
			$_SESSION['kitchen']['room'] = array();
			$_SESSION['kitchen']['room']['area'] = $_POST['data'];
		}
		if( $_POST['action'] == "save_room_design" )
		{
			echo $_SESSION['kitchen']['room_design'] = $_POST['data'];
		}
		if( $_POST['action'] == "get_room_holder" )
		{
			echo $_SESSION['kitchen']['room']['area'];
		}
		
		if( $_POST['action'] == "get_preview" )
		{
			$data = json_decode((string) htmlspecialchars_decode($_SESSION['roomDesignSavedData']),true);
			//print_r($data['units']);
			$ids = array();
			foreach( $data['units'] as $unit ){
				$ids[] = $unit['uData']['uid'];
			}
			$handle = $_POST['d']['handle'];
			$top = $_POST['d']['toptexture'];
			$sql = '
				select
					uv.Id,
					u.Id as UnitId,
					wt.Id as IdTop
				from
					textures 			as t,
					units 				as u,
					unit_variations 	as uv,
					unit_doors 			as d,
					carcasses 			as c,
					manufacturers 		as m,
					units_tops			as wt,
					units_handles		as h
				where
					m.Id="'.$_SESSION['ftype'].'" and
					c.Id="'.$_POST['d']['carcase'].'" and
					d.Id="'.$_POST['d']['unitDoorType'].'" and
					t.Id="'.$_POST['d']['texture'].'" and
					wt.IdTop="'.$_POST['d']['toptexture'].'" and
					h.IdHandle="'.$_POST['d']['handle'].'" and
					uv.IdTexture	= t.Id and
					uv.IdUnit		= u.Id and
					uv.IdDoor		= d.Id and
					u.IdManufacturer= m.Id and
					uv.IdCarcass	= c.Id and
					h.IdUnit		= u.Id and
					( (wt.IdUnit=u.Id and u.HasWorktop="yes") or u.HasWorktop="no" )
					'.( count( $ids ) > 0 ? ' and u.Id in ('.implode(',',$ids).') ' : '' ).'
				group by
					uv.Id
				';
			$list = new DbList( $sql );
			//die();
			$preview = $data;
			//echo $sql;
			foreach( $list->GetCollection() as $item ){
				$top = $item['IdTop'];
				foreach( $preview['units'] as &$unit ){
					if( $unit['uData']['uid'] == $item['UnitId'] ){
						$unit['uData']['uvid'] = $item['Id'];
						$unit['uData']['pics'] 		= array(
							WEBSITE_URL.'uploads/unit_u'.$item['Id'].'_h'.$handle.'_t'.$top.'_a0.png',
							WEBSITE_URL.'uploads/unit_u'.$item['Id'].'_h'.$handle.'_t'.$top.'_a90.png',
							WEBSITE_URL.'uploads/unit_u'.$item['Id'].'_h'.$handle.'_t'.$top.'_a180.png',
							WEBSITE_URL.'uploads/unit_u'.$item['Id'].'_h'.$handle.'_t'.$top.'_a270.png'
						);
						continue;
					}
				}
				/*for( $i = 0; $i< count( $preview['units'] ); $i++ ){
					if( $preview['units'][$i]['uData']['uid'] == $item['UnitId'] ){
						$preview['units'][$i]['uData']['pics'] 		= array(
							WEBSITE_URL.'uploads/unit_u'.$item['Id'].'_h'.$handle.'_t'.$top.'_a0.png',
							WEBSITE_URL.'uploads/unit_u'.$item['Id'].'_h'.$handle.'_t'.$top.'_a90.png',
							WEBSITE_URL.'uploads/unit_u'.$item['Id'].'_h'.$handle.'_t'.$top.'_a180.png',
							WEBSITE_URL.'uploads/unit_u'.$item['Id'].'_h'.$handle.'_t'.$top.'_a270.png'
						);
						$preview['units'][$i]['uData']['pics'] 		= array(
						);
						continue;
					}
				}*/
			}
			if( isset( $_POST['d']['apply'] ) ){
				$_SESSION['kitchen']['room_design'] = htmlspecialchars(json_encode($preview));
			}else{
				$_SESSION['preview_data'] = $preview;
			}
			echo json_encode(true);
		}
	}
	
	if( !empty( $_GET['action'] ) )
	{
		if( $_GET['action'] == "get_room_design" )
		{
			if( isset( $_GET['preview'] ) )
				echo json_encode($_SESSION['preview_data']);
			else
				echo htmlspecialchars_decode($_SESSION['kitchen']['room_design']);
		}
		if( $_GET['action'] == "get_room_style" )
		{
			$ret = false;
			if( !empty( $_SESSION['saved_room_style'] ) ){
				$ret = $_SESSION['saved_room_style'];
			}
			echo json_encode($ret);
		}
		################### ROOM DOOR TYPES ###################
		if( $_GET['action'] == "get_room_door_types" )
		{
			$list = new DbList('select * from room_doors_types order by Name ASC');
			echo '<?xml version="1.0" encoding="utf-8"?>
<types>';
			foreach($list->GetCollection() as $d)
			{
				echo '	<door_type id="'.$d['Id'].'" name="'.$d['Name'].'" swf="'.$d['Swf'].'" />'."\r\n";
			}
			echo '</types>';
		}
		################### ROOM DOORS ###################
		if( $_GET['action'] == "get_room_doors" )
		{
			$where = '';
			if( !empty($_GET['type']) ) $where .= ' and d.IdType="'.$_GET['type'].'" ';
			$list = new DbList('select d.*, t.Name as Type, ( select Picture from room_doors_pics as p2 where p2.IdDoor=d.Id order by Id ASC limit 1 ) as Picture, ( select Count(Distinct p2.Id) from room_doors_pics as p2 where p2.IdDoor=d.Id ) as Variations from room_doors as d, room_doors_pics as p, room_doors_types as t where p.IdDoor=d.Id and t.Id=d.IdType '.$where.' group by d.Id order by d.Name ASC');
			echo '<?xml version="1.0" encoding="utf-8"?>
<doors>';
			foreach($list->GetCollection() as $d)
			{
				echo '	<door id="'.$d['Id'].'" name="'.$d['Name'].'" width="'.$d['W'].'" height="'.$d['H'].'" type="'.$d['Type'].'" typeid="'.$d['IdType'].'" variations="'.$d['Variations'].'">'.WEBSITE_URL."uploads/door_variation/".$d['Picture'].'</door>'."\r\n";
				echo '	<door id="'.$d['Id'].'" name="'.$d['Name'].'" width="'.$d['W'].'" height="'.$d['H'].'" type="'.$d['Type'].'" typeid="'.$d['IdType'].'" variations="'.$d['Variations'].'">'.WEBSITE_URL."uploads/door_variation/".$d['Picture'].'</door>'."\r\n";
				echo '	<door id="'.$d['Id'].'" name="'.$d['Name'].'" width="'.$d['W'].'" height="'.$d['H'].'" type="'.$d['Type'].'" typeid="'.$d['IdType'].'" variations="'.$d['Variations'].'">'.WEBSITE_URL."uploads/door_variation/".$d['Picture'].'</door>'."\r\n";
				echo '	<door id="'.$d['Id'].'" name="'.$d['Name'].'" width="'.$d['W'].'" height="'.$d['H'].'" type="'.$d['Type'].'" typeid="'.$d['IdType'].'" variations="'.$d['Variations'].'">'.WEBSITE_URL."uploads/door_variation/".$d['Picture'].'</door>'."\r\n";
				echo '	<door id="'.$d['Id'].'" name="'.$d['Name'].'" width="'.$d['W'].'" height="'.$d['H'].'" type="'.$d['Type'].'" typeid="'.$d['IdType'].'" variations="'.$d['Variations'].'">'.WEBSITE_URL."uploads/door_variation/".$d['Picture'].'</door>'."\r\n";
				echo '	<door id="'.$d['Id'].'" name="'.$d['Name'].'" width="'.$d['W'].'" height="'.$d['H'].'" type="'.$d['Type'].'" typeid="'.$d['IdType'].'" variations="'.$d['Variations'].'">'.WEBSITE_URL."uploads/door_variation/".$d['Picture'].'</door>'."\r\n";
				echo '	<door id="'.$d['Id'].'" name="'.$d['Name'].'" width="'.$d['W'].'" height="'.$d['H'].'" type="'.$d['Type'].'" typeid="'.$d['IdType'].'" variations="'.$d['Variations'].'">'.WEBSITE_URL."uploads/door_variation/".$d['Picture'].'</door>'."\r\n";
			}
			echo '</doors>';
		}
	}
	
	mysql_close();
	/////////////////////////////
?>