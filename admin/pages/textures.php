<?php

	$list = new DbList('select * from manufacturers order by Name ASC');
	$manufacturers = array();
	foreach( $list as $l ){
		$manufacturers[$l['Id']] = $l;
	}
	$smarty->assign('manufacturers',$manufacturers);
	
	if( !empty( $_POST['action'] ) && $_POST['action'] == 'modify' )
	{
		$item = new DbTexture($_POST['Id']);
		$item_id = $_POST['Id'] == -1 ? $item->getNextId() : $_POST['Id'];
		$item->fromArray($_POST,array('Id'));
		$item['Manufacturers'] = '{'.implode($_POST['Manufacturers'],'}{').'}';
		if( !empty( $_FILES['Picture']['name'] ) )
		{
			$uploader = new image_uploader($_FILES['Picture'],$config['server_path'].'uploads/textures/');
			//$uploader->resize(640,480);
			if( $uploader->error === false )
			{
				if( $_POST['Id'] != -1 && is_file($config['server_path'].'uploads/textures/'.$item['Picture']) )
				{
					unlink($config['server_path'].'uploads/textures/'.$item['Picture']);
				}
				$item['Picture'] = $uploader->new_file_name;
			}
		}
		if( $_POST['Id'] == -1 )
			$item->CreateNew();
		else
			$item->Update();
		Util::Redirect($config['admin_url'].'?page='.$_GET['page'].( !empty( $_GET['pg'] ) ? '&pg='.$_GET['pg'] : '' ));
	}
	
	if( !empty( $_POST['action'] ) && $_POST['action'] == 'delete' )
	{
		$item = new DbTexture($_POST['Id']);
		$item->Delete();
		Util::Redirect($config['admin_url'].'?page='.$_GET['page']);
	}
	
	
	$where = 'where 1=1';
	if( !empty( $_GET['expression'] ) ) $where .= ' and Name like "%'.str_replace(' ','%',$_GET['expression']).'%" ';
	if( !empty( $_GET['manufacturer'] ) ) $where .= ' and Manufacturers like "%{'.$_GET['manufacturer'].'}%" ';
	
	
	$list = new DbList('select count(distinct id) from textures '.$where);
	$nr = $list[0][0];
	
	$curpag = !empty( $_GET['pg'] ) ? $_GET['pg'] : 1;
	$per_page = 10;
	$fl = ($curpag-1)*$per_page;
	$smarty->assign('pagini',ceil($nr/$per_page));
	$smarty->assign('curpag',$curpag);
	
	$list = new DbList('select * from textures '.$where.' order by Id DESC limit '.$fl.','.$per_page);
	$items = array();
	foreach( $list as $l )
	{
		$m = Util::cauta($l['Manufacturers'],'{','}');
		$l['Manufacturers'] = array();
		foreach( $manufacturers as $k => $man )
		{
			if( in_array($k,$m) )
			{
				$l['Manufacturers'][$k] = $man;
			}
		}
		array_push($items,$l);
	}
	$smarty->assign('items',$items);
	$smarty->assign('linkwcp',Util::GetCurrentUrlWithoutKeys(array('pg')));
	
	$core['template'] = "textures.tpl";
?>