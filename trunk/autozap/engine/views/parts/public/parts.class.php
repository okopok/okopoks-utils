<?php
class view_public_parts implements view_brands_models_interface
{
  function run()
  {
    controller_smarty::run();
    controller_smarty::setTheme('default','public');
  }
  function brand($data)
  {
    //Base::print_ar($data);
    self::run();
    controller_smarty::registerBlock('center_bottom','parts_bybrand');
    controller_smarty::assign('parts',$data);
  }
  function model($data)
  {
    //Base::print_ar($data);
    self::run();
    controller_smarty::registerBlock('center_bottom','parts_bymodel');
    controller_smarty::assign('parts',$data);
  }

  function all($data)
  {
    //Base::print_ar($data);
    self::run();
    controller_smarty::registerBlock('center_bottom','parts_all');
    controller_smarty::assign('parts',$data);
  }
}
?>