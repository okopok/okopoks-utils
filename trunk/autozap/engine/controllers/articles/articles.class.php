<?php

class controller_articles implements controller_interface
{
  public function run()
  {
    $article_id = 0;
    $_virtuals  = Virtuals::dirs();
    $engine     = array('subdir'=>'articles');
    $MODEL_ARTICLES = Base::load('model_Articles', $engine);
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
        $data = $MODEL_ARTICLES->getOne($article_id);
        view_articles::showOne($data);
        if(count($data) == 0 )
        {
          header('Location: /articles/');
        }
      }else{
        header('Location: /articles/');
      }
    }else{
      $data = $MODEL_ARTICLES->getPage(10, 1);
      view_articles::showAll($data);
    }
    controller_smarty::display();
    //Base::print_ar($data);
  }
}
?>