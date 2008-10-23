<?php

class Itunes extends XmlAbstract implements PluginInterface 
{
    
    function __construct($xml)
    {
        $this->setXmlString($xml);
    }
    
	
    function isValid()
    {
        if(eregi('xmlns:itunes="http://www.itunes.com/dtds/podcast-1.0.dtd"',$this->getXmlString()))
        {
            print "GOTCHA!";
            return true;
        }
        return false;
    }
    function setXml($xml)
    {
        $this->xml = $xml;
    }
    function getChannelName(){}
    function getChannelLink(){}
    function getChannelInfo(){}
    function getChannelImage(){}
    function getChannelUpdateTime(){}
    
    function getItemName(){}
    function getItemLink(){}
    function getItemGuid(){}
    function getItemInfo(){}
    function getItemAuthor(){}
    function getItemMedia(){}
    function getItemImage(){}
    function getItemPubTime(){}
}