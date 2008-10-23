<?php


interface PluginInterface
{
    function isValid();
    function setXml($xml);
    
    function getChannelName();
    function getChannelLink();
    function getChannelInfo();
    function getChannelImage();
    function getChannelUpdateTime();
    
    function getItemName();
    function getItemLink();
    function getItemGuid();
    function getItemInfo();
    function getItemAuthor();
    function getItemMedia();
    function getItemImage();
    function getItemPubTime();
}

?>