<?php

require_once(MONITORING_LIB_PATH.'Abstract.php');
/*
 * Monitoring_Core
 * @author Molodtsov Aleksander <a.molodcov@chronopay.com>
 * @uses Monitoring_Abstract
 * @package Monitoring
 * @subpackage Core
 */
class Monitoring_Core extends Monitoring_Abstract{

	var $__sPluginsDirs 	= 'Plugins/';
	var $__sPluginsSuffix 	= '.php';
	var $__hPlugins			= array();
	var $__hResults			= array();
	var $__sStatus 			= 'unknown';
	var $__aStatuses	= array('running','done','failed','error','unknown');

	/**
	 * class constructor
	 *
	 * @return Monitoring_Core
	 */
	function Monitoring_Core(){
		$this->__sPluginsDirs = MONITORING_LIB_PATH.$this->__sPluginsDirs;
		register_shutdown_function(array($this, "shutdown"));
	}

	/**
	 * sets plugins dir
	 *
	 * @param string $sString
	 * @return bool
	 */
	function setPluginsDirs($sString){
		if(is_dir($sString)){
			$this->__sPluginsDirs = $sString;
			return true;
		}
		return false;
	}

	/**
	 * get all plugins in plugins dir
	 *
	 * @return array
	 */
	function getPlugins(){

		if ($dh = @opendir($this->__sPluginsDirs)) {

			while (($file = readdir($dh)) !== false) {

				if($file == '.' OR $file == '..' OR $file == 'Abstract.php') continue;

				if(is_file($this->__sPluginsDirs.$file) and strrpos($file, $this->__sPluginsSuffix)){

					$oPlugin = $this->getPlugin(substr($file,0, strrpos($file, $this->__sPluginsSuffix)));

				}
			}
			closedir($dh);
		}
		return $this->__hPlugins;
	}

	/**
	 * get plugin by name without prefix
	 *
	 * @param string $sName
	 * @return object
	 */
	function getPlugin($sName){
		if($this->__hPlugins[$sName]){
			return $this->__hPlugins[$sName];
		}
		if(!file_exists($this->__sPluginsDirs.$sName.$this->__sPluginsSuffix)){
			$this->__aErrors[] = 'plugin: '.$this->__sPluginsDirs.$sName.$this->__sPluginsSuffix.' is not exists!';
			return false;
		}

		require($this->__sPluginsDirs.$sName.$this->__sPluginsSuffix);

		$sPluginName = 'Monitoring_Plugins_'.$sName;

		if(!method_exists($sPluginName, 'run')){
			$this->__aErrors[] = 'Method: '.$sPluginName.'::run is not exists';
			return false;
		}
		$this->__hPlugins[$sName] = new $sPluginName;
		return $this->__hPlugins[$sName];
	}

	/**
	 * create id for core instance
	 *
	 */
	function create(){
		$db = $this->getDbAdapter();
		$db->query("
			INSERT INTO monitoring (status, timestamp_start)
			VALUES ('".$db->escape($this->getStatus())."', current_timestamp) RETURNING id
		");
		if($db->isValid()){
			$this->setId(reset($db->fetchArray()));
		}else{
			$this->setStatus(MONITORING_STATUS_ERROR);
			$this->setError($db->getErrors());
		}
	}

	/**
	 * updated core instance and saves statuses
	 *
	 */
	function update(){
		$db = $this->getDbAdapter();
		$db->query("
				UPDATE monitoring
					SET
						status 			= '".$db->escape($this->getStatus())."',
						timestamp_end 	= current_timestamp,
						errors 			= '".$db->escape($this->getErrorsStr())."',
						data 			= '".$db->escape($this->getDataStr())."'
					WHERE id = '".$db->escape($this->getId())."'"
			);
	}

	/**
	 * Run all tests
	 *
	 */
	function run(){
		$plugins = $this->getPlugins();
		$db = $this->getDbAdapter();
		$this->setStatus(MONITORING_STATUS_RUNNING);
		$this->create();
		if($this->getId()){

			foreach($plugins as $oPlugin){

				$oPlugin->setDbAdapter($this->__oDbAdapter);

				$this->__hResults[$oPlugin->getName()] = $oPlugin;
				$this->__hResults[$oPlugin->getName()] = $oPlugin->run($this->getId());

				print $oPlugin->getStatus()."\n\n";
			}
			$this->setStatus(MONITORING_STATUS_DONE);

		}else{
			$this->setStatus(MONITORING_STATUS_ERROR);
			$this->setError('Monitroing id is not created');
		}
		$this->update();
	}

	/**
	 * shutdown - emulator of __destruct method. If program fails = saves statuses and errors to db
	 *
	 */
	function shutdown(){
		// if core status is default, running or unknown - update core with error
		if($this->getStatus() == MONITORING_STATUS_DEFAULT || $this->getStatus() == MONITORING_STATUS_RUNNING || $this->getStatus()==MONITORING_STATUS_UNKNOWN){

			$db = $this->getDbAdapter();
			$this->setError(var_export(error_get_last(),true));
			$this->setError('Monitoring finished not properly');
			$this->setError('Last status: '.$this->getStatus());
			$this->setStatus(MONITORING_STATUS_ERROR);
			$this->update();
			foreach($this->__hResults as $oPlugin){
				// if plugin status is default, running or unknown - plugin core with error
				if($oPlugin->getStatus()==MONITORING_STATUS_DEFAULT || $oPlugin->getStatus() == MONITORING_STATUS_RUNNING || $oPlugin->getStatus()==MONITORING_STATUS_UNKNOWN){
					$oPlugin->setError(var_export(error_get_last(),true));
					$oPlugin->setError($oPlugin->getName().' finished not properly');
					$oPlugin->setError('Last status: '.$oPlugin->getStatus());
					$oPlugin->setStatus(MONITORING_STATUS_ERROR);
					$oPlugin->update();
				}
			}


		}
	}

	function getResults(){
		$this->__hResults;
	}
}
