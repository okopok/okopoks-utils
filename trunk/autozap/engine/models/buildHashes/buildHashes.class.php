<?php
//print __LINE__;
//$this->print_ar($method_params);
class model_buildHashes implements model_interface
{
  public function run()
  {
    $type = func_get_arg(0);
    if(! isset($type)) return array();
    switch ($type){
      case 'brands_models': return self::brands_models();  break;
      case 'articles':      return self::articles();       break;
      case 'brands':        return self::brands();         break;
      case 'models':        return self::models();         break;
      case 'brands_by_id':  return self::brands_by_id();   break;
      default:              return array();
    }
  }

  function brands_models()
  {
    $brandsModelsData = bd::getData("
        SELECT pk_brands_id, brands_name, brands_name_tag, pk_models_id, models_name, models_name_tag from ".DB_TABLE_REFIX."brands as b
        INNER JoIn ".DB_TABLE_REFIX."models as m
        ON b.pk_brands_id = m.fk_brands_id
        ORDER BY brands_name, models_name
    ");
    $BRANDS_MODELS_HASH = array();
    foreach ($brandsModelsData as $row)
    {
      $BRANDS_MODELS_HASH[$row['brands_name_tag']][$row['models_name_tag']] = $row;
    }
    file_put_contents(BRANDS_MODELS_HASH, serialize($BRANDS_MODELS_HASH));
    return $BRANDS_MODELS_HASH;
  }

  function articles()
  {
    $articlesData = bd::getData("
      SELECT pk_article_id, article_name, article_name_tag, article_timestamp, article_owner, article_publish, article_changetime
      FROM ".DB_TABLE_REFIX."articles ORDER BY article_timestamp DESC, article_name ASC
    ");
    foreach ($articlesData as $row)
    {
    	$newArticlesData[$row['pk_article_id']]['tag'] = $row['article_name_tag'];
    	$newArticlesData[$row['pk_article_id']]['name'] = $row['article_name'];
    }
    file_put_contents(ARTICLES_HASH, serialize($newArticlesData));
    return $articlesData;
  }

  function brands()
  {
    $brandsData = bd::getData("
        SELECT pk_brands_id, brands_name, brands_name_tag FROM ".DB_TABLE_REFIX."brands ORDER BY brands_name
    ");
    $BRANDS_HASH = array();
    foreach ($brandsData as $row)
    {
       $BRANDS_HASH[$row['brands_name_tag']] = $row;
    }
    file_put_contents(BRANDS_HASH, serialize($BRANDS_HASH));
    return $BRANDS_HASH;
  }

  function models()
  {
      $modelsData = bd::getData("
          SELECT pk_brands_id, pk_models_id, models_name, models_name_tag FROM ".DB_TABLE_REFIX."brands as b
          INNER JoIn ".DB_TABLE_REFIX."models as m
          ON b.pk_brands_id = m.fk_brands_id
          ORDER BY brands_name, models_name
      ");
      $MODELS_HASH = array();
      foreach ($modelsData as $row)
      {
        $MODELS_HASH[$row['pk_models_id']] = $row;
      }
      file_put_contents(MODELS_HASH, serialize($MODELS_HASH));
      return $MODELS_HASH;
  }
  function brands_by_id()
  {
    $brandsData = bd::getData("
        SELECT pk_brands_id, brands_name, brands_name_tag FROM ".DB_TABLE_REFIX."brands ORDER BY brands_name
    ");
    $BRANDS_HASH = array();
    foreach ($brandsData as $row)
    {
       $BRANDS_HASH[$row['pk_brands_id']] = $row;
    }
    file_put_contents(BRANDS_BY_ID_HASH, serialize($BRANDS_HASH));
    return $BRANDS_HASH;
  }

  function all()
  {
    self::brands();
    self::brands_by_id();
    self::brands_models();
    self::articles();
    self::models();
  }

  /**
   * rebuild all brands hashes
   *
   */
  function allbrands()
  {
    self::brands();
    self::brands_by_id();
    self::brands_models();
  }
}

?>