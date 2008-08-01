<?php

class model_brandsModels extends Base implements model_interface
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

  /**
   * Enter description here...
   *
   * @param unknown_type $table
   * @return unknown
   */
  function getBrandsModelsByTable($table = '')
  {
    switch ($table)
    {
      case 'parts':
      case 'waiting':
      if($table == 'parts')   $cond = 'yes';
      if($table == 'waiting') $cond = 'waiting';

        $sql = '
            SELECT b.*, m.*
              FROM '.DB_TABLE_REFIX.'brands as b
        INNER JOIN '.DB_TABLE_REFIX.'models as m ON b.pk_brands_id = m.fk_brands_id
        INNER JOIN '.DB_TABLE_REFIX.'parts as p  ON m.pk_models_id = p.fk_models_id
             WHERE parts_cond = "'.$cond.'"
          GROUP BY m.pk_models_id';
        break;
      case 'repare':
        $sql = '
            SELECT b.*, m.*
              FROM '.DB_TABLE_REFIX.'brands as b
        INNER JOIN '.DB_TABLE_REFIX.'models as m ON b.pk_brands_id = m.fk_brands_id
        INNER JOIN '.DB_TABLE_REFIX.'repare as r ON m.pk_models_id = r.fk_models_id
          GROUP BY m.pk_models_id';
        break;
    }
    return bd::getData($sql);
  }

}
