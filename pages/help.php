<?
	$smarty = $_SESSION["smarty"];
	
	$list = new DbList('select * from html_pages where Zone="help" order by `Order` ASC');
	//print_r($list->GetCollection());
	$smarty->assign('pages',$list->GetCollection());
	
	//afiseaza totul
	$thePage = $smarty->fetch( "pages/help.tpl" );
	$smarty->assign('thePage',$thePage);
?>