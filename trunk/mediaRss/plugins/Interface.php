<?php


interface PluginRSSInterface
{
    function isValid();
    function setXml($xml);
    
    function getChannelName();
    function getChannelLink();
    function getChannelInfo();
    function getChannelImage();
    function getChannelUpdateTime();
    
    function getItem();
    function getItems();
    
    function getItemName();
    function getItemLink();
    function getItemGuid();
    function getItemInfo();
    function getItemAuthor();
    function getItemImage();
    function getItemPubTime();
    
    function getItemMedia();
    function getItemMediaUrl();
    function getItemMediaLength();
    function getItemMediaType();
}

interface PluginStoreInterface
{
    function getAllLists();    
    function getList($url);    
    function saveAllLists($array);
    function saveList($url,$array);    
    function delete();
}

interface ChannelItemInterface
{
    function setChannel(&$channel);
    function setItem(&$item);    
}
?>