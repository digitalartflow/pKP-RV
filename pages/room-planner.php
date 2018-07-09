<?
	//echo ini_get('max_input_vars');
//die();
	$smarty->assign('previewMode',false);
	if( isset( $_GET['l3d'] ) ){
		$smarty->assign('previewMode',true);
		if( !empty( $_SESSION['roomDesignSavedStyleData'] ) ){
			$smarty->assign('saved_room_style',$_SESSION['roomDesignSavedStyleData']);
			//print_r($_SESSION['roomDesignSavedStyleData']);
		}
	}
	if( !empty( $_GET['lrid'] ) && is_numeric( $_GET['lrid'] ) ){
		$ow = false;
		$list = new DbList('select * from room_designs where IdUser="'.$_SESSION['logged']['Id'].'" and Id="'.$_GET['lrid'].'"');
		if( $list->Size() > 0 )
			$ow = $list->Get(0);
		$CustomStyle = json_decode($ow['CustomStyle'],true);
		if( !empty( $CustomStyle['manufacture'] ) ) $_SESSION['ftype'] = $CustomStyle['manufacture'];
		if( $ow ){
			$_SESSION['kitchen']['room_design'] = $ow['Data'];
			$_SESSION['saved_room_style'] = $ow['CustomStyle'];
		}else{
			unset($_SESSION['kitchen']);
			unset($_SESSION['saved_room_style']);
			Util::Redirect(WEBSITE_URL);
		}
	}
	
	if( isset( $_GET['rpl_access'] ) ){
		$_SESSION['rpl_access'] = $_GET['rpl_access'];
	}

	if( !isset( $_SESSION['rpl_access'] ) || $_SESSION['rpl_access'] != '123qwe' ){
		//die('maintainance');
	}
	
	$smarty = $_SESSION["smarty"];
	
	$list = new DbList('select * from manufacturers where Id in (select DISTINCT IdManufacturer from units) order by Name ASC');
	$manufacturers = $list->GetCollection();
	$smarty->assign('brands',$manufacturers);
	
	
	$list = new DbList('select HasStyles from manufacturers where Id="'.(int) $_SESSION['ftype'].'"');
	$list = $list->Get(0);
	$smarty->assign('showChooseStyle',$list[0]);
	
	$list = new DbList('select * from units_categories where IdParent=0 and IdFurnitureType="'.(int) $_SESSION['ftype'].'" order by Name ASC');
	$cats = $list->GetCollection();
	$smarty->assign('cats',$cats);
	
	$list = new DbList('select * from units_categories where IdParent!=0 and IdFurnitureType="'.(int) $_SESSION['ftype'].'" order by Name ASC');
	$scats = $list->GetCollection();
	$smarty->assign('scats',$scats);
	
	$list = new DbList('select * from unit_doors where Manufacturers like "{'.$_SESSION['ftype'].'}" order by Name ASC');
	$doors = $list->GetCollection();
	$smarty->assign('doors',$doors);
	
	$list = new DbList('select * from carcasses where Manufacturers like "{'.$_SESSION['ftype'].'}" order by Name ASC');
	$carcasses = $list->GetCollection();
	$smarty->assign('carcasses',$carcasses);
	
	$list = new DbList('select * from textures where Manufacturers like "{'.$_SESSION['ftype'].'}" order by Name ASC');
	$textures = $list->GetCollection();
	$smarty->assign('textures',$textures);
	
	$list = new DbList('select * from latches where Manufacturers like "{'.$_SESSION['ftype'].'}" order by Name ASC');
	$handles = $list->GetCollection();
	$smarty->assign('handles',$handles);
	
	$list = new DbList('select * from tops where Manufacturers like "{'.$_SESSION['ftype'].'}" order by Name ASC');
	$tops = $list->GetCollection();
	$smarty->assign('tops',$tops);
	
	$list = new DbList('select * from ps_style order by name ASC');
	$ps_styles = $list->GetCollection();
	$smarty->assign('ps_styles',$ps_styles);
	
	$list = new DbList('select * from ps_made_material order by name ASC');
	$ps_made_materials = $list->GetCollection();
	$smarty->assign('ps_made_materials',$ps_made_materials);
	
	
	$list = new DbList('select * from html_pages where Zone="help" order by `Order` ASC');
	$smarty->assign('pages',$list->GetCollection());
	
	function getObjectsFromId( $ids = array(), $objs = array() ){
		$ret = array();
		foreach( $ids as $id ){
			foreach( $objs as $obj ){
				if( $obj['Id'] == $id ) $ret[] = $obj;
			}
		}
		return $ret;
	}
	if( !isset($_SESSION['state_postalcode']['PostalCode']) ){
		$_SESSION['state_postalcode']['PostalCode'] = $_SESSION['logged']['PostalCode'];
	}
	if( !isset($_SESSION['state_postalcode']['State']) ){
		$_SESSION['state_postalcode']['State'] = $_SESSION['logged']['State'];
	}
	$list = new DbList('select * from states_regions where min<='.$_SESSION['state_postalcode']['PostalCode'].' and max>='.$_SESSION['state_postalcode']['PostalCode'].' and id_state='.$_SESSION['state_postalcode']['State'].' limit 1');
	$region = $list->GetCollection();
	$list = new DbList('select * from predefined_styles where furniture_types like "%{'.$_SESSION['ftype'].'}%" and Regions like "%{'.$region[0]['Id'].'}%" order by name ASC');
	$predefined_styles = $list->GetCollection();
	$default = false;
	foreach( $predefined_styles as &$ps ){
		$ps['doors'] = getObjectsFromId(Util::search($ps['doors'],'{','}'),$doors);
		$ps['handles'] = getObjectsFromId(Util::search($ps['handles'],'{','}'),$handles);
		$ps['carcasses'] = getObjectsFromId(Util::search($ps['carcasses'],'{','}'),$carcasses);
		$ps['textures'] = getObjectsFromId(Util::search($ps['textures'],'{','}'),$textures);
		$ps['top_textures'] = getObjectsFromId(Util::search($ps['top_textures'],'{','}'),$tops);
		$ps['furniture_types'] = getObjectsFromId(Util::search($ps['furniture_types'],'{','}'),$manufacturers);
		$ps['styles'] = Util::search($ps['styles'],'{','}');
		$ps['made_materials'] = Util::search($ps['made_materials'],'{','}');
		if( $ps['default'] == 1 ){
			$default = $ps;
		}
	}	
	if( !$default && !empty($predefined_styles[0]) ) $default = $predefined_styles[0];
	$smarty->assign('dps',$default);
	$smarty->assign('predefined_styles',$predefined_styles);
	//echo "<pre>";
	//print_r($default);
	//die();
	
	
	//afiseaza totul
	$thePage = $smarty->fetch( "pages/room-planner.tpl" );
	$smarty->assign('thePage',$thePage);
?>