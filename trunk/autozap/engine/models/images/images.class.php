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
      copy($imageData['tmp_name'], IMAGES_DIR.$imgPath.IMAGES_ARTICLES_ORIGINAL_NAME.$ext);
      $IMG = new ImageResizer();
      $IMG->resize(IMAGES_ARTICLES_MEDIUN,IMAGES_ARTICLES_MEDIUN, $imageData['tmp_name'], IMAGES_DIR.$imgPath.'-'.IMAGES_ARTICLES_MEDIUN.$ext, array('fill_in_box' => 1));
      $IMG->resize(IMAGES_ARTICLES_SMALL,IMAGES_ARTICLES_SMALL, IMAGES_DIR.$imgPath.'-'.IMAGES_ARTICLES_MEDIUN.$ext, IMAGES_DIR.$imgPath.'-'.IMAGES_ARTICLES_SMALL.$ext,        array('fill_in_box' => 1));
      return $id;
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

}

?>