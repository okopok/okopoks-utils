<?php

require_once(CLASSES_DIR.'PluginInterface.php');
class Atom extends XmlAbstract implements PluginInterface {
	
	function __construct()
	{
		print 'ATOM!!!';
	}
	
    function isValid(){}
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