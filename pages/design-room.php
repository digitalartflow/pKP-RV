<?
	$smarty = $_SESSION["smarty"];
	
	$list = new DbList('select d.*, t.Name as Type, ( select Picture from room_doors_pics as p2 where p2.IdDoor=d.Id order by Id ASC limit 1 ) as Picture, ( select Count(Distinct p2.Id) from room_doors_pics as p2 where p2.IdDoor=d.Id ) as Variations from room_doors as d, room_doors_pics as p, room_doors_types as t where p.IdDoor=d.Id and t.Id=d.IdType group by d.Id order by d.Name ASC');
	$doors_cats = $list->GetCollection();
	$smarty->assign('doors_cats',$doors_cats);	
	
	$list = new DbList('select dv.*, d.W, d.H, dt.Swf from room_doors_pics as dv, room_doors as d, room_doors_types as dt where d.Id=dv.IdDoor and dt.Id=d.IdType order by dv.Name ASC');
	$doors_vars = $list->GetCollection();
	$smarty->assign('doors_vars',$doors_vars);
	
	
	$list = new DbList('select d.*, t.Name as Type, ( select Picture from room_windows_pics as p2 where p2.IdWindow=d.Id order by Id ASC limit 1 ) as Picture, ( select Count(Distinct p2.Id) from room_windows_pics as p2 where p2.IdWindow=d.Id ) as Variations from room_windows as d, room_windows_pics as p, room_window_types as t where p.IdWindow=d.Id and t.Id=d.IdType group by d.Id order by d.Name ASC');
	$windows_cats = $list->GetCollection();
	$smarty->assign('windows_cats',$windows_cats);	
	
	$list = new DbList('select dv.*, d.W, d.H from room_windows_pics as dv, room_windows as d, room_window_types as dt where d.Id=dv.IdWindow and dt.Id=d.IdType order by dv.Name ASC');
	$windows_vars = $list->GetCollection();
	$smarty->assign('windows_vars',$windows_vars);
	
	$list = new DbList('select * from html_pages where Zone="help" order by `Order` ASC');
	$smarty->assign('pages',$list->GetCollection());
	
	//afiseaza totul
	$thePage = $smarty->fetch( "pages/design-room.tpl" );
	$smarty->assign('thePage',$thePage);
?>