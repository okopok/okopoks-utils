<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/engine/tmp/config.php');
require_once(ENGINE_DIR. '/interfaces.php');
require_once(ROOT_DIR.   '/Base.class.php');
require_once(UTILS_DIR . 'Utils.class.php');
require_once(UTILS_DIR . 'bd.class.php');
require_once(UTILS_DIR . 'RecordSet.class.php');
require_once(UTILS_DIR . 'Virtuals.class.php');
require_once(SMARTY_DIR. 'Smarty.class.php');
function __autoload($class_name)
{
  $prefix = substr($class_name, 0, strpos($class_name,'_'));
  $name   = substr($class_name, strpos($class_name,'_')+1);

  switch ($prefix)
  {
    case 'controller':
      $path = CONTROLLERS_DIR;

      break;
    case 'model':
      $path = MODELS_DIR;
      break;
    case 'view':
      $path = VIEWS_DIR;
      break;
    default: return false;
  }
  $alterPath = $path."$name/public/$name.class.php";
  $path .= $name.'.class.php';

  if(file_exists($path) or file_exists($alterPath))
  {
    if(file_exists($path)) require_once($path); else require_once($alterPath);
  }else{
    Base::setErrors("class <strong>$class_name</strong> not found in <strong>$path</strong> or <strong>$alterPath</strong>!");
    trigger_error("class <strong>$class_name</strong> not found in <strong>$path</strong> or <strong>$alterPath</strong>!",E_USER_ERROR);
  }
}
?>