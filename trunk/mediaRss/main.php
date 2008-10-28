<?php
require_once('Base.php');

$Classes = Base::getConfig('dirs','classes');
require_once($Classes.'XmlAbstract.php');
require_once($Classes.'Opml.php');
require_once($Classes.'Detector.php');
Base::getCache();

class Main extends XmlAbstract 
{
    protected $parser        = false;
    protected $subscriptions = array();
    public $ERRORS           = array();

	function getParser()
	{
		$detector     = new Detector();
		$this->parser = $detector->detect($this->getXmlString());
		return $this->parser;
	}
	
	
	function download($filename)
	{	    
	    $curl = Base::getCurl();
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
        $array['channel']['flags']      = Base::getConfig('flags');
        
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
            $array['items'][$guid]['flags']         = Base::getConfig('flags');
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
	
	function addList($subUrl, $array)
	{
	    $this->subscriptions[$subUrl] = $array;
	    return $this;
	}
}



$aha = new Main();
$cfg = Base::getConfig();
//$aha->loadXmlFile(UPLOAD_DIR.'Подкасты.itunes.xml');
$opml   = new Opml();
$name   = Cache::setName("opml.my.itunes.xml.items", $cfg['cache']['lifetime']['opml']);
$url    = $cfg['dirs']['upload'].'Подкасты.itunes.xml';
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
    $name = Cache::setName('xml.'.$item['text'],$cfg['cache']['lifetime']['xml']);
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
        $aha->addList($item['xmlUrl'], $list);
        print "FROM CACHE XML - {$item['xmlUrl']}\n";
    }
}

require_once($cfg['dirs']['plugins_store'].$cfg['plugins']['store_default'].'.php');
$storage = new Store;
$storage->saveAllLists($aha->getAllLists());

print_r($aha->ERRORS);

//print $opml->getTitle();
//$aha->getType();
?>