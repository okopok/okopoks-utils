<?php

class view_public_spec implements view_interface
{
  function run(){
    controller_smarty::setTheme('default','public');
  }

  function showBig($data, $num)
  {
     controller_smarty::registerBlock('center_top', 'articles_spec_big');
     controller_smarty::assign('specsBig',$data);
  }

  function showSmall($data, $num)
  {
     controller_smarty::registerBlock('left_bottom', 'articles_spec_small');
     controller_smarty::assign('specsSmall',$data);
  }
}