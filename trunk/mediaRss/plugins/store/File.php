<?php
require_once(PLUGINS_DIR.'Interface.php');
class Store implements PluginStoreInterface 
{
    
    function getAllLists()
    {
        return Cache::get(CACHE_LISTS_ALL_NAME);
    }
    
    function getList($url)
    {
        Cache::setName(CACHE_LISTS_ALL_NAME);
        if(Cache::checkLifetime())
        {
            $list = Cache::get(CACHE_LISTS_ALL_NAME);
            if(isset($list[$url]))
            {
                return $list[$url];
            }
        }
        return array();
    }
    
    function saveAllLists($array)
    {
        Cache::setName(CACHE_LISTS_ALL_NAME);
        Cache::store($array);
        return true;
    }
    
    function saveList($url, $array)
    {
        $list       = self::getList($url);
        $list[$url] = $array;
        self::saveAllLists($list);
        return true;
    }
    
    function delete()
    {
        
    }
    
}

?>