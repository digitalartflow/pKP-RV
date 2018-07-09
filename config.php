<?	
	############### CONNECTION WITH THE DATABASE ###############
	define( "DB_HOST"    , "[Type your details - Follow manual.pdf]"           );  // type your database host
	define( "DB_USER"    , "[Type your details - Follow manual.pdf]"            );  // type database user
	define( "DB_PASS"    , "[Type your details - Follow manual.pdf]"              );  // your database password
	define( "DB_DATABASE", "[Type your details - Follow manual.pdf]"    );  // your database name
	############################################################
	define("WEBSITE_URL", "[Type your details - Follow manual.pdf]");  // type your URL
	define("LIVE_ADMIN_KEY", "[Type your details - Follow manual.pdf]");  // type your URL
	define("WEBSITE_NOREPLY_EMAIL", "[Type your details - Follow manual.pdf]");  
	define("WEBSITE_CONTACT_EMAIL", "[Type your details - Follow manual.pdf]");
	############### DEFINE ADMIN VARS ##########################
	define("SERVER_PATH", getcwd());
	define("PROGRAM_PATH", SERVER_PATH);
	##################### DIVERSE ##############################	
	define("SECRET_PHRASE", "secretPhrase");
	//echo SERVER_PATH;
	//die();
	function ConnectToDB()
	{
		mysql_connect  ( DB_HOST, DB_USER, DB_PASS ) or die ( "EROARE LA CONEXIUNE".mysql_error() );
		mysql_select_db( DB_DATABASE );
		mysql_query("SET NAMES utf8");
	}
	//mesage setting
	function ServerMSG( $content=false, $type="error", $timeout=5000, $id=false )
	{
		$smarty = $_SESSION['smarty'];
		if( empty( $_SESSION['msg'] ) && !$content ) return false;
		$msg            = array();
		$msg['id']      = $id ? $id : rand(999,99999);
		$msg['content'] = $content ? $content : $_SESSION['msg'];
		$msg['type']    = $type;
		$msg['timeout'] = $timeout;
		$_SESSION['msg'] = false;
		$smarty->assign('msg',$msg);
		return $smarty->fetch('objects/mesajServer.tpl');
	}
?>