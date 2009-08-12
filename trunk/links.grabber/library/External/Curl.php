<?php

/**
 * @package utils
 * @copyright Molotdsov Sasha <asid@mail.ru>
 * @version 0.9
 */
class My_Curl
{
	protected $__curlSRC   = null;     			// курл сурс
	protected $__cookiesDir= '';       			// путь до кук
	protected $__defaultTimeout   = 10;       	// ДЕФОЛТНЫЙ таймаут соединения в секундах


	/**
	* Получение сурса. Если был, то просто возвращаем, если небыло, то создаём
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
	* Получаем новый ресурс соединения
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
	 * Enter description here...
	 *
	 * @param unknown_type $path
	 * @return unknown
	 */
	public function setCookiesDir($path)
	{
		$this->__cookiesDir = $path;
		return $this;
	}

	/**
	 * если есть инпуты, то добавляем отправку постов
	 *
	 * @param unknown_type $inputs
	 * @return unknown
	 */
	public function setInputs($inputs)
	{
		$this->getSrc();
		if(is_array($inputs) and count($inputs) > 0)
		{
			curl_setopt($this->__curlSRC, CURLOPT_POST, 1);
			curl_setopt($this->__curlSRC, CURLOPT_POSTFIELDS, $inputs);
		}else{
			curl_setopt($this->__curlSRC, CURLOPT_POST, 0);
			curl_setopt($this->__curlSRC, CURLOPT_POSTFIELDS, array());
		}
		return $this;
	}

	/**
	 * следовать за редиректами
	 *
	 * @param unknown_type $time
	 * @return unknown
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
	 * устанавливаем таймаут обрыва соединения
	 *
	 * @param unknown_type $follow
	 * @return unknown
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
	 * если есть реферер, то добаляем его
	 *
	 * @param unknown_type $refer
	 * @return unknown
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
	 * Отправляем посты на страницу
	 *
	 * @param string $page  - url
	 * @param string $refer - referer = если есть реферер, то добаляем его
	 * @param array $inputs - inputs = если есть инпуты, то добавляем отправку постов
	 * @param bool $follow  - follow redirects = следовать за редиректами
	 * @param int $timeOut  - timeout = таймаут обрыва соединения
	 * @return string
	 */
	public function getPage($url)
	{
		$this->getSrc();

		curl_setopt($this->__curlSRC, CURLOPT_URL, $url);

		$ret = curl_exec ( $this->__curlSRC );

		// сбрасываем инпуты и устанавливаем будущий реферер на текущую страницу.
		$this->setInputs(false)->setRefer($url);

		return $ret;
	}

	/**
	 * Enter description here...
	 *
	 * @return unknown
	 */
	public function getErrno()
	{
	    return curl_errno($this->__curlSRC);
	}

	/**
	 * Enter description here...
	 *
	 * @return unknown
	 */
	public function getError()
	{
	    return curl_error($this->__curlSRC);
	}

	/**
	 * Enter description here...
	 *
	 * @return unknown
	 */
	public function getInfo()
	{
	    return curl_getinfo($this->__curlSRC);
	}

	/**
	 * Использовать прокси или нет
	 *
	 * @param string $host адресс прокси сервера. Если 0, то работает новое собенение без прокси. Все сессии сбрасываются
	 * @param string $user логин
	 * @param string $pass пароль
	 */
	public function setProxy($host = false, $user = false, $pass = false)
	{
		if($host)
		{
			$this->getSrc();
			curl_setopt ($this->__curlSRC, CURLOPT_PROXY,   $host);
			if($user and $pass)
			{
				curl_setopt ($this->__curlSRC, CURLOPT_PROXYUSERPWD, "$user : $pass");
			}
		}else{
		  	$this->getNewSrc();
		}
		return $this;
	}
}
?>