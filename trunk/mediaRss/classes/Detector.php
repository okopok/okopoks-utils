<?php

class Detector{
	
	var $xml = null;
	
	function __construct()
	{
	}

	
	function detect($xml)
	{
		$cfg = Base::getConfig();
		foreach (glob($cfg['dirs']['plugins_rss'].'*.php') as $pluginRSS)
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
		
		$pluginRSSClassName = $cfg['plugins']['rss_default'].'Plugin';
		if(file_exists($cfg['dirs']['plugins_rss'].$pluginRSSClassName.'.php'))
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