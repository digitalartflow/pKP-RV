<?php
	
	if( !empty( $_POST['action'] ) && $_POST['action'] == 'modify' )
	{
		$item = new DbPsMadeMaterial($_POST['Id']);
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
		$item = new DbPsMadeMaterial($_POST['Id']);
		$item->Delete();
		Util::Redirect($config['admin_url'].'?page='.$_GET['page']);
	}
	
	
	$where = 'where 1=1';
	if( !empty( $_GET['expression'] ) ) $where .= ' and name like "%'.str_replace(' ','%',$_GET['expression']).'%" ';
	
	
	$list = new DbList('select count(distinct Id) from ps_made_material '.$where);
	$nr = $list[0][0];
	
	$curpag = !empty( $_GET['pg'] ) ? $_GET['pg'] : 1;
	$per_page = 20;
	$fl = ($curpag-1)*$per_page;
	$smarty->assign('pagini',ceil($nr/$per_page));
	$smarty->assign('curpag',$curpag);
	
	$list = new DbList('select * from ps_made_material order by `name` ASC limit '.$fl.','.$per_page);
	$items = $list;
	$smarty->assign('items',$items);
	$smarty->assign('linkwcp',Util::GetCurrentUrlWithoutKeys(array('pg')));
	
	$core['template'] = "ps_made_materials.tpl";
?>