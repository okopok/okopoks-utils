<?php
interface controller_interface
{
  public function run();
}
interface model_interface
{
  public function run();
}
interface view_interface
{
  public function run();
}

interface view_brands_models_interface
{
  public function run();
  public function model($data);
  public function brand($data);
  public function all($data);
}
?>