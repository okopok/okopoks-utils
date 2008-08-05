<?php
class controller_brands_models implements controller_interface
{

  function run()
  {
    $virt = Virtuals::dirs();
    $engine = array('subdir'=>'brands_models');

    switch ($virt[0])
    {
      case 'parts':   self::parts();   break;
      case 'repare':  self::repare();  break;
      case 'waiting': self::waiting(); break;
      default:        Base::location('/');
    }
  }

  function parts()
  {
    $virt = Virtuals::dirs();
    $engine = array('subdir'=>'brands_models');
    $brands_models = Base::load('controller_getHashes')->run('brands_models');
    Base::load('view_parts', array('subdir'=>'parts'))->run();
    //Base::print_ar($brands_models);

    controller_smarty::assign('brands_images', model_checkImages::run('brands'));
    controller_smarty::assign('models_images', model_checkImages::run('models'));

    if(isset($virt[1]) and isset($virt[2]) and strlen($virt[1]) and strlen($virt[2]) and isset($brands_models[$virt[1]][$virt[2]]))
    {
      view_parts::model(Base::load('model_brandsModels', $engine)->getPartsByModel($virt[1],$virt[2]));
    }elseif(isset($virt[1]) and strlen($virt[1]) and isset($brands_models[$virt[1]])){
      view_parts::brand(Base::load('model_brandsModels', $engine)->getPartsByBrand($virt[1]));
    }else{
      view_parts::all(Base::load('model_brandsModels', $engine)->getParts());
    }
    controller_smarty::display();
  }

  function repare()
  {
    $engine = array('subdir'=>'repare');

    $virt = Virtuals::dirs();
    $engine = array('subdir'=>'brands_models');
    $brands_models = Base::load('controller_getHashes')->run('brands_models');
    Base::load('view_parts', array('subdir'=>'parts'))->run();
    //Base::print_ar($brands_models);

    controller_smarty::assign('brands_images', model_checkImages::run('brands'));
    controller_smarty::assign('models_images', model_checkImages::run('models'));

    if(isset($virt[1]) and isset($virt[2]) and strlen($virt[1]) and strlen($virt[2]) and isset($brands_models[$virt[1]][$virt[2]]))
    {
      view_repare::model(Base::load('model_brandsModels', $engine)->getPartsByModel($virt[1],$virt[2]));
    }elseif(isset($virt[1]) and strlen($virt[1]) and isset($brands_models[$virt[1]])){
      view_repare::brand(Base::load('model_brandsModels', $engine)->getPartsByBrand($virt[1]));
    }else{
      view_repare::all(Base::load('model_brandsModels', $engine)->getParts());
    }
    controller_smarty::display();
    controller_smarty::assign('parts', Base::load('model_brandsModels', $engine)->getRepare());
  }

  function waiting()
  {
    Base::load('model_brandsModels', $engine)->getWaiting();
  }
}