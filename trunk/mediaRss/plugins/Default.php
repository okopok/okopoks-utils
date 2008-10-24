<?php

require_once(CLASSES_DIR.'pluginInterface.php');
class DefaultPlugin extends XmlAbstract implements PluginInterface 
{
    protected static $key  = false;
    protected $data = array();
    
    function __construct($xml)
    {
        $this->parceXml($xml);
    }
    
	
    function isValid()
    {
        return true;
    }
    function getChannelName()
    {
        return $this->getXml()->channel->title;
    }
    function getChannelLink()
    {
        return $this->getXml()->channel->link;
    }
    function getChannelInfo()
    {
       return $this->getXml()->channel->description; 
    }
    function getChannelImage(){}
    function getChannelUpdateTime(){}
    
    function getItem()
    {
        if(!count($this->data))
        {
            $this->getItems();
        }
        ++$this->key;
        if(!isset($this->data[$this->key]))
        {
            return false;
        }
        return $this;
    }
    
    function getItems()
    {
        if(!$this->parsedXml())
        {
            $this->parceXml($this->getXmlString());
        }
        $this->data = array();
        foreach ($this->getXml()->channel->item as $item)
        {
            $this->data[] = $item;
        }
        return $this;
    }
    
    function getItemName()
    {
        return $this->data[$this->key]->title;
    }
    
    function getItemLink(){}
    function getItemGuid(){}
    function getItemInfo(){}
    function getItemAuthor(){}
    function getItemMedia(){}
    function getItemMediaUrl(){}
    function getItemMediaLength(){}
    function getItemMediaType(){}
    function getItemImage(){}
    function getItemPubTime(){}
}