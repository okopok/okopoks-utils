<?php
require_once(dirname(__FILE__).'/config.php');
require_once(CLASSES_DIR.'/XmlAbstract.php');
require_once(CLASSES_DIR.'Opml.php');
require_once(CLASSES_DIR.'Cache.php');
class Main extends XmlAbstract 
{
    protected $parser = false;
        
	function getParser()
	{
	    if(is_object($this->parser))
	    {
	        return $this->parser;
	    }
		require_once(CLASSES_DIR.'Detector.php');
		$xml = $this->getXml();		
		$detector = new Detector($this->getXmlString());
		$this->parser = $detector;
		return $this->parser;
	}
	
	
	function download($file)
	{
	    if($file = file_get_contents($file))
	    {
	        return $file;
	    }else{
	        throw new Exception('Cant get file '.$file);
	    }
	}
	
	function getStorePath($item)
	{
	    return '';
	}
	
	function store($item,$file)
	{
	    file_put_contents($this->getStorePath($item),$file);	    
	}
}
Cache::setPath(CACHE_DIR);


$aha = new Main();

//$aha->loadXmlFile(UPLOAD_DIR.'Подкасты.itunes.xml');
$opml = new Opml();
$name = Cache::setName("opml.my.itunes.xml.items",3600);

if(!Cache::checkLifetime())
{
    $opmlXml = $opml->loadXmlFile(UPLOAD_DIR.'my.itunes.xml');
    $items = $opml->getItems();
    Cache::store($items);
    print "FROM FILE OPML\n";
}else{
    $items = Cache::get($name);
    print "FROM CACHE OPML\n";
}

foreach ($items as $item)
{
    $name = Cache::setName('xml.'.$item['text'],3600);
    if(!Cache::checkLifetime())
    {
        print_r(Cache::getErrors());
        $xmlString = $aha->download($item['xmlUrl']);
        Cache::store($xmlString);
        print "FROM SITE XML";
    }else{
        $xmlString = Cache::get($name);
        print "FROM CACHE XML";
    }
    $xml = $aha->parceXml($xmlString)->getXml();
    print_r($xml);
}
$aha->parceXml($xmlString);
$aha->getParser();
//print $opml->getTitle();
//$aha->getType();
?>