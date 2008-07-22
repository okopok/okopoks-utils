<?php

$BRAND = reset($method_params);
$size100 = '100x100';
$size50 = '50x50';
$imgPath = BRANDS_IMAGES_DIR.$BRAND['pk_brands_id'];

if(isset($_POST['old_name']))
{
  // ------------------------------------------------------
  $brand_tag = $BRAND['brands_name_tag'];
  if($_POST['old_name'] <> $_POST['name'])
  {
    $brand_tag = $this->_utils->tagger($this->_utils->rus2translit(trim($_POST['name'])));
    $this->_mysql->qr("
    UPDATE ".DB_TABLE_REFIX."brands
    SET brands_name = '".mysql_real_escape_string(trim($_POST['name']))."',
        brands_name_tag = '$brand_tag'
    WHERE pk_brands_id = '{$BRAND['pk_brands_id']}'
    ");
  }
  // ------------------------------------------------------
  if(isset($_POST['del_img']))
  {
    @unlink(IMAGES_DIR.$imgPath.'-'.$size100.'.jpg');
    @unlink(IMAGES_DIR.$imgPath.'-'.$size50.'.jpg');
  }

  // ------------------------------------------------------
  if(isset($_FILES['img']['tmp_name']))
  {
    $ext = strtolower(substr($_FILES['img']['name'], strrpos($_FILES['img']['name'],'.')));
    $exts = array('.gif','.jpg','.jpeg','.png');
    if(eregi('image', $_FILES['img']['type']) and in_array($ext, $exts))
    {
      include(CLASSES_DIR.'ImageResizer.class.php');
      $_IMG = new ImageResizer();
      copy($_FILES['img']['tmp_name'], IMAGES_DIR.$imgPath.'-original'.$ext);
      $_IMG->resize(100,100, $_FILES['img']['tmp_name'], IMAGES_DIR.$imgPath.'-100x100.jpg', array('fill_in_box' => 1));
      $_IMG->resize(50,50, IMAGES_DIR.$imgPath.'-100x100.jpg', IMAGES_DIR.$imgPath.'-50x50.jpg',        array('fill_in_box' => 1));
    }
  }

  header('location:'.ADMIN_URL_ROOT.strtolower($method_name).'/'.$brand_tag.'/edit/');
}
// ------------------------------------------------------
if(isset($_POST['del_brand']))
{
  // TODO: ядекюрэ нвхярйс йюпрхмнй
  $this->_mysql->qr("DELETE FROM ".DB_TABLE_REFIX."brands WHERE pk_brands_id = '{$BRAND['pk_brands_id']}'");

  $data = $this->_mysql->getData("SELECT pk_models_id as id FROM ".DB_TABLE_REFIX."models WHERE fk_brands_id = '{$BRAND['pk_brands_id']}'");
  foreach ($data as $row)
  {
    $this->_mysql->qr("DELETE FROM ".DB_TABLE_REFIX."parts WHERE fk_models_id = '{$row['id']}'");
    $this->_mysql->qr("DELETE FROM ".DB_TABLE_REFIX."repare WHERE fk_models_id = '{$row['id']}'");
  }
  $this->_mysql->qr("DELETE FROM ".DB_TABLE_REFIX."models WHERE fk_brands_id = '{$BRAND['pk_brands_id']}'");
  header('location:'.ADMIN_URL_ROOT.'showbrands/');
}
// ------------------------------------------------------
// ------------------------------------------------------

if(is_file(IMAGES_DIR.$imgPath.'-'.$size100.'.jpg'))
{
  $BRAND['img'] = IMAGES_URL.$imgPath.'-'.$size100.'.jpg';
}
$this->_smarty->assign('brand', $BRAND);
$this->tpl = $method_name;

?>