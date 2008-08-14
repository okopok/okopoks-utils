<?php
class model_users implements model_interface
{
  function run(){}

  function getAll()
  {
    return  bd::getData("SELECT * FROM ".DB_TABLE_REFIX."users ORDER BY users_name");
  }
}
?>