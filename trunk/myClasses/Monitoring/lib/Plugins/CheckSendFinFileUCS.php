<?php

require_once(dirname(__FILE__).'/Abstract.php');
/*
 * Monitoring_Plugins_SendFinFileUCS
 * @author Molodtsov Aleksander <a.molodcov@chronopay.com>
 * @uses Monitoring_Plugins_Abstract
 * @package Monitoring
 * @subpackage Plugins
 */
class Monitoring_Plugins_SendFinFileUCS extends Monitoring_Plugins_Abstract{

	function __init($iRunId){
		print "\n\n".str_repeat("=", strlen(__METHOD__))."\n".__METHOD__."\n".str_repeat("=", strlen(__METHOD__))."\n\n";

		$db 			= $this->getDbAdapter();
		$sArchiveDir	= '/home/chronopay.com/ucs/archives/' . date('Y');
		$sLogFile		= '/home/chronopay.com/logs/ucs/mailer' . date('Y-m-d');
		$sRecipient 	= 'monitor@abgcard.ru';
		$sSearchString 	= 'Mail sent to ' . $sRecipient;

		$sLogFile 		= __FILE__;

		$this->setStatus(MONITORING_STATUS_FAILED);

		if(file_exists($sLogFile)){

			$aFile = array_slice(array_map('trim',file($sLogFile)),-3,3);

			foreach($aFile as $line){
				if(preg_match("|{$sSearchString}|ism",$line)){
					$this->setStatus(MONITORING_STATUS_DONE);
					$this->setData($line);
					break;
				}
			}
			if($this->getStatus() != MONITORING_STATUS_DONE) $this->setError('No matches in file '.$sLogFile);
		}else{
			$this->setError('There is not log file '.$sLogFile);
		}
	}
}

