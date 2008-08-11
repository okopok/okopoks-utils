<?php

class controller_public_articles implements controller_interface
{
  public function run()
  {
    $article_id     = 0;
    $_virtuals      = Virtuals::dirs();

    if(isset($_virtuals[1]) and isset($_virtuals[2]) and $_virtuals[1] == 'page' and is_numeric($_virtuals[2]))
    {
      self::showPage($_virtuals[2]);
    }elseif(isset($_virtuals[1]))
    {
      self::showOne($_virtuals[1]);
    }else{
      self::showAll();
    }
    //controller_smarty::display();
    //Base::print_ar($data);
  }

  function showAll()
  {
    $MODEL_ARTICLES = Base::load('model_public_articles');
    view_public_articles::showAll($MODEL_ARTICLES->getPage(ARTICLES_PAGE_LIMIT, 1));
  }

  function showOne($id)
  {
    $MODEL_ARTICLES = Base::load('model_public_articles');
    if(is_numeric($id))
    {
      $article_id = $id;
    }else{
      $article_id = substr($id, strrpos($id, '-')+1);
    }
    if(is_numeric($article_id))
    {
      $data = $MODEL_ARTICLES->getOne($article_id);
      view_public_articles::showOne($data);
      if(count($data) == 0 )
      {
        Base::location('/articles/');
      }
    }else{
      Base::location('/articles/');
    }
  }

  function showPage($page)
  {
    if($page < 1) Base::location('/articles/page/1/');
    $MODEL_ARTICLES = Base::load('model_public_articles');
    view_public_articles::showAll($MODEL_ARTICLES->getPage(ARTICLES_PAGE_LIMIT,$page));
  }

  function showPreviews($id = 0, $page = 1)
  {
    if($id > 0)
    {
      $data = Base::load('model_public_articles')->getOne($id);
    }else{
      $data = Base::load('model_public_articles')->getPage(ARTICLES_PAGE_LIMIT,$page)->result;
    }
    foreach ($data as $key => $row)
    {
      $row['article_text'] = substr(trim(strip_tags($row['article_text'],ARTICLES_ALLOW_TAGS)),0, ARTICLES_PREVIEW_LENGHT);
      $row['article_text'] = substr($row['article_text'],0,strpos($row['article_text'],'. '));
      $data[$key] = $row;
    }
    view_public_articles::showPreviews($data);
  }
}
?>