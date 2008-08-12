<?php

class controller_admin_articles implements controller_interface
{
  function run()
  {

  }

  function showList($page)
  {
    $data = model_admin_articles::getPage(ARTICLES_PAGE_LIMIT,$page,'all');
    $view = Base::load('view_admin_articles');
    $view->showList($data);
  }
}