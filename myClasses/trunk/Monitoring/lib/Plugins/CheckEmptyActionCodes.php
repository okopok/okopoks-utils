<?php

require_once(dirname(__FILE__).'/Abstract.php');
/*
 * Monitoring_Plugins_CheckEmptyActionCodes
 * @author Molodtsov Aleksander <a.molodcov@chronopay.com>
 * @uses Monitoring_Plugins_Abstract
 * @package Monitoring
 * @subpackage Plugins
 */
class Monitoring_Plugins_CheckEmptyActionCodes extends Monitoring_Plugins_Abstract{

	function __init($iRunId){
		print "\n\n".str_repeat("=", strlen(__METHOD__))."\n".__METHOD__."\n".str_repeat("=", strlen(__METHOD__))."\n\n";
		$date1 = date("Y-m-d");
		$db = $this->getDbAdapter();

		$sql = "SELECT count(id) as count, sum(total) as sum, product_id, processing_id, action_code, type FROM transactions left join processing_merchant_account on transactions.merchant = processing_merchant_account.processing_merchant_account_id WHERE (date_payment >= '$date1') AND (action_code is null) GROUP BY product_id, processing_id, type, action_code;";
		//print $sql."\n";
		$res = $db->query($sql);
		$this->setData($res->numRows(). ' Empty Action Codes founded');
		if($res->numRows()) {
			$this->setData(var_export($res->fetchAll(),true));
		}
		$this->setStatus(MONITORING_STATUS_DONE);
	}

}
