<?
	$smarty = $_SESSION["smarty"];
	
	//afiseaza totul
	$thePage = $smarty->fetch( "pages/checkout-success.tpl" );
	$smarty->assign('thePage',$thePage);
?>