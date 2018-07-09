<?php

    class Util
    {
		
		static function getKeywords($expr = '', $min = 3)
		{
			$expr = Util::cleanString($expr,'',true);
			$cuv = explode(' ',$expr);
			$ret = array();
			foreach( $cuv as $c )
				if( strlen($c) >= $min ) $ret[] = $c;
			return implode(', ',$ret);
		}
		
		static function cleanString( $string, $rep = '-', $numeric = true, $special = true, $extra = '', $drep = false )
		{
			$accepted = 'qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM';
			if( $numeric ) $accepted .= '1234567890';
			if( $special ) $accepted .= ' -_';
			if( $extra ) $accepted .= $extra;
			$accepted = str_split($accepted);
			$string = str_split($string);
			$new_string = '';
			foreach( $string as $s )
				if( in_array( $s, $accepted ) ) $new_string .= $s;
				elseif( !$drep )
					if( substr( $new_string,strlen($new_string)-1 ) == $rep ) $new_string .= '';
					else $new_string .= $rep;
				else
					$new_string .= $rep;
			return $new_string;
		}
		static function isValidEmail($email){
			return eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email);
		}
		// Encrypt Function
		static function mc_encrypt($encrypt, $mc_key) {
			$iv = mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND);
			$passcrypt = trim(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $mc_key, trim($encrypt), MCRYPT_MODE_ECB, $iv));
			$encode = base64_encode($passcrypt);
			return $encode;
		}
		
		// Decrypt Function
		static function mc_decrypt($decrypt, $mc_key) {
			$decoded = base64_decode($decrypt);
			$iv = mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND);
			$decrypted = trim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $mc_key, trim($decoded), MCRYPT_MODE_ECB, $iv));
			return $decrypted;
		}
		
        static function array2json($arr) {
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
                    if($is_list) $parts[] = Util::array2json($value); /* :RECURSION: */
                    else $parts[] = '"' . $key . '":' . Util::array2json($value); /* :RECURSION: */
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

        static function apachelink( $string )
        {

            $ret   = strtolower( $string );
            $ret   = Util::removeFunnyCharacters($ret);

            $ret   = str_replace( "&amp;", "", $ret );
            $ret   = str_replace( "&quot;", "", $ret );
            $ret   = str_replace( "&gt;", "", $ret );
            $ret   = str_replace( "&lt;", "", $ret );
            //inlocuieste spatiile cu cratima
            $ret   = str_replace( " " , "-", $ret );
            //nu lasa decat litere si cifre
            $ret   = ereg_replace("[^a-z0-9-]", "-", $ret);
            $parts = explode( "-", $ret );
            $ret   = "";
            $i     = 0;
            foreach( $parts as $part )
            {
                if( trim( $part ) != "" && $i < 150)
                {
                    $ret .= $part."-";
                    $i++;
                }
            }
            if( strlen( $ret ) > 1 ) $ret = substr( $ret, 0, strlen( $ret ) - 1 );
            $ret   = Util::removeFunnyCharacters($ret);
            return $ret;
        }

        static function removeFunnyCharacters($str)
        {
            $table = array(
                'Š'=>'S', 'š'=>'s', 'Đ'=>'Dj', 'đ'=>'dj', 'Ž'=>'Z', 'ž'=>'z', 'Č'=>'C', 'č'=>'c', 'Ć'=>'C', 'ć'=>'c',
                'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
                'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O',
                'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U', 'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss',
                'à'=>'a', 'ă'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c', 'è'=>'e', 'é'=>'e',
                'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o',
                'ô'=>'o', 'õ'=>'o', 'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'ý'=>'y', 'þ'=>'b',
                'ţ'=>'t', 'ÿ'=>'y', 'Ŕ'=>'R', 'ŕ'=>'r', 'ş'=>'s', 'Ş'=>'S'
            );
            $ret = strtr($str, $table);
            return $ret;
        }

        static function cauta($content,$strStart,$strStop)
        {
            $response     = array();
            $new_content2 = $content;
            while(strpos($new_content2,$strStart) !== false)
            {
                    $pos1         = strpos($new_content2,$strStart);
                    $new_content2 = substr($new_content2,$pos1+strlen($strStart));
                    $pos2         = strpos($new_content2,$strStop);
                    $slice        = substr($new_content2,0,$pos2);
                    $new_content2 = substr($new_content2,$pos2+strlen($strStop));
                    array_push($response,$slice);
            }
            return $response;
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

        static function EndsWith( $str, $sub )
        {
            return ( substr( $str, strlen( $str ) - strlen( $sub ) ) === $sub );
        }

        static function StartsWith( $str, $sub )
        {
            return ( substr( $str, 0, strlen( $sub )  ) === $sub );
        }

        static function LastPage()
        {
            $lp = Util::GetCurrentUrl();
            $lp = str_replace("?","~",$lp);
            $lp = str_replace("&","#",$lp);
            return $lp;
        }

        static function ReturnLastPage( $lp )
        {
            $lp = str_replace("~","?",$lp);
            $lp = str_replace("#","&",$lp);
            return $lp;
        }

        static function Redirect($url = false)
        {
			if( $url === false ) $url = Util::GetCurrentUrlHTTP();
			header( 'Location: '.$url );
			die();
            echo
            '<script language="javascript">
              window.location="'.$url.'";
             </script>
            ';
        }

        static function GetCurrentUrl( $base_url = "" )
        {
            $ret  = $base_url."?";
            $arr  = $_GET;
            $vals = array_keys($arr);
            foreach($vals as $val)
            {
                    $ret.= $val."=".$arr[$val]."&";
            }
            $ret = substr($ret,0, strlen($ret)-1);
            return $ret;
        }

        static function GetCurrentUrlHTTP()
        {
            $ret  = "http://".$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
            return $ret;
        }

       static function GetCurrentUrlWithoutKeys($keys)
        {
            $ret = $_SERVER['PHP_SELF']."?";
            $arr = $_GET;
            $vals= array_keys($arr);
            foreach($vals as $val)
            {
                    if( array_search($val, $keys) === false )
                    $ret .= $val."=".$arr[$val]."&";
            }
            $ret = substr($ret,0, strlen($ret)-1);
            return $ret;
        }

        static function GetCurrentUrlReplacingVal($base_url, $key, $value)
        {
            $ret = $base_url."?";
            $arr = $_GET;
            $vals= array_keys($arr);
            foreach($vals as $val)
            {
                    if( $val != $key )
                    {
                            $ret .= $val."=".$arr[$val]."&";
                    }
                    else
                    {
                            $ret .= $val."=".$value."&";
                    }
            }
            $ret = substr($ret,0, strlen($ret)-1);
            return $ret;
        }

}
//aici voi pune niste functii globale

function ParsMysql($sql)
{
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

function CleanPostAndGet()
{
	foreach($_POST as $key => $val)
	{
		$_POST[$key] = stripslashes(strip_tags(htmlspecialchars($val, ENT_QUOTES)));
		$$key        = stripslashes(strip_tags(htmlspecialchars($val, ENT_QUOTES)));
	}
	foreach($_GET as $key => $val)
	{
		$_GET[$key] = stripslashes(strip_tags(htmlspecialchars($val, ENT_QUOTES)));
		$$key       = stripslashes(strip_tags(htmlspecialchars($val, ENT_QUOTES)));
	}
}

?>