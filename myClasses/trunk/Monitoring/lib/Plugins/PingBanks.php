<?php

require_once(dirname(__FILE__).'/Abstract.php');
/*
 * Monitoring_Plugins_PingBanks
 * @author Molodtsov Aleksander <a.molodcov@chronopay.com>
 * @uses Monitoring_Plugins_Abstract
 * @package Monitoring
 * @subpackage Plugins
 */
class Monitoring_Plugins_PingBanks extends Monitoring_Plugins_Abstract {

	var $__hBanksHosts	= array(
		'Cartu Bank' 		=> array('url'=>'https://213.131.36.78:4254/Base24/WSB24.asmx?wsdl','port'=>443),
		'ChargeAsia' 		=> array('url'=>'https://secure.ChargeAsia.com/secure/MSCatRemoteProcess.asp', 			'port'=>443),
		'Caixa' 			=> array('url'=>'https://sis.sermepa.es/sis/operaciones', 			'port'=>443),
		'Azeri Card'		=> array('url'=>'https://172.25.8.2/cgi-bin/cgi_link', 				'port'=>443),
		'Discover'			=> array('url'=>'https://secure.authorize.net/gateway/transact.dll', 					'port'=>443),
		'eCommerce Global'	=> array('url'=>'https://secure.ecommerceglobal.com/gateway/gw1.cgi',					'port'=>443),
		'acopay'			=> array('url'=>'https://www.ecopay.com/prod/access.php', 			'port'=>443),
		'ElectraCash'		=> array('url'=>'https://secure.electracash.net/electracashdirect/postcapture.aspx', 	'port'=>443),
		'Inter Consult'		=> array('url'=>'https://secure.iconsultpay.com/transaction.php', 	'port'=>443),
		'Median v2'			=> array('url'=>'192.168.1.251', 									'port'=>443),
		'Multicard Iso MK'	=> array('url'=>'172.20.47.100',									'port'=>'30200'),
		'Pago'				=> array('url'=>'https://secure.rs.chronopay.com', 					'port'=>'30000'),
		'Pay18'				=> array('url'=>'https://www.pay18.com/prod/access.php', 			'port'=>443),
		'Pay Vision'		=> array('url'=>'https://processor.payvisionservices.com/Gateway/BasicOperations.asmx/', 'port'=>443),
		'Pay Vision 3ds'	=> array('url'=>'https://processor.payvisionservices.com/Gateway/ThreeDSecureOperations.asmx/', 'port'=>443),
		'Post Bank'			=> array('url'=>'217.73.40.225', 									'port'=>'4110'),
		'Process54'			=> array('url'=>'https://www.ponudnik.com/cgi-bin/cccenter', 		'port'=>443),
		'PromSvBank'		=> array('url'=>'192.168.34.23', 									'port'=>'6666'),
		'Scand Order'		=> array('url'=>'https://merchants.scandorderinc.com/pos/pos_entrypoint.cfm', 			'port'=>443),
		'SebUnibanka'		=> array('url'=>'62.84.6.3', 										'port'=>'1118'),
		'SoEasyPay' 		=> array('url'=>'https://secure.ugspay.com/interface/payment2/index.php?wsdl', 			'port'=>443),
		'UcsAuth7_1' 		=> array('url'=>'172.16.40.20', 									'port'=>'33981'),
		'UcsAuth7_2' 		=> array('url'=>'172.16.40.28', 									'port'=>'33981'),
		'UcsAuth7_3' 		=> array('url'=>'172.16.40.30', 									'port'=>'33981'),
		'Volpay' 			=> array('url'=>'http://62.209.40.97/supermaxxx/gateway_v2.php', 	'port'=>443),
		'UkrPC' 			=> array('url'=>'https://secure.upc.ua/go/service/02', 				'port'=>443),
		'WireCard' 			=> array('url'=>'https://c3.wirecard.com/secure/ssl-gateway', 		'port'=>443),
	);

	/**
	 * Enter description here...
	 *
	 * @param int $iRunId
	 */
	function __init($iRunId){
		print "\n\n".str_repeat("=", strlen(__METHOD__))."\n".__METHOD__."\n".str_repeat("=", strlen(__METHOD__))."\n\n";

		$this->setStatus(MONITORING_STATUS_DONE);

		require_once("PEAR.php");
		require_once("Net/Socket.php");

		$this->Socket =& new Net_Socket();

		foreach($this->__hBanksHosts as $sBankName => $sHost){
			$bSocket 	= $this->pingSocket($sHost['url'], $sHost['port']);
			$bPing 		= $this->pingPing($sHost['url']);
			$aPassed = $aFailed = $aStrange = array();
			if($bSocket && $bPing){
				print "OK -> ";
				$aPassed[] = $sHost;
			}else if(!$bSocket && !$bPing){
				print "FAIL -> ";
				$aFailed[] = $sHost;
			}else{
				print "STRANGE -> ";
				$aStrange[] = $sHost;
			}
			print $sBankName.' -> '.$sHost['url']."\n";
			var_dump($this->pingPing($sHost['url']));
break;
		}
		$this->setStatus(MONITORING_STATUS_DONE);

	}

	/**
	 * Pings by PEAR:Net_Socket;
	 *
	 * @param string $sHost
	 * @param int $iPort
	 * @return bool
	 */
	function pingSocket($sHost, $iPort){
		$st = microtime(true);
		$sHost = $this->getHost($sHost);
		$connect = $this->Socket->connect($sHost, $iPort, false, 15);
		if($connect !== true) {
			$this->setData("STATUS: ERROR | HOST: $sHost, PORT: $iPort, ERROR: ".$connect->getMessage());
			return false;
		}
		$this->setData("STATUS: OK | HOST: $sHost, PORT: $iPort, CONNECTION TIME: ".(microtime(true)-$st));
		$this->Socket->disconnect();
		return true;
	}

	/**
	 * ping by exec ping
	 *
	 * @param int $sHost
	 */
	function pingPing($sHost){

		$sHost = $this->getHost($sHost);
		exec('ping '.$sHost.' -c3 2>&1 | grep loss && exit', $output, $var);
		$data = implode("\n",$output);
		$this->setData($data);
		var_dump($data,$var);
		if($var > 0 || preg_match('|[0-9]{1,} errors|ism', $data) || preg_match('|100% packet loss|ism', $data) || !preg_match('| loss|ism', $data)){
			return false;
		}
		return true;
	}

	/**
	 * ping by curl
	 *
	 * @param string $host
	 * @param int $timeout
	 * @return hash
	 */
	function pingCurl($host, $timeout = 5) {
		$ch = curl_init();
		curl_setopt ($ch, CURLOPT_URL, $host['url']);
		if(isset($host['port']) and is_numeric($host['port'])){
			curl_setopt($ch, CURLOPT_PORT, $host['port']);
		}
		curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt	($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
		curl_setopt ($ch, CURLOPT_FAILONERROR, 	  1);
		curl_setopt ($ch, CURLOPT_HEADER,         1);
		curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 0);
		ob_start();
		curl_exec ($ch);
		ob_end_clean();

		$output['data'] 	= curl_getinfo($ch);
		$output['error'] 	= curl_errno($ch) ? curl_errno($ch).': '.curl_error($ch) : false;

		return $output;
	}

	/**
	 * get host from string
	 *
	 * @param string $sString
	 * @return string
	 */
	function getHost($sString){
		$aUrl = parse_url($sString);
		if(preg_match('|^[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}$|s', $sString)){
			// this is IP - ok ^__^
		}elseif(isset($aUrl['host'])){
			$sString = $aUrl['host'];
		}elseif(isset($aUrl['path'])){
			$sString = $aUrl['path'];
		}else{
			$this->setData("STATUS: ERROR | WRONG HOST in : $sHost");
		}
		return strtolower($sString);
	}

}
