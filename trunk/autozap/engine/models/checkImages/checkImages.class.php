<?php
class model_checkImages implements model_interface
{
  function run()
  {
    $type = func_get_arg(0);

    $ok = true;
    switch ($type)
    {
      case 'brands':
        $imgUrl            = IMAGES_URL.BRANDS_IMAGES_DIR;
        $imgPath           = IMAGES_DIR.BRANDS_IMAGES_DIR;
        $sizes['medium']   = IMAGES_BRANDS_MEDIUM;
        $sizes['small']    = IMAGES_BRANDS_SMALL;
        $sizes['original'] = IMAGES_BRANDS_ORIGINAL_NAME;
        $key               = 'pk_brands_id';
        $masName           = 'brandsImages';
        break;
      case 'models':
        $imgUrl            = IMAGES_URL.MODELS_IMAGES_DIR;
        $imgPath           = IMAGES_DIR.MODELS_IMAGES_DIR;
        $sizes['medium']   = IMAGES_MODELS_MEDIUM;
        $sizes['small']    = IMAGES_MODELS_SMALL;
        $sizes['original'] = IMAGES_MODELS_ORIGINAL_NAME;
        $key               = 'pk_models_id';
        $masName           = 'modelsImages';
        break;
      default: $ok = false;
    }

    if(!$ok) return false;
    $data = Base::load('controller_getHashes')->run($type);
    $images = array();
    foreach ($data as $tag => $row)
    {
      if($type == 'brands')    $images[$row[$key]] = model_images::getBrandImage($row[$key]);
      if($type == 'models')    $images[$row[$key]] = model_images::getModelImage($row[$key]);
      if($type == 'articles')  $images[$row[$key]] = model_images::getArticleImage($row[$key]);
    }
    //Base::print_ar($images);
    return $images;
  }
}
?>