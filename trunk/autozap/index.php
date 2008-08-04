<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/includes.php');
bd::init();
print_r(bd::getData("select 1"));
print_r(bd::query("select 1"));
//die;


/*

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
*/

//$m = new Base();
Base::load('controller_smarty')->run();
Base::load('controller_display')->run();
//Base::load('controller_displasy')->run();
//Base::load('controller_test')->run(234,65,457234,234,6);
//$m->controller['controller_test']->run(1,2,3);
//new controller_display();

//print 'hello world!<xmp>';

//print_r(scandir('../'));
//print_r($_SERVER);
?>