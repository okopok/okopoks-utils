<?php

class controller_admin_articles implements controller_interface
{
  function run()
  {
    $_virtuals = Virtuals::dirs();

    if(isset($_virtuals[2]) and is_numeric($_virtuals[2]) and (!isset($_virtuals[3]) or $_virtuals[3] != 'edit'))
    {
      self::showOne($_virtuals[2]);
    }elseif(isset($_virtuals[2]) and is_numeric($_virtuals[2]) and isset($_virtuals[3]) and $_virtuals[3] == 'edit'){
      self::editOne($_virtuals[2]);
    }elseif(isset($_virtuals[2]) and $_virtuals[2] == 'page' and isset($_virtuals[3]) and is_numeric($_virtuals[3]) and $_virtuals[3] > 0){
      self::showList($_virtuals[3]);
    }else{
      self::showList(1);
    }
  }

  function showList($page)
  {
    $data = model_public_articles::getPage(ARTICLES_PAGE_LIMIT,$page,'all');
    $view = Base::load('view_admin_articles');
    fb('showlist',FirePHP::TRACE );
    fb($data,'articles_data_list');
    $view->showList($data);
  }

  function showOne($id)
  {
    $data = model_public_articles::getOne($id);
    $view = Base::load('view_admin_articles');
    $view->showOne($data);
  }

  function editOne($id)
  {
    if(isset($_POST['mode']) and $_POST['mode'] == 'edit')
    {
      $model = Base::load('model_admin_editArticles','articles');
      $model->edit($id, $_POST);
      Base::load('model_buildHashes')->articles();
      Base::location($_SERVER['REQUEST_URI']);
    }elseif(isset($_POST['mode']) and $_POST['mode'] == 'delete'){
      self::deleteOne($id);
    }
    $users = Base::load('model_users')->getAll();
    fb($users,'users');
    controller_smarty::assign('users',$users);
    $data = model_public_articles::getOne($id);
    $view = Base::load('view_admin_articles');
    $view->showEditOne($data);
  }

  function deleteOne($id)
  {
    $model = Base::load('model_admin_editArticles','articles');
    $model->delete($id);
  }
}