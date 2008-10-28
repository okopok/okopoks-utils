<?php
require_once(Base::getConfig('dirs','plugins').'Interface.php');
class Store implements PluginStoreInterface 
{
    
    function getAllLists()
    {
        return Cache::get(Base::getConfig('cache','lists_all_name'));
    }
    
    function getList($url)
    {
        $cfg = Base::getConfig('cache');
        Cache::setName($cfg['lists_all_name'], $cfg['lifetime']['lists']);
        if(Cache::checkLifetime())
        {
            $list = Cache::get($cfg['lists_all_name']);
            if(isset($list[$url]))
            {
                return $list[$url];
            }
        }
        return array();
    }
    
    function saveAllLists($array)
    {
        Cache::setName(Base::getConfig('cache','lists_all_name'));
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