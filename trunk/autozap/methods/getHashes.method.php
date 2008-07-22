<?php

if(isset($method_params[0]))
{
  switch ($method_params[0]){
    case 'brands_models':
      if(is_file(BRANDS_MODELS_HASH))
      {
        return unserialize(file_get_contents(BRANDS_MODELS_HASH));
      }else{
        return $this->buildHashes('brands_models');
      }
      break;
    case 'articles':
      if(is_file(ARTICLES_HASH))
      {
        return unserialize(file_get_contents(ARTICLES_HASH));
      }else{
        return $this->buildHashes('articles');
      }
      break;
    case 'brands':
      if(is_file(BRANDS_HASH))
      {
        return unserialize(file_get_contents(BRANDS_HASH));
      }else{
        return $this->buildHashes('brands');
      }
      break;
    case 'models':
      if(is_file(MODELS_HASH))
      {
        return unserialize(file_get_contents(MODELS_HASH));
      }else{
        return $this->buildHashes('models');
      }
      break;
    case 'brands_by_id':
      if(is_file(BRANDS_BY_ID_HASH))
      {
        return unserialize(file_get_contents(BRANDS_BY_ID_HASH));
      }else{
        return $this->buildHashes('brands_by_id');
      }
      break;
     default:
      return array();
  }
}else{
  return array();
}
?>