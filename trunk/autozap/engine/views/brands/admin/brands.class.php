<?php

class view_admin_brands implements view_interface
{
  function run()
  {

  }

  function showEditOne($data)
  {
    fb($data,'showEditOne in view_admin_brands');
    controller_smarty::assign('brands', $data);
    controller_smarty::registerBlock('center_center','brands_edit_one','admin');
  }
  function showList($data)
  {
    controller_smarty::registerBlock('center_center','brands_showList','admin');
    fb($data,'showList in brands_showList');
    controller_smarty::assign('brandsModels', $data);
  }
}

?>