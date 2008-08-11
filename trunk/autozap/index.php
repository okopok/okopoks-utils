<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/includes.php');
bd::init();
print_r(bd::getData("select 1"));
print_r(bd::query("select 1"));

$_virtuals = Virtuals::dirs();

Base::load('controller_smarty')->run();

if($_virtuals[0] == 'admin')
{
  print 'aha';
  Base::load('controller_public_display')->run();
}else{

  Base::load('controller_public_display')->run();
}

?>