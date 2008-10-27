<?php
require_once(dirname(__FILE__).'/config.php');
require_once(CLASSES_DIR.'/XmlAbstract.php');
require_once(CLASSES_DIR.'Opml.php');
require_once(CLASSES_DIR.'Cache.php');
require_once(UTILS_DIR.'CurlGetContent.class.php');

class Main extends XmlAbstract 
{
    protected $parser        = false;
    protected $subscriptions = array();
    public $ERRORS           = array();
    protected $curl          = false;
    
	function getParser()
	{
		require_once(CLASSES_DIR.'Detector.php');
		$xml = $this->getXml();		
		$detector = new Detector();
		$this->parser = $detector->detect($this->getXmlString());
		return $this->parser;
	}
	
	function getCurl()
	{
	    if(is_object($this->curl))
	    {
	        return $this->curl;
	    }else{
	        $this->curl = new CurlGetContent();
	        return $this->curl;
	    }
	}
	
	function download($filename)
	{	    
	    $curl = $this->getCurl();
	    $file = $curl->getPage($filename);
	    if($curl->errno())
	    {
	        $info = $curl->info();
	        throw new Exception(
	        'Cant get url: '.$filename.' 
	        Errno: '.$curl->errno().'
	        Error: '.$curl->error().'
	        httpCode: '.$info['http_code']);
	    }
	    return $file;
	    
	}
	
	function getStorePath($item)
	{
	    return '';
	}
	
	function store($item,$file)
	{
	    file_put_contents($this->getStorePath($item),$file);	    
	}
	
	function makeList($subUrl)
	{
	    if(!is_object($this->parser)) throw new Exception('XML Parser not Set');
        $array = array(
            'channel' => array(), 
            'items' => array()
            );
        $array['channel']['name']       = $this->parser->getChannelName();
        $array['channel']['rssurl']     = $subUrl;
        $array['channel']['link']       = $this->parser->getChannelLink();
        $array['channel']['info']       = $this->parser->getChannelInfo();
        $array['channel']['image']      = $this->parser->getChannelImage();
        $array['channel']['updateTime'] = $this->parser->getChannelUpdateTime();
        $array['channel']['flags'][FLAG_DELETED]    = false;
        $array['channel']['flags'][FLAG_DOWNLOADED] = false;
        $array['channel']['flags'][FLAG_ERRORS]     = false;  
        
	    while ($item = $this->parser->getItem()) 
        {
            $guid = $this->parser->getItemGuid();
            $array['items'][$guid]['name']          = $this->parser->getItemName();
            $array['items'][$guid]['link']          = $this->parser->getItemLink();
            $array['items'][$guid]['guid']          = $this->parser->getItemGuid();
            $array['items'][$guid]['info']          = $this->parser->getItemInfo();
            $array['items'][$guid]['author']        = $this->parser->getItemAuthor();
            $array['items'][$guid]['mediaUrl']      = $this->parser->getItemMediaUrl();
            $array['items'][$guid]['mediaType']     = $this->parser->getItemMediaType();
            $array['items'][$guid]['mediaLength']   = $this->parser->getItemMediaLength();
            $array['items'][$guid]['image']         = $this->parser->getItemImage();
            $array['items'][$guid]['pubTime']       = $this->parser->getItemPubTime();
            $array['items'][$guid]['flags'][FLAG_DELETED]           = false;
            $array['items'][$guid]['flags'][FLAG_DOWNLOADED]        = false;
            $array['items'][$guid]['flags'][FLAG_ERRORS]            = false;            
        }
	    $this->subscriptions[$subUrl] = $array;
	    $this->setList($subUrl,$array);
	    return $array;
	}
	
	function getList($subUrl)
	{
	    if(isset($this->subscriptions[$subUrl]))
	    {	       
	        print $url; 
	        return $this->subscriptions[$subUrl];	        
	    }
	    return false;
	}
	
	function getAllLists()
	{
	    return $this->subscriptions;
	}
	function setList($subUrl, $array)
	{
	    $this->subscriptions[$subUrl] = $array;
	    return $this;
	}
}
Cache::setPath(CACHE_DIR);


$aha = new Main();

//$aha->loadXmlFile(UPLOAD_DIR.'Подкасты.itunes.xml');
$opml   = new Opml();
$name   = Cache::setName("opml.my.itunes.xml.items",3600);
$url    = UPLOAD_DIR.'Подкасты.itunes.xml';
if(!Cache::checkLifetime())
{
    $opmlXml = $opml->loadXmlFile($url);
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
        Cache::getErrors();
        try{
            $xmlString = $aha->download($item['xmlUrl']);    
        }    
        catch (Exception $e)
        {
            $aha->ERRORS[] = $e->getMessage();
            continue;
        }
        $aha->parceXml( $xmlString )->getParser();
        $list = $aha->makeList( $item['xmlUrl']);
        
        Cache::store( $list );
        print "FROM SITE XML - {$item['xmlUrl']}\n";
    }else{
        $list = Cache::get($name);
        $aha->setList($item['xmlUrl'],$list);
        print "FROM CACHE XML - {$item['xmlUrl']}\n";
    }
}

require_once(PLUGINS_STORE_DIR.PLUGINS_STORE_DEFAULT.'.php');
$storage = new Store;
$storage->saveAllLists($aha->getAllLists());

print_r($aha->ERRORS);

//print $opml->getTitle();
//$aha->getType();
?>