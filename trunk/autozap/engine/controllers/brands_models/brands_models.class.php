<?php
class controller_brands_models implements controller_interface
{

  function run()
  {
    $virt = Virtuals::dirs();
    switch ($virt[0])
    {
      case 'parts':
        cotroller_smarty::assign('parts', Base::load('model_brandsModels', $engine)->getParts());
      break;
      case 'repare':
        cotroller_smarty::assign('parts', Base::load('model_brandsModels', $engine)->getRepare());
      break;
      case 'waiting':
        cotroller_smarty::assign('parts', Base::load('model_brandsModels', $engine)->getWaiting());
      break;
      default: Base::location('/');
    }
  }

  function parts()
  {

  }

  function repare()
  {

  }

  function waiting()
  {

  }
}