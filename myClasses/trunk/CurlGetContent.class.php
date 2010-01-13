$<?php

/**
 * @package utils
 * @copyright Molotdsov Sasha <asid@mail.ru>
 * @version 0.9
 */
class My_Curl
{
	/**
	 * @var resourse
	 */
	protected $__curlSRC   = null;

	/**
	 * Cookie path
	 *
	 * @var string
	 */
	protected $__cookiesDir= '';

	/**
	 * default curl timeout
	 *
	 * @var integer
	 */
	protected $__defaultTimeout   = 10;


	/**
	* Get curl resourse. If it wasn't created - create it ^__^
	*
	* @return resourse
	*/
	public function getSrc()
	{
		if(!is_resource($this->__curlSRC))
		{
		  	return $this->getNewSrc();
		}else{
		  	return $this->__curlSRC;
		}
	}

	/**
	* Get NEW curl resourse
	* @return source
	*/
	public function getNewSrc()
	{
		if(!is_dir($this->__cookiesDir))
		{
			@mkdir(dirname(__FILE__).$this->__cookiesDir, 0777, true);
		}

		$header[] = "Accept: text/xml,application/xml,application/xhtml+xml,text/html;q=0.9,text/plain;q=0.8,image/png,*/*;q=0.5";
		$header[] = "Cache-Control: max-age=0";
		$header[] = "Accept-Charset: windows-1251,utf-8;q=0.7,*;q=0.7";
		$header[] = "Accept-Language: ru-ru,ru;q=0.8,en-us;q=0.5,en;q=0.3";
		$header[] = "Pragma: "; // browsers keep this blank.

		$this->__curlSRC = curl_init();
		curl_setopt($this->__curlSRC, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.7) Gecko/2009021910 Firefox/3.0.7');
		curl_setopt($this->__curlSRC, CURLOPT_HTTPHEADER, $header);
		curl_setopt($this->__curlSRC, CURLOPT_ENCODING, 'gzip,deflate');
		curl_setopt($this->__curlSRC, CURLOPT_AUTOREFERER, true);

		curl_setopt($this->__curlSRC, CURLOPT_COOKIEJAR,  $this->__cookiesDir.'.cookie.txt');
		curl_setopt($this->__curlSRC, CURLOPT_COOKIEFILE, $this->__cookiesDir.'.cookie.txt');
		curl_setopt($this->__curlSRC, CURLOPT_RETURNTRANSFER, 1);
		return $this->__curlSRC;
	}

	/**
	 * set cookie store path
	 *
	 * @param string $path
	 * @return this
	 */
	public function setCookiesDir($path)
	{
		$this->__cookiesDir = $path;
		return $this;
	}

	/**
	 * set post data or reset it
	 *
	 * @param hash $inputs
	 * @return this
	 */
	public function setPostData($data)
	{
		$this->getSrc();
		if(is_array($data) and count($data) > 0)
		{
			curl_setopt($this->__curlSRC, CURLOPT_POST, 1);
			curl_setopt($this->__curlSRC, CURLOPT_POSTFIELDS, $data);
		}else{
			curl_setopt($this->__curlSRC, CURLOPT_POST, 0);
			curl_setopt($this->__curlSRC, CURLOPT_POSTFIELDS, array());
		}
		return $this;
	}

	/**
	 * set timeout
	 *
	 * @param integer $time - if false, then set default timeout
	 * @return this
	 */
	public function setTimeout($time = false)
	{
		$this->getSrc();
		// устанавливаем таймаут обрыва соединения
		if(is_numeric($time)){
			curl_setopt($this->__curlSRC, CURLOPT_TIMEOUT, $time);
		}else{
			curl_setopt($this->__curlSRC, CURLOPT_TIMEOUT, $this->__defaultTimeout);
		}
		return $this;
	}

	/**
	 * set follow redirects
	 *
	 * @param boolean $follow
	 * @return this
	 */
	public function setFollow($follow = false)
	{
		$this->getSrc();
		if($follow == true)
		{
			curl_setopt ($this->__curlSRC, CURLOPT_FOLLOWLOCATION, true);
		}else{
			curl_setopt ($this->__curlSRC, CURLOPT_FOLLOWLOCATION, false);
		}
		return $this;
	}

	/**
	 * set referer header
	 *
	 * @param string $refer
	 * @return this
	 */
	public function setRefer($refer = false)
	{
		$this->getSrc();
		if($refer)
		{
			curl_setopt ($this->__curlSRC, CURLOPT_REFERER,   $refer);
		}else{
			curl_setopt ($this->__curlSRC, CURLOPT_REFERER,   null);
		}
		return $this;
	}

	/**
	 * Switch debug handler for verbose curl processing
	 *
	 * @param boolean $flag
	 * @return this
	 */
	public function setDebug($flag = false)
	{
		$this->getSrc();
		if($flag)
		{
			curl_setopt($this->__curlSRC, CURLOPT_VERBOSE, true);
		}
		else
		{
			curl_setopt($this->__curlSRC, CURLOPT_VERBOSE, false);
		}
		return $this;
	}

	/**
	 * exec curl request
	 *
	 * @param string $page  - url
	 * @return string
	 */
	public function getPage($url)
	{
		$this->getSrc();

		curl_setopt($this->__curlSRC, CURLOPT_URL, $url);

		$ret = curl_exec ( $this->__curlSRC );

		$this->setPostData(false)->setRefer($url);

		return $ret;
	}

	/**
	 * get error number
	 *
	 * @return integer
	 */
	public function getErrno()
	{
	    return curl_errno($this->__curlSRC);
	}

	/**
	 * get errors
	 *
	 * @return string
	 */
	public function getError()
	{
	    return curl_error($this->__curlSRC);
	}

	/**
	 * get curl info
	 *
	 * @return hash
	 */
	public function getInfo()
	{
	    return curl_getinfo($this->__curlSRC);
	}

	/**
	 * Set curl proxy
	 *
	 * @param string $host proxy host
	 * @param string $user login
	 * @param string $pass pass
	 * @return this
	 */
	public function setProxy($host = false, $login = false, $pass = false)
	{
		if($host)
		{
			$this->getSrc();
			curl_setopt ($this->__curlSRC, CURLOPT_PROXY,   $host);
			if($login and $pass)
			{
				curl_setopt ($this->__curlSRC, CURLOPT_PROXYUSERPWD, "$login : $pass");
			}
		}else{
		  	$this->getNewSrc();
		}
		return $this;
	}
}
?>