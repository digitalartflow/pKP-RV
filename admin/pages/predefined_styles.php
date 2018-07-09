<?php
	
	$manufacturers = new DbList('select * from manufacturers order by Name ASC');
	$smarty->assign('manufacturers',$manufacturers);
	
	$states = new DbList('select * from states order by name ASC');
	$smarty->assign('states',$states);
	
	$states_regions = new DbList('select * from states_regions order by Id DESC');
	$smarty->assign('states_regions',$states_regions);

	$handles_categories = new DbList('select * from latches order by Name ASC');
	$smarty->assign('handles_categories',$handles_categories);
	
	$furniture_types = new DbList('select * from manufacturers order by Name ASC');
	$smarty->assign('furniture_types',$furniture_types);
	
	$tops_categories = new DbList('select * from tops order by Name ASC');
	$smarty->assign('tops_categories',$tops_categories);
	
	$doors_categories = new DbList('select * from unit_doors order by Name ASC');
	$smarty->assign('doors_categories',$doors_categories);
	
	$carcasses_categories = new DbList('select * from carcasses order by Name ASC');
	$smarty->assign('carcasses_categories',$carcasses_categories);
	
	$textures_categories = new DbList('select * from textures order by Name ASC');
	$smarty->assign('textures_categories',$textures_categories);
	
	$ps_made_material = new DbList('select * from ps_made_material order by Name ASC');
	$smarty->assign('ps_made_material',$ps_made_material);
	
	$ps_style = new DbList('select * from ps_style order by Name ASC');
	$smarty->assign('ps_style',$ps_style);
	
	if( !empty( $_POST['action'] ) && $_POST['action'] == 'modify' )
	{
		$item = new DbPredefinedStyle($_POST['Id']);
		$item_id = $_POST['Id'] == -1 ? $item->getNextId() : $_POST['Id'];
		$item->fromArray($_POST,array('Id'));	
		$item['Regions'] = !empty( $_POST['Regions'] ) ? '{'.implode('}{',$_POST['Regions']).'}' : '';
		$item['doors'] 				= '{'.@implode('}{',$_POST['doors']).'}';
		$item['handles'] 			= '{'.@implode('}{',$_POST['handles']).'}';
		$item['carcasses'] 			= '{'.@implode('}{',$_POST['carcasses']).'}';
		$item['textures'] 			= '{'.@implode('}{',$_POST['textures']).'}';
		$item['top_textures'] 		= '{'.@implode('}{',$_POST['top_textures']).'}';
		$item['furniture_types'] 	= '{'.@implode('}{',$_POST['furniture_types']).'}';
		$item['made_materials'] 	= '{'.@implode('}{',$_POST['made_materials']).'}';
		$item['styles'] 	= '{'.@implode('}{',$_POST['styles']).'}';
		$item['default'] 			= !empty( $_POST['default'] ) ? 1 : 0;
		if( !empty( $item['default'] ) ){
			DbList::ExecNoneQuery('update predefined_styles set `default`=0 where `default`=1');
		}
		if( !empty( $_FILES['picture']['name'] ) )
		{
			$uploader = new image_uploader($_FILES['picture'],$config['server_path'].'uploads/predefined_styles/original/');
			$uploader->cropfill(180,180,$config['server_path'].'uploads/predefined_styles/small/'.$uploader->new_file_name);
			if( $uploader->error === false )
			{
				if( is_file($config['server_path'].'uploads/predefined_styles/original/'.$item['pic']) )
					unlink($config['server_path'].'uploads/predefined_styles/original/'.$item['pic']);
				if( is_file($config['server_path'].'uploads/predefined_styles/small/'.$item['pic']) )
					unlink($config['server_path'].'uploads/predefined_styles/small/'.$item['pic']);
				$item['pic'] = $uploader->new_file_name;
			}
			//else echo 'Error => '.$uploader->error.' => '.$config['server_path'].'uploads/door_variation/'.$uploader->new_file_name.'<br>';
		}
		if( $_POST['Id'] == -1 )
			$item->CreateNew();
		else
			$item->Update();
		//die();
		Util::Redirect($config['admin_url'].'?page='.$_GET['page'].( !empty( $_GET['pg'] ) ? '&pg='.$_GET['pg'] : '' ));
	}
	
	if( !empty( $_POST['action'] ) && $_POST['action'] == 'delete' )
	{
		$item = new DbPredefinedStyle($_POST['Id']);
		$item->Delete();
		Util::Redirect($config['admin_url'].'?page='.$_GET['page']);
	}
	
	
	$where = 'where 1=1';
	if( !empty( $_GET['expression'] ) ) $where .= ' and name like "%'.str_replace(' ','%',$_GET['expression']).'%" ';
	
	
	$list = new DbList('select count(distinct Id) from predefined_styles '.$where);
	$nr = $list[0][0];
	
	$curpag = !empty( $_GET['pg'] ) ? $_GET['pg'] : 1;
	$per_page = 20;
	$fl = ($curpag-1)*$per_page;
	$smarty->assign('pagini',ceil($nr/$per_page));
	$smarty->assign('curpag',$curpag);
	
	$list = new DbList('select * from predefined_styles '.$where.' order by `default` DESC, price_order ASC, `Id` DESC limit '.$fl.','.$per_page);
	$items = $list;
	foreach( $items as &$item )
	{
		$item['made_materials'] = Util::search($item['made_materials'],'{','}');
		$item['styles'] = Util::search($item['styles'],'{','}');
		$item['doors'] = Util::search($item['doors'],'{','}');
		$item['handles'] = Util::search($item['handles'],'{','}');
		$item['carcasses'] = Util::search($item['carcasses'],'{','}');
		$item['textures'] = Util::search($item['textures'],'{','}');
		$item['top_textures'] = Util::search($item['top_textures'],'{','}');
		$item['furniture_types'] = Util::search($item['furniture_types'],'{','}');
		$item['Regions'] = Util::search($item['Regions'],'{','}');
	}
	$smarty->assign('items',$items);
	$smarty->assign('linkwcp',Util::GetCurrentUrlWithoutKeys(array('pg')));
	
	$core['template'] = "predefined_styles.tpl";
?>