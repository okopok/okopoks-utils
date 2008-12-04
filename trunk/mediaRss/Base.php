<?php

class Base
{
    protected static $curl   = false;
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
	
	public static function getCurl()
	{
	    if(is_object(self::$curl))
	    {
	        return self::$curl;
	    }else{
	        require_once(self::getConfig('dirs','utils').'CurlGetContent.class.php');
	        self::$curl = new CurlGetContent();
	        return self::$curl;
	    }
	}
	
	public static function getCache($path = false)
	{
	    $dirs = self::getConfig('dirs');
	    require_once($dirs['classes'].'Cache.php');
	    if(!$path) $path = $dirs['cache'];
	    Cache::setPath($path);
	}
	
    
	public static function pathCleaner($tag, $delim = ' ')
    {
        $tag = @iconv('UTF-8','cp1251',$tag);
        return trim(preg_replace("|([$delim]{2,})|",$delim,preg_replace('|([^\w\d\.\-\_\(\)\[\]])|ism',$delim,$tag)));
    }
}