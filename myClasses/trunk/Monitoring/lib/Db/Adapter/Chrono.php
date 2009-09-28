<?php
require_once(dirname(__FILE__).'/Abstract.php');
/*
 * Monitoring_Db_Adapter_Chrono
 * @author Molodtsov Aleksander <a.molodcov@chronopay.com>
 * @uses Monitoring_Db_Adapter_Abstract
 * @package Monitoring
 * @subpackage Db
 */
class Monitoring_Db_Adapter_Chrono extends Monitoring_Db_Adapter_Abstract{

	function query(){
		if(!func_num_args()){
			return false;
		}else if(func_num_args()==1){
			$sSql 	= reset(func_get_args());
		}else{
			$aArgs 	= func_get_args();
			$sSql 	= reset($aArgs);
			unset($aArgs[0]);
			$sSql 	= $this->prepare($sSql, $aArgs);
		}
		$this->__oSrc = new Query($this->__oDb, $sSql);
		return $this;
	}

	function prepare($sSql, $aArgs = array()){
		if(count($aArgs)){
			foreach($aArgs as $key => $value) $aArgs[$key] = $this->escape($value);
			array_unshift($aArgs,$sSql);
			$sSql = call_user_func_array('sprintf',$aArgs);
		}
		return $sSql;
	}

	function numRows(){
		return $this->__oSrc->getNumRows();
	}

	function escape($sString){
		return pg_escape_string($sString);
	}

	function isValid(){
		return $this->__oSrc->isSuccessfull();
	}

}
