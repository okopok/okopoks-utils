<?php

class Opml extends XmlAbstract 
{
    private $items = array();
    function __construct()
    {
        
    }
    
    function getItems()
    {
        $xml = $this->getXml();
        if(!isset($xml->body->outline)) throw new Exception("Bad OPML file ".$this->getFile());
        $this->_getOutlines($xml->body);
        return $this->items;
    }
    
    function getTitle()
    {
        if(!isset($this->getXml()->head->title))  throw new Exception("Bad OPML file ".$this->getFile());
        return (string)$this->getXml()->head->title;
    }
    
    private function _getOutlines($body)
    {
        foreach ($body->outline as $outline)
        {
            if(isset($outline->outline))
            {
                $this->_getOutlines($outline);
            }
            if(isset($outline->attributes()->xmlUrl))
            {
                $items = (array)$outline->attributes();
                $this->items[] = $items['@attributes'];
            }  
        }
        return $this->items;
    }
}

?>