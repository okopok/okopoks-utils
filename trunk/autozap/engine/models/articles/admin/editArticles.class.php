<?php

class model_admin_editArticles implements model_interface
{

  function run()
  {

  }

  function edit($id,$data)
  {
    fb($id,'edit');
    fb($data,'edit2');

    if(!is_numeric($id)) return false;
    if(isset($_FILES['field_article_img']))
    {
      $img = model_images::saveArticleImage($id, $_FILES['field_article_img']);
    }

    $sql = "
      UPDATE ".DB_TABLE_REFIX."articles SET
      article_name       = '".((isset($data['field_article_name']))? $data['field_article_name']:'')."',
      article_name_tag   = '".((isset($data['field_article_name']))? utils::tagger(utils::rus2translit($data['field_article_name'])):'')."',
      article_text       = '".((isset($data['field_article_text']))? $data['field_article_text']:'')."',
      article_timestamp  = ".((isset($data['field_article_timestamp']))? strtotime($data['field_article_timestamp']):'UNIX_TIMESTAMP()').",
      article_owner      = ".((isset($data['field_article_owner']))? $data['field_article_owner']:'').",
      article_publish    = '".((isset($data['field_article_publish']))? $data['field_article_publish']:'no')."',
      article_changetime = UNIX_TIMESTAMP(),
      article_img        = ".((isset($img)) ? "'$img'" : 'article_img').",
      article_spec       = '".((isset($data['field_article_spec']))? $data['field_article_spec']:'no')."'
      WHERE pk_article_id     = '$id'
    ";

    bd::query($sql);
    fb('rows Updated', mysql_affected_rows());

  }
}