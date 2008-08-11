<?php
class controller_public_brands_models implements controller_public_interface
{

  function run()
  {
    $virt = Virtuals::dirs();
    switch ($virt[0])
    {
      case 'parts':   self::parts();   break;
      case 'repare':  self::repare();  break;
      case 'waiting': self::waiting(); break;
      default:        Base::location('/');
    }
  }



  function repare()
  {
    $virt = Virtuals::dirs();
    print __LINE__;
    $brands_models = Base::load('controller_public_getHashes')->run('brands_models');
    Base::load('view_public_parts')->run();
    //Base::print_ar($brands_models);

    controller_smarty::assign('brands_images', model_public_checkImages::run('brands'));
    controller_smarty::assign('models_images', model_public_checkImages::run('models'));

    if(isset($virt[1]) and isset($virt[2]) and strlen($virt[1]) and strlen($virt[2]) and isset($brands_models[$virt[1]][$virt[2]]))
    {
      view_public_repare::model(Base::load('model_public_brandsModels')->getRepareByModel($virt[1],$virt[2]));
    }elseif(isset($virt[1]) and strlen($virt[1]) and isset($brands_models[$virt[1]])){
      view_public_repare::brand(Base::load('model_public_brandsModels')->getRepareByBrand($virt[1]));
    }else{
      view_public_repare::all(Base::load('model_public_brandsModels')->getRepare());
    }

    //controller_smarty::display();

  }


}