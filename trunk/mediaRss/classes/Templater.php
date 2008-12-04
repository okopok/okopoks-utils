<?php

class Templater implements ChannelItemInterface
{
    protected $channel = false;
    protected $item    = false;
    
    function setChannel(&$channel)
    {
        $this->channel = $channel;
        return $this;
    }
    
    function setItem(&$item)
    {
        $this->item = $item;
        return $this;
    }
    

    
    /**
     * 
     * %channelTitle%  - имя рсс канала
     * %author%        - автор композиции из рсс (если есть) или из тега (если включён плагин
     * %album%         - альбом композиции из тега
     * %itemTitle%     - название песни из рсс или из тега
     * %filename%      - название файла
     */
    function parceString($string)
    {
        if(!is_array($this->item))
        {
            throw new Exception("Item not set");
        }
        $pattern = array(
         '%channelTitle%' => $this->_getChannelTitle(),
         '%author%'       => $this->_getAuthor(),
         '%album%'        => $this->_getAlbum(),
         '%itemTitle%'    => $this->_getItemTitle(),
         '%filename%'     => $this->_getFilename(),
        );
        return str_ireplace(array_keys($pattern), array_values($pattern), $string);        
    }

    public function filenameTrimmer($tag)
    {
        $tag = @iconv('UTF-8','cp1251',$tag);
        return trim(preg_replace('|([\.]{2,})|',' ',preg_replace('|([^a-zа-я\d\.\-\_\(\)\[\]\s])|ism','.',$tag)));
    }
    
    private function _getAuthor()
    {
        return Base::pathCleaner($this->item['author']);
    }
    
    private function _getAlbum()
    {
        
    }

    private function _getItemTitle()
    {
        return Base::pathCleaner($this->item['name']);
    }
    
    private function _getChannelTitle()
    {
        return Base::pathCleaner($this->channel['name']);
    }
    
    private function _getFilename()
    {
        
    }
}

?>