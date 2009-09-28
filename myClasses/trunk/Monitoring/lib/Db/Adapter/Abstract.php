<?php

require_once(MONITORING_LIB_PATH.'Abstract.php');
/*
 * Monitoring_Db_Adapter_Abstract
 * @author Molodtsov Aleksander <a.molodcov@chronopay.com>
 * @uses Monitoring_Abstract
 * @package Monitoring
 * @subpackage Db
 */
class Monitoring_Db_Adapter_Abstract extends Monitoring_Abstract{

	var $__oDb 		= null;
	var $__oSrc		= null;
	var $__sSql 	= null;


	function prepare($sSql, $aArgs = array()){
		return $sSql;
	}

	function setDb($Db){
		if(is_object($Db)){
			$this->__oDb = $Db;
			return true;
		}
		return false;
	}

	function fetchArray(){
		return $this->__oSrc->fetchArray();
	}

	function fetchAll(){
		$output = array();
		while($hRow = $this->fetchArray()){
			$output[] = $hRow;
		}
		return $output;
	}

	function isValid(){
		return $this->__oSrc->isValid();
	}
	function numRows(){
		return $this->__oSrc->numRows();
	}
	function escape($sString){
		return $sString;
	}

	function fetchRow(){
		return $this->__oSrc->fetchRow();
	}

	function getError(){
		return $this->__oSrc->getError();
	}

	function getErrno(){
		return $this->__oSrc->getErrno();
	}
}
