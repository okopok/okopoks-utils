<?php

class Detector{
	
	var $xml = null;
	
	function __construct()
	{
	}

	
	function detect($xml)
	{
		
		foreach (glob(PLUGINS_DIR.'*.php') as $plugin)
		{
			$pluginClassName = substr(basename($plugin),0,strpos(basename($plugin),'.')).'Plugin';
			require_once($plugin);
			print "\n".$plugin."\n";
			if(class_exists($pluginClassName))
			{
			    
				$pluginClass = new $pluginClassName($xml);
				if($pluginClass->isValid())
				{
				    print $pluginClassName."\n";
				    return $pluginClass;
				}
			}			
		}
		$pluginClassName = PLUGINS_DEFAULT.'Plugin';
		if(file_exists(PLUGINS_DIR.$pluginClassName.'.php'))
		{
		   if(class_exists($pluginClassName))
			{
			    print PLUGINS_DEFAULT."\n";
				$pluginClass = new $pluginClassName($xml);
				return $pluginClass;
			} 
		}
		throw new Exception("No match plugin");
	}
}

?>