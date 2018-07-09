<?php

	$list = new DbList('select * from room_doors_types order by name ASC');
	$types = array();
	foreach( $list as $l ){
		$types[$l['Id']] = $l;
	}
	$smarty->assign('types',$types);
	
	if( !empty( $_POST['action'] ) && $_POST['action'] == 'modify' )
	{
		$item = new DbHtmlPage($_POST['Id']);
		$item_id = $_POST['Id'] == -1 ? $item->getNextId() : $_POST['Id'];
		$item->fromArray($_POST,array('Id'));
		$item['Zone'] = 'help';
		if( $_POST['Id'] == -1 ) $item['Link'] = $item_id.'_help.html';
		file_put_contents($config['server_path'].'html_pages/'.$item['Link'],$_POST['Content']);		
		if( $_POST['Id'] == -1 )
			$item->CreateNew();
		else
			$item->Update();
		//die();
		Util::Redirect($config['admin_url'].'?page='.$_GET['page'].( !empty( $_GET['pg'] ) ? '&pg='.$_GET['pg'] : '' ));
	}
	
	if( !empty( $_POST['action'] ) && $_POST['action'] == 'delete' )
	{
		$item = new DbHtmlPage($_POST['Id']);
		$item->Delete();
		Util::Redirect($config['admin_url'].'?page='.$_GET['page']);
	}
	
	
	$where = 'where 1=1';
	if( !empty( $_GET['expression'] ) ) $where .= ' and Name like "%'.str_replace(' ','%',$_GET['expression']).'%" ';
	
	
	$list = new DbList('select count(distinct id) from html_pages '.$where);
	$nr = $list[0][0];
	
	$curpag = !empty( $_GET['pg'] ) ? $_GET['pg'] : 1;
	$per_page = 20;
	$fl = ($curpag-1)*$per_page;
	$smarty->assign('pagini',ceil($nr/$per_page));
	$smarty->assign('curpag',$curpag);
	
	$list = new DbList('select * from html_pages '.$where.' order by `Order` ASC limit '.$fl.','.$per_page);
	$items = $list;
	foreach( $items as &$item )
	{
		$item['Content'] = @file_get_contents($config['server_path'].'html_pages/'.$item['Link']);
	}
	$smarty->assign('items',$items);
	$smarty->assign('linkwcp',Util::GetCurrentUrlWithoutKeys(array('pg')));
	
	$core['template'] = "help_pages.tpl";
?>