<?php
/**
 * Enter description here...
 *
 */


class Base
{
  static private $errors = array();
  static private $objects = array();



  /**
   * Enter description here...
   *
   * @param unknown_type $method_name
   * @param unknown_type $method_params
   * @return unknown
   */
  function __call($method_name, $method_params){
    if(is_file(METHODS_DIR.$method_name.'.method.php'))
    {
      return (include(METHODS_DIR.$method_name.'.method.php'));
    }else{
      die("OOOOPS! Method '$method_name' does not exists '".__CLASS__."'!");
    }
  }

  public function getInstance()
  {
    return $this;
  }

  function load($class_name, $arr = array('subdir' => '', 'fullPath' => '')) {
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
        return false;
      }
    }
    if(class_exists($class_name))
    {
      self::$objects[$prefix][$class_name] = true;
      return new $class_name;
    }else
    {
      self::setErrors("class_exists($class_name) == false");
      return false;
    }
  }

  /**
   * Enter description here...
   *
   * @param unknown_type $array
   * @param unknown_type $console
   */
  static function print_ar($array = array(), $console = false)
  {
    print "\n".(($console == false)? "<xmp>\n":'');
    print_r($array);
    print "\n".(($console == false)? "</xmp>\n":'');
  }


  static function setErrors($value = false)
  {
    if(defined('DEBUG') and DEBUG == true)
    {
      self::print_ar($value);
    }
    self::$errors[] = $value;
  }

  function loadController($name, $fulPath = false)
  {
     if(strlen($fulPath))
     {
       $path = $fulPath;
     }else{
       $path = CONTROLLERS_DIR.$name.'/'.$name.".php";
     }
      if(file_exists($path) and is_readable($path))
      {
        require_once($path);
      }else{
        return false;
      }
  }

  function getController($name)
  {
    if(!class_exists($name))
    {
      $this->setErrors("class '$name' not exists");
    }else
    {
      return new $name;
    }
  }

  function loadModels()
  {

  }


  /**
   * ѕровер€ем, есть ли картинки
   *
   * @param sting $type - что провер€ем (brands или models)
   * @return bool or array
   */
  function chechImages($type)
  {
    $ok = true;
    switch ($type)
    {
      case 'brands':
        $imgUrl            = IMAGES_URL.BRANDS_IMAGES_DIR;
        $imgPath           = IMAGES_DIR.BRANDS_IMAGES_DIR;
        $sizes['medium']   = IMAGES_BRANDS_MEDIUM;
        $sizes['small']    = IMAGES_BRANDS_SMALL;
        $sizes['original'] = IMAGES_BRANDS_ORIGINAL_NAME;
        $key               = 'pk_brands_id';
        $masName           = 'brandsImages';
        break;
      case 'models':
        $imgUrl            = IMAGES_URL.MODELS_IMAGES_DIR;
        $imgPath           = IMAGES_DIR.MODELS_IMAGES_DIR;
        $sizes['medium']   = IMAGES_MODELS_MEDIUM;
        $sizes['small']    = IMAGES_MODELS_SMALL;
        $sizes['original'] = IMAGES_MODELS_ORIGINAL_NAME;
        $key               = 'pk_models_id';
        $masName           = 'modelsImages';
        break;
      default: $ok = false;
    }

    if(!$ok) return false;
    $data = $this->getHashes($type);
    $images = array();
    foreach ($data as $tag => $row)
    {
      foreach (explode(',',IMAGE_EXTS) as $ext)
      {
        if(file_exists($imgPath.$row[$key].'-'.IMAGES_BRANDS_SMALL.$ext))
        {
          $images[$row[$key]]['small']    = $imgUrl.$row[$key].'-'.$sizes['small'].$ext;
          $images[$row[$key]]['medium']   = $imgUrl.$row[$key].'-'.$sizes['medium'].$ext;
          $images[$row[$key]]['original'] = $imgUrl.$row[$key].'-'.$sizes['original'].$ext;
          break;
        }
      }
    }
    //print_r($images);
    $this->_smarty->assign($masName, $images);
    return $images;
  }


  /**
   * Enter description here...
   *
   * @return unknown
   */
  function showArticles()
  {
    $data = $this->_mysql->getData("
              SELECT a.*, users_name
              FROM ".DB_TABLE_REFIX."articles as a
              inner join ".DB_TABLE_REFIX."users as u
              on a.article_owner = u.pk_users_id
              ORDER BY article_timestamp DESC
    ");
    $this->_smarty->assign('articles', $data);
    return $data;
  }


  /**
   * Enter description here...
   *
   * @param unknown_type $brand
   * @param unknown_type $model
   * @return unknown
   */
  function showByBrandsModels($brand = 'all', $model = 'all', $table = 'parts', $cond = 'yes')
  {
    $where = '';

    $BRANDS_HASH = $this->getHashes('brands_models');

    if($brand != 'all' and isset($BRANDS_HASH[$brand]))
    {
      $where = "WHERE brands_name_tag = '$brand' ";
    }
    if($brand != 'all' and $model != 'all' and isset($BRANDS_HASH[$brand][$model]))
    {
      $where = "WHERE brands_name_tag = '$brand' AND models_name_tag = '$model' ";
    }

    if($table == 'parts') $where .= " AND parts_cond = '$cond'";

    $data = $this->_mysql->getData("
    SELECT brands_name, brands_name_tag, pk_brands_id, pk_models_id, models_name, models_name_tag, p.*
    FROM ".DB_TABLE_REFIX."$table as p
    INNER JOIN ".DB_TABLE_REFIX."models as m
    ON m.pk_models_id = p.fk_models_id
    INNER JOIN ".DB_TABLE_REFIX."brands AS b
    ON b.pk_brands_id = m.fk_brands_id
     $where
    ");
    return $data;
  }


  function getBrandsModelsByTable($table = '')
  {
    switch ($table)
    {
      case 'parts':
      case 'waiting':
      if($table == 'parts')   $cond = 'yes';
      if($table == 'waiting') $cond = 'waiting';

        $sql = '
            SELECT b.*, m.*
              FROM '.DB_TABLE_REFIX.'brands as b
        INNER JOIN '.DB_TABLE_REFIX.'models as m ON b.pk_brands_id = m.fk_brands_id
        INNER JOIN '.DB_TABLE_REFIX.'parts as p  ON m.pk_models_id = p.fk_models_id
             WHERE parts_cond = "'.$cond.'"
          GROUP BY m.pk_models_id';
        break;
      case 'repare':
        $sql = '
            SELECT b.*, m.*
              FROM '.DB_TABLE_REFIX.'brands as b
        INNER JOIN '.DB_TABLE_REFIX.'models as m ON b.pk_brands_id = m.fk_brands_id
        INNER JOIN '.DB_TABLE_REFIX.'repare as r ON m.pk_models_id = r.fk_models_id
          GROUP BY m.pk_models_id';
        break;
    }
    return $this->_mysql->getData($sql);
  }

}

?>