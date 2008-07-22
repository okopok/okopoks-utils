<?php
// класс для разбора форм
class FormParser{
  public  $formName     = 'formName';
  public  $dataType     = '';

  private $raw          = 'raw';
  private $mysql        = 'sql';
  private $html         = 'html';
  private $error        = 'error';
  private $text         = 'text';
  public  $iniFile      = '';
  private $RulesArray   = array();
  private $RulesMethods = array();
  
  private $dataArray    = array();

////////////////////////////////////////
  function __construct($type = '')
  {
    $this->iniFile = dirname(__FILE__).'/forms.ini';
    $this->RulesArray[$this->raw]   = array();
    $this->RulesArray[$this->text]  = array();
    $this->RulesArray[$this->html]  = array();
    $this->RulesArray[$this->mysql] = array();
    $this->RulesArray[$this->error] = array();
  }
////////////////////////////////////////
  function setTypes(){
    
  }
////////////////////////////////////////
  private function getFormRules(){
    if(file_exists($this->iniFile)){
      $this->RulesArray = parce_ini_file($this->iniFile,true);
    }else{
      die('Ini file Does not exists in "'.$this->iniFile.'"');
    }
    return $this->RulesArray;
  }
////////////////////////////////////////
  private function getDataArray(){
    if(isset($_POST[$this->formName])){
      return $this->dataArray[$this->raw] = $_POST;
    }elseif(isset($_GET[$this->formName])){
      return $this->dataArray[$this->raw] = $_GET;
    }else{
      return true;
    }
  }
////////////////////////////////////////
  
}
$ut = new FormParser();

?>