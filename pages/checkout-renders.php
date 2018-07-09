<?
	$smarty = $_SESSION["smarty"];
	
	if( isset( $_SESSION['msg_login'] ) && !empty( $_SESSION['msg_login'] ) )
	{
		$smarty->assign('msg_login',$_SESSION['msg_login']);
		$_SESSION['msg_login'] = false;
	}
	
	if( !empty( $_POST['action'] ) && $_POST['action'] == "checkout" )
	{
		$item = new DbOrder();
		$item->set('IdUser', $_SESSION['logged']['Id']);
		$item->set('RoomDesign', json_encode($_SESSION['kitchen']['room_design']));
		$cart = array();
		foreach( $_POST as $k => $v )
			if( substr($k,0,6) == "Render" )
				array_push($cart,array('Corner'=>$k,'Render'=>$v));
		$item->set('ShoppingCart', json_encode($cart));
		$item->set('Total', $_POST['Total']);
		$item->set('Adress', $_POST['Adress']);
		$item->set('Phone', $_POST['Phone']);
		$item->set('ContactHours', $_POST['ContactHours']);
		$item->set('Date', date('Y-m-d H:i:s'));
		$item->CreateNew();
		Util::Redirect('checkout-succes.html');
		die();
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
			$list = new DbList('select uv.Id, uv.IdUnit, uv.PriceDiff, u.Name, u.Price from unit_variations as uv, units as u where uv.Id="'.$u.'" and uv.IdUnit=u.Id');
			$uv   = $list->Get(0);
			$item['Id'] 			= $uv['Id'];
			$item['Name'] 			= $uv['Name'];
			$item['Nr'] 			= $nr;
			$item['Price'] 			= $uv['Price']+$uv['PriceDiff'];	
			$list = new DbList('select * from units_handles where IdUnit="'.$uv['Id'].'" and IdHandle="'.$_SESSION['shoppingCart']['sd']['h'].'" limit 1');
			if( $list->Size() > 0 )
			{
				$uh = $list->Get(0);
				$item['Price'] += $uh['PriceDiff'];
			}
			$list = new DbList('select * from units_tops where IdUnit="'.$uv['Id'].'" and IdTop="'.$_SESSION['shoppingCart']['sd']['to'].'" limit 1');
			if( $list->Size() > 0 )
			{
				$ut = $list->Get(0);
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
	
	//afiseaza totul
	$thePage = $smarty->fetch( "pages/checkout-renders.tpl" );
	$smarty->assign('thePage',$thePage);
?>