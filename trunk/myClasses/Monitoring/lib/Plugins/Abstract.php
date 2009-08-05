<?php

require_once(MONITORING_LIB_PATH.'Abstract.php');

/*
 * Monitoring_Plugins_Abstract
 * @author Molodtsov Aleksander <a.molodcov@chronopay.com>
 * @uses Monitoring_Abstract
 * @package Monitoring
 * @subpackage Plugins
 */
class Monitoring_Plugins_Abstract extends Monitoring_Abstract{

	/**
	 * run plugin
	 * @param integer $iMonitoringId id of Monitoring (parent) run
	 *
	 */
	function run($iMonitoringId){
		$this->setStatus(MONITORING_STATUS_RUNNING);

		$this->create($iMonitoringId);

		$this->__init($this->getId());

		if($this->getStatus()==MONITORING_STATUS_RUNNING){
			$this->setStatus(MONITORING_STATUS_UNKNOWN);
			$this->setError('Final status not setted!');
		}

		$this->update();

		return $this;
	}

	/**
	 * creates plugin id in db
	 *
	 * @param int $iMonitoringId plugin parent id
	 */
	function create($iMonitoringId){
		$db = $this->getDbAdapter();
		$db->query("
			INSERT INTO monitoring_plugins (monitoring_id, name, status, timestamp_start)
			VALUES ('".$db->escape($iMonitoringId)."', '".$db->escape($this->getName())."', '".$db->escape($this->getStatus())."', current_timestamp) RETURNING id"
		);
		if($db->isValid()){
			$this->setId(reset($db->fetchArray()));
		}
	}

	/**
	 * update plugin and saves data to db
	 *
	 */
	function update(){
		$db = $this->getDbAdapter();
		$db->query("
			UPDATE monitoring_plugins
			SET
				status = '".$db->escape($this->getStatus())."',
				timestamp_end = current_timestamp,
				errors = '".$db->escape($this->getErrorsStr())."',
				data = '".$db->escape($this->getDataStr())."'
			WHERE id = '".$db->escape($this->getId())."'"
		);
	}

	/**
	 * initiate plugin
	 * @param integer $iMonitoringId id of Monitoring (parent) run
	 */
	function __init($iPluginId){
		die(__METHOD__.' must be reloaded');
	}



}
