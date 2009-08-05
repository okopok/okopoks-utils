<?php
$gl_include_path = '/home/chronopay.com/lib/';
require_once $gl_include_path.'init_console.inc';

define('MONITORING_LIB_PATH', dirname(__FILE__).'/lib/');

require_once(MONITORING_LIB_PATH.'Core.php');
require_once(MONITORING_LIB_PATH.'Db/Adapter/Chrono.php');

$DbAdapter 	= new Monitoring_Db_Adapter_Chrono();
$DbAdapter->setDb($Db);

$Monitoring = new Monitoring_Core;
$Monitoring->setDbAdapter($DbAdapter);
$Monitoring->setStatus(MONITORING_STATUS_RUNNING);
$Monitoring->create();

$plug = $Monitoring->getPlugin('PingBanks');
//$plug = $Monitoring->getPlugin('CheckArcot');
$plug->setDbAdapter($DbAdapter);
$plug->run($Monitoring->getId());

var_dump("plugin errors", $plug->getErrors(), "monitoring errors", $Monitoring->getErrors());
if(!count($plug->getErrors()) and !count($Monitoring->getErrors())){
	$Monitoring->setStatus(MONITORING_STATUS_DONE);
	$Monitoring->update();
}
// OR
//$Monitoring->run();


?>
