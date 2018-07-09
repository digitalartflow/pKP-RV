<?php
	if( !empty( $_POST['action'] ) && $_POST['action'] == 'delete' )
	{
		$item = new DbUnit($_POST['Id']);
		$item->Delete();
		Util::Redirect($config['admin_url'].'?page='.$_GET['page']);
	}
	
	
	$where = 'where 1=1';
	if( !empty( $_GET['expression'] ) ) $where .= ' and Name like "%'.str_replace(' ','%',$_GET['expression']).'%" ';
	
	
	$list = new DbList('select count(distinct id) from units '.$where);
	$nr = $list[0][0];
	
	$curpag = !empty( $_GET['pg'] ) ? $_GET['pg'] : 1;
	$per_page = 20;
	$fl = ($curpag-1)*$per_page;
	$smarty->assign('pagini',ceil($nr/$per_page));
	$smarty->assign('curpag',$curpag);
	
	$list = new DbList('select * from units '.$where.' order by `Name` ASC limit '.$fl.','.$per_page);
	$items = $list;
	$smarty->assign('items',$items);
	$smarty->assign('linkwcp',Util::GetCurrentUrlWithoutKeys(array('pg')));
	
	$core['template'] = "units.tpl";
?>