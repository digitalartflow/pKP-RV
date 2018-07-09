<?
	$smarty = $_SESSION["smarty"];
	
	if( isset( $_GET['type'] ) ){
		$_SESSION['ftype'] = $_GET['type'];
	}
	
	$list = new DbList('select * from html_pages where Zone="help" order by `Order` ASC');
	$smarty->assign('pages',$list->GetCollection());
	
	//afiseaza totul
	$thePage = $smarty->fetch( "pages/start-planning.tpl" );
	$smarty->assign('thePage',$thePage);
?>