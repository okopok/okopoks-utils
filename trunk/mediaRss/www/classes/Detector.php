<?php

class Detector{
	
	var $xml = null;
	
	function __construct($xml = null)
	{
		if(is_object($xml))
		{
			$this->setXml($xml);
			return $this->detect();
		}
		
	}
	
	function setXml($xml)
	{
		$this->xml = $xml;
	}
	
	function detect()
	{
		
		foreach (glob(PLUGINS_DIR.'*.php') as $plugin)
		{
			$pluginClassName = substr(basename($plugin),0,strpos(basename($plugin),'.'));
			print $plugin."\n".$pluginClassName."\n";
			
			require_once($plugin);
			if(class_exists($pluginClassName))
			{
				$pluginClass = new $pluginClassName;
			}
			
		}
	}
}

?>