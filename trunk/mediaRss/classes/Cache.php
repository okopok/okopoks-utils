<?php

class Cache
{
    protected static $path = false;
    protected static $errors      = array();
    protected static $name = false;
    static function store($item)
    {
        file_put_contents(self::$path.self::$name,serialize($item));
    }
    
    static function get($tag)
    {
        if(file_exists(self::$path.$tag))
        {
            return unserialize(file_get_contents(self::$path.$tag));
        }else{
            $tag = trim(preg_replace('|([^\w\d\.])|ism','',$tag));
            return unserialize(file_get_contents(reset(glob(self::$path.$tag.'-*.cache'))));
        }
    }
    
    static function checkLifetime()
    {
        
        if(!file_exists(self::$path.self::$name))
        {
            self::$errors[] = 'no such file '.self::$path.self::$name;
            return false;
        }
        $stat = stat(self::$path.self::$name);
        $exp  = explode('-', self::$name);
        if(($stat['mtime'] + $exp[1]) > time())
        {
            return true;
        }
        return false;
    }
    
    static function getErrors()
    {
        return self::$errors;
    }
    static function setName($tag, $lifetime)
    {
       self::$errors = array();
       $tag = trim(preg_replace('|([^\w\d\.])|ism','',$tag));
       self::$name = $tag.'-'.$lifetime.'.cache';
       return self::getName();
    }
    
    static function getName()
    {
       return self::$name;
    }
    
    static function setPath($path)
    {
       self::$path = $path;
       return new self;
    }
    
}