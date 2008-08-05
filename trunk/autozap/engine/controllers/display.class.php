<?php


class controller_display implements controller_interface
{

  public function run()
  {
    $this->base = Base::getInstance();
    //print $this->base->print_ar('a');
    $this->tpl = '';
    $this->_smarty = Base::load('controller_loadSmarty')->run();
    $_virtuals = Virtuals::dirs();
    if(!$this->_smarty->is_cached($_virtuals[0].'.html', $_SERVER['REQUEST_URI']))
    {
      //$this->print_ar($_virtuals);
      $hashes['brands_models'] = Base::load('controller_getHashes')->run('brands_models');
      $hashes['articles']      = Base::load('controller_getHashes')->run('articles');
      $hashes['brands']        = Base::load('controller_getHashes')->run('brands');
      $hashes['models']        = Base::load('controller_getHashes')->run('models');
      $hashes['brands_by_id']  = Base::load('controller_getHashes')->run('brands_by_id');

      //Base::print_ar($_virtuals);
      //$this->_smarty->assign('hashes', $hashes);
      //$this->_smarty->assign('_VIRT'  , $_virtuals);
      switch ($_virtuals[0])
      {
        case 'debug':    $this->debug(); $this->tpl = 'debug'; break;
        // ----------------------------------------------------------
        case 'articles':
          Base::load('controller_articles', array('subdir'=>'articles'))->run();
        break;
        // ----------------------------------------------------------
        case 'parts':
        case 'waiting':
        case 'repare':
          $engine['subdir'] = 'brands_models';
          Base::load('controller_brands_models', $engine)->run();

        break;
        default: print 'aga';
        // ----------------------------------------------------------
      }
    }

    //$this->_smarty->display($this->tpl.'.html', $_SERVER['REQUEST_URI']);
  }


  static function getSmarty()
  {
    if(!is_object(self::$smarty))
    {
      self::$smarty = new Smarty();
    }
    return self::$smarty;
  }


}
?>

