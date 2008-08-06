<?php

$MODEL = reset($method_params);


$imgPath = MODELS_IMAGES_DIR.$MODEL['pk_models_id'];

if(isset($_POST['old_name']))
{
  // ------------------------------------------------------
  $brand_tag = $MODEL['models_name_tag'];
  if($_POST['old_name'] <> $_POST['name'])
  {
    $brand_tag = $this->_utils->tagger($this->_utils->rus2translit(trim($_POST['name'])));
    $this->_mysql->qr("
    UPDATE ".DB_TABLE_REFIX."models
    SET models_name = '".mysql_real_escape_string(trim($_POST['name']))."',
        models_name_tag = '$brand_tag'
    WHERE pk_models_id = '{$MODEL['pk_models_id']}'
    ");
  }
  // ------------------------------------------------------
  if(isset($_POST['del_img']))
  {
    @unlink(IMAGES_DIR.$imgPath.'-'.IMAGES_MODELS_MEDIUM.'.jpg');
    @unlink(IMAGES_DIR.$imgPath.'-'.IMAGES_MODELS_SMALL.'.jpg');
  }

  // ------------------------------------------------------
  if(isset($_FILES['img']['tmp_name']))
  {
    $ext  = strtolower(substr($_FILES['img']['name'], strrpos($_FILES['img']['name'],'.')));
    if(eregi('image', $_FILES['img']['type']) and in_array($ext, explode(',',IMAGE_EXTS)))
    {
      include(CLASSES_DIR.'ImageResizer.class.php');
      $_IMG = new ImageResizer();
      copy($_FILES['img']['tmp_name'], IMAGES_DIR.$imgPath.IMAGES_MODELS_ORIGINAL_NAME.$ext);
      $_IMG->resize(IMAGES_MODELS_MEDIUM,IMAGES_MODELS_MEDIUM, $_FILES['img']['tmp_name'], IMAGES_DIR.$imgPath.'-'.IMAGES_MODELS_MEDIUM.$ext, array('fill_in_box' => 1));
      $_IMG->resize(IMAGES_MODELS_SMALL,IMAGES_MODELS_SMALL, IMAGES_DIR.$imgPath.'-'.IMAGES_MODELS_MEDIUM.$ext, IMAGES_DIR.$imgPath.'-'.IMAGES_MODELS_SMALL.$ext,        array('fill_in_box' => 1));
    }
  }

  header('location:'.ADMIN_URL_ROOT.strtolower($method_name).'/'.$brand_tag.'/edit/');
}
// ------------------------------------------------------
if(isset($_POST['del_brand']))
{
  // TODO: ядекюрэ нвхярйс йюпрхмнй
  foreach (explode(',',IMAGE_EXTS) as $ext)
  {
  	@unlink(IMAGES_DIR.$imgPath.'-'.IMAGES_MODELS_MEDIUM.trim($ext));
    @unlink(IMAGES_DIR.$imgPath.'-'.IMAGES_MODELS_SMALL.trim($ext));
    @unlink(IMAGES_DIR.$imgPath.'-'.IMAGES_MODELS_ORIGINAL_NAME.trim($ext));
  }

  $this->_mysql->qr("DELETE FROM ".DB_TABLE_REFIX."models WHERE pk_models_id = '{$MODEL['pk_models_id']}'");
  $this->_mysql->qr("DELETE FROM ".DB_TABLE_REFIX."parts  WHERE  fk_models_id = '{$MODEL['pk_models_id']}'");
  $this->_mysql->qr("DELETE FROM ".DB_TABLE_REFIX."repare WHERE fk_models_id = '{$MODEL['pk_models_id']}'");

  header('location:'.ADMIN_URL_ROOT.'showMODELS/');
}
// ------------------------------------------------------
// ------------------------------------------------------

if(is_file(IMAGES_DIR.$imgPath.'-'.IMAGES_MODELS_MEDIUM.'.jpg'))
{
  $MODEL['img'] = IMAGES_URL.$imgPath.'-'.IMAGES_MODELS_MEDIUM.'.jpg';
}
$this->_smarty->assign('brand', $BRAND);
$this->tpl = $method_name;

?>