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
  static function load($class_name, $subdir = false) {
    $name = explode('_',$class_name);
    print $class_name;

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
    if(!strlen($subdir)) $subdir = "$name";

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
    $path .= $subdir.'/';
    if(isset($type)) $path .= $type.'/';
    $path .= $name.'.class.php';


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
      print " - required<br />";
    }else{
      print " - called<br />";
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


  static public function location($url)
  {
    header('Location: '.$url);
    die;
  }
}

?>