<?php
/**
 * Enter description here...
 *
 */
class Main
{
  public $tpl = 'index';

  /**
   * Enter description here...
   *
   */
  public function __construct()
  {
    require_once($_SERVER['DOCUMENT_ROOT'].'/tmp/config.php');
    require_once(SMARTY_DIR .  'Smarty.class.php');
    require_once(CLASSES_DIR . 'Utils.class.php');
    require_once(CLASSES_DIR . 'RecordSet.class.php');
    require_once(CLASSES_DIR . 'Virtuals.class.php');

    // smarty_start_config
      $this->_smarty = new Smarty();
      $this->_smarty->template_dir    = SMARTY_TEMPLATE_DIR;
      $this->_smarty->compile_dir     = SMARTY_COMPILE_DIR;
      $this->_smarty->config_dir      = SMARTY_CONFIG_DIR; // пока не задано
      $this->_smarty->cache_dir       = SMARTY_CACHE_DIR;
      $this->_smarty->cache_lifetime  = SMARTY_CACHE_LIFE_TIME;
      $this->_smarty->caching = SMARTY_CACHE;
    // smarty_end_config

    $this->__VIRTUALS            = Virtuals::dirs();

    $this->_utils = new Utils;

    $this->_mysql = new DB_MySQL(DB_BASE, DB_HOST, DB_USER, DB_PASS);
    $this->_mysql->connect();
  }

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

  /**
   * Enter description here...
   *
   * @param unknown_type $method_name
   * @param unknown_type $method_params
   * @return unknown
   */
  function caller($method_name, $method_params){
     return self::__call($method_name, $method_params);
  }

  /**
   * Enter description here...
   *
   */
  function checkUser()
  {

  }

  /**
   * Enter description here...
   *
   * @param unknown_type $array
   * @param unknown_type $console
   */
  function print_ar($array = array(), $console = false)
  {
    print "\n".(($console == false)? "<xmp>\n":'');
    print_r($array);
    print "\n".(($console == false)? "</xmp>\n":'');
  }


  /**
   * Enter description here...
   *
   * @return unknown
   */
  function getClassObj()
  {
    return $this;
  }


  /**
   * Enter description here...
   *
   */
  function display()
  {
    if(!$this->_smarty->is_cached($this->__VIRTUALS[0].'.html', $_SERVER['REQUEST_URI']))
    {
      $this->print_ar($this->__VIRTUALS);
      $hashes['brands_models'] = $this->getHashes('brands_models');
      $hashes['articles']      = $this->getHashes('articles');
      $hashes['brands']        = $this->getHashes('brands');
      $hashes['models']        = $this->getHashes('models');
      $hashes['brands_by_id']  = $this->getHashes('brands_by_id');

      $this->_smarty->assign('hashes', $hashes);
      $this->_smarty->assign('_VIRT'  , $this->__VIRTUALS);
      switch ($this->__VIRTUALS[0])
      {
        case 'debug':    $this->debug(); $this->tpl = 'debug'; break;
        // ----------------------------------------------------------
        case 'articles':
          $this->tpl = 'articles';
          $article_id = 0;
          if(isset($this->__VIRTUALS[1]))
          {
            if(is_numeric($this->__VIRTUALS[1]))
            {
              $article_id = $this->__VIRTUALS[1];
            }else{
              $article_id = substr($this->__VIRTUALS[1], strrpos($this->__VIRTUALS[1], '-')+1);
            }
            if(is_numeric($article_id))
            {
              $data = $this->_mysql->getData("
              SELECT a.*, users_name
              FROM ".DB_TABLE_REFIX."articles as a
              inner join ".DB_TABLE_REFIX."users as u
              on a.article_owner = u.pk_users_id
              WHERE pk_article_id = '$article_id'");

              if(count($data) == 0 )
              {
                header('Location: /articles/');
              }
              $this->_smarty->assign('article', reset($data));
              //$this->print_ar($data);
            }else{
              header('Location: /articles/');
            }
          }else{
            $this->showArticles();
          }

        break;
        // ----------------------------------------------------------
        case 'parts':
        case 'waiting':
        case 'repare':
          if(isset($this->__VIRTUALS[1])) $brand  = $this->__VIRTUALS[1]; else $brand  = 'all';
          if(isset($this->__VIRTUALS[2])) $models = $this->__VIRTUALS[2]; else $models = 'all';
          //$this->print_ar($this->showParts($brand, $models));
          $cond = 'yes';
          if($this->__VIRTUALS[0] == 'parts')   $cond = 'yes';
          if($this->__VIRTUALS[0] == 'waiting') $cond = 'waiting';
          if($this->__VIRTUALS[0] == 'repare')
          {
            $table = 'repare';
          }else{
            $table = 'parts';
          }
          $this->_smarty->assign('BrandsModelsByTable', $this->getBrandsModelsByTable($this->__VIRTUALS[0]));
          $this->_smarty->assign($this->__VIRTUALS[0], $this->showByBrandsModels($brand, $models, $table,  $cond));
          $this->tpl = $this->__VIRTUALS[0];

        break;
        // ----------------------------------------------------------
      }
    }

    $this->_smarty->display($this->tpl.'.html', $_SERVER['REQUEST_URI']);
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