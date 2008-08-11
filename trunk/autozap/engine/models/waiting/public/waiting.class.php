<?php

class model_public_waiting implements model_interface
{

  function run()
  {

  }

  function getWaiting()
  {
    $sql = '
        SELECT b.pk_brands_id,m.pk_models_id,p.*
          FROM '.DB_TABLE_REFIX.'brands as b
    INNER JOIN '.DB_TABLE_REFIX.'models as m ON b.pk_brands_id = m.fk_brands_id
    INNER JOIN '.DB_TABLE_REFIX.'parts as p  ON m.pk_models_id = p.fk_models_id
         WHERE parts_cond = "waiting"
         ORDER BY b.brands_name, m.models_name
         ';
    return bd::getData($sql);
  }

  function getWaitingByBrand($tag)
  {
    $brands = Base::load('controller_getHashes')->run('brands');
    if(!isset($brands[$tag])) return false;
    $sql = '
        SELECT b.pk_brands_id,m.pk_models_id,p.*
          FROM '.DB_TABLE_REFIX.'brands as b
    INNER JOIN '.DB_TABLE_REFIX.'models as m ON b.pk_brands_id = m.fk_brands_id
    INNER JOIN '.DB_TABLE_REFIX.'parts as p ON m.pk_models_id = p.fk_models_id
         WHERE parts_cond = "waiting" and b.pk_brands_id = "'.$brands[$tag]['pk_brands_id'].'"
         ORDER BY b.brands_name, m.models_name
         ';
    return bd::getData($sql);
  }

  function getWaitingByModel($brand, $model)
  {
    $brands_models = Base::load('controller_getHashes')->run('brands_models');
    if(!isset($brands_models[$brand][$model])) return false;
    $sql = '
        SELECT b.pk_brands_id,m.pk_models_id,p.*
          FROM '.DB_TABLE_REFIX.'brands as b
    INNER JOIN '.DB_TABLE_REFIX.'models as m ON b.pk_brands_id = m.fk_brands_id
    INNER JOIN '.DB_TABLE_REFIX.'parts as p ON m.pk_models_id = p.fk_models_id
         WHERE parts_cond = "waiting" and m.pk_models_id = "'.$brands_models[$brand][$model]['pk_models_id'].'"
         ORDER BY b.brands_name, m.models_name
         ';
    return bd::getData($sql);
  }
}