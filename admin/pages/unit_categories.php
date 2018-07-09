<?php

	$list = new DbList('select * from units_categories where IdParent=0 order by name ASC');
	$pcategs = array();
	foreach( $list as $l ){
		$pcategs[$l['Id']] = $l;
	}
	$smarty->assign('pcategs',$pcategs);

	$list = new DbList('select * from manufacturers order by Name ASC');
	$furnituretypes = array();
	foreach( $list as $l ){
		$furnituretypes[$l['Id']] = $l;
	}
	$smarty->assign('furnituretypes',$furnituretypes);
	
	if( !empty( $_POST['action'] ) && $_POST['action'] == 'modify' )
	{
		$item = new DbUnitCategory($_POST['Id']);
		$item_id = $_POST['Id'] == -1 ? $item->getNextId() : $_POST['Id'];
		$item->fromArray($_POST,array('Id'));	
		if( $_POST['Id'] == -1 )
			$item->CreateNew();
		else
			$item->Update();
		//die();
		Util::Redirect($config['admin_url'].'?page='.$_GET['page'].( !empty( $_GET['pg'] ) ? '&pg='.$_GET['pg'] : '' ));
	}
	
	if( !empty( $_POST['action'] ) && $_POST['action'] == 'delete' )
	{
		$item = new DbUnitCategory($_POST['Id']);
		$item->Delete();
		Util::Redirect($config['admin_url'].'?page='.$_GET['page']);
	}
	
	
	$where = 'where 1=1';
	if( !empty( $_GET['expression'] ) ) $where .= ' and Name like "%'.str_replace(' ','%',$_GET['expression']).'%" ';
	
	
	$list = new DbList('select count(distinct id) from units_categories '.$where);
	$nr = $list[0][0];
	
	$curpag = !empty( $_GET['pg'] ) ? $_GET['pg'] : 1;
	$per_page = 20;
	$fl = ($curpag-1)*$per_page;
	$smarty->assign('pagini',ceil($nr/$per_page));
	$smarty->assign('curpag',$curpag);
	
	$list = new DbList('select * from units_categories '.$where.' order by `Id` ASC limit '.$fl.','.$per_page);
	$items = $list;
	foreach( $items as &$item )
	{
		$item['Parent'] = @$pcategs[$item['IdParent']]['Name'];
		$item['FurnitureType'] = @$furnituretypes[$item['IdFurnitureType']]['Name'];
	}
	$smarty->assign('items',$items);
	$smarty->assign('linkwcp',Util::GetCurrentUrlWithoutKeys(array('pg')));
	
	$core['template'] = "unit_categories.tpl";
?>