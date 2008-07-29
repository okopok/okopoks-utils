<?php
//print __LINE__;
//$this->print_ar($method_params);
class model_buildHashes extends Base implements model_interface
{
  public function run()
  {
    $method_params = func_get_args();
    if(isset($method_params[0]))
    {
      switch ($method_params[0]){
        case 'brands_models':
          $brandsModelsData = $this->_mysql->getData("
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
          break;
        // ....................................................................
        case 'articles':
          $articlesData = $this->_mysql->getData("
            SELECT pk_article_id, article_name, article_name_tag, article_timestamp, article_owner, article_publish, article_changetime
            FROM ".DB_TABLE_REFIX."articles ORDER BY article_timestamp DESC, article_name ASC
          ");
          file_put_contents(ARTICLES_HASH, serialize($articlesData));
          return $articlesData;
          break;
        // ....................................................................
        case 'brands':
          $brandsData = $this->_mysql->getData("
              SELECT pk_brands_id, brands_name, brands_name_tag FROM ".DB_TABLE_REFIX."brands ORDER BY brands_name
          ");
          $BRANDS_HASH = array();
          foreach ($brandsData as $row)
          {
             $BRANDS_HASH[$row['brands_name_tag']] = $row;
          }
          file_put_contents(BRANDS_HASH, serialize($BRANDS_HASH));
          return $BRANDS_HASH;
          break;
        // ....................................................................
        case 'models':
          $modelsData = $this->_mysql->getData("
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
          break;
        // ....................................................................
        case 'brands_by_id':
          $brandsData = $this->_mysql->getData("
              SELECT pk_brands_id, brands_name, brands_name_tag FROM ".DB_TABLE_REFIX."brands ORDER BY brands_name
          ");
          $BRANDS_HASH = array();
          foreach ($brandsData as $row)
          {
             $BRANDS_HASH[$row['pk_brands_id']] = $row;
          }
          file_put_contents(BRANDS_BY_ID_HASH, serialize($BRANDS_HASH));
          return $BRANDS_HASH;
          break;
        // ....................................................................
        default:
          return array();
      }
    }else{
      return array();
    }
  }
}

?>