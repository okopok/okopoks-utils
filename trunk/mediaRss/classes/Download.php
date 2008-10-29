<?php

class Download
{
    protected $downloadList = array();
    
    function addItem($id, $url)
    {
        $this->downloadList[$id]['url'] = $url;
    }
    
	function downloadFile($filename)
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
	
	function downloadAll()
	{
	    foreach ($this->downloadList as $id => $arr)
	    {
	        try {
	            $this->downloadList[$id]['data'] = $this->downloadFile($arr['url']);
	        }catch (Exception $e)
	        {
	            $this->downloadList[$id]['error'] = $e->getMessage();
	        }
	    }
	    return $this->downloadList;
	}
    
    
}


?>