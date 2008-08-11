<?php

class view_index implements view_interface
{
  function run()
  {
    controller_smarty::run();
    controller_smarty::setTheme('default','public');
    controller_smarty::registerBlock('center_center','index');

  }


}