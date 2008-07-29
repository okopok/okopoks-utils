<?php
//print '--------------<br />';
//print $method_name;
//$this->print_ar( $method_params);
//print '--------------<br />';
$data = $this->_mysql->getData('SELECT * FROM '.DB_TABLE_REFIX.'brands'.((isset($method_params[0]['pk_brands_id']))? ' WHERE pk_brands_id = "'.$method_params[0]['pk_brands_id'].'"':''));
$this->_smarty->assign('brands', $data);
//$this->print_ar($data);
?>