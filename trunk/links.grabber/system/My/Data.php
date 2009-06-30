<?php


class My_Data
{
	protected $__inputPath 	= false;
	protected $__outputPath	= false;
	protected $__output		= array();
	protected $__badLinks 	= array();
	protected $timestamp	= null;
	protected $__cache 		= null;
	protected $__loaded_file= array();

	const ALL_LINKS = 'ALL_LINKS';
	const BAD_PAGES = 'BAD.PAGES';
	const ALL_PAGES = 'ALL.PAGES';
	const ALL_OUTPUT = 'ALL.OUTPUT';

	public function __construct()
	{
		//$this->timestamp = date('Y.m.d-His');
		$this->timestamp = 'prefix';
		$this->__cache = My_Main::getCache();
		My_Main::debug('loading cache '.self::ALL_OUTPUT);
		$this->__output[self::ALL_OUTPUT]	= $this->__loadCache(self::ALL_OUTPUT);
		My_Main::debug('done');
		My_Main::debug('loading cache '.self::BAD_PAGES);
		$this->__output[self::BAD_PAGES] 	= $this->__loadCache(self::BAD_PAGES);
		My_Main::debug('done');
		My_Main::debug('loading cache '.self::BAD_PAGES);
		$this->__output[self::ALL_PAGES] 	= $this->__loadCache(self::ALL_PAGES);
		My_Main::debug('done');
	}

	public function load($path)
	{
		Zend_Loader::loadClass('My_Main');
		$config = My_Main::getConfig();

		$lines = file($path);

		if(!is_array($lines) || !count($lines)) return array();

		$output = array();

		foreach ($lines as $line)
		{
			$lineNum 	= count($output);
			$line 	= trim($line,"\n\r\t\"");
			$row 	= explode($config->csv->delimiter, $line);
			foreach($row as $key => $val) $row[$key] = trim($val, '"');
			if(count($row) != count($config->csv->vars)) continue;

			foreach ($config->csv->vars as $key => $value)
			{
				$output[$lineNum][$key] = $row[$value];
			}

			if((int)$output[$lineNum]['limitFrom'] && (int)$output[$lineNum]['limitTo'] && eregi(preg_quote($config->csv->pagerRegex), $output[$lineNum]['link']))
			{
				$temp = $output[$lineNum];
				unset($output[$lineNum]);
				for ($i = $temp['limitFrom']; $i < (int)$temp['limitTo']+1; $i++, $lineNum = count($output))
				{
					$output[$lineNum] 			= $temp;
					$output[$lineNum]['link']  	= str_replace($config->csv->pagerRegex, $i,$output[$lineNum]['link']);
					unset($output[$lineNum]['limit']);
					unset($output[$lineNum]['pager']);
				}
			}

		}
		My_Main::debug('loaded '.$path.' file');
		return $output;
	}

	public function loadAll()
	{
		My_Main::debug('check __inputPath');
		if(!is_dir($this->__inputPath)) return false;
		My_Main::debug('__inputPath is exists');
		$output = array();
		foreach (scandir($this->__inputPath) as $path)
		{
			if($path == '.' || $path == '..' || is_dir($this->__inputPath.'/'.$path)) continue;
			My_Main::debug('file '.$this->__inputPath.'/'.$path);
			$ext = strtolower(substr($path,strrpos($path,'.')+1));

			if($ext != 'csv') continue;

			My_Main::debug('loading '.$this->__inputPath.'/'.$path.' file');
			$output[$path] = $this->load($this->__inputPath.'/'.$path);
		}
		return $output;
	}

	public function parse($array,$key)
	{
		$output = array();
		$proxyList = My_Main::getProxyList();
		Zend_Loader::loadClass('My_Main');

		$config = My_Main::getConfig();
		shuffle($proxyList);
		$proxyList = array_fill_keys($proxyList,0);
		foreach ($array as $line)
		{
			sleep($config->timeout);
			$curl = My_Main::getCurl();
			$html = '';
			arsort($proxyList);
			$links = array();
			print My_Logger::log($line['link'].' :: ');
			if($line['proxy'])
			{
				print My_Logger::log('USIGN PROXY:');

				$bad = 0;
				foreach ($proxyList as $proxy => $okTimes)
				{
					print My_Logger::log("\n\t".$proxy.': ');
					$curl->setProxy($proxy);
					$html = $curl->getPage($line['link']);

					if($curl->getError())
					{
						print My_Logger::log($curl->getErrno());
						print My_Logger::log(" - ");
						print My_Logger::log($curl->getError());
						print My_Logger::log(" - ");
						$html = '';
						print My_Logger::log(' FALSE ; ');
						$bad++;
					}else{
						break;
					}
				}

				if($bad == count($proxyList))
				{
				  DIE('EVERY PROXY URLS are FAILED');
				}
				$proxyList[$proxy] = $okTimes+1;
			}else{
				$html = $curl->getPage($line['link']);

				if($curl->getError())
				{
					print My_Logger::log($curl->getErrno());
					print My_Logger::log(" - ");
					print My_Logger::log($curl->getError());
					$html = '';
				}
			}

			if(!$html)
			{
				$this->__output[self::BAD_PAGES][] = $line['link'];
				print My_Logger::log("FALSE");
				print My_Logger::log("\n\n");
				continue;
			}

			$links = $this->__parseHTML($html, $line);
			print My_Logger::log("OK -> ".count($links).' links');
			print My_Logger::log("\n\n");
			if(!isset($this->__output[self::ALL_OUTPUT]) || !is_array($this->__output[self::ALL_OUTPUT]))
			{
				$this->__output[self::ALL_OUTPUT] = array();
			}
			$this->__output[self::ALL_OUTPUT] = array_merge($this->__output[self::ALL_OUTPUT], $links);
			$this->save();
		}
		return $output;
	}



	public function parseAll()
	{
		My_Main::debug("\t".'parsing!');
		$this->__loaded_file = $this->loadAll();

		foreach ($this->__loaded_file as $key => $arr)
		{
			My_Main::debug('parsing  '.$key);
			$this->parse($arr,$key);
			//$this->__output[self::ALL_OUTPUT][$key] = $this->parse($arr,$key);
		}
		My_Main::debug("\t".'parsing done!');
		return $this;
	}

	public function setInputPath($path)
	{
		$this->__inputPath = $path;
		return $this;
	}

	public function setOutputPath($path)
	{
		$this->__outputPath = $path;
		return $this;
	}

	public function save()
	{
		My_Main::debug("\t\t".'saving start');

		$file = array();
		$out = array();
		foreach ($this->__output[self::ALL_OUTPUT] as $link)
		{
			//print_r($this->__output[self::ALL_OUTPUT]);die;

			$plar = parse_url($link);
			$domen = substr($plar['host'], strrpos($plar['host'], '.')+1);
			$file[$domen][] = $link;

			foreach ($file as $domen => $links)
			{
				//$file[$domen] = array_unique($links);
				$path = $this->__outputPath.'/'.$domen.'.txt';
				//$out = array_merge($out, $file[$key][$domen]);
				$this->__save2file($path, $file[$domen], true);
			}
		}

		//$this->__cache(self::ALL_OUTPUT, $this->__output[self::ALL_OUTPUT]);
		$this->__cache(self::BAD_PAGES,  $this->__output[self::BAD_PAGES]);

		$this->__save2file($this->__outputPath.'/'. self::ALL_LINKS .'.txt', $this->__output[self::ALL_OUTPUT], true);
		$this->__save2file($this->__outputPath.'/'. self::BAD_PAGES .'.txt', $this->__output[self::BAD_PAGES], true);


		foreach ($this->__loaded_file as $links)
		{
			foreach ($links as $row)
			{
				$this->__output[self::ALL_PAGES][] = $row['link'];
			}
		}

		$this->__cache(self::ALL_PAGES, $this->__output[self::ALL_PAGES]);
		$this->__save2file($this->__outputPath.'/'. self::ALL_PAGES .'.txt', $this->__output[self::ALL_PAGES], true);
		My_Main::debug("\t\t".'saving end');

		// reset arrays for memory save
		$this->__output[self::ALL_OUTPUT] = $this->__output[self::BAD_PAGES] = $this->__output[self::ALL_PAGES] = array();
		return true;
	}

	private function __parseHTML($html, $settings)
	{
		$ext = trim($settings['ext'],'."\'');
		$output = array();
		//parse_url()
		preg_match_all("/\<a.*?href=(\'|\")(.*?)(\'|\").*?>/",$html, $matches);
		if(isset($matches[2]) and count($matches[2]))
		{
			$settingLinkArr = parse_url($settings['link']);
			foreach ($matches[2] as $link)
			{
				$newLink = '';
				$linkArr = @parse_url($link);

				if(isset($linkArr['path']) && (substr($linkArr['path'], strrpos($linkArr['path'],$ext)) == $ext || $ext == ''))
				{
					if(!isset($linkArr['host']))
					{
						$newLink .= $settingLinkArr['scheme'].'://'.$settingLinkArr['host'];
						if(substr($link, 0, 1) != '/')
						{
							$newLink .= (isset($settingLinkArr['path'])? $settingLinkArr['path'] : '');
						}
					}
					$newLink .= $link.(isset($linkArr['query'])? '?'.$linkArr['query']:'').(isset($linkArr['fragment'])? '?'.$linkArr['fragment']:'');
					$output[] = $newLink;
				}
			}
		}
		return $output;
	}

	private function __loadCache($key)
	{
		$key = preg_replace('/[^a-z0-9]/ism','', $key);
		if($this->__cache->test($key))
		{
			return $this->__cache->load($key);
		}
		return array();
	}

	private function __cache($key, $array)
	{
		$key = preg_replace('/[^a-z0-9]/ism','', $key);
		$data = $this->__cache->load($key);
		if(is_array($data))
		{
			$array = array_merge_recursive($data, $array);
		}
		//$array = array_unique($array);
		$this->__cache->save($array);
	}

	private function __save2file($sFilename, $aArray, $bAdd = false)
	{
		//file_put_contents($filename, implode("\r\n",array_unique($array)));
		if($bAdd){
		  file_put_contents($sFilename, implode("\r\n",$aArray));
		}else{
		  $rFile = fopen($sFilename, 'a+');
		  fwrite($rFile, implode("\r\n",$aArray));
		  fclose($rFile);
		}
		return true;
	}



}

?>
