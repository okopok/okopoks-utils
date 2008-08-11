<?php

class controller_admin_articles implements controller_interface
{
  function run()
  {

  }

  function showList($page)
  {
    $data = model_articles::getPage(ARTICLES_PAGE_LIMIT,$page,'all');
    $engine['subdir'] = 'articles';
    $engine['type']   = 'public';
    $view = Base::load('view_admin_articles');
    $view->showList($data);
  }
}