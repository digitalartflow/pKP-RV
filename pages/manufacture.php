<?
	$smarty = $_SESSION["smarty"];
	
	
	$list = new DbList('select * from html_pages where Zone="help" order by `Order` ASC');
	$smarty->assign('pages',$list->GetCollection());
	
	$list = new DbList('select * from manufacturers  order by Name ASC');
	$types = $list->GetCollection();
	//print_r($types);
	$smarty->assign('types',$types);
	
	//afiseaza totul
	$thePage = $smarty->fetch( "pages/manufacture.tpl" );
	$smarty->assign('thePage',$thePage);
?>