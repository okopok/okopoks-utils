<?php

class My_Main
{
	protected static $__config 		= false;
	protected static $__proxyList 	= false;
	protected static $__cache 		= false;
	protected static $__curl		= false;

	public function getCurl()
	{
		Zend_Loader::loadClass('My_Curl');
		$__curl = new My_Curl();
		$__curl = $__curl->setCookiesDir(self::getConfig()->curl->cookies);
		return $__curl;
	}

	public function getCache()
	{
		if(!self::$__cache)
		{
			Zend_Loader::loadClass('Zend_Cache');
			$config = self::getConfig();
			$config = $config->toArray();

			self::$__cache = Zend_Cache::factory(
											'Core',
			                             	'File',
			                             	$config['cache']['frontendOptions'],
			                             	$config['cache']['backendOptions']
			);
		}
		return self::$__cache;
	}

	public static function getConfig()
	{
		if(!is_object(self::$__config))
		{
//			Zend_Loader::loadClass('My_Config_Adapter_'.$adapter_name);
			Zend_Loader::loadClass('Zend_Config');
//			$adapter = new My_Config_Adapter_Mycsv();
//			self::$__config = $adapter;
			$options['nestSeparator'] = ':';
			self::$__config = new Zend_Config(require 'config.php');
		}
		return self::$__config;
	}

	public static function getProxyList()
	{
		if(!self::$__proxyList)
		{
			$file = file(__ROOTDIR__.'proxy.txt');
			if(is_array($file))
			{
				self::$__proxyList = array();
				foreach ($file as $line) {
					self::$__proxyList[] = trim($line,"\n\r\t");
				}
			}
		}
		shuffle(self::$__proxyList);
		return self::$__proxyList;
	}

}

?>