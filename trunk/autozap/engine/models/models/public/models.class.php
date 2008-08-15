<?php
class model_public_models implements model_interface
{
  function run(){}

  function getOne($id)
  {
    $data = bd::getData("SELECT * FROM ".DB_TABLE_REFIX."models WHERE pk_models_id = '{$id}'");
    return reset($data);
  }


}

?>