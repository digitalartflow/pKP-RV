<?
	class Util{
	
		static function check_email_address($email) {
			// First, we check that there's one @ symbol, and that the lengths are right
			if (!ereg("^[^@]{1,64}@[^@]{1,255}$", $email))
			{
				// Email invalid because wrong number of characters in one section, or wrong number of @ symbols.
				return false;
			}
			// Split it into sections to make life easier
			$email_array = explode("@", $email);
			$local_array = explode(".", $email_array[0]);
			for ($i = 0; $i < sizeof($local_array); $i++)
			{
				if (!ereg("^(([A-Za-z0-9!#$%&'*+/=?^_`{|}~-][A-Za-z0-9!#$%&'*+/=?^_`{|}~\.-]{0,63})|(\"[^(\\|\")]{0,62}\"))$", $local_array[$i]))
				{
					return false;
				}
			}
			if (!ereg("^\[?[0-9\.]+\]?$", $email_array[1]))
			{ // Check if domain is IP. If not, it should be valid domain name
				$domain_array = explode(".", $email_array[1]);
				if (sizeof($domain_array) < 2)
				{
					return false; // Not enough parts to domain
				}
				for ($i = 0; $i < sizeof($domain_array); $i++)
				{
					if (!ereg("^(([A-Za-z0-9][A-Za-z0-9-]{0,61}[A-Za-z0-9])|([A-Za-z0-9]+))$", $domain_array[$i]))
					{
						return false;
					}
				}
			}
			return true;
		}

		
		static function cleanString( $string, $rep_white = "_", $isText = false )
		{
			$allowed = "qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM1234567890-_";
			if( $isText ) $allowed .= ",;.'\"~!@#$%^&*()_=+{}[]:|\\<>?`AÎSTÂaîstâ";
			$allowed = str_split($allowed);
			$ret = "";
			$string = str_split( $string );
			foreach( $string as $s )
			{
				if( $s == " " && $rep_white ) $ret .= $rep_white;
				elseif( in_array($s,$allowed) ) $ret .= $s;
			}
			return $ret;
		}
		
		static function scoateDiacritice( $string )
		{
			$accented = array(
				'À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Æ', 'Ă', 'Ą',
				'Ç', 'Ć', 'Č', 'Œ',
				'Ď', 'Đ',
				'à', 'á', 'â', 'ã', 'ä', 'å', 'æ', 'ă', 'ą',
				'ç', 'ć', 'č', 'œ',
				'ď', 'đ',
				'È', 'É', 'Ê', 'Ë', 'Ę', 'Ě',
				'Ğ',
				'Ì', 'Í', 'Î', 'Ï', 'İ',
				'Ĺ', 'Ľ', 'Ł',
				'è', 'é', 'ê', 'ë', 'ę', 'ě',
				'ğ',
				'ì', 'í', 'î', 'ï', 'ı',
				'ĺ', 'ľ', 'ł',
				'Ñ', 'Ń', 'Ň',
				'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ø', 'Ő',
				'Ŕ', 'Ř',
				'Ś', 'Ş', 'Š',
				'ñ', 'ń', 'ň',
				'ò', 'ó', 'ô', 'ö', 'ø', 'ő',
				'ŕ', 'ř',
				'ś', 'ş', 'š',
				'Ţ', 'Ť',
				'Ù', 'Ú', 'Û', 'Ų', 'Ü', 'Ů', 'Ű',
				'Ý', 'ß',
				'Ź', 'Ż', 'Ž',
				'ţ', 'ť',
				'ù', 'ú', 'û', 'ų', 'ü', 'ů', 'ű',
				'ý', 'ÿ',
				'ź', 'ż', 'ž',
				'А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р',
				'а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'р',
				'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ъ', 'Ы', 'Ь', 'Э', 'Ю', 'Я',
				'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ъ', 'ы', 'ь', 'э', 'ю', 'я'
				);
	
			$replace = array(
				'A', 'A', 'A', 'A', 'A', 'A', 'AE', 'A', 'A',
				'C', 'C', 'C', 'CE',
				'D', 'D',
				'a', 'a', 'a', 'a', 'a', 'a', 'ae', 'a', 'a',
				'c', 'c', 'c', 'ce',
				'd', 'd',
				'E', 'E', 'E', 'E', 'E', 'E',
				'G',
				'I', 'I', 'I', 'I', 'I',
				'L', 'L', 'L',
				'e', 'e', 'e', 'e', 'e', 'e',
				'g',
				'i', 'i', 'i', 'i', 'i',
				'l', 'l', 'l',
				'N', 'N', 'N',
				'O', 'O', 'O', 'O', 'O', 'O', 'O',
				'R', 'R',
				'S', 'S', 'S',
				'n', 'n', 'n',
				'o', 'o', 'o', 'o', 'o', 'o',
				'r', 'r',
				's', 's', 's',
				'T', 'T',
				'U', 'U', 'U', 'U', 'U', 'U', 'U',
				'Y', 'Y',
				'Z', 'Z', 'Z',
				't', 't',
				'u', 'u', 'u', 'u', 'u', 'u', 'u',
				'y', 'y',
				'z', 'z', 'z',
				'A', 'B', 'B', 'r', 'A', 'E', 'E', 'X', '3', 'N', 'N', 'K', 'N', 'M', 'H', 'O', 'N', 'P',
				'a', 'b', 'b', 'r', 'a', 'e', 'e', 'x', '3', 'n', 'n', 'k', 'n', 'm', 'h', 'o', 'p',
				'C', 'T', 'Y', 'O', 'X', 'U', 'u', 'W', 'W', 'b', 'b', 'b', 'E', 'O', 'R',
				'c', 't', 'y', 'o', 'x', 'u', 'u', 'w', 'w', 'b', 'b', 'b', 'e', 'o', 'r'
				);
	
			return str_replace($accented, $replace, $string);
		}
		static function corecteazaDiacritice( $string )
		{
			$d = array("&icirc;","&Icirc;","&acirc;","&Acirc;","&#259;","&#258;","&#351;","&#350;","&#355;","&#354;");
			$c = array("î","Î","â","Â","a","A","s","S","t","T");
			for( $i = 0; $i<count($d); $i++ )
			{
				$string = str_replace($d[$i],$c[$i],$string);
			}
			return $string;
		}
		
		static function RemoveLastSpace( $string = "" )
		{
			while( substr( $string, strlen($string)-1, 1 ) == " " )
				$string = substr( $string, 0,strlen($string)-1);
			return $string;
		}
		
		static function arrayRemoveEmptyVals( $array = array() )
		{
			$ret = array();
			foreach( $array as $a )
			{
				if( $a != "" && $a != array() ) array_push($ret,$a);
			}
			if( empty( $ret) ) $ret = false;
			return $ret;
		}
	
		static function search($content,$strStart,$strStop, $canbeempty = true, $ind = false){
			$response=array();
			$new_content2=$content;
			while(strpos($new_content2,$strStart) !== false){
				$pos1=strpos($new_content2,$strStart);
				$new_content2=substr($new_content2,$pos1+strlen($strStart));
				$pos2=strpos($new_content2,$strStop);
				$slice=substr($new_content2,0,$pos2);
				$new_content2=substr($new_content2,$pos2+strlen($strStop));
				$trimedslice = trim($slice);
				$trimedslice = str_replace('&nbsp;','',$trimedslice);
				$trimedslice = str_replace(' ','',$trimedslice);
				if( $canbeempty || ( !$canbeempty && !empty( $trimedslice ) )) array_push($response,$slice);
			}
			if( $ind===false ) return $response;
			elseif( isset( $response[$ind] ) ) return $response[$ind];
				else return false;
		}
		
		static function SetMSG( $msg )
		{
			$_SESSION['site_msg'] = $msg;
		}
		
		static function RememberVars( $vars )
		{
			$_SESSION['RememberedVars'] = $vars;
		}
	
		static function print_array( $array = array() )
		{
			echo "<pre>";
			print_r($array);
			echo "</pre>";
		}

		static function sectotime( $sec ){
			//return from seconds the time like H:i:s
			$sec = ( $sec=="" )?(0):($sec);
			$h = floor($sec/3600);
			$left = $sec%3600;
			$m = floor($left/60);
			$left = $left%60;
			$s = $left;
			return date('H:i:s',strtotime($h.":".$m.":".$s));
		}

		static function LastPage(){
			//return the curent url replacing ? and & ( usefull when wanting to put return to page link in a $_GET element
			$lp = Util::GetCurrentUrl();
			$lp = str_replace("?","~",$lp);
			$lp = str_replace("&","$",$lp);
			$lp = substr($lp,1);
			return $lp;
		}
		
		static function ReturnLastPage( $lp ){
			//the reversed process of LastPage() but you have to give it the procesed link
			$lp = str_replace("~","?",$lp);
			$lp = str_replace("$","&",$lp);
			return $lp;
		}
		
		static function Eroare($msg){
			//displays an error message
			$smarty = $_SESSION['smarty'];
			$smarty->assign("msg",$msg);
			return $smarty->fetch("ClassObjects/MessageModule.tpl");
		}
		
		static function Redirect($url){
			//redirects you to desired page
			echo 
			'
				<script language="javascript">
					document.location="'.$url.'";
				</script>
			';
		}
		
		static function NumberFormatPrice( $price  ){
			//creates the number format from xx.yy to xx,yy
			return number_format($price,2,",",".");
		}
		
		static function GetCurrentUrl(){
			//return current url
			$ret = $_SERVER['REQUEST_URI'];
			return $ret;
		}
		
		static function GetCurrentUrlWithoutKeys($keys){
			//return current url without desired keys
			$ret = $_SERVER['PHP_SELF']."?";
			$arr = $_GET;
			$vals= array_keys($arr);
			foreach($vals as $val){
				if( array_search($val, $keys) === false ) 
				$ret .= $val."=".$arr[$val]."&";
				
			}
			$ret = substr($ret,0, strlen($ret)-1);
			return $ret;
		}
		
		static function GetCurrentUrlReplacingVal($key,$val){
			//return desired url replacing the desired key value with the new $val
			$ret = $_SERVER['PHP_SELF']."?";
			$arr = $_GET;
			$vals= array_keys($arr);
			foreach($vals as $val){
				if( $val != $key ){
					$ret .= $val."=".$arr[$val]."&";
				}else{
					$ret .= $val."=".$val."&";
				}
			}
			$ret = substr($ret,0, strlen($ret)-1);
			return $ret;
		}
	}
	
	//aici voi pune niste functii globale
	function ParsMysql($sql){
		//returns the sql error more nicely
		$keywordColor = '#0000ff';
		$wordColor    = '#ff9900';
		$tab          = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
		$ret = strtolower( $sql );
		$ret = str_replace("select", "<br><font color='".$keywordColor."'>SELECT</font><br>".$tab, $ret);
		$ret = str_replace("where", "<br><font color='".$keywordColor."'>WHERE</font><br>".$tab, $ret);
		$ret = str_replace("asc", "<font color='".$keywordColor."'>ASC</font>", $ret);
		$ret = str_replace("as", "<font color='".$keywordColor."'>AS</font>", $ret);
		$ret = str_replace("and", "<font color='".$keywordColor."'>AND</font>", $ret);
		$ret = str_replace("order by", "<br><font color='".$keywordColor."'>ORDER BY</font>", $ret);
		$ret = str_replace("group by", "<br><font color='".$keywordColor."'>GROUP BY</font>", $ret);
		$ret = str_replace("limit", "<font color='".$keywordColor."'>LIMIT</font>", $ret);
		$ret = str_replace("update", "<br><font color='".$keywordColor."'>UPDATE</font><br>".$tab, $ret);
		$ret = str_replace("delete", "<br><font color='".$keywordColor."'>DELETE</font><br>".$tab, $ret);
		$ret = str_replace("from", "<br><font color='".$keywordColor."'>FROM</font><br>".$tab, $ret);
		$ret = str_replace("set", "<font color='".$keywordColor."'>WHERE</font>", $ret);
		$ret = "<font color='".$wordColor."'>".$ret."</font>";
		return $ret;
	}

	function CleanPostAndGet(){
		//security for post and get
		foreach($_POST as $key => $val){
			if( !is_array($val) ){
				$_POST[$key] = stripslashes(strip_tags(htmlspecialchars($val, ENT_QUOTES)));
				$$key = stripslashes(strip_tags(htmlspecialchars($val, ENT_QUOTES)));
			}
		}
		foreach($_GET as $key => $val){
			$_GET[$key] = stripslashes(strip_tags(htmlspecialchars($val, ENT_QUOTES)));
			$$key = stripslashes(strip_tags(htmlspecialchars($val, ENT_QUOTES)));
		}
	}
	if (!function_exists('json_encode')) {
		function json_encode($obj) {
			if (is_array($obj)) {
				if (array_is_associative($obj)) {
					$arr_out = array();
					foreach ($obj as $key=>$val) {
						$arr_out[] = '"' . $key . '":' . json_encode($val);
					}
					return '{' . implode(',', $arr_out) . '}';
				} else {
					$arr_out = array();
					$ct = count($obj);
					for ($j = 0; $j < $ct; $j++) {
						$arr_out[] = json_encode($obj[$j]);
					}
					return '[' . implode(',', $arr_out) . ']';
				}
			} else {
				if (is_int($obj)) {
					return $obj;
				} else {
					$str_out = stripslashes(trim($obj));
					$str_out = str_replace(array('"', '', '/'), array('\"', '\\', '/'), $str_out);
					return '"' . $str_out . '"';
				}
		
			}
		}
	}
	
	function array_is_associative($array) {
		$count = count($array);
		for ($i = 0; $i < $count; $i++) {
			if (!array_key_exists($i, $array)) {
				return true;
			}
		}
		return false;
	}
?>
