<?php
require_once('Base.php');

$Classes = Base::getConfig('dirs','classes');
require_once($Classes.'XmlAbstract.php');

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
	
	function getStorePath($item)
	{
	    return '';
	}
	
	function store($item,$file)
	{
	    file_put_contents($this->getStorePath($item),$file);	    
	}
	
	function run()
	{	    
        $Classes = Base::getConfig('dirs','classes');
	    require_once($Classes.'Opml.php');
        require_once($Classes.'Detector.php');
        require_once($Classes.'Download.php');
        $cfg        = Base::getConfig();
        
        //$aha->loadXmlFile(UPLOAD_DIR.'Подкасты.itunes.xml');
        $opml       = new Opml();
        $download   = new Download();
        $name       = Cache::setName("opml.my.itunes.xml.items", $cfg['cache']['lifetime']['opml']);
        $url        = $cfg['dirs']['upload'].'Подкасты.itunes.xml';
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
        require_once($cfg['dirs']['plugins_store'].$cfg['plugins']['store_default'].'.php');
                
        $storage             = new Store;
        $this->subscriptions = $storage->getAllLists();
        
        // получаем список того, что уже скачали
        $downloadedCacheName = Cache::setName('downloaded' ,$cfg['cache']['lifetime']['downloaded']);        
        if(!Cache::checkLifetime())
        {
            Cache::getErrors();
            $downloaded = array();
        }else{
            $downloaded = Cache::get($downloadedCacheName);
        }
        
        // закручиваем цикл по всем подпискам
        foreach ($items as $channel)
        {
            $name = Cache::setName('xml.'.$channel['text'],$cfg['cache']['lifetime']['xml']);
            if(!Cache::checkLifetime())
            {
                Cache::getErrors();
                try{
                    $xmlString = $download->downloadFile($channel['xmlUrl']);    
                }    
                catch (Exception $e)
                {
                    $aha->ERRORS[] = $e->getMessage();
                    continue;
                }
                $this->parceXml( $xmlString )->getParser();
                $list = $this->makeList( $channel['xmlUrl']);
                
                Cache::store( $list );
                print "FROM SITE XML - {$channel['xmlUrl']}\n";
            }else{
                $list = Cache::get($name);
                $this->addList($channel['xmlUrl'], $list);
                print "FROM CACHE XML - {$channel['xmlUrl']}\n";
            }

            $storage->setChannel($list['channel']);            
            $i = 0;
            
            // закручиваем цикл на всех ссылках одной подписки
            foreach ($list['items'] as $key => $item)
            {
                if(!isset($item['mediaUrl'])) continue;
                $i++;
                // если мы проверили или скачали уже три или больше ссылок, то выходим из скачки
                if($cfg['download']['count'] <= $i)
                {
                    break;
                }
                
                // если ссылка есть в скачанных или есть скачанный файл, то пишем это в лог и пропускаем
                if(isset($downloaded[$item['guid']]))
                {
                    $item['flags']['downloaded'] = $downloaded[$item['guid']]['downloaded'];
                    Cache::setName('xml.'.$channel['text'],$cfg['cache']['lifetime']['xml']);
                    $list['items'][$key] = $item;
                    $this->addList($channel['xmlUrl'], $list);
                    Cache::store($list);
                    print "\t".$item['guid'].' downloaded'."\n";
                    continue;
                }
                
                if((strlen($item['flags']['downloaded']) and file_exists($item['flags']['downloaded'])))
                {
                    $downloaded[$item['guid']]['mediaUrl']   = $item['mediaUrl'];
                    $downloaded[$item['guid']]['downloaded'] = $item['flags']['downloaded'];
                    Cache::setName('downloaded', $cfg['cache']['lifetime']['downloaded']);
                    Cache::store($downloaded);
                    print "\t".$item['guid'].' downloaded'."\n";
                    continue;
                }
                
                // качаем файл
                $item = $storage->setItem($item)->storeItem();
                
                // есди файд скачали, пишем его в лог
                if(strlen($item['flags']['downloaded']))
                {
                    $downloaded[$item['guid']]['mediaUrl']   = $item['mediaUrl'];
                    $downloaded[$item['guid']]['downloaded'] = $item['flags']['downloaded'];
                    
                    Cache::setName('downloaded', $cfg['cache']['lifetime']['downloaded']);
                    Cache::store($downloaded);
                }
                
                // полюбому пишем лог если добрались до сюда
                Cache::setName('xml.'.$channel['text'] ,$cfg['cache']['lifetime']['xml']);
                $list['items'][$key] = $item;
                $this->addList($channel['xmlUrl'], $list);
                Cache::store($list);
            }
            
            // пишем лог о все ссылках
            $storage->saveAllLists($this->getAllLists());
            die;
        }

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
	    $this->addList($subUrl,$array);
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



$aha        = new Main();
$aha->run();
print "\n\n\n";
print_r($aha->ERRORS);

//print $opml->getTitle();
//$aha->getType();
?>