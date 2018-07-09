<?php

	$list = new DbList('select * from room_window_types order by name ASC');
	$types = array();
	foreach( $list as $l ){
		$types[$l['Id']] = $l;
	}
	$smarty->assign('types',$types);
	
	if( !empty( $_POST['action'] ) && $_POST['action'] == 'modify' )
	{
		$item = new DbRoomWindow($_POST['Id']);
		$item_id = $_POST['Id'] == -1 ? $item->getNextId() : $_POST['Id'];
		$item->fromArray($_POST,array('Id'));
		if( $_POST['Id'] == -1 )
			$item->CreateNew();
		else
			$item->Update();
			//print_r($item);
			//die();
			
		$found_pics = array();
			
		for( $i = 0; $i< count($_POST['dv_Id']); $i++ )
		{
			//if is editing a door, ignore the template of door variation
			if( $_POST['Id'] != -1 && $i == 0 )
			{
				continue;
			}
			$item = new DbRoomWindowPic($_POST['dv_Id'][$i]);
			$found_pics[] = $_POST['dv_Id'][$i] == -1 ? $item->getNextId() : $_POST['dv_Id'][$i];
			$item['IdWindow'] = $item_id;
			$item['Name'] = $_POST['dv_Name'][$i];
			if( !empty( $_FILES['dv_Picture']['name'][$i] ) )
			{
				$uploader = new image_uploader($_FILES['dv_Picture'],$config['server_path'].'uploads/window_variation/',false,$i);
				//$uploader->resize(640,480);
				if( $uploader->error === false )
				{
					if( $_POST['dv_Id'][$i] != -1 && is_file($config['server_path'].'uploads/window_variation/'.$item['Picture']) )
					{
						unlink($config['server_path'].'uploads/window_variation/'.$item['Picture']);
					}
					$item['Picture'] = $uploader->new_file_name;
				}
			}
			
			for( $j = 0; $j<4; $j++ )
			{
				$c = $j*90;
				if( !empty( $_FILES['dv_Render'.$c]['name'][$i] ) )
				{
					$uploader = new image_uploader($_FILES['dv_Render'.$c],$config['server_path'].'uploads/window_variation/',false,$i);
					//$uploader->resize(640,480);
					if( $uploader->error === false )
					{
						if( $_POST['dv_Id'][$i] != -1 && is_file($config['server_path'].'uploads/window_variation/'.$item['Render'.$c]) )
						{
							unlink($config['server_path'].'uploads/window_variation/'.$item['Render'.$c]);
						}
						$item['Render'.$c] = $uploader->new_file_name;
					}
					//else echo 'Error => '.$uploader->error.' => '.$config['server_path'].'uploads/door_variation/'.$uploader->new_file_name.'<br>';
				}
			}
			//print_r($item);
			if( $_POST['dv_Id'][$i] == -1 )
				$item->CreateNew();
			else
				$item->Update();
			
		}
		//delete any pic that is in the database but not in the $_POST
		//print_r($found_pics);
		if( $_POST['Id'] != -1 )
		{
			$list = new DbList('select Id from room_windows_pics where IdWindow = "'.$item_id.'"');
			foreach( $list as $dbPic )
			{
				if( !in_array($dbPic['Id'],$found_pics) )
				{
					$item = new DbRoomWindowPic( $dbPic['Id'] );
					$item->Delete();
				}
			}
		}
		//die();
		Util::Redirect($config['admin_url'].'?page='.$_GET['page'].( !empty( $_GET['pg'] ) ? '&pg='.$_GET['pg'] : '' ));
	}
	
	if( !empty( $_POST['action'] ) && $_POST['action'] == 'delete' )
	{
		$item = new DbRoomWindow($_POST['Id']);
		$item->Delete();
		Util::Redirect($config['admin_url'].'?page='.$_GET['page']);
	}
	
	
	$where = 'where r.IdType=t.Id';
	if( !empty( $_GET['expression'] ) ) $where .= ' and r.Name like "%'.str_replace(' ','%',$_GET['expression']).'%" ';
	if( !empty( $_GET['type'] ) ) $where .= ' and t.Id = "'.$_GET['type'].'" ';
	
	
	$list = new DbList('select count(distinct r.id) from room_windows r, room_window_types t '.$where);
	$nr = $list[0][0];
	
	$curpag = !empty( $_GET['pg'] ) ? $_GET['pg'] : 1;
	$per_page = 10;
	$fl = ($curpag-1)*$per_page;
	$smarty->assign('pagini',ceil($nr/$per_page));
	$smarty->assign('curpag',$curpag);
	
	$list = new DbList('select r.* from room_windows r, room_window_types t '.$where.' order by r.Id DESC limit '.$fl.','.$per_page);
	$items = array();
	foreach( $list as $l )
	{
		$l['Pics'] = new DbList('select * from room_windows_pics where IdWindow="'.$l['Id'].'" order by Id ASC');
		array_push($items,$l);
	}
	$smarty->assign('items',$items);
	$smarty->assign('linkwcp',Util::GetCurrentUrlWithoutKeys(array('pg')));
	
	$core['template'] = "room_windows.tpl";
?>