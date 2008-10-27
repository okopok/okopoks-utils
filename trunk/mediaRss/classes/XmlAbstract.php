<?php
/**
 * Enter description here...
 *
 */
class XmlAbstract 
{
  protected  $xml       = null;
  protected $file      = null;
  protected $xmlString = null;
  /**
   * Enter description here...
   *
   * @param unknown_type $xml
   * @return unknown
   */
  public function setXml($xml)
  {
      $this->xml = $xml;
      return $this;
  }
  
  /**
   * Enter description here...
   *
   * @return unknown
   */
  public function getXml()
  {
      return $this->xml;
  }
  
  
  /**
   * Enter description here...
   *
   * @param unknown_type $file
   * @return unknown
   */
  public function loadXmlFile($file)
  {
      $this->file = $file;
      if(file_exists($file) and is_readable($file))
      {
          $this->parceXml(file_get_contents($file));          
      }else{
          throw new Exception("File '$file' can't read");
      }
      return $this;
  }
  
  function getFile()
  {
    return $this->file;    
  }
  function setXmlString($xml)
  {
      $this->xmlString = $xml;
      return $this;
  }
  
  function getXmlString()
  {
      return $this->xmlString;
  }
  
  function parsedXml()
  {
      return is_object($this->xml);
  }
  
  /**
   * Enter description here...
   *
   * @param unknown_type $string
   * @return unknown
   */
  public function parceXml($string)
  {      
      if($xml = simplexml_load_string($string))
      {
          $this->xmlString = $string;
          $this->setXml($xml);
      }else{
          throw new Exception("Bad XML given".((strlen($this->file))? ' in file '.$this->file : ''));
      }
      return $this;
  }
}

?>