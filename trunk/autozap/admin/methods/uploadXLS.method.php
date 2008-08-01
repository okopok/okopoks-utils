<?php

if(!isset($_FILES['xls'])) return false;
$sheetNameExploder = '-';


require_once EXCELREADER_DIR.'reader.php';
// ExcelFile($filename, $encoding);
$this->__excel = new Spreadsheet_Excel_Reader();
// Set output Encoding.
$this->__excel->setOutputEncoding('CP1251');
$this->__excel->read($_FILES['xls']['tmp_name']);

$this->print_ar($_FILES);
$this->print_ar($_POST);
//$this->print_ar($this->__excel->sheets[0]);

$BRANDS_MODELS_HASH = $this->Main->caller('buildHashes', array('brands_models'));
$BRANDS_HASH        = $this->Main->caller('buildHashes', array('brands'));


foreach ($this->__excel->sheets as $key => $sheet)
{
  if(!ereg($sheetNameExploder, $sheet['sheetName'])) continue;
  $brand = trim(substr($sheet['sheetName'], 0,strpos($sheet['sheetName'], $sheetNameExploder)));
  $model = trim(substr($sheet['sheetName'], strpos($sheet['sheetName'], $sheetNameExploder)+1, strlen($sheet['sheetName'])));
  $brand_tag = $this->Main->_utils->tagger($this->Main->_utils->rus2translit($brand));
  $model_tag = $this->Main->_utils->tagger($this->Main->_utils->rus2translit($model));

  print "$brand ($brand_tag: ";

  if(isset($BRANDS_HASH[$brand_tag]))
  {
    $brand_id = $BRANDS_HASH[$brand_tag]['pk_brands_id'];
  }else{
    $this->Main->_mysql->qr("INSERT INTO ".DB_TABLE_REFIX."brands SET
      brands_name     = '".mysql_real_escape_string($brand)."',
      brands_name_tag = '".mysql_real_escape_string($brand_tag)."'
    ");
    $brand_id = mysql_insert_id();
    $BRANDS_HASH[$brand_tag]['brands_name']     = $brand;
    $BRANDS_HASH[$brand_tag]['brands_name_tag'] = $brand_tag;
    $BRANDS_HASH[$brand_tag]['pk_brands_id']    = $brand_id;
  }

  print $brand_id.") = $model ($model_tag: ";
  if(isset($BRANDS_MODELS_HASH[$brand_tag][$model_tag]))
  {
    $model_id = $BRANDS_MODELS_HASH[$brand_tag][$model_tag]['pk_models_id'];
  }else{
    $this->Main->_mysql->qr("INSERT INTO ".DB_TABLE_REFIX."models SET
      fk_brands_id   = '$brand_id',
      models_name     = '".mysql_real_escape_string($model)."',
      models_name_tag = '".mysql_real_escape_string($model_tag)."'
    ");
    $model_id = mysql_insert_id();

    $BRANDS_MODELS_HASH[$brand_tag][$model_tag]['pk_models_id']    = $model_id;
    $BRANDS_MODELS_HASH[$brand_tag][$model_tag]['models_name']     = $model;
    $BRANDS_MODELS_HASH[$brand_tag][$model_tag]['models_name_tag'] = $model_tag;

    $BRANDS_MODELS_HASH[$brand_tag][$model_tag]['brands_name']     = $brand;
    $BRANDS_MODELS_HASH[$brand_tag][$model_tag]['brands_name_tag'] = $brand_tag;
    $BRANDS_MODELS_HASH[$brand_tag][$model_tag]['pk_brands_id']    = $brand_id;

  }
  print "$model_id)</br>";
  //$this->print_ar($sheet['cells']);

  switch ($_POST['price_type'])
  {
    case 'parts':
    case 'waiting':
        $table = 'parts';
        $this->Main->_mysql->qr("DELETE FROM ".DB_TABLE_REFIX."parts WHERE fk_models_id = '$model_id' ".(($_POST['price_type'] == 'waiting')?" AND parts_cond ='waiting'":" AND parts_cond != 'waiting'"));
      break;
    case 'repare':
        $table = 'repare';
        $this->Main->_mysql->qr("DELETE FROM ".DB_TABLE_REFIX."repare WHERE fk_models_id = '$model_id'");
      break;
  }

  if(!isset($sheet['cells'])) return false;
  foreach ($sheet['cells'] as $row => $cell)
  {
    $sql = array();
    switch ($_POST['price_type'])
    {
      case 'parts':
        // если эту строку мы пропускаем, то пропускаем. Если нет имени, то тоже пропускаем
        if($row < XLS_PARTS_START_ROW OR !isset($cell[XLS_PARTS_NAME]))
        {
          continue;
        }

        // если Ячеек меньше 3х, то запчасти нет
        if(count($cell) < 3)
        {
          $sql['parts_cond']           = "parts_cond = 'no'";
        }
        // если цена новая ИЛИ старая есть и равна 0, то запчасти нет
        if((isset($cell[XLS_PARTS_COST]) and $cell[XLS_PARTS_COST] == 0) OR (isset($cell[XLS_PARTS_COST_OLD]) AND $cell[XLS_PARTS_COST_OLD] == 0))
        {
          $sql['parts_cond']           = "parts_cond = 'no'";
        }
        // если и старая И новая цены равны 0, то запчасти нет
        if((isset($cell[XLS_PARTS_COST]) and $cell[XLS_PARTS_COST] == 0) AND (isset($cell[XLS_PARTS_COST_OLD]) AND $cell[XLS_PARTS_COST_OLD] == 0))
        {
          $sql['parts_cond']           = "parts_cond = 'no'";
        }
        // если кол-во новых И кол-во старых запчастей равны 0, то запчасти нет
        if((isset($cell[XLS_PARTS_NUMBER]) and $cell[XLS_PARTS_NUMBER] == 0) AND (isset($cell[XLS_PARTS_NUMBER_OLD]) AND $cell[XLS_PARTS_NUMBER_OLD] == 0))
        {
          $sql['parts_cond']           = "parts_cond = 'no'";
        }
        // если кол-во новых ИЛИ кол-во старых запчастей равны 0, то запчасти нет
        if((isset($cell[XLS_PARTS_NUMBER]) and $cell[XLS_PARTS_NUMBER] == 0) OR (isset($cell[XLS_PARTS_NUMBER_OLD]) AND $cell[XLS_PARTS_NUMBER_OLD] == 0))
        {
          $sql['parts_cond']           = "parts_cond = 'no'";

        }

                                               $sql['XLS_PARTS_NAME']       = "parts_name = '".mysql_real_escape_string($cell[XLS_PARTS_NAME])."'";
        if(isset($cell[XLS_PARTS_UID]))        $sql['XLS_PARTS_UID']        = "parts_uid = '".mysql_real_escape_string($cell[XLS_PARTS_UID])."'";
        if(isset($cell[XLS_PARTS_COST]))       $sql['XLS_PARTS_COST']       = "parts_cost = '".mysql_real_escape_string($cell[XLS_PARTS_COST])."'";
        if(isset($cell[XLS_PARTS_NUMBER]))     $sql['XLS_PARTS_NUMBER']     = "parts_number = '".mysql_real_escape_string($cell[XLS_PARTS_NUMBER])."'";
        if(isset($cell[XLS_PARTS_COST_OLD]))   $sql['XLS_PARTS_COST_OLD']   = "parts_cost_old = '".mysql_real_escape_string($cell[XLS_PARTS_COST_OLD])."'";
        if(isset($cell[XLS_PARTS_NUMBER_OLD])) $sql['XLS_PARTS_NUMBER_OLD'] = "parts_number_old = '".mysql_real_escape_string($cell[XLS_PARTS_NUMBER_OLD])."'";

      break;
      //...................
      case 'repare':
        if($row < XLS_REPARE_START_ROW OR !isset($cell[XLS_REPARE_NAME], $cell[XLS_REPARE_COST]) OR $cell[XLS_REPARE_COST] == 0)
        {
          continue;
        }
                                               $sql['XLS_REPARE_NAME']      = "repare_name  = '".mysql_real_escape_string($cell[XLS_REPARE_NAME])."'";
        if(isset($cell[XLS_REPARE_HOURS]))     $sql['XLS_REPARE_HOURS']     = "repare_hours = '".mysql_real_escape_string($cell[XLS_REPARE_HOURS])."'";
                                               $sql['XLS_REPARE_COST']      = "repare_cost  = '".mysql_real_escape_string($cell[XLS_REPARE_COST])."'";
      break;
      //...................
      case 'waiting':

        if($row < XLS_WATING_START_ROW OR !isset($cell[XLS_WATING_NAME]))
        {
          continue;
        }
        print __LINE__."</br>";
                                               $sql['XLS_WATING_NAME']      = "parts_name = '".mysql_real_escape_string($cell[XLS_WATING_NAME])."'";
                                               $sql['parts_cond']           = "parts_cond = 'waiting'";
      break;
    }
    if(count($sql) > 0)
    {
      $sql['model_id'] = "fk_models_id = '$model_id'";
      $this->Main->_mysql->qr("INSERT INTO ".DB_TABLE_REFIX."{$table} SET ".implode(' , ',$sql));
    }
  }

}





$exelType = 'application/vnd.ms-excel';
?>