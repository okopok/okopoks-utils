<?php
/**
 * Получаем хеш бренда и его моделей
 */
//print '--------------<br />';
//print $method_name;
//print '--------------<br />';
//$this->print_ar( $method_params);
$brand = $models = array();

if(isset($method_params[0]['pk_brands_id']) and is_numeric($method_params[0]['pk_brands_id']))
{
  $brand = $this->_mysql->getData('SELECT * FROM '.DB_TABLE_REFIX.'brands WHERE pk_brands_id = '.$method_params[0]['pk_brands_id']);

  if(count($brand) == 0) return  array();
  $this->_smarty->assign('brand', $brand[0]);
  $models = $this->_mysql->getData('SELECT * FROM '.DB_TABLE_REFIX.'models WHERE fk_brands_id = '.$method_params[0]['pk_brands_id'].' ORDER BY models_name_tag');
  if(count($models) == 0) return  array();
  $this->_smarty->assign('models', $models);
}

return array('brand' => $brand, 'models'=> $models);

?>