<?php


class CurlWebClient {

	var $oCurlObj;
	var $data;

	function CurlWebClient($url) {
		$this->oCurlObj = curl_init($url);
		$this->setOpt(CURLOPT_URL, $url);
		$this->setOpt(CURLOPT_USERAGENT, "Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.8.1.12) Gecko/20080207 Ubuntu/9.10 (gutsy) Firefox/3.0.11");
	}

	/**
	 * @static
	 * @return CurlWebClient
	 */
	function standardHttpsRequest($url, $iTimeoutSec = 300) {

		$oClient = new CurlWebClient($url);
		$oClient->setOpt(CURLOPT_RETURNTRANSFER, true);
		$oClient->setOpt(CURLOPT_FOLLOWLOCATION, true);
		$oClient->setOpt(CURLOPT_SSL_VERIFYPEER, false);
		$oClient->setOpt(CURLOPT_TIMEOUT, $iTimeoutSec);

		return $oClient;
	}

	function setPostVars($hPostData) {

		$arPostVars = '';
		foreach ($hPostData as $field => $value)
			$arPostVars[] = $field .'='. $value;

		$this->setOpt(CURLOPT_POST, true);
		$this->setOpt(CURLOPT_POSTFIELDS, implode('&', $arPostVars));
	}

	function setOpt($sOption, $value) {
		curl_setopt($this->oCurlObj, $sOption, $value);
	}

	function inclideHeadersInResponse() { $this->setOpt(CURLOPT_HEADER, true); }

	function setCookie($sCookie) { $this->setOpt(CURLOPT_COOKIE, $sCookie); }

	function execute($bDebug = false) {
		if ($bDebug) $this->setOpt(CURLOPT_VERBOSE, true);
		$this->data = curl_exec($this->oCurlObj);
		return $this->data;
	}

	function _getHeader($sHeaderName) {
		$arLines = explode("\n", $this->data);
		foreach ($arLines as $line) {

			$line = trim($line);
			if (!$line) break;

			list($sCurrentHeader, ) = explode(':', $line);
			if (strtolower($sCurrentHeader) != strtolower($sHeaderName)) continue;

			return substr($line, strlen($sHeaderName) + 2);
		}
		return false;
	}

	function getCookie() {
		$sCookie = $this->_getHeader('Set-Cookie');
		$sCookie = substr($sCookie, 0, strpos($sCookie, ';'));
		return $sCookie;
	}

	function getErrno(){
	  return curl_errno($this->oCurlObj);
	}

	function getError(){
	  return curl_error($this->oCurlObj);
	}

}
