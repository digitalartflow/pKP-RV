<?
	$smarty = $_SESSION["smarty"];
	
	//afiseaza totul
	$thePage = $smarty->fetch( "pages/where-to.tpl" );
	$smarty->assign('thePage',$thePage);
?>