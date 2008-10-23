<?php

class Detector{
	
	var $xml = null;
	
	function __construct($xml = null)
	{
	   return $this->detect($xml);
	}

	
	function detect($xml)
	{
		
		foreach (glob(PLUGINS_DIR.'*.php') as $plugin)
		{
			$pluginClassName = substr(basename($plugin),0,strpos(basename($plugin),'.'));
			require_once($plugin);
			print $plugin."\n";
			if(class_exists($pluginClassName))
			{
			    print 'asd'."\n";
				$pluginClass = new $pluginClassName($xml);
				if($pluginClass->isValid())
				{
				    return $pluginClass;
				}
			}			
		}
		throw new Exception("No match plugin");
	}
}

?>