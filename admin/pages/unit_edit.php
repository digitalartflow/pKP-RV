<?php
	
	if( !empty( $_POST['action'] ) && $_POST['action'] == 'modify' )
	{
		$item = new DbUnit($_POST['Id']);
		$item_id = $_POST['Id'] == -1 ? $item->getNextId() : $_POST['Id'];
		$item->fromArray($_POST,array('Id'));
		$item['Categories'] = '{'.implode('}{',$_POST['categs']).'}';
		$item['Regions'] = !empty( $_POST['Regions'] ) ? '{'.implode('}{',$_POST['Regions']).'}' : '';
		$item['IsFloating'] = !empty( $_POST['DistanceFromBottom'] ) ? 1 : 0;
		$item['HasAppliance'] = !empty( $_POST['HasAppliance'] ) ? $_POST['HasAppliance'] : 'no';
		$item['HasWorktop'] = !empty( $_POST['HasWorktop'] ) ? $_POST['HasWorktop'] : 'no';
		if( !empty( $_FILES['Swf2D']['name'] ) )
		{
			$uploader = new image_uploader($_FILES['Swf2D'],$config['server_path'].'uploads/swf_2d/',false,false,array('swf'));
			//$uploader->resize(640,480);
			if( $uploader->error === false )
			{
				if( $_POST['Id'] != -1 && is_file($config['server_path'].'uploads/swf_2d/'.$item['Swf2D']) )
				{
					unlink($config['server_path'].'uploads/swf_2d/'.$item['Swf2D']);
				}
				$item['Swf2D'] = $uploader->new_file_name;
			}
		}
		if( $_POST['Id'] == -1 )
			$item->CreateNew();
		else
			$item->Update();
		//die();
		Util::Redirect($config['admin_url'].'?page='.$_GET['page'].'&id='.$item_id);
	}
	
	if( !empty( $_POST['action'] ) && $_POST['action'] == 'delete' )
	{
		$item = new DbUnit($_POST['Id']);
		$item->Delete();
		Util::Redirect($config['admin_url'].'?page='.$_GET['page']);
	}
	
	if( !empty( $_POST['action'] ) && $_POST['action'] == 'modify_handle' )
	{
		$item = new DbUnitHandle($_POST['Id']);
		$item_id = $_POST['Id'] == -1 ? $item->getNextId() : $_POST['Id'];
		$item->fromArray($_POST,array('Id'));
		for( $j = 0; $j<4; $j++ )
		{
			$c = $j*90;
			if( !empty( $_FILES['dv_Render'.$c]['name'] ) )
			{
				$uploader = new image_uploader($_FILES['dv_Render'.$c],$config['server_path'].'uploads/unit_handles/');
				//$uploader->resize(640,480);
				if( $uploader->error === false )
				{
					if( is_file($config['server_path'].'uploads/unit_handles/'.$item['Image'.$c]) )
					{
						unlink($config['server_path'].'uploads/unit_handles/'.$item['Image'.$c]);
					}
					$item['Image'.$c] = $uploader->new_file_name;
				}
				//else echo 'Error => '.$uploader->error.' => '.$config['server_path'].'uploads/door_variation/'.$uploader->new_file_name.'<br>';
			}
		}
		if( $_POST['Id'] == -1 )
			$item->CreateNew();
		else
			$item->Update();
		//die();
		Util::Redirect($config['admin_url'].'?page='.$_GET['page'].'&id='.$item['IdUnit']);
	}
	
	if( !empty( $_POST['action'] ) && $_POST['action'] == 'delete_handle' )
	{
		$item = new DbUnitHandle($_POST['Id']);
		$item->Delete();
		Util::Redirect($config['admin_url'].'?page='.$_GET['page'].'&id='.$_GET['id']);
	}
	
	if( !empty( $_POST['action'] ) && $_POST['action'] == 'modify_top' )
	{
		$item = new DbUnitTop($_POST['Id']);
		$item_id = $_POST['Id'] == -1 ? $item->getNextId() : $_POST['Id'];
		$item->fromArray($_POST,array('Id'));
		for( $j = 0; $j<4; $j++ )
		{
			$c = $j*90;
			if( !empty( $_FILES['dv_Render'.$c]['name'] ) )
			{
				$uploader = new image_uploader($_FILES['dv_Render'.$c],$config['server_path'].'uploads/unit_tops/');
				//$uploader->resize(640,480);
				if( $uploader->error === false )
				{
					if( is_file($config['server_path'].'uploads/unit_tops/'.$item['Image'.$c]) )
					{
						unlink($config['server_path'].'uploads/unit_tops/'.$item['Image'.$c]);
					}
					$item['Image'.$c] = $uploader->new_file_name;
				}
				//else echo 'Error => '.$uploader->error.' => '.$config['server_path'].'uploads/door_variation/'.$uploader->new_file_name.'<br>';
			}
		}
		if( $_POST['Id'] == -1 )
			$item->CreateNew();
		else
			$item->Update();
		//die();
		Util::Redirect($config['admin_url'].'?page='.$_GET['page'].'&id='.$item['IdUnit']);
	}
	
	if( !empty( $_POST['action'] ) && $_POST['action'] == 'delete_top' )
	{
		$item = new DbUnitTop($_POST['Id']);
		$item->Delete();
		Util::Redirect($config['admin_url'].'?page='.$_GET['page'].'&id='.$_GET['id']);
	}
	
	if( !empty( $_POST['action'] ) && $_POST['action'] == 'modify_variation' )
	{
		$item = new DbUnitVariation($_POST['Id']);
		$item_id = $_POST['Id'] == -1 ? $item->getNextId() : $_POST['Id'];
		$item->fromArray($_POST,array('Id'));
		for( $j = 0; $j<4; $j++ )
		{
			$c = $j*90;
			if( !empty( $_FILES['dv_Render'.$c]['name'] ) )
			{
				$uploader = new image_uploader($_FILES['dv_Render'.$c],$config['server_path'].'uploads/unit_variations/');
				//$uploader->resize(640,480);
				if( $uploader->error === false )
				{
					if( is_file($config['server_path'].'uploads/unit_variations/'.$item['Image'.$c]) )
					{
						unlink($config['server_path'].'uploads/unit_variations/'.$item['Image'.$c]);
					}
					$item['Image'.$c] = $uploader->new_file_name;
				}
				//else echo 'Error => '.$uploader->error.' => '.$config['server_path'].'uploads/door_variation/'.$uploader->new_file_name.'<br>';
			}
		}
		if( $_POST['Id'] == -1 )
			$item->CreateNew();
		else
			$item->Update();
		//die();
		Util::Redirect($config['admin_url'].'?page='.$_GET['page'].'&id='.$item['IdUnit']);
	}
	
	if( !empty( $_POST['action'] ) && $_POST['action'] == 'delete_variation' )
	{
		$item = new DbUnitVariation($_POST['Id']);
		$item->Delete();
		Util::Redirect($config['admin_url'].'?page='.$_GET['page'].'&id='.$_GET['id']);
	}
	
	
	
	$handles_categories = new DbList('select * from latches order by Name ASC');
	$smarty->assign('handles_categories',$handles_categories);
	
	$manufacturers = new DbList('select * from manufacturers order by Name ASC');
	$smarty->assign('manufacturers',$manufacturers);
	
	$tops_categories = new DbList('select * from tops order by Name ASC');
	$smarty->assign('tops_categories',$tops_categories);
	
	$doors_categories = new DbList('select * from unit_doors order by Name ASC');
	$smarty->assign('doors_categories',$doors_categories);
	
	$carcasses_categories = new DbList('select * from carcasses order by Name ASC');
	$smarty->assign('carcasses_categories',$carcasses_categories);
	
	$textures_categories = new DbList('select * from textures order by Name ASC');
	$smarty->assign('textures_categories',$textures_categories);
	
	$list = new DbList('select * from units where id="'.@$_GET['id'].'" limit 1');
	$item = count( $list ) > 0 ? $list[0] : null;
	$smarty->assign('item',$item);
	if( !is_null( $item ) )
	{
		$item_categories = Util::search($item['Categories'],'{','}');
		
		$handles = new DbList('select * from units_handles where IdUnit="'.$item['Id'].'"');
		$smarty->assign('handles',$handles);
		
		$tops = new DbList('select * from units_tops where IdUnit="'.$item['Id'].'"');
		$smarty->assign('tops',$tops);
		
		$variations = new DbList('select * from unit_variations where IdUnit="'.$item['Id'].'"');
		$smarty->assign('variations',$variations);
			
	}
	
	
	$states = new DbList('select * from states order by name ASC');
	$smarty->assign('states',$states);
	
	$states_regions = new DbList('select * from states_regions order by Id DESC');
	if( !empty( $item['Regions'] ) ){
		$item['Regions'] = Util::search($item['Regions'],'{','}');
	}else $item['Regions'] = array();
	foreach( $states_regions as &$sr ){
		if( in_array($sr['Id'], $item['Regions']) ) $sr['checked'] = true;
		else  $sr['checked'] = false;
	}
	//print_r($states_regions);
	$smarty->assign('states_regions',$states_regions);
	
	
	$list = new DbList('select * from units_categories order by IdParent ASC, Name ASC');
	$categs = array();
	foreach( $list as $categ )
	{
		$categ['checked'] = false;
		if( isset( $item_categories ) && in_array($categ['Id'],$item_categories) ) $categ['checked'] = true;
		if( $categ['IdParent'] == 0 ) $categs[$categ['Id']] = array_merge($categ,array('categs'=>array()));
		else $categs[$categ['IdParent']]['categs'][] = $categ;
	}
	$smarty->assign('categs',$categs);
	
	$core['template'] = "unit_edit.tpl";
?>