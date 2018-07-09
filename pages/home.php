<?
	header('Location: '.WEBSITE_URL.'where-to.html');
die();
	$smarty = $_SESSION["smarty"];
	
	//afiseaza totul
	$thePage = $smarty->fetch( "pages/home.tpl" );
	$smarty->assign('thePage',$thePage);
?>