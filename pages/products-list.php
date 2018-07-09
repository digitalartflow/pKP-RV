<?php
	$list = new DbList('select * from manufacturers where Id in (select DISTINCT IdManufacturer from units) order by Name ASC');
	$manufacturers = $list->GetCollection();
	$smarty->assign('brands',$manufacturers);
	
	$list = new DbList('select * from units_categories where IdParent=0 order by Name ASC');
	$cats = $list->GetCollection();
	$smarty->assign('cats',$cats);
	
	$list = new DbList('select * from units_categories where IdParent!=0 order by Name ASC');
	$scats = $list->GetCollection();
	$smarty->assign('scats',$scats);
	
	$list = new DbList('select * from unit_doors order by Name ASC');
	$doors = $list->GetCollection();
	$smarty->assign('doors',$doors);
	
	$list = new DbList('select * from carcasses order by Name ASC');
	$carcasses = $list->GetCollection();
	$smarty->assign('carcasses',$carcasses);
	
	$list = new DbList('select * from textures order by Name ASC');
	$textures = $list->GetCollection();
	$smarty->assign('textures',$textures);
	
	$list = new DbList('select * from latches order by Name ASC');
	$handles = $list->GetCollection();
	$smarty->assign('handles',$handles);
	
	$list = new DbList('select * from tops order by Name ASC');
	$tops = $list->GetCollection();
	$smarty->assign('tops',$tops);
	
	
	$where = '';
	if( !empty( $_POST['m'] ) ) $where .= ' and m.Id="'.$_POST['m'].'" ';
	if( !empty( $_POST['c'] ) ) $where .= ' and c.Id="'.$_POST['c'].'" ';
	if( !empty( $_POST['d'] ) ) $where .= ' and d.Id="'.$_POST['d'].'" ';
	if( !empty( $_POST['t'] ) ) $where .= ' and t.Id="'.$_POST['t'].'" ';
	if( !empty( $_GET['s'] ) ) $where .= ' and ( u.Name like "%'.$_GET['s'].'%" or uv.Code="'.$_GET['s'].'")';
	if( !empty( $_GET['cat'] ) ) $where .= ' and u.Categories like "%{'.$_GET['cat'].'}%" ';
	if( !empty( $_GET['scat'] ) ) $where .= ' and u.Categories like "%{'.$_GET['scat'].'}%" ';
	if( !empty( $_POST['sua'] ) && $_POST['sua'] == 1 ) $where .= ' and u.HasAppliance!="yes" ';
	if( !empty( $_POST['sua'] ) && $_POST['sua'] == 2 ) $where .= ' and u.HasAppliance="yes" ';
	$order = 'u.Name ASC';
	if( !empty( $_GET['ord'] ) && $_GET['ord'] == 'name-desc' ) $order = ' u.Name DESC ';
	if( !empty( $_GET['ord'] ) && $_GET['ord'] == 'price-asc' ) $order = ' FinalPrice ASC ';
	if( !empty( $_GET['ord'] ) && $_GET['ord'] == 'price-desc' ) $order = ' FinalPrice DESC ';
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
	if( !empty( $where ) ){
		$per_page = 100;
		$cur_page = !empty( $_GET['pg'] )  ? (int) $_GET['pg'] : 1;
		$smarty->assign('cur_page',$cur_page);
		$from = ($cur_page-1)*$per_page;
		$where = ' uv.Id!=0  '.$where;
		$sql = '
		select
			SQL_CALC_FOUND_ROWS
			uv.*,
			CONCAT(uv.Id,u.Id,t.Id,d.Id,m.Id,c.Id) as UnitCode,
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
			wt.Id as IdTop,
			h.IdHandle as IdHandle
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
			wt.IdUnit=u.Id
		group by
			UnitCode
		order by
			'.$order.'
		limit '.$from.','.$per_page.'
		';
		$list = new DbList( $sql );
		$total = new DbList( 'SELECT FOUND_ROWS()' );
		$total = $total->Get(0);
		$total = $total[0];
		$pages = ceil($total/$per_page);
		$smarty->assign('pages',$pages);
		$items = array();
		$list = $list->GetCollection();
		foreach( $list as $item )
		{
			$data 				= array();
			$data['uvid'] 		= $item['Id'];
			$data['uid'] 		= $item['UnitId'];
			//$data['uid'] 		= $item['Id'];
			$data['dfb'] 		= $item['DistanceFromBottom'];
			$data['floating'] 	= $item['IsFloating'];
			$data['swf'] 		= WEBSITE_URL.'uploads/swf_2d/'.$item['Swf2D'];
			/*$data['pics'] 		= array(
				'uploads/unit_variations/'.$item['Image0'],
				'uploads/unit_variations/'.$item['Image90'],
				'uploads/unit_variations/'.$item['Image180'],
				'uploads/unit_variations/'.$item['Image270']
				);*/
			$top = $item['IdTop'];
			$handle = $item['IdHandle'];
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
			//$item['JSON_DATA'] 	= addslashes(array2json($data));
			$items[] = $item;
		}
		$smarty->assign('items',$items);
	}
	
	$thePage = $smarty->fetch( "pages/products-list.tpl" );
	$smarty->assign('thePage',$thePage);
?>