<?php

require_once(dirname(__FILE__).'/Abstract.php');
/*
 * Monitoring_Plugins_CheckArcot
 * @author Molodtsov Aleksander <a.molodcov@chronopay.com>
 * @uses Monitoring_Plugins_Abstract
 * @package Monitoring
 * @subpackage Plugins
 */
class Monitoring_Plugins_CheckArcot extends Monitoring_Plugins_Abstract{

	var $__sOldArcot 	= '192.168.128.136';
	var $__sNewArcot 	= '192.168.128.146';
	var $__iArcotPort 	= 9900;
	var $__sArcotPath 	= '';
	var $__sCardNo		= '4111-1111-1111-1111';
	var $__sUserAgent	= '';
	var $__dsLogin		= '';
	var $__dsPass		= '';


	function __init($iRunId){
		print "\n\n".str_repeat("=", strlen(__METHOD__))."\n".__METHOD__."\n".str_repeat("=", strlen(__METHOD__))."\n\n";
		return true;
		$db = $this->getDbAdapter();

		$gl_include_path = "/home/chronopay.com/lib/3ds/arcot/";
		require_once $gl_include_path . "oldlib/count3.inc";
		//require_once $gl_include_path . "processing/getinfo.php";
		require_once $gl_include_path . "arcot.inc.php";
		$input  = $ICE->stringToProxy("xFort:tcp -h ".ICE_HOST." -p ".ICE_PORT);
		$input	= $input->ice_checkedCast("::mpi::mpiserver::xFort");
		$SignedPARes	= $createPaRes[1];
		$LoggingID		= '';


		//$step3  = $input->VerifyAndUnpackPAResMsgEx($SignedPARes, $card_no, $LoggingID, $authValidationResultEx);

		if ($payment_type_id == 2) {
			$AcquirerBIN	= $procesingArcotInfo['acquirer_bin_mc'];
			$DsLogin		= $procesingArcotInfo['ds_login_mc'];
			$DsPassword		= ''; // must be empty - auth by ssl
		} else {
			$AcquirerBIN	= $procesingArcotInfo['acquirer_bin'];
			$DsLogin		= $procesingArcotInfo['ds_login'];
			$DsPassword		= $procesingArcotInfo['ds_password'];
		}

		$qualifyingInfo = new mpi_ArcotQualifyingInfo();
		$qualifyingInfo->DeviceCategory		= 0;
		$qualifyingInfo->AcceptHeader		= trim($argv[2]);
		$qualifyingInfo->UserAgentHeader	= trim($argv[3]);
		$qualifyingInfo->AcquirerBIN		= (integer)$AcquirerBIN;
		$qualifyingInfo->DsLogin			= trim($DsLogin);
		$qualifyingInfo->DsPassword			= trim($DsPassword);
//				var_dump($qualifyingInfo);

		$step1 = $input->CheckIfAuthRequired($card_no, $qualifyingInfo, $authRequiredResult);
	}


}
