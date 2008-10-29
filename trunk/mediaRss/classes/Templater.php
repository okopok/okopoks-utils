<?php

class Templater
{
    protected $item = false;
    function setItem($item)
    {
        $this->item = $item;
        return $this;
    }

    
    /**
     * 
     * %channelTitle%  - ��� ��� ������
     * %author%        - ����� ���������� �� ��� (���� ����) ��� �� ���� (���� ������� ������
     * %album%         - ������ ���������� �� ����
     * %itemTitle%     - �������� ����� �� ��� ��� �� ����
     * %filename%      - �������� �����
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
    
    
    private function _getAuthor()
    {
        
    }
    
    public function filenameTrimmer($tag)
    {
        $tag = @iconv('UTF-8','cp1251',$tag);
        return trim(preg_replace('|([\.]{2,})|',' ',preg_replace('|([^a-z�-�\d\.\-\_\(\)\[\]\s])|ism','.',$tag)));
    }
    
    private function _getAlbum()
    {
        
    }

    private function _getItemTitle()
    {
        
    }
    
    private function _getChannelTitle()
    {
        
    }
    
    private function _getFilename()
    {
        
    }
}

?>