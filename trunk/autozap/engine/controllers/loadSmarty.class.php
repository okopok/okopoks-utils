<?php

class controller_loadSmarty  implements controller_interface
{
  function run()
  {
    require_once(SMARTY_DIR .  'Smarty.class.php');
    // smarty_start_config
    $smarty = new Smarty();
    $smarty->template_dir    = SMARTY_TEMPLATE_DIR;
    $smarty->compile_dir     = SMARTY_COMPILE_DIR;
    $smarty->config_dir      = SMARTY_CONFIG_DIR; // пока не задано
    $smarty->cache_dir       = SMARTY_CACHE_DIR;
    $smarty->cache_lifetime  = SMARTY_CACHE_LIFE_TIME;
    $smarty->caching = SMARTY_CACHE;
    // smarty_end_config
    return $smarty;
  }
}