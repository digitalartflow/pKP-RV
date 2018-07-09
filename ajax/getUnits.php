<?php
	error_reporting(E_ALL);//initialize error reporting to show all errors
	ini_set('upload_max_filesize','4M');
	ini_set('display_errors', '1');//set to show error
	session_start();//start the session
	include ("../includes.php");//include includes.php
	########################## CONFIGURE SMARTY #################################
	$smarty                  = new Smarty();
	$smarty->left_delimiter  = "{{";
	$smarty->right_delimiter = "}}";
	$_SESSION["smarty"]      = $smarty;
	$smarty->template_dir    = "templates/";
	$smarty->compile_dir     = "templates_c/";
	#############################################################################
	
	$start = time();
	//connect to the database
	mysql_connect  ( DB_HOST, DB_USER, DB_PASS ) or die ( "EROARE LA CONEXIUNE".mysql_error() );
	mysql_select_db( DB_DATABASE );
	/////////////////////////
	CleanPostAndGet();
	
	function array2json($arr) {
		if(function_exists('json_encode')) return json_encode($arr); //Lastest versions of PHP already has this functionality.
		$parts = array();
		$is_list = false;
	
		//Find out if the given array is a numerical array
		$keys = array_keys($arr);
		$max_length = count($arr)-1;
		if(($keys[0] == 0) and ($keys[$max_length] == $max_length)) {//See if the first key is 0 and last key is length - 1
			$is_list = true;
			for($i=0; $i<count($keys); $i++) { //See if each key correspondes to its position
				if($i != $keys[$i]) { //A key fails at position check.
					$is_list = false; //It is an associative array.
					break;
				}
			}
		}
	
		foreach($arr as $key=>$value) {
			if(is_array($value)) { //Custom handling for arrays
				if($is_list) $parts[] = array2json($value); /* :RECURSION: */
				else $parts[] = '"' . $key . '":' . array2json($value); /* :RECURSION: */
			} else {
				$str = '';
				if(!$is_list) $str = '"' . $key . '":';
	
				//Custom handling for multiple data types
				if(is_numeric($value)) $str .= $value; //Numbers
				elseif($value === false) $str .= 'false'; //The booleans
				elseif($value === true) $str .= 'true';
				else $str .= '"' . addslashes($value) . '"'; //All other things
				// :TODO: Is there any more datatype we should be in the lookout for? (Object?)
	
				$parts[] = $str;
			}
		}
		$json = implode(',',$parts);
		
		if($is_list) return '[' . $json . ']';//Return numerical JSON
		return '{' . $json . '}';//Return associative JSON
	} 
	
	$where = ' uv.Id!=0 ';
	$_SESSION['getUnitsPost'] = $_POST;
	if( !empty( $_POST['m'] ) ) $where .= ' and m.Id="'.$_POST['m'].'" ';
	if( !empty( $_POST['c'] ) ) $where .= ' and c.Id="'.$_POST['c'].'" ';
	if( !empty( $_POST['d'] ) ) $where .= ' and d.Id="'.$_POST['d'].'" ';
	if( !empty( $_POST['t'] ) ) $where .= ' and t.Id="'.$_POST['t'].'" ';
	if( !empty( $_POST['s'] ) ) $where .= ' and u.Name like "%'.$_POST['s'].'%" ';
	if( !empty( $_POST['cat'] ) ) $where .= ' and u.Categories like "%{'.$_POST['cat'].'}%" ';
	if( !empty( $_POST['scat'] ) ) $where .= ' and u.Categories like "%{'.$_POST['scat'].'}%" ';
	if( !empty( $_POST['sua'] ) && $_POST['sua'] == 1 ) $where .= ' and u.HasAppliance!="yes" ';
	if( !empty( $_POST['sua'] ) && $_POST['sua'] == 2 ) $where .= ' and u.HasAppliance="yes" ';
	$order = 'u.Name ASC';
	if( !empty( $_POST['ord'] ) && $_POST['ord'] == 'name-desc' ) $order = ' u.Name DESC ';
	if( !empty( $_POST['ord'] ) && $_POST['ord'] == 'price-asc' ) $order = ' FinalPrice ASC ';
	if( !empty( $_POST['ord'] ) && $_POST['ord'] == 'price-desc' ) $order = ' FinalPrice DESC ';
	$top = '0';
	if( !empty( $_POST['to'] ) )
	{
		$where .= ' and wt.IdTop="'.$_POST['to'].'" ';
		$top    = $_POST['to'];
	}
	$handle = '0';
	if( !empty( $_POST['h'] ) )
	{
		$where .= ' and h.IdHandle="'.$_POST['h'].'" ';
		$handle    = $_POST['h'];
	}
	
	if( !empty( $_SESSION['state_postalcode']['State'] ) && !empty( $_SESSION['state_postalcode']['PostalCode'] ) ){
		$list = new DbList('select Id from states_regions where id_state="'.$_SESSION['state_postalcode']['State'].'" and min<='.$_SESSION['state_postalcode']['PostalCode'].' and max>='.$_SESSION['state_postalcode']['PostalCode'].' limit 1');
		if( $list->Size() > 0 ){
			$state_postalcode = $list->Get(0);
			$state_postalcode = $state_postalcode['Id'];
			$where .= ' and ( u.Regions like "%{'.$state_postalcode.'}%" or u.Regions = "" or u.Regions IS NULL  )  ';
		}
	}
	
	$sql = '
	select
		uv.*,
		u.Id as UnitId,
		u.Name as UnitName,
		u.DistanceFromBottom as DistanceFromBottom,
		u.IsFloating as IsFloating,
		u.Height as Height,
		u.Width as Width,
		u.Depth as Depth,
		u.Icon as UnitIcon,
		u.Attaching as UnitAttaching,
		u.Price as UnitPrice,
		u.Swf2D as Swf2D,
		u.HasAppliance as HasAppliance,
		u.ApplianceName as ApplianceName,
		u.ApplianceDescription as ApplianceDescription,
		( uv.PriceDiff+u.Price+h.PriceDiff+wt.PriceDiff ) as FinalPrice,
		wt.Id as IdTop
	from
		textures 			as t,
		units 				as u,
		unit_variations 	as uv,
		unit_doors 			as d,
		carcasses 			as c,
		manufacturers 		as m,
		units_tops			as wt,
		units_handles		as h
	where
		'.$where.' and
		uv.IdTexture	= t.Id and
		uv.IdUnit		= u.Id and
		uv.IdDoor		= d.Id and
		u.IdManufacturer= m.Id and
		uv.IdCarcass	= c.Id and
		h.IdUnit		= u.Id and
		( (wt.IdUnit=u.Id and u.HasWorktop="yes") or u.HasWorktop="no" )
	group by
		uv.Id
	order by
		'.$order.'
	';
	$list = new DbList( $sql );
	$items = array();
	foreach( $list->GetCollection() as $item )
	{
		$data 				= array();
		$data['uvid'] 		= $item['Id'];
		$data['uid'] 		= $item['UnitId'];
		//$data['uid'] 		= $item['Id'];
		$data['dfb'] 		= $item['DistanceFromBottom'];
		$data['floating'] 	= $item['IsFloating'];
		$data['swf'] 		= WEBSITE_URL.'uploads/swf_2d/'.$item['Swf2D'];
		$top = $item['IdTop'];
		/*$data['pics'] 		= array(
			'uploads/unit_variations/'.$item['Image0'],
			'uploads/unit_variations/'.$item['Image90'],
			'uploads/unit_variations/'.$item['Image180'],
			'uploads/unit_variations/'.$item['Image270']
			);*/
		$data['pics'] 		= array(
			WEBSITE_URL.'uploads/unit_u'.$item['Id'].'_h'.$handle.'_t'.$top.'_a0.png',
			WEBSITE_URL.'uploads/unit_u'.$item['Id'].'_h'.$handle.'_t'.$top.'_a90.png',
			WEBSITE_URL.'uploads/unit_u'.$item['Id'].'_h'.$handle.'_t'.$top.'_a180.png',
			WEBSITE_URL.'uploads/unit_u'.$item['Id'].'_h'.$handle.'_t'.$top.'_a270.png'
			);
		$data['width'] 		= $item['Width']/10;
		$data['height'] 	= $item['Height']/10;
		$data['depth'] 		= $item['Depth']/10;
		$item['pic'] = $data['pics'][0];
		$data['y'] = 100;
		$data['x'] = 105;
		$item['JSON_DATA'] 	= addslashes(array2json($data));
		
		/*$price  = $item['PriceDiff'];
		$price += $item['UnitPrice'];
		
		$list = new DbList('select * from units_handles where IdUnit="'.$item['IdUnit'].'" and IdHandle="'.$_POST['h'].'" limit 1');
		if( $list->Size() > 0 )
		{
			$itm = $list->Get(0);
			$price += $itm['PriceDiff'];
		}
		$list = new DbList('select * from units_tops where IdUnit="'.$item['IdUnit'].'" and IdTop="'.$_POST['to'].'" limit 1');
		if( $list->Size() > 0 )
		{
			$itm = $list->Get(0);
			$price += $itm['PriceDiff'];
		}
		$item['FinalPrice'] = $price;*/
		//$item['FinalPrice'] = $item['NewFinalPrice'];
		$items[] = $item;
	}
	$smarty->assign('items',$items);
	
	//print_r($items);
	
	$smarty->display('getUnits.tpl');
	
	mysql_close();
	/////////////////////////////
?>