<?php

class controller_smarty implements controller_interface
{
  static $instance  = false;
  static $smarty    = false;
  static $theme     = '';
  static $themeType = '';
  static $blocks    = array();

  function run()
  {
    if(self::$instance) return self::$instance;
    self::$smarty = new Smarty;
    self::$smarty->template_dir    = SMARTY_TEMPLATE_DIR;
    self::$smarty->compile_dir     = SMARTY_COMPILE_DIR;
    self::$smarty->config_dir      = SMARTY_CONFIG_DIR; // пока не задано
    self::$smarty->cache_dir       = SMARTY_CACHE_DIR;
    self::$smarty->cache_lifetime  = SMARTY_CACHE_LIFE_TIME;
    self::$smarty->caching         = SMARTY_CACHE;
    self::$instance = new self;
    return self::$instance;
  }
  static function setCachind($bool)
  {
    self::$smarty->caching = $bool;
  }

  static function is_cached($id)
  {
    return self::$smarty->is_cached(self::getThemePath(),$id);
  }

  static function setTheme($theme, $type)
  {
    self::$theme     = $theme;
    self::$themeType = $type;
  }


  static function getTheme()
  {
    return array('theme' => self::$theme,'type' => self::$themeType);
  }

  static function registerBlock($key, $path, $type = 'public')
  {
    if($type == 'admin')
    {
      $path = THEMES_TPL_BLOCKS_ADMIN_DIR.$path.'.'.THEMES_EXTENSION;
    }else{
      $path = THEMES_TPL_BLOCKS_PUBLIC_DIR.$path.'.'.THEMES_EXTENSION;
    }

    self::$blocks[$key]['path'] = $path;
    self::$blocks[$key]['type'] = $type;
  }

  static function assign($name, $data)
  {
    self::$smarty->assign($name, $data);
  }

  function getThemePath()
  {
    if(self::$themeType == 'admin')
    {
      return THEMES_TPL_THEME_ADMIN_DIR.self::$theme.'.'.THEMES_EXTENSION;
    }else{
      return THEMES_TPL_THEME_PUBLIC_DIR.self::$theme.'.'.THEMES_EXTENSION;
    }
  }
  static function display()
  {
    self::$smarty->assign( 'blocks', self::$blocks ) ;
    self::$smarty->display(self::getThemePath(), $_SERVER['REQUEST_URI']);
  }

}