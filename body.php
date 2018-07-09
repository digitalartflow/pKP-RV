<?
	$pages = array
	(
	
		"home"						=> "pages/home.php",
		"products-list"						=> "pages/products-list.php",
		"where-to"					=> "pages/where-to.php",
		"choose-state"				=> "pages/choose-state.php",
		"product-type"				=> "pages/manufacture.php",
		"help"						=> "pages/help.php",
		"start-planning"			=> "pages/start-planning.php",
		"design-room"				=> "pages/design-room.php",
		"design-room2"				=> "pages/design-room2.php",
		"room-planner"				=> "pages/room-planner.php",
		"room-planner2"				=> "pages/room-planner.php",
		"checkout"					=> "pages/checkout.php",
		"checkout-succes"			=> "pages/checkout-success.php",
		"checkout-renders"			=> "pages/checkout-renders.php",
		
		###################### MY ACCOUNT ##############################
		################################################################
		
	);
	$pages_login = array
	(
	);
	if( array_key_exists( $page, $pages ) )
	{
		if( $pages[$page] != "" )
		{
			if( is_file( $pages[$page] ) )
			{
				if( ( !isset( $_SESSION['user_logat'] ) || empty( $_SESSION['user_logat'] ) ) && array_key_exists( $page, $pages_login ) )
				{
					Util::Redirect(WEBSITE_URL.'autentificare.html');
					die();
				}
				include ($pages[$page]);
			}
			else
				$smarty->assign('thePage',"<div class='warning'>" . "<br>THE PAGE IS UNDER MAINTAINANCE!<br><br>" . "</div>");
		}
		else
			$smarty->assign('thePage',"<div class='warning'>" . "<br>REQUESTED PAGE DOES NOT EXISTS!<br><br>" . "</div>");
	}
	else
	{
		//verifica daca nu cumva este o pagina editabila
		if(is_file('html_pages/'.$page.'.html'))
			$smarty->assign('thePage', implode(file('html_pages/'.$page.'.html')) );
		else
			$smarty->assign('thePage',"<div class='warning'>" . "<br>REQUESTED PAGE DOES NOT EXISTS!<br><br>" . "</div>");
	}
?>
