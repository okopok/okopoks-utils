<?php

class controller_public_spec implements controller_interface
{

  function run()
  {
    $data = model_public_articles::getSpecs();
    //Base::print_ar($data);
    fb($data, 'articlesSpec');
    Base::load('view_public_spec','articles')->run();
    Base::load('view_public_spec','articles')->showBig($data, 6);
    Base::load('view_public_spec','articles')->showSmall($data, 4);
    //view_public_specs::showBig();
  }

  function getBig()
  {
    $data = model_public_articles::getSpecs();
    fb($data, 'articlesSpec');
    Base::load('view_public_spec','articles')->showBig($data, 6);
  }

  function getSmall()
  {
    $data = model_public_articles::getSpecs();
    fb($data, 'articlesSpec');
    Base::load('view_public_spec','articles')->showSmall($data, 4);
  }

}