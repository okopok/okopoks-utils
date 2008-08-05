<?php
class controller_getHashes implements controller_interface
{
  static private $data = array();
  public function run()
  {
    $type = func_get_arg(0);
    if(isset($type))
    {
      if(isset(self::$data[$type]) and count(self::$data[$type]))
      {
        return self::$data[$type];
      }
      switch ($type){
        case 'brands_models':
          if(is_file(BRANDS_MODELS_HASH))
          {
            $data[$type] = unserialize(file_get_contents(BRANDS_MODELS_HASH));
          }else{
            $data[$type] =  Base::load('model_buildHashes')->run('brands_models');
          }
          break;
        case 'articles':
          if(is_file(ARTICLES_HASH))
          {
            $data[$type] =  unserialize(file_get_contents(ARTICLES_HASH));
          }else{
            $data[$type] =  Base::load('model_buildHashes')->run('articles');
          }
          break;
        case 'brands':
        case 'brands_by_name':
        case 'brandsbyname':
          if(is_file(BRANDS_HASH))
          {
            $data[$type] =  unserialize(file_get_contents(BRANDS_HASH));
          }else{
            $data[$type] =  Base::load('model_buildHashes')->run('brands');
          }
          break;
        case 'models':
        case 'modelsbyid':
        case 'models_by_id':
          if(is_file(MODELS_HASH))
          {
            $data[$type] =  unserialize(file_get_contents(MODELS_HASH));
          }else{
            $data[$type] =  Base::load('model_buildHashes')->run('models');
          }
          break;
        case 'brands_by_id':
        case 'brandsbyid':
          if(is_file(BRANDS_BY_ID_HASH))
          {
            $data[$type] =  unserialize(file_get_contents(BRANDS_BY_ID_HASH));
          }else{
            $data[$type] =  Base::load('model_buildHashes')->run('brands_by_id');
          }
          break;
         default:
          $data[$type] =  array();
      }
      self::$data[$type] = $data[$type];
      return self::$data[$type];
    }else{
      return  array();
    }
  }
}

?>