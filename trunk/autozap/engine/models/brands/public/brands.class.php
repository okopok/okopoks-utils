<?php
class model_public_brands implements model_interface
{
  function run(){}

  function getOne($id)
  {
    $data = bd::getData("SELECT * FROM ".DB_TABLE_REFIX."brands WHERE pk_brands_id = '{$id}'");
    return reset($data);
  }
  function delete($id)
  {
    model_images::deleteBrandsImages($id);
    $data = $this->_mysql->getData("SELECT pk_models_id FROM ".DB_TABLE_REFIX."models WHERE fk_brands_id = '{$id}'");
    foreach ($data as $row)
    {
      model_images::deleteModelsImages($row['pk_models_id']);
      bd::query("DELETE FROM ".DB_TABLE_REFIX."parts  WHERE fk_models_id = '{$row['pk_models_id']}'");
      bd::query("DELETE FROM ".DB_TABLE_REFIX."repare WHERE fk_models_id = '{$row['pk_models_id']}'");
    }
    bd::query("DELETE FROM ".DB_TABLE_REFIX."models WHERE fk_brands_id = '{$id}'");
  }


}

?>