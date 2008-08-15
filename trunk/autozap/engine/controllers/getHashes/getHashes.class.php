<?php
class controller_getHashes implements controller_interface
{
  public function run()
  {
    $type = func_get_arg(0);
    if(isset($type))
    {
      switch ($type)
      {
        case 'brands_models':
          return self::brands_models();
          break;
        case 'articles':
          return self::articles();
          break;
        case 'brands':
        case 'brands_by_name':
        case 'brandsbyname':
          return self::brands();
          break;
        case 'models':
        case 'modelsbyid':
        case 'models_by_id':
          return self::models();
          break;
        case 'brands_by_id':
        case 'brandsbyid':
          return self::brandsbyid();
          break;
         default:
          return array();
      }
    }else{
      return  array();
    }
  }

  function brands()
  {
    if(is_file(BRANDS_HASH))
    {
      $data =  unserialize(file_get_contents(BRANDS_HASH));
    }else{
      $data =  Base::load('model_buildHashes')->run('brands');
    }
    return $data;
  }

  function models()
  {
    if(is_file(MODELS_HASH))
    {
      $data =  unserialize(file_get_contents(MODELS_HASH));
    }else{
      $data =  Base::load('model_buildHashes')->run('models');
    }
    return $data;
  }

  function brandsbyid()
  {
    if(is_file(BRANDS_BY_ID_HASH))
    {
      $data =  unserialize(file_get_contents(BRANDS_BY_ID_HASH));
    }else{
      $data =  Base::load('model_buildHashes')->run('brands_by_id');
    }
    return $data;
  }

  function articles()
  {
    if(is_file(ARTICLES_HASH))
    {
      $data =  unserialize(file_get_contents(ARTICLES_HASH));
    }else{
      $data =  Base::load('model_buildHashes')->run('articles');
    }
    return $data;
  }

  function brands_models()
  {
    if(is_file(BRANDS_MODELS_HASH))
    {
      $data = unserialize(file_get_contents(BRANDS_MODELS_HASH));
    }else{
      $data =  Base::load('model_buildHashes')->run('brands_models');
    }
    return $data;
  }

}

?>