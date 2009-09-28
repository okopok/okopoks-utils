<?php

define("MONITORING_STATUS_RUNNING",	'running');
define("MONITORING_STATUS_DONE",	'done');
define("MONITORING_STATUS_FAILED",	'failed');
define("MONITORING_STATUS_ERROR",	'error');
define("MONITORING_STATUS_UNKNOWN",	'unknown');
define("MONITORING_STATUS_DEFAULT",	'default');
/*
 * Monitoring_Abstract
 * @author Molodtsov Aleksander <a.molodcov@chronopay.com>
 * @package Monitoring
 * @subpackage Core
 */
class Monitoring_Abstract{

	var $__aErrors 		= array();
	var $__oDbAdapter 	= null;
	var $__sStatus		= 'default';
	var $__aStatuses	= array('running','done','failed','error','unknown','default');
	var $__aData		= array();
	var $__id = null;

	function getId(){
		return $this->__id;
	}

	function setId($id){
		$this->__id = $id;
	}

	function getErrors(){
		return $this->__aErrors;
	}

	function setData($sString){
		$this->__aData[] = $sString;
		return true;
	}

	function getData(){
		return $this->__aData;
	}

	function getDataStr(){
		return trim(implode("\n", $this->getData()));
	}

	function getErrorsStr(){
		return trim(implode("\n", $this->getErrors()));
	}
	function setError($sString){
		$this->__aErrors[] = $sString;
		return true;
	}

	function getName(){
		return get_class($this);
	}

	function getDbAdapter(){
		return $this->__oDbAdapter;
	}

	function setDbAdapter($oDbAdapter){
		if(is_object($oDbAdapter)){
			$this->__oDbAdapter = $oDbAdapter;
			return true;
		}
		return false;
	}

	function getStatus(){
		return  $this->__sStatus;
	}

	function setStatus($status = MONITORING_STATUS_UNKNOWN){
		if(!isset($this->__aStatuses[$status]) AND !in_array($status, $this->__aStatuses)){
			$status = MONITORING_STATUS_UNKNOWN; // if status is not index or string = set default
		}
		if(isset($this->__aStatuses[$status])){
			$status = $this->__aStatuses[$status]; // if status is index = set string;
		}
		$this->__sStatus = $status;
		return $status;
	}

}
