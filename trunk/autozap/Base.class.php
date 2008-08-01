<?php
/**
 *
 */
class Base
{
  static private $errors = array();   // массив ошибок
  static private $objects = array();  // массив вызыванных классов


  /**
   * Выдаёт экземляр самого себя :)
   *
   * @return object
   */
  static public function getInstance()
  {
    return new self;
  }

  /**
   * Вызывает модуль контроллера, модели или вида и выдаёт результат вызова
   *
   * @param string $class_name
   * @param array $arr array('subdir','fullpath');
   * @return mixed
   */
  static function load($class_name, $arr = array('subdir' => '', 'fullPath' => '')) {
    $prefix = substr($class_name, 0, strpos($class_name,'_'));
    $name   = substr($class_name, strpos($class_name,'_')+1);

    if((!isset($arr['fullPath']) OR !strlen($arr['fullPath'])) AND strlen($prefix))
    {
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
      if(strlen($arr['subdir'])) $path .= $arr['subdir'].'/';
      $path .= $name.'.class.php';
    }else{
      $prefix = 'fullpath';
      $path = $arr['fullPath'];
    }
    if(!isset(self::$objects[$prefix][$class_name]))
    {
      if(file_exists($path) )
      {
        require_once $path;
      }else{
        self::setErrors("file_exists($path) == false");
        //throw new Exception("file_exists($path) == false");
        trigger_error("file <strong style='color:red;'>$path</strong>  not exists", E_USER_ERROR);
      }
    }
    if(class_exists($class_name))
    {
      self::$objects[$prefix][$class_name] = true;
      return new $class_name;
    }else
    {
      self::setErrors("class_exists($class_name) == false");
      //throw new Exception("class_exists($class_name) == false");
      trigger_error("class <strong style='color:red;'>$class_name</strong>  not exists", E_USER_ERROR);
    }
  }

  /**
   * Красиво печатает всякую фигню
   *
   * @param mixed $array - то что нужно напечатать
   * @param bool $console - в консоли или нет
   * @return string - выходной поток принта
   */
  static function print_ar($array = array(), $console = false)
  {
    ob_start();
    print "\n".(($console == false)? "<xmp>\n":'');
    print_r($array);
    print "\n".(($console == false)? "</xmp>\n":'');
    return ob_get_flush();
  }


  /**
   * Заполняет массив ошибок для протокола
   *
   * @param string $value - ошибка :)
   */
  static function setErrors($value = false)
  {
    if(defined('DEBUG') and DEBUG == true)
    {
      self::print_ar($value);
    }
    self::$errors[] = $value;
    return true;
  }


}

?>