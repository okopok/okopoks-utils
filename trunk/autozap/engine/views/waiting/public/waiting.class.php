<?php
class view_waiting implements view_brands_models_interface
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
    self::run();
    controller_smarty::registerBlock('center_center','waiting_bybrand');
    controller_smarty::assign('waiting',$data);
  }

  function model($data)
  {
    self::run();
    controller_smarty::registerBlock('center_center','waiting_bymodel');
    controller_smarty::assign('waiting',$data);
  }

  function all($data)
  {
    self::run();
    controller_smarty::registerBlock('center_center','waiting_all');
    controller_smarty::assign('waiting',$data);
  }

}
?>