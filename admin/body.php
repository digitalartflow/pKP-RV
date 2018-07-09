<?
	$spage = str_replace('-','_',$page);
	$spage = 'pages/'.str_replace('__','/',$spage).'.php';
	if( is_file( $spage ) )
	{
		require_once $spage;
	}
	else
		echo "<b>" . "Page error!" . "</b>";

