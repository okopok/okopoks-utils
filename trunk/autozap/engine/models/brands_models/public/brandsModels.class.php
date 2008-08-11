<?php

class model_public_brandsModels implements model_interface
{

  function run()
  {

  }

  /**
   * Enter description here...
   *
   * @param unknown_type $brand
   * @param unknown_type $model
   * @param unknown_type $table
   * @param unknown_type $cond
   * @return unknown
   */
  function showByBrandsModels($brand = 'all', $model = 'all', $table = 'parts', $cond = 'yes')
  {
    $where = '';
    $BRANDS_HASH = Base::load('controller_getHashes')->run('brands_models');
    if($brand != 'all' and isset($BRANDS_HASH[$brand]))
    {
      $where = "WHERE brands_name_tag = '$brand' ";
    }
    if($brand != 'all' and $model != 'all' and isset($BRANDS_HASH[$brand][$model]))
    {
      $where = "WHERE brands_name_tag = '$brand' AND models_name_tag = '$model' ";
    }

    if($table == 'parts') $where .= " AND parts_cond = '$cond'";

    $data = bd::getData("
    SELECT brands_name, brands_name_tag, pk_brands_id, pk_models_id, models_name, models_name_tag, p.*
    FROM ".DB_TABLE_REFIX."$table as p
    INNER JOIN ".DB_TABLE_REFIX."models as m
    ON m.pk_models_id = p.fk_models_id
    INNER JOIN ".DB_TABLE_REFIX."brands AS b
    ON b.pk_brands_id = m.fk_brands_id
     $where
    ");
    return $data;
  }










}

