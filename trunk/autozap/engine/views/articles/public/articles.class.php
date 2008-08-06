<?php

class view_articles  implements view_interface
{


  function run()
  {
    controller_smarty::run();
    controller_smarty::setTheme('default','public');
  }

  function showOne($data)
  {
    self::run();
    controller_smarty::registerBlock('center_center','articles_one_article');
    controller_smarty::assign('article', reset($data));
  }
  function showAll($data)
  {
    self::run();
    controller_smarty::registerBlock('center_center','articles_page_articles');
    controller_smarty::assign('articles', $data);
  }

  function showPreviews($data)
  {
    self::run();
    controller_smarty::registerBlock('center_center','articles_preview');
    controller_smarty::assign('articles', $data);
  }

}