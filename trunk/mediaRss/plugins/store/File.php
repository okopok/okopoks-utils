<?php
require_once(Base::getConfig('dirs','plugins').'Interface.php');
require_once(Base::getConfig('dirs','classes').'Templater.php');
class Store implements PluginStoreInterface, ChannelItemInterface
{
    protected $channel = false;
    protected $item    = false;
    protected $Templater = false;
    
    function __construct()
    {
        $this->Templater = new Templater();
    }
    function getAllLists()
    {
        return Cache::get(Base::getConfig('cache','lists_all_name'));
    }
    
    function getList($url)
    {
        $cfg = Base::getConfig('cache');
        Cache::setName($cfg['lists_all_name'], $cfg['lifetime']['lists']);
        if(Cache::checkLifetime())
        {
            $list = Cache::get($cfg['lists_all_name']);
            if(isset($list[$url]))
            {
                return $list[$url];
            }
        }
        return array();
    }
    
    function saveAllLists($array)
    {
        Cache::setName(Base::getConfig('cache','lists_all_name'), Base::getConfig('cache','lifetime','lists'));
        Cache::store($array);
        return true;
    }
    
    function saveList($url, $array)
    {
        $list       = self::getList($url);
        $list[$url] = $array;
        self::saveAllLists($list);
        return true;
    }
    
    function delete()
    {
        
    }
    
    function setChannel(&$channel)
    {
        $this->channel = $channel;
        $this->Templater->setChannel($channel);
        return $this;
    }
    
    function setItem(&$item)
    {
        $this->item = $item;
        $this->Templater->setItem($item);
        return $this;
    }
    
    function getExtension()
    {
        $conf   = Base::getConfig('download');
        $urlext = substr($this->item['mediaUrl'], strrpos($this->item['mediaUrl'],'.')+1, strlen($this->item['mediaUrl']));
        if(in_array($urlext,$conf['extensions']))
        {
            return $urlext;
        }else{
            foreach ($conf['mediaTypes'] as $type => $value) 
            {
            	if($this->item['mediaType'] == $type)
            	{
            	    return $value;
            	}
            }
        }
        return false;
    }
    
    function storeItem()
    {
        if(!$this->item)     throw new Exception('Item is not set');
        if(!$this->channel)  throw new Exception('Channel is not set');
        
        $path           = $this->Templater->parceString(Base::getConfig('download','templateNoTags'));
        $confDirs       = Base::getConfig('dirs');
        $curl           = Base::getCurl();
        
        $this->printStat('downloading');
        $filedata = $curl->getPage($this->item['mediaUrl'],'',array(),true, Base::getConfig('download','timeout'));
        if($curl->errno())
        {
            $this->printStat('error');
            $this->printStat($curl->errno().' : '.$curl->error());
            $this->printStat($curl->info());
            
            $this->item['flags']['errors'][$curl->errno()]['text'] = $curl->errno().' : '.$curl->error();
            $this->item['flags']['errors'][$curl->errno()]['info'] = $curl->info();
        }else{
            $filename = $confDirs['download'].$path.'.'.$this->getExtension();
            $this->file2dir($filename, $filedata);  
            $this->printStat('final filesize: '.round(filesize($filename)/1024/1024,2));
            $this->item['flags']['downloaded'] = $filename;
            $this->printStat('done');
        }
              
        return $this->item;
    }
    

    function file2dir($path, $file)
    {
        if(!is_dir(dirname($path))) @mkdir(dirname($path), 0777, true);
        file_put_contents($path, $file);
        return $path;
    }
    
    function printStat($type)
    {
        switch ($type) {
        	case 'downloading':
                print "\n====== downloading =====\n";
                print "file: ".$this->item['mediaUrl']."\n";
                print "lenght: ".round($this->item['mediaLength']/1024/1024,2).' Mb'."\n";
                print 'timeout is: '.Base::getConfig('download','timeout')." sec\n";
        		break;
        	case "done":
        	    print "\n========= done! ========\n";
        	    break;
        	case 'line':
        	    print "\n========================\n";
        	    break;
        	case 'error':
        	    print "\n========= error ========\n";
        	    break;
        	default:
        	    print "\n";
        	    print_r($type);
        	    print "\n";
        		break;
        }
    }
    
    
}

?>