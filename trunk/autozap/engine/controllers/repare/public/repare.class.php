<?php

class controller_public_repare implements controller_interface
{

  function run()
  {
    $virt = Virtuals::dirs();

    $brands_models = Base::load('controller_getHashes')->run('brands_models');
    controller_smarty::assign('controller_action','repare');
    controller_smarty::assign('brands_images', model_checkImages::run('brands'));
    controller_smarty::assign('models_images', model_checkImages::run('models'));
    if(isset($virt[1]) and isset($virt[2]) and strlen($virt[1]) and strlen($virt[2]) and isset($brands_models[$virt[1]][$virt[2]]))
    {
      view_public_repare::model(Base::load('model_public_repare')->getRepareByModel($virt[1],$virt[2]));
    }elseif(isset($virt[1]) and strlen($virt[1]) and isset($brands_models[$virt[1]])){
      view_public_repare::brand(Base::load('model_public_repare')->getRepareByBrand($virt[1]));
    }else{
      view_public_repare::all(Base::load('model_public_repare')->getRepare());
    }

  }

}