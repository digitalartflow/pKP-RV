<?
	class Paginare{
		function Cont( $cur_pag = 1, $pages = 1, $pafis = 11, $link = '', $aflink = ''  )
		{
			$ret = '<span class="paginare">';
			$ret .= '<a class="paginare" href="'.$link.'1'.$aflink.'">&laquo;</a>';
			$fp  = $cur_pag-ceil(($pafis-1)/2);
			$tp  = $cur_pag+floor(($pafis-1)/2);
			$fp += $tp > $pages ? $pages-$tp : 0;
			$tp += $fp <= 0 ? 1-$fp : 0;
			if( $fp <= 0 ) $fp =1;
			if( $tp > $pages ) $tp = $pages;
			if( $fp != 1 ) $ret .= " ... ";
			for($i=$fp; $i<=$tp;$i++)
			{
				if( $i == $cur_pag )  $ret .= ' <strong>Pagina '.$i.'</strong> ';
				else $ret .= ' <a class="paginare" href="'.$link.$i.$aflink.'">'.$i.'</a> ';
			}
			if( $tp != $pages ) $ret .= " ... ";
			$ret .= '<a class="paginare" href="'.$link.$pages.$aflink.'">&raquo;</a>';
			$ret .= '</span> ';
			return $ret;
		}
	}
?>