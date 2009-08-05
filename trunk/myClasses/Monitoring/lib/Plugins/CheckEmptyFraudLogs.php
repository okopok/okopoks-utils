<?php

$gl_include_path = "/home/chronopay.com/lib/";
require_once $gl_include_path."init_console.inc";

require_once(dirname(__FILE__).'/Abstract.php');
/*
 * Monitoring_Plugins_CheckEmptyFraudLogs
 * @author Molodtsov Aleksander <a.molodcov@chronopay.com>
 * @uses Monitoring_Plugins_Abstract
 * @package Monitoring
 * @subpackage Plugins
 */
class Monitoring_Plugins_CheckEmptyFraudLogs extends Monitoring_Plugins_Abstract {


	function __init($iRunId){
		print "\n\n".str_repeat("=", strlen(__METHOD__))."\n".__METHOD__."\n".str_repeat("=", strlen(__METHOD__))."\n\n";
		$sql = "
			SELECT c.id, c.customer_id, c.date_regist
			FROM customers AS c
			LEFT JOIN customer_empty_fsl_notify_log AS l ON (l.customer_id = c.customer_id)
			LEFT JOIN payment_type AS pt ON (pt.payment_type_id = c.payment_type_id)
			WHERE c.date_regist >= NOW() - '2 day'::interval
				AND c.status = 1
				AND (SELECT customer_id
					FROM customer_fsl
					WHERE c.customer_id = customer_fsl.customer_id
					LIMIT 1
				) IS NULL
				AND l.customer_id IS NULL
				AND pt.group_name = 'CreditCard';
		";
		$db = $this->getDbAdapter();
		$res = $db->query($sql);
		$iCustomersCount = $res->numRows();
		$this->setData($iCustomersCount. ' Empty Fraud Logs founded');
		if($res->numRows()) {
			$this->setData(var_export($res->fetchAll(),true));
		}
		$this->setStatus(MONITORING_STATUS_DONE);
	}

}


?>



