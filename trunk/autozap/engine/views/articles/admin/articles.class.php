<?php

class view_admin_articles  implements view_interface
{


  function run()
  {
    controller_smarty::run();
    controller_smarty::setTheme('default','admin');
  }

  function showOne($data)
  {
    self::run();
    controller_smarty::registerBlock('center_center','articles_one_article','admin');
    controller_smarty::assign('article', reset($data));
  }
  function showAll($data)
  {
    self::run();
    controller_smarty::registerBlock('center_center','articles_page_articles','admin');
    controller_smarty::assign('articles', $data);
  }

  function showList($data)
  {
    self::run();
    fb('showList',FirePHP::TRACE );
    controller_smarty::registerBlock('center_center','articles_list','admin');
    controller_smarty::assign('articles', $data);
  }

  function showEditOne($data)
  {
    self::run();
    fb('showList',FirePHP::TRACE );
    controller_smarty::registerBlock('center_center','articles_edit_one','admin');
    controller_smarty::assign('articles', $data);
  }

}

?>