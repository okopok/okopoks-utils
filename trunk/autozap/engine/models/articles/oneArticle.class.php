<?php

class model_oneArticle implements model_interface
{
  function run()
  {
    $article_id = func_get_args();
    $article_id = $article_id[0];
    return  bd::getData(
        "
          SELECT a.*, users_name
          FROM ".DB_TABLE_REFIX."articles as a
          inner join ".DB_TABLE_REFIX."users as u
          on a.article_owner = u.pk_users_id
          WHERE pk_article_id = '$article_id'
        ");
  }

}

?>