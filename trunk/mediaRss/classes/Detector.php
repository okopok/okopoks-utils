<?php

class Detector{
	
	var $xml = null;
	
	function __construct()
	{
	}

	
	function detect($xml)
	{
		
		foreach (glob(PLUGINS_RSS_DIR.'*.php') as $pluginRSS)
		{
			$pluginRSSClassName = substr(basename($pluginRSS),0,strpos(basename($pluginRSS),'.')).'Plugin';
			require_once($pluginRSS);
			if(class_exists($pluginRSSClassName))
			{
			    
				$pluginRSSClass = new $pluginRSSClassName($xml);
				if($pluginRSSClass->isValid())
				{
				    return $pluginRSSClass;
				}
			}			
		}
		$pluginRSSClassName = PLUGINS_RSS_DEFAULT.'Plugin';
		if(file_exists(PLUGINS_RSS_DIR.$pluginRSSClassName.'.php'))
		{
		   if(class_exists($pluginRSSClassName))
			{
				$pluginRSSClass = new $pluginRSSClassName($xml);
				return $pluginRSSClass;
			} 
		}
		throw new Exception("No match plugin");
	}
}

?>