<?php
class controller_getHashes extends Base implements controller_interface
{
  public function run()
  {
    $method_params = func_get_args();
    if(isset($method_params[0]))
    {
      switch ($method_params[0]){
        case 'brands_models':
          if(is_file(BRANDS_MODELS_HASH))
          {
            return unserialize(file_get_contents(BRANDS_MODELS_HASH));
          }else{
            return Base::load('model_buildHashes')->run('brands_models');
          }
          break;
        case 'articles':
          if(is_file(ARTICLES_HASH))
          {
            return unserialize(file_get_contents(ARTICLES_HASH));
          }else{
            return Base::load('model_buildHashes')->run('articles');
          }
          break;
        case 'brands':
          if(is_file(BRANDS_HASH))
          {
            return unserialize(file_get_contents(BRANDS_HASH));
          }else{
            return Base::load('model_buildHashes')->run('brands');
          }
          break;
        case 'models':
          if(is_file(MODELS_HASH))
          {
            return unserialize(file_get_contents(MODELS_HASH));
          }else{
            return Base::load('model_buildHashes')->run('models');
          }
          break;
        case 'brands_by_id':
          if(is_file(BRANDS_BY_ID_HASH))
          {
            return unserialize(file_get_contents(BRANDS_BY_ID_HASH));
          }else{
            return Base::load('model_buildHashes')->run('brands_by_id');
          }
          break;
         default:
          return array();
      }
    }else{
      return array();
    }
  }
}

?>