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

    if($_virtuals[0] == 'admin')
    {
      controller_smarty::setCachind(false);
      controller_smarty::setTheme('default','admin');
    }else{
      controller_smarty::setCachind(true);
      controller_smarty::setTheme('default','public');
    }
    if(!controller_smarty::is_cached($_SERVER['REQUEST_URI']))
    {
      //$this->print_ar($_virtuals);
      print 'Cached';
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
          Base::load('controller_articles', array('subdir'=>'articles', 'type'=>'public'))->run();
        break;
        // ----------------------------------------------------------
        case 'parts':
        case 'waiting':
        case 'repare':
          $engine['subdir'] = 'brands_models';
          $engine['type']   = 'public';
          Base::load('controller_brands_models', $engine)->run();
        break;
        default: controller_index::run();
        // ----------------------------------------------------------
      }
    }else{
      print 'From Cache';
    }
    controller_smarty::display();
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

