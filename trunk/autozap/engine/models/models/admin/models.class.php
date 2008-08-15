<?php
class model_admin_models implements model_interface
{
  function run(){}

  function edit($id,$data)
  {
    if(!is_numeric($id)) return false;
    if(isset($data['field_model_del_img']))
    {
      model_images::deleteModelsImages($id);
    }
    if(isset($_FILES['field_model_img']))
    {
      $img = model_images::saveModelImage($id, $_FILES['field_model_img']);
    }

    $brand_tag = Utils::tagger(Utils::rus2translit(trim($data['field_model_name'])));
    bd::query("
      UPDATE ".DB_TABLE_REFIX."models
      SET models_name = '".mysql_real_escape_string(trim($data['field_model_name']))."',
          models_name_tag = '$brand_tag',
          models_info = '".mysql_real_escape_string(trim($data['field_model_info']))."'
      WHERE pk_models_id  = '$id'
    ");
  }
  function delete($id)
  {
    model_images::deleteModelsImages($row['pk_models_id']);
    bd::query("DELETE FROM ".DB_TABLE_REFIX."parts  WHERE fk_models_id = '$id'");
    bd::query("DELETE FROM ".DB_TABLE_REFIX."repare WHERE fk_models_id = '$id'");
    bd::query("DELETE FROM ".DB_TABLE_REFIX."models WHERE pk_models_id = '$id'");
  }


}

?>