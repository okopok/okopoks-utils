<?php

/**
 * simple class to get pages with psockopen
 * @author Sasha Molodtsov <a.molodcov@chronopay.com>
 * @since 5.08.09
 */
class SocketGetPage{

	var $iPort 				= 80;
	var $iTimeout 			= 10;
	var $iRedirects			= 0;
	var $iMaxRedirects		= 5;
	var $bDebug				= false;
	var $bFollow_location 	= true;
	var $sUrl				= false;
	var $sCookie_file 		= false;
	var $sPost_data			= false;

	var $__sHost			= '';
	var $__sPath 			= '/';
	var $__sType			= '';
	var $__sResponse		= '';
	var $__sBody			= '';
	var $__sMethod			= "GET";

	var $__sHeader			= '';
	var $__aResponseHeaders = array();
	var $__aSendHeader		= array(
								'Accept-Language' => 'Accept-Language: en-us, en;q=0.50',
								'User-Agent'	  => 'User-Agent: Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.9.0.12) Gecko/2009070811 Ubuntu/9.04 (jaunty) Firefox/3.0.12'
							);

	var $__iErrno			= 0;
	var $__sError			= false;

	var $__sRn				= "\r\n";

	/**
	 * constructor
	 *
	 * @param string $sUrl
	 * @return SocketGetPage
	 */
	function SocketGetPage($sUrl = false){
		if($sUrl){
			$this->setUrl($sUrl);
		}
	}

	/**
	 * parse url to make host, path, port, type vars
	 *
	 * @param string $sUrl
	 * @return string
	 */
	function parseUrl($sUrl){
		$url_parsed = parse_url($sUrl);
		if(!isset($url_parsed["host"])) return false;
		$this->__sHost	= $url_parsed["host"];

		if(isset($url_parsed["port"]) && (int)$url_parsed["port"]){
			$this->sPort = $url_parsed["port"];
		}
		if(isset($url_parsed['scheme']) and $url_parsed['scheme']=='https'){
			$this->__sType = 'ssl://';
		}
		$this->__sPath = '/';
		if(isset($url_parsed["path"])) 	$this->__sPath .= ltrim($url_parsed["path"],'/');
		if(isset($url_parsed["query"])) $this->__sPath .= "?".$url_parsed["query"];
	}

	/**
	 * setting cookie file to write and get cookie in\from it
	 *
	 * @param string $cookie_file
	 */
	function setCookieFile($cookie_file){
		if (@file_exists($cookie_file)){
			$cookie = urldecode(@file_get_contents($cookie_file));
			if ($cookie){
				$this->sCookie_file = $cookie_file;
				$this->__aSendHeader['Cookie'] = "Cookie: $cookie";
				$add = @fopen($cookie_file,'w');
				fwrite($add,"");
				fclose($add);
			}
		}
	}

	/**
	 * setting data to post
	 *
	 * @param string $sData
	 */
	function setPostData($sData){
		$this->__aSendHeader['Content-Type'] 	= "Content-Type: application/x-www-form-urlencoded";
		$this->__aSendHeader['Content-Length'] 	= "Content-Length: " .strlen($sData);
		$this->__aSendHeader['Post Data']		= $sData;
		$this->__sMethod  = 'POST';
		$this->sPost_data = $sData;
	}

	/**
	 * setting url
	 *
	 * @param string $sUrl
	 */
	function setUrl($sUrl){
		$this->parseUrl($sUrl);
		$this->sUrl = $sUrl;
	}

	/**
	 * setting basic authorization
	 *
	 * @param string $sUser
	 * @param string $sPass
	 */
	function setAuth($sUser, $sPass){
		$this->__aSendHeader['Authorization'] = "Authorization: Basic " .base64_encode($sUser.':'.$sPass);
	}

	/**
	 * setting referer (page from where we go)
	 *
	 * @param string $sRefer
	 */
	function setRefer($sRefer){
		$this->__aSendHeader['Referer'] = "Referer: $sRefer";
	}

	/**
	 * setting user-agent to let servers think, that script is a human
	 *
	 * @param string $sUserAgent
	 */
	function setUserAgent($sUserAgent){
		$this->__aSendHeader['User-Agent'] = "User-Agent: $user_agent";
	}

	/**
	 * getting response-headers
	 *
	 * @return array
	 */
	function getHeaders(){
		return $this->__aResponseHeaders;
	}

	/**
	 * getting response-header
	 *
	 * @return string
	 */
	function getResponseHeader(){
		return $this->__sHeader;
	}

	/**
	 * getting send-header
	 *
	 * @return string
	 */
	function getSendHeaders(){
		$hHeaders = $this->__aSendHeader;
		array_unshift($hHeaders, "Host: {$this->__sHost}");
		array_unshift($hHeaders, "{$this->__sMethod} {$this->__sPath} HTTP/1.0");
		array_push($hHeaders, 'Connection: Close');

		return implode($this->__sRn, $hHeaders).$this->__sRn.$this->__sRn;
	}

	/**
	 * getting response-body
	 *
	 * @return string
	 */
	function getBody(){
		return $this->__sBody;
	}

	/**
	 * getting last raw-response
	 *
	 * @return string
	 */
	function getResponse(){
		return $this->__sResponse;
	}

	/**
	 * cheching - if cookie exists in response header - writing it to cookieFile
	 *
	 */
	function checkCookie(){
		if ($this->sCookie_file && preg_match("/^Set\-Cookie\: /i",$this->__sHeader)){
			$cookie = @explode("Set-Cookie: ",$this->__sHeader,2);
			$cookie = $cookie[1];
			$cookie = explode("\r",$cookie);
			$cookie = $cookie[0];
			$cookie = str_replace("path=/","",$cookie[0]);
			$add = @fopen($this->sCookie_file,'a');
			fwrite($add,$cookie,strlen($cookie));
			fclose($add);
		}
	}

	/**
	 * checking redirect status. If new location exists in response header - making redirect
	 *
	 * @return bool
	 */
	function checkRedirect(){
		if ($this->bFollow_location && preg_match("/^Location\:/ism",$this->__sHeader)){
			if($this->iMaxRedirects <= $this->iRedirects){
				$this->__sError = 'Max '.$this->iMaxRedirects.' redirects reached';
				if($this->bDebug){
					print_r("\t".$this->__sError."\n\n");
				}
				return false;
			}
			$url = @explode("Location: ",$this->__sHeader);
			$url = $url[1];
			$url = @explode("\r",$url);
			$url = $url[0];
			$l = "&#76&#111&#99&#97&#116&#105&#111&#110&#58";
			foreach($this->__aResponseHeaders as $key => $value){
				$this->__aResponseHeaders[$key] = str_replace("Location:",$l,$value);
			}
			$this->iRedirects++;

			$this->setUrl($url);
			if($this->bDebug){
				print_r("\t".'Redirection to: '. $url."\n\n");
			}
			return $this->exec(false);
		}
		return false;
	}

	/**
	 * Executing query to url
	 *
	 * @param bool $bReset_headers - reset old headers or not default true
	 * @return bool
	 */
	function exec($bReset_headers = true){
		if($this->bDebug){
			print_r("\t".'connecting to: '.$this->__sType.$this->__sHost.':'.$this->iPort);
		}
		$open = fsockopen($this->__sType.$this->__sHost, $this->iPort, $this->__iErrno, $this->__sError, $this->iTimeout);
		if(!$open){
			if($this->bDebug){
				print_r(' - FAIL with errors: '.$this->__iErrno. "\n\n");
				print_r($this->__sError);
				print "\n\n";
			}
			return false;
		}
		if($this->bDebug){
				print_r(' - OK!'."\n\n".'Sending header: '."\n\n");
				print_r($this->getSendHeaders());
				print "\n\n";
		}
		fputs($open, $this->getSendHeaders());
		$this->__sResponse = '';
		while (!feof($open)) {
			$this->__sResponse .= fgets($open, 4096);
		}
		fclose($open);
		if($bReset_headers) $this->__aResponseHeaders = array();
		$aResponse = @explode($this->__sRn.$this->__sRn , $this->__sResponse , 2);
		$this->__sHeader = $aResponse[0];
		$this->__aResponseHeaders[] = $this->__sHeader;
		if (isset($aResponse[1])){
			$this->__sBody = $aResponse[1];
		}
		if($this->bDebug){
			print_r("\t".'Response Header: '."\n\n". $this->__sHeader."\n\n");
		}
		$this->checkCookie();
		$this->checkRedirect();
		if($this->__iErrno){
			return false;
		}
		return true;
	}

	function getError(){
		return $this->__sError;
	}

	function getErrno(){
		return $this->__iErrno;
	}

}
/*
/////////////
////Usage////
/////////////
$oldheader 		= '';
$url 			= "https://localhost.ru";
$follow 		= true;
$return_content_type = 2;//1 for header, 2 for body, 3 for both, 4 raw response
$refer 			= 'http://localhost.ru';
$user_agent 	= 'Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.9.0.12) Gecko/2009070811 Ubuntu/9.04 (jaunty) Firefox/3.0.12';
$user 			= 'userLogin';
$pass 			= 'userPass';
$timeout 		= 10;
$port 			= 443;
$cookie_file 	= false;
$post_data 		= false;

$Soc = new SocketGetPage($url);
$Soc->setRefer($refer);
$Soc->iPort = 443;
$Soc->setAuth($user, $pass);
$Soc->bDebug = true;
$Soc->exec();
print $Soc->getBody();

*/