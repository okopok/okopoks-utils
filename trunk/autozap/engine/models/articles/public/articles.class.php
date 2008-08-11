<?php

class model_public_articles implements model_interface
{
  function run(){ }

  function getOne($id)
  {
    if(!is_numeric($id)) return false;
    return  bd::getData(
        "
          SELECT a.*, users_name
          FROM ".DB_TABLE_REFIX."articles AS a
          INNER JOIN ".DB_TABLE_REFIX."users AS u
          ON a.article_owner = u.pk_users_id
          WHERE pk_article_id = '$id'
        ");
  }

  function getSet($set, $published = 'yes', $order = 'article_timestamp DESC')
  {
    $where = '';
    if($published == 'yes' or $published == 'no') $where = "article_publish = '$published'";
    return  bd::getData(
        "
          SELECT a.*, users_name
          FROM ".DB_TABLE_REFIX."articles AS a
          INNER JOIN ".DB_TABLE_REFIX."users AS u
          ON a.article_owner = u.pk_users_id
          WHERE pk_article_id in ($set) $where

          ORDER BY $order
        ");
  }

  function getPage($limit, $page = 1,$published = 'yes', $order = 'article_timestamp DESC')
  {
    $where = '';
    if($published == 'yes' or $published == 'no') $where = " WHERE article_publish = '$published'";
    return new RecordSet("
          SELECT SQL_CALC_FOUND_ROWS a.*, users_name
          FROM ".DB_TABLE_REFIX."articles AS a
          INNER JOIN ".DB_TABLE_REFIX."users AS u
          ON a.article_owner = u.pk_users_id
          $where
          ORDER BY $order
    ", $limit, $page);
  }


  function getAll($published = 'yes', $order = 'article_timestamp DESC')
  {
    $where = '';
    if($published == 'yes' or $published == 'no') $where = " WHERE article_publish = '$published'";
    return  bd::getData(
        "
          SELECT a.*, users_name
          FROM ".DB_TABLE_REFIX."articles AS a
          INNER JOIN ".DB_TABLE_REFIX."users AS u
          ON a.article_owner = u.pk_users_id
          $where
          ORDER BY $order
        ");
  }



}

?>