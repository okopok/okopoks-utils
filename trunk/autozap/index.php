<?php
ob_start();
require_once($_SERVER['DOCUMENT_ROOT'].'/includes.php');
bd::init();

Base::load('controller_smarty')->run();

$_virtuals = Virtuals::dirs();
if($_virtuals[0] == 'admin')
{
  Base::load('controller_admin_display')->run();
}else{

  Base::load('controller_public_display')->run();
}

?>