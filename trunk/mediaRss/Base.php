<?php

class Base
{
    protected $curl          = false;
    protected static $config = array();
    
    public static function getConfig($key = false)
	{
	    if(empty(self::$config))
	    { 
            self::$config = require_once(dirname(__FILE__).'/config.php');
	    }
	    if(func_num_args())
	    {
	      	$arr = self::$config;
    	    foreach (func_get_args() as $key)
    	    {
    	        if(!is_string($key)) continue;
    	        if(isset($arr[$key]))
    	        {
    	            $arr = $arr[$key];
    	        }else{
    	            return array();	            
    	        }
    	    }
    	    return $arr;
	    }
	    return self::$config;
	}
	
	function getCurl()
	{
	    if(is_object($this->curl))
	    {
	        return $this->curl;
	    }else{
	        require_once(self::getConfig('dirs','utils').'CurlGetContent.class.php');
	        $this->curl = new CurlGetContent();
	        return $this->curl;
	    }
	}
	
	function getCache($path = false)
	{
	    $dirs = self::getConfig('dirs');
	    require_once($dirs['classes'].'Cache.php');
	    if(!$path) $path = $dirs['cache'];
	    Cache::setPath($path);
	}
	
}