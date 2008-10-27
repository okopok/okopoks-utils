<?php
require_once(PLUGINS_DIR.'Interface.php');
class DefaultPlugin extends XmlAbstract implements PluginRSSInterface 
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
        return (string)$this->getXml()->channel->title;
    }
    function getChannelLink()
    {
        return (string)$this->getXml()->channel->link;
    }
    function getChannelInfo()
    {
       return (string)$this->getXml()->channel->description; 
    }
    function getChannelImage()
    {
        return (string)$this->getXml()->channel->image->url; 
    }
    function getChannelUpdateTime(){
        return (string)$this->getXml()->channel->pubDate; 
    }
    
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
        if(!isset($this->getXml()->channel->item)) throw new Exception('Bad XML GIVEN');
        foreach ($this->getXml()->channel->item as $item)
        {
            $this->data[] = $item;
        }
        return $this;
    }
    
    function getItemName()
    {
        return (string)$this->data[$this->key]->title;
    }
    
    function getItemLink()
    {
        return (string)$this->data[$this->key]->link;
    }
    function getItemGuid()
    {
        return (string)$this->data[$this->key]->guid;
    }
    function getItemInfo(){
        return (string)$this->data[$this->key]->description;
    }
    function getItemAuthor(){
        return (string)$this->data[$this->key]->author;
    }
    function getItemMedia(){
        return isset($this->data[$this->key]->enclosure)?$this->data[$this->key]->enclosure:false;
    }
    function getItemMediaUrl()
    {
        return self::getItemMedia() ? (string)self::getItemMedia()->attributes()->url : false; 
    }
    function getItemMediaLength()
    {
        return self::getItemMedia() ? (string)self::getItemMedia()->attributes()->length : false; 
    }
    function getItemMediaType()
    {
        return self::getItemMedia() ? (string)self::getItemMedia()->attributes()->type : false; 
    }
    function getItemImage(){}
    function getItemPubTime(){}
}