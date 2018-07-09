<?
class getfromdb
{
	function getCatKids( $p, $list )
	{
		$kids = array();
		foreach( $list as $l )
		{
			if( $l['id_parent'] == $p['id'] )
			{
				$l['kids'] = self::getCatKids($l,$list);
				array_push($kids,$l);
			}
		}
		return $kids;
	}
	function categorii()
	{
		$list = new DbList('select * from categorii order by nume ASC');
		$categorii = array();
		foreach( $list as $l )
		{
			if( $l['id_parent'] == 0 )
			{
				$cat = $l;
				$cat['kids'] = self::getCatKids($l,$list);
				array_push($categorii,$cat);
			}
		}
		return $categorii;
	}
}
?>