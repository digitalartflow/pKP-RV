<?
	$smarty = $_SESSION["smarty"];
	if( !isset( $_SESSION['state_postalcode'] ) ) $_SESSION['state_postalcode'] = array();
	
	$list = new DbList('select * from html_pages where Zone="help" order by `Order` ASC');
	$smarty->assign('pages',$list->GetCollection());
	
	if( !empty( $_POST['action'] ) && $_POST['action'] =='choose_state' ){
		$errors = '';
		if( !empty( $_POST['state'] ) ){
			//$_SESSION['state_postalcode']['State'] = $_POST['state'];
		}else{
			$errors .= 'Please choose a state!\r\n';
		}
		if( !empty( $_POST['postal_code'] ) ){
			//$_SESSION['state_postalcode']['PostalCode'] = $_POST['postal_code'];
		}else{
			$errors .= 'Please insert postal code!\r\n';
		}
		
		//check if state exists
		if( $errors == '' ){
			$state = new DbList('select * from states where id="'.(int) $_POST['state'].'"');
			$state = $state->GetCollection();
			if( count( $state ) <= 0 ){
				$errors .= 'Selected state does not exists in the database!';
			}
		}
		//check if postal code is in state
		
		if( $errors == '' ){
			$state_region = new DbList('select * from states_regions where min<= '.(int) $_POST['postal_code'].' and max>='.(int) $_POST['postal_code'].' ');
			$state_region = $state_region->GetCollection();
			if( count($state_region) <= 0 ){
				$errors .= 'Postal code you have inserted is not in the selected state!';
			}else{
				$found = false;
				foreach( $state_region as $region){
					if( $region['id_state'] == (int) $_POST['state'] ) $found = true;
				}
				if( !$found ){
					$errors .= 'Postal code you have inserted is not in the selected state!';
				}
			}
		}
		if( $errors != '' ){
			$smarty->assign('errors',$errors);
		}else{
			$_SESSION['state_postalcode']['State'] = $_POST['state'];
			$_SESSION['state_postalcode']['PostalCode'] = $_POST['postal_code'];
			Util::Redirect('product-type.html');
		}
	}
	
	//afiseaza totul
	$thePage = $smarty->fetch( "pages/choose-state.tpl" );
	$smarty->assign('thePage',$thePage);
?>