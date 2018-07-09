<?
	$smarty = $_SESSION["smarty"];
	
	$list = new DbList('select * from states order by Name ASC');
	$smarty->assign('states',$list->GetCollection());
	
	if( isset( $_SESSION['msg_login'] ) && !empty( $_SESSION['msg_login'] ) )
	{
		$smarty->assign('msg_login',$_SESSION['msg_login']);
		$_SESSION['msg_login'] = false;
	}
	
	if( !empty( $_POST['action'] ) && $_POST['action'] == "login" )
	{
		$list = new DbList('select * from users where Email="'.$_POST['Email'].'" and Password="'.$_POST['Password'].'"');
		if( $list->Size() > 0 )
		{
			$_SESSION['logged'] = $list->Get(0);
		}
		$_SESSION['msg_login'] = 'Email and/or password incorect!';
		Util::Redirect('checkout.html');
		die();
	}
	
	$total = 0;
	$items = array();
	if( !empty( $_SESSION['shoppingCart']['u'] ) )
		foreach( $_SESSION['shoppingCart']['u'] as $u => $nr )
		{
			$item = array();
			$list = new DbList('select uv.Id, uv.IdUnit, uv.Code, uv.PriceDiff, u.Name, u.Price from unit_variations as uv, units as u where uv.Id="'.$u.'" and uv.IdUnit=u.Id');
			$uv   = $list->Get(0);
			$item['Id'] 			= $uv['Id'];
			$item['Name'] 			= $uv['Name'];
			$item['Code'] 			= $uv['Code'];
			$item['Nr'] 			= $nr;
			$item['Price'] 			= $uv['Price']+$uv['PriceDiff'];
			$item['Numbers'] = isset( $_SESSION['shoppingCart']['u_nr'][$u] ) ?$_SESSION['shoppingCart']['u_nr'][$u] : array();
			$list = new DbList('select * from units_handles where IdUnit="'.$uv['IdUnit'].'" and IdHandle="'.$_SESSION['shoppingCart']['sd']['h'].'" limit 1');
			if( $list->Size() > 0 )
			{
				$uh = $list->Get(0);
				$item['Price'] += $uh['PriceDiff'];
			}
			$list = new DbList('select * from units_tops where IdUnit="'.$uv['IdUnit'].'" and IdTop="'.$_SESSION['shoppingCart']['sd']['to'].'" limit 1');
			if( $list->Size() > 0 )
			{
				$ut = $list->Get(0);
				$item['IdTop'] = $ut['Id'];
				$item['Price'] += $ut['PriceDiff'];
			}
			$item['TotalPrice'] 	= $item['Price']*$nr;
			$total					+= $item['TotalPrice'];
			array_push($items,$item);
		}
	if( isset( $_SESSION['shoppingCart']['renders'] ) && !empty( $_SESSION['shoppingCart']['renders'] ) )
		foreach( $_SESSION['shoppingCart']['renders'] as $corner )
		{
			$smarty->assign('corner_'.$corner,'true');		
			$total += 20;
		}
	$smarty->assign('items',$items);
	$smarty->assign('total',$total);
	$smarty->assign('flashRenders',$_SESSION['flashRenders']);
	/*echo "<pre>";
	print_r($_SESSION);
	echo "<pre>";*/
	
	
	
	if( !empty( $_POST['action'] ) && $_POST['action'] == "checkout" )
	{
		$tpl = $smarty->fetch( "emails/order.tpl" );
		//print_r($_SESSION['logged']);
		//echo $tpl;
		$header = "From: ".WEBSITE_NOREPLY_EMAIL."\r\n"; 
		$header.= "MIME-Version: 1.0\r\n"; 
		$header.= "Content-Type: text/html; charset=utf-8\r\n"; 
		$header.= "X-Priority: 1\r\n"; 
		$msg = $tpl;
		//die();
		//mail($_SESSION['logged']['Email'],'Order information',$msg,$header);
		//mail(WEBSITE_CONTACT_EMAIL,'Order information',$msg,$header);
		
		$item = new DbOrder();
		$nid = $item->getNextId();
		$item->set('IdUser', $_SESSION['logged']['Id']);
		$item->set('RoomDesign', json_encode($_SESSION['kitchen']['room_design']));
		$item->set('ShoppingCart', json_encode($_SESSION['shoppingCart']));
		$item->set('Total', $_POST['Total']);
		$item->set('Adress', $_POST['Adress']);
		$item->set('Phone', $_POST['Phone']);
		$item->set('ContactHours', $_POST['ContactHours']);
		$item->set('Date', date('Y-m-d H:i:s'));
		$item->CreateNew();
		//echo $tpl;
		//die();
		mail($_SESSION['logged']['Email'],'Order information',$msg,$header);
		mail((string) WEBSITE_CONTACT_EMAIL,'New order',$msg,$header);
		Util::Redirect('checkout-succes.html');
		die();
	}
	
	//afiseaza totul
	$thePage = $smarty->fetch( "pages/checkout.tpl" );
	$smarty->assign('thePage',$thePage);
?>