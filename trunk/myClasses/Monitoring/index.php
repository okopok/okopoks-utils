<?php
$gl_include_path = '/home/chronopay.com/lib/';
require_once $gl_include_path.'init_console.inc';

define('MONITORING_LIB_PATH', dirname(__FILE__).'/lib/');

require_once(MONITORING_LIB_PATH.'Db/Adapter/Chrono.php');

$DbAdapter 	= new Monitoring_Db_Adapter_Chrono();
$DbAdapter->setDb($Db);

$oRes 		= $DbAdapter->query('SELECT NOW()');
//var_dump($oRes->fetchArray());
$oRes 		= $DbAdapter->query("SELECT '%s' || '%s'", 1234.2, '432,234');

$sSql = "
SELECT
	m.id 				as pk_monitoring_id,
	m.timestamp_start 	as monitoring_timestamp_start,
	m.timestamp_end 	as monitoring_timestamp_end,
	m.errors 			as monitoring_errors,
	m.data 				as monitoring_data,
	m.status 			as monitoring_status,

	mp.id 				as monitoring_plugins_id,
	mp.name 			as monitoring_plugins_name,
	mp.errors 			as monitoring_plugins_errors,
	mp.data 			as monitoring_plugins_data,
	mp.status 			as monitoring_plugins_status,
	mp.timestamp_start 	as monitoring_plugins_timestamp_start,
	mp.timestamp_end 	as monitoring_plugins_timestamp_end
FROM monitoring as m
INNER JOIN monitoring_plugins as mp ON m.id = mp.monitoring_id
ORDER BY m.timestamp_start DESC, mp.timestamp_start ASC
";
$oRes = $DbAdapter->query($sSql);
$data = array();
while($hRow = $oRes->fetchArray())
{
	$data[$hRow['pk_monitoring_id']]['start'] 												= $hRow['monitoring_timestamp_start'];
	$data[$hRow['pk_monitoring_id']]['end'] 												= $hRow['monitoring_timestamp_end'];
	$data[$hRow['pk_monitoring_id']]['status'] 												= $hRow['monitoring_status'];
	$data[$hRow['pk_monitoring_id']]['errors'] 												= $hRow['monitoring_errors'];
	$data[$hRow['pk_monitoring_id']]['data'] 												= $hRow['monitoring_data'];
	$data[$hRow['pk_monitoring_id']]['id'] 													= $hRow['pk_monitoring_id'];

	$data[$hRow['pk_monitoring_id']]['plugins'][$hRow['monitoring_plugins_id']]['id'] 		= $hRow['monitoring_plugins_id'];
	$data[$hRow['pk_monitoring_id']]['plugins'][$hRow['monitoring_plugins_id']]['name'] 	= $hRow['monitoring_plugins_name'];
	$data[$hRow['pk_monitoring_id']]['plugins'][$hRow['monitoring_plugins_id']]['start'] 	= $hRow['monitoring_plugins_timestamp_start'];
	$data[$hRow['pk_monitoring_id']]['plugins'][$hRow['monitoring_plugins_id']]['end'] 		= $hRow['monitoring_plugins_timestamp_end'];
	$data[$hRow['pk_monitoring_id']]['plugins'][$hRow['monitoring_plugins_id']]['status'] 	= $hRow['monitoring_plugins_status'];
	$data[$hRow['pk_monitoring_id']]['plugins'][$hRow['monitoring_plugins_id']]['errors'] 	= $hRow['monitoring_plugins_errors'];
	$data[$hRow['pk_monitoring_id']]['plugins'][$hRow['monitoring_plugins_id']]['data'] 	= $hRow['monitoring_plugins_data'];
}

foreach($data as $id => $hash){
	print $id.$hash['start']."\n";
	foreach($hash['plugins'] as $pid => $phash){
		print "\t\t".implode(' ; ', $phash)."\n";
	}
}
//print_r($data);
