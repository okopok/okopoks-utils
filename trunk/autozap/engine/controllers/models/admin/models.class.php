<?php

class controller_admin_models implements controller_interface
{
  function run()
  {
    $_virtuals = Virtuals::dirs();

    if(isset($_virtuals[2]) and is_numeric($_virtuals[2]) and (!isset($_virtuals[3]) or $_virtuals[3] != 'edit'))
    {
      self::showOne($_virtuals[2]);
    }elseif(isset($_virtuals[2]) and is_numeric($_virtuals[2]) and isset($_virtuals[3]) and $_virtuals[3] == 'edit'){
      self::editOne($_virtuals[2]);
    }else{
      self::showList(1);
    }
  }

  function showList($page)
  {
    $data = controller_getHashes::models();
    fb($data,'models_data_list');
    $view = Base::load('view_admin_models');
    $view->showList($data);
  }

  function showOne($id)
  {
    $data = model_public_models::getOne($id);
    $view = Base::load('view_admin_models');
    $view->showOne($data);
  }

  function editOne($id)
  {
    if(isset($_POST['mode']) and $_POST['mode'] == 'edit')
    {
      $model = Base::load('model_admin_models');
      $model->edit($id, $_POST);
      Base::load('model_buildHashes')->models();
      Base::location($_SERVER['REQUEST_URI']);
    }elseif(isset($_POST['mode']) and $_POST['mode'] == 'delete'){
      self::deleteOne($id);
    }

    $img  = model_images::getModelImage($id);
    controller_smarty::assign('modelsImg',$img);
    fb($img,'img');
    $data = model_public_models::getOne($id);
    $view = Base::load('view_admin_models');
    $view->showEditOne($data);
  }

  function deleteOne($id)
  {
    $model = Base::load('model_admin_models');
    $model->delete($id);
  }
}

?>