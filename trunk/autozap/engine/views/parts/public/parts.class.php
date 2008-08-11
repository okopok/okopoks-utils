<?php
class view_public_parts implements view_brands_models_interface
{
  function run()
  {
    controller_smarty::run();
    controller_smarty::setTheme('default','public');
    controller_smarty::assign('brandsbyid', controller_getHashes::run('brands_by_id'));
    controller_smarty::assign('modelsbyid', controller_getHashes::run('models'));
  }
  function brand($data)
  {
    //Base::print_ar($data);
    self::run();
    controller_smarty::registerBlock('center_center','parts_bybrand');
    controller_smarty::assign('parts',$data);
  }
  function model($data)
  {
    //Base::print_ar($data);
    self::run();
    controller_smarty::registerBlock('center_center','parts_bymodel');
    controller_smarty::assign('parts',$data);
  }

  function all($data)
  {
    //Base::print_ar($data);
    self::run();
    controller_smarty::registerBlock('center_center','parts_all');
    controller_smarty::assign('parts',$data);
  }
}
?>