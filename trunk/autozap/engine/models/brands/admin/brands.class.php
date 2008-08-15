<?php
class model_admin_brands implements model_interface
{
  function run(){}

  function edit($id,$data)
  {
    if(!is_numeric($id)) return false;
    if(isset($data['field_brand_del_img']))
    {
      model_images::deleteBrandsImages($id);
    }
    if(isset($_FILES['field_brand_img']))
    {
      $img = model_images::saveBrandImage($id, $_FILES['field_brand_img']);
    }

    $brand_tag = Utils::tagger(Utils::rus2translit(trim($data['field_brand_name'])));
    bd::query("
      UPDATE ".DB_TABLE_REFIX."brands
      SET brands_name = '".mysql_real_escape_string(trim($data['field_brand_name']))."',
          brands_name_tag = '$brand_tag',
          brands_info = '".mysql_real_escape_string(trim($data['field_brand_info']))."'
      WHERE pk_brands_id  = '$id'
    ");


  }
  function delete($id)
  {
    bd::query("DELETE FROM ".DB_TABLE_REFIX."brands WHERE pk_brands_id = '{$id}'");
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