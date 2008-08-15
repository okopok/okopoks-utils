<?php
include_once(UTILS_DIR.'ImageResizer.class.php');
class model_images implements model_interface
{
  function run()
  {}

  function saveArticleImage($id, $imageData)
  {
      $imgPath = ARTICLES_IMAGES_DIR.$id;
      $ext = strtolower(substr($imageData['name'], strrpos($imageData['name'],'.')));
      if(eregi('image', $dataImg['type']) and in_array($ext, explode(',',IMAGE_EXTS)))
      {
        copy($imageData['tmp_name'], IMAGES_DIR.$imgPath.IMAGES_ARTICLES_ORIGINAL_NAME.$ext);
        $IMG = new ImageResizer();
        $IMG->resize(IMAGES_ARTICLES_MEDIUN,IMAGES_ARTICLES_MEDIUN, $imageData['tmp_name'], IMAGES_DIR.$imgPath.'-'.IMAGES_ARTICLES_MEDIUN.$ext, array('fill_in_box' => 1));
        $IMG->resize(IMAGES_ARTICLES_SMALL,IMAGES_ARTICLES_SMALL, IMAGES_DIR.$imgPath.'-'.IMAGES_ARTICLES_MEDIUN.$ext, IMAGES_DIR.$imgPath.'-'.IMAGES_ARTICLES_SMALL.$ext,        array('fill_in_box' => 1));
        return $id;
      }else{
        return false;
      }
  }

  function getArticleImage($id)
  {
    $sql = 'SELECT article_img FROM '.DB_TABLE_REFIX.'articles WHERE pk_article_id = "'.$id.'"';
    $data = reset(bd::getData($sql));
    fb($data,'data');
    if(isset($data['article_img']) and is_numeric($data['article_img']))
    {
      $path = IMAGES_URL.ARTICLES_IMAGES_DIR.$id;
      foreach (explode(',',IMAGE_EXTS) as $ext)
      {
        if(file_exists(IMAGES_DIR.ARTICLES_IMAGES_DIR.$id.IMAGES_ARTICLES_ORIGINAL_NAME.$ext))
        {
          return array(
            'original'=>$path.IMAGES_ARTICLES_ORIGINAL_NAME.$ext,
            'small'=>$path.'-'.IMAGES_ARTICLES_SMALL.$ext,
            'medium'=>$path.'-'.IMAGES_ARTICLES_MEDIUN.$ext
          );
        }
      }
      print 'asdasd';
    }elseif(isset($data['article_img']) and strlen($data['article_img'])){
      return array('original'=>$data['article_img']);
    }else{
      return array();
    }
  }

  function getBrandImage($id)
  {
    $path = IMAGES_URL.BRANDS_IMAGES_DIR.$id;
    foreach (explode(',',IMAGE_EXTS) as $ext)
    {
      if(file_exists(IMAGES_DIR.BRANDS_IMAGES_DIR.$id.IMAGES_BRANDS_ORIGINAL_NAME.$ext))
      {
        return array(
          'original'=>$path.IMAGES_BRANDS_ORIGINAL_NAME.$ext,
          'small'=>$path.'-'.IMAGES_BRANDS_SMALL.$ext,
          'medium'=>$path.'-'.IMAGES_BRANDS_MEDIUM.$ext
        );
      }
    }
  }

  function getModelImage($id)
  {
    $path = IMAGES_URL.MODELS_IMAGES_DIR.$id;
    foreach (explode(',',IMAGE_EXTS) as $ext)
    {
      if(file_exists(IMAGES_DIR.MODELS_IMAGES_DIR.$id.IMAGES_MODELS_ORIGINAL_NAME.$ext))
      {
        return array(
          'original'=>$path.IMAGES_MODELS_ORIGINAL_NAME.$ext,
          'small'=>$path.'-'.IMAGES_MODELS_SMALL.$ext,
          'medium'=>$path.'-'.IMAGES_MODELS_MEDIUM.$ext
        );
      }
    }
  }
  function saveModelImage($id, $dataImg)
  {
    $imgPath  = MODELS_IMAGES_DIR.$id;
    $ext      = strtolower(substr($dataImg['name'], strrpos($dataImg['name'],'.')));
    if(eregi('image', $dataImg['type']) and in_array($ext, explode(',',IMAGE_EXTS)))
    {
      $_IMG = new ImageResizer();
      copy($dataImg['tmp_name'], IMAGES_DIR.$imgPath.IMAGES_MODELS_ORIGINAL_NAME.$ext);
      $_IMG->resize(IMAGES_MODELS_MEDIUM,IMAGES_MODELS_MEDIUM, $dataImg['tmp_name'], IMAGES_DIR.$imgPath.'-'.IMAGES_MODELS_MEDIUM.$ext, array('fill_in_box' => 1));
      $_IMG->resize(IMAGES_MODELS_SMALL,IMAGES_MODELS_SMALL, IMAGES_DIR.$imgPath.'-'.IMAGES_MODELS_MEDIUM.$ext, IMAGES_DIR.$imgPath.'-'.IMAGES_MODELS_SMALL.$ext,        array('fill_in_box' => 1));
      return $id;
    }else{
      return false;
    }
  }

  function saveBrandImage($id, $dataImg)
  {
    $imgPath  = BRANDS_IMAGES_DIR.$id;
    $ext      = strtolower(substr($dataImg['name'], strrpos($dataImg['name'],'.')));
    if(eregi('image', $dataImg['type']) and in_array($ext, explode(',',IMAGE_EXTS)))
    {
      $_IMG = new ImageResizer();
      copy($dataImg['tmp_name'], IMAGES_DIR.$imgPath.IMAGES_BRANDS_ORIGINAL_NAME.$ext);
      $_IMG->resize(IMAGES_BRANDS_MEDIUM,IMAGES_BRANDS_MEDIUM, $dataImg['tmp_name'], IMAGES_DIR.$imgPath.'-'.IMAGES_BRANDS_MEDIUM.$ext, array('fill_in_box' => 1));
      $_IMG->resize(IMAGES_BRANDS_SMALL,IMAGES_BRANDS_SMALL, IMAGES_DIR.$imgPath.'-'.IMAGES_BRANDS_MEDIUM.$ext, IMAGES_DIR.$imgPath.'-'.IMAGES_BRANDS_SMALL.$ext,        array('fill_in_box' => 1));
      return $id;
    }else{
      return false;
    }
  }

  function deleteBrandsImages($id)
  {
    $imgPath  = BRANDS_IMAGES_DIR.$id;
    foreach (explode(',',IMAGE_EXTS) as $ext)
    {
    	@unlink(IMAGES_DIR.$imgPath.'-'.IMAGES_BRANDS_MEDIUM.trim($ext));
      @unlink(IMAGES_DIR.$imgPath.'-'.IMAGES_BRANDS_SMALL.trim($ext));
      @unlink(IMAGES_DIR.$imgPath.IMAGES_BRANDS_ORIGINAL_NAME.trim($ext));
    }
  }

  function deleteModelsImages($id)
  {
    $imgPath  = MODELS_IMAGES_DIR.$id;
    foreach (explode(',',IMAGE_EXTS) as $ext)
    {
    	@unlink(IMAGES_DIR.$imgPath.'-'.IMAGES_MODELS_MEDIUM.trim($ext));
      @unlink(IMAGES_DIR.$imgPath.'-'.IMAGES_MODELS_SMALL.trim($ext));
      @unlink(IMAGES_DIR.$imgPath.IMAGES_MODELS_ORIGINAL_NAME.trim($ext));
    }
  }

  function deleteArticlesImages($id)
  {
    $imgPath  = ARTICLES_IMAGES_DIR.$id;
    foreach (explode(',',IMAGE_EXTS) as $ext)
    {
    	@unlink(IMAGES_DIR.$imgPath.'-'.IMAGES_ARTICLES_MEDIUN.trim($ext));
      @unlink(IMAGES_DIR.$imgPath.'-'.IMAGES_ARTICLES_SMALL.trim($ext));
      @unlink(IMAGES_DIR.$imgPath.IMAGES_ARTICLES_ORIGINAL_NAME.trim($ext));
    }
  }

}

?>