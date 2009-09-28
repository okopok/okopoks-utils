<?php

require_once(dirname(__FILE__).'/Abstract.php');
/*
 * Monitoring_Plugins_SendFinFileMultiCard
 * @author Molodtsov Aleksander <a.molodcov@chronopay.com>
 * @uses Monitoring_Plugins_Abstract
 * @package Monitoring
 * @subpackage Plugins
 */
class Monitoring_Plugins_SendFinFileMultiCard extends Monitoring_Plugins_Abstract{

	function __init($iRunId){
		print "\n\n".str_repeat("=", strlen(__METHOD__))."\n".__METHOD__."\n".str_repeat("=", strlen(__METHOD__))."\n\n";

		$db 			= $this->getDbAdapter();
		$iStartTime  	= time();
		$sLogDate    	= date('Y-m-d', $iStartTime);
		$sLogDir    	= '/home/chronopay.com/logs/multicard';
		$sArchiveDir 	= '/home/chronopay.com/financefile/multicard/archives/'.date('Y', $iStartTime).'/';
		$hMailsTo    	= array('exchange@multicarta.vtb.ru');
		$sSearchString 	= 'Mail sent to '.implode(', ', $hMailsTo);
		$sLogDir 		= dirname(__FILE__);
		$files 			= array();

		if(is_dir($sLogDir)){
			$ch = opendir($sLogDir);
			while($file = readdir($ch)){
				if(is_file($sLogDir.'/'.$file)){
					$files[] = $file;
				}
			}
			rsort($files);
		}else{
			$this->setError('No log dir');
		}

		$this->setStatus(MONITORING_STATUS_FAILED);
		if(count($files)){
			$aFile = array_slice(array_map('trim',file($sLogDir.'/'.reset($files))),-3,3); // reads last 3 strings from last trimmed file in LogDir
			foreach($aFile as $line){
				if(preg_match("|{$sSearchString}|ism",$line)){
					$this->setStatus(MONITORING_STATUS_DONE);
					$this->setData($line);
					break;
				}
			}
			if($this->getStatus() != MONITORING_STATUS_DONE) $this->setError('No matches in file '.$sLogDir.'/'.reset($files));
		}
	}

}
