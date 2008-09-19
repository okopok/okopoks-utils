<?php

class view_admin_models implements view_interface
{
  function run()
  {

  }

  function showEditOne($data)
  {
    fb($data,'showEditOne in view_admin_models');
    controller_smarty::assign('models', $data);
    controller_smarty::registerBlock('center_center','models_edit_one','admin');
  }
  function showList($data)
  {
    fb($data,'showList in view_admin_models');  
    controller_smarty::assign('brandsModels', $data);
    controller_smarty::registerBlock('center_center','models_showList','admin');
  }
}

?>