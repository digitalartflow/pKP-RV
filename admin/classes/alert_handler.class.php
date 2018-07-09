<?
class alert{
	
	public static function check()
	{
		if( !isset( $_SESSION['srv_alert'] ) )
			$_SESSION['srv_alert'] = array();
	}
	
	public static function add_error( $msg = false, $ret = true )
	{
		self::check();
		if( $msg === false ) return false;
		array_push($_SESSION['srv_alert'],array(
			'type' 	=> 'error',
			'msg'	=> $msg
		));
		return true;
	}
	
	public static function add_ok( $msg = false, $ret = true )
	{
		self::check();
		if( $msg === false ) return false;
		array_push($_SESSION['srv_alert'],array(
			'type' 	=> 'ok',
			'msg'	=> $msg
		));
		return true;
	}
	
	public static function clear()
	{
		$_SESSION['srv_alert'] = array();
	}
	
	public static function show(){
		self::check();
		$ret = $_SESSION['srv_alert'];
		if( count($ret) == 0 ) return false;
		$_SESSION['srv_alert'] = array();
		return $ret;
	}
	
}
?>