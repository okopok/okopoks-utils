<?php

class Download
{
    protected $downloadList = array();
    
    function addItem($id, $url)
    {
        $this->downloadList[$id] = $url;
    }
    
    function downLoadFile()
    {
        $curl = Base::getCurl();
    }
    
    
}


?>