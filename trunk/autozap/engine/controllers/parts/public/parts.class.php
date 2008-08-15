<?php
class controller_public_parts implements controller_interface
{
  function run()
  {
    $virt = Virtuals::dirs();
    $brands_models = Base::load('controller_getHashes')->run('brands_models');
    Base::load('view_public_parts')->run();
    controller_smarty::assign('controller_action','parts');
    //Base::print_ar($brands_models);
    controller_smarty::assign('brandsbyid', controller_getHashes::run('brands_by_id'));
    controller_smarty::assign('modelsbyid', controller_getHashes::run('models'));
    controller_smarty::assign('brands_images', model_checkImages::run('brands'));
    controller_smarty::assign('models_images', model_checkImages::run('models'));

    if(isset($virt[1]) and isset($virt[2]) and strlen($virt[1]) and strlen($virt[2]) and isset($brands_models[$virt[1]][$virt[2]]))
    {
      view_public_parts::model(Base::load('model_public_parts')->getPartsByModel($virt[1],$virt[2]));
    }elseif(isset($virt[1]) and strlen($virt[1]) and isset($brands_models[$virt[1]])){
      view_public_parts::brand(Base::load('model_public_parts')->getPartsByBrand($virt[1]));
    }else{
      view_public_parts::all(Base::load('model_public_parts')->getParts());
    }
  }

}