<?php

class controller_articles extends Base implements controller_interface
{
  public function run()
  {
    $this->tpl  = 'articles';
    $article_id = 0;
    $_virtuals = Virtuals::dirs();

    if(isset($_virtuals[1]))
    {
      if(is_numeric($_virtuals[1]))
      {
        $article_id = $_virtuals[1];
      }else{
        $article_id = substr($_virtuals[1], strrpos($_virtuals[1], '-')+1);
      }
      if(is_numeric($article_id))
      {
        $data = Base::load('model_Articles', array('subdir'=>'articles'))->getOne($article_id);
        if(count($data) == 0 )
        {
          header('Location: /articles/');
        }
        //$this->_smarty->assign('article', reset($data));
        //$this->print_ar($data);
      }else{
        header('Location: /articles/');
      }
    }else{
      $data = Base::load('model_Articles', array('subdir'=>'articles'))->getPage(10, 1);
      //$this->showArticles();
    }
    Base::print_ar($data);
  }
}
?>