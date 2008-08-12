<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/engine/tmp/config.php');
require_once(ENGINE_DIR. '/interfaces.php');
require_once(ROOT_DIR.   '/Base.class.php');
require_once(UTILS_DIR . 'Utils.class.php');
require_once(UTILS_DIR . 'bd.class.php');
require_once(UTILS_DIR . 'RecordSet.class.php');
require_once(UTILS_DIR . 'Virtuals.class.php');
require_once(UTILS_DIR . 'FirePHPCore/fb.php');
require_once(SMARTY_DIR. 'Smarty.class.php');
fb('start');
function __autoload($class_name)
{
    $name = explode('_',$class_name);

    //print $class_name;

    if(count($name) == 3)
    {
      $prefix = $name[0];
      $type   = $name[1];
      $name   = $name[2];
    }elseif(count($name == 2))
    {
      $prefix = $name[0];
      $name   = $name[1];
    }else{
       return false;
    }
    $subdir = "$name";

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
    $path .= $name.'/';
    if(isset($type)) $path .= $type.'/';
    $path .= $name.'.class.php';


    if(!class_exists($class_name))
    {
      if(file_exists($path) )
      {
        require_once $path;
      }else{
        //throw new Exception("file_exists($path) == false");
        trigger_error("file <strong style='color:red;'>$path</strong>  not exists", E_USER_ERROR);
      }
      fb($class_name.' - required',FirePHP::LOG);
    }else{
      fb($class_name.' - called',FirePHP::LOG);
    }

    if(class_exists($class_name))
    {
      try {
        //self::$objects[$prefix][$class_name] = true;
        return new $class_name;
      }catch (Exception $e){
        $e->getMessage();
      }
      //return new $class_name;
    }else
    {
      //self::setErrors("class_exists($class_name) == false");
      //throw new Exception("class_exists($class_name) == false");
      trigger_error("class <strong style='color:red;'>$class_name</strong>  not exists in <strong>$path</strong>", E_USER_ERROR);
    }
}
?>