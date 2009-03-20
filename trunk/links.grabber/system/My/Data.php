<?php


class My_Data
{
	protected $__inputPath 	= false;
	protected $__outputPath	= false;
	protected $__output		= array();
	protected $__badLinks 	= array();

	public function __construct()
	{

	}



	public function load($path)
	{
		Zend_Loader::loadClass('My_Main');
		$config = My_Main::getConfig();

		$lines = file($path);

		if(!is_array($lines) || !count($lines)) return array();

		$glue = ($config->csv->quotes)? '"'.$config->csv->delimiter.'"':$config->csv->delimiter;
		$output = array();

		foreach ($lines as $line)
		{
			$lineNum 	= count($output);
			$line 	= trim($line,"\n\r\t\"");
			$row 	= explode($glue, $line);

			if(count($row) != count($config->csv->vars)) continue;

			foreach ($config->csv->vars as $key => $value)
			{
				$output[$lineNum][$key] = $row[$value];
			}

			// если есть пагер, то распарсиваем его на ссылки.
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
		return $output;
	}

	public function loadAll()
	{
		if(!is_dir($this->__inputPath)) return false;
		$output = array();
		foreach (scandir($this->__inputPath) as $path)
		{
			if($path == '.' || $path == '..' || is_dir($this->__inputPath.'/'.$path)) continue;

			$ext = strtolower(substr($path,strrpos($path,'.')+1));

			if($ext != 'csv') continue;

			$output[$path] = $this->load($this->__inputPath.'/'.$path);
		}
		return $output;
	}


	public function parse($array)
	{
		$output = array();
		foreach ($array as $line)
		{
			$curl = My_Main::getCurl();
			$html = '';
			$links = array();
			print $line['link'].' :: ';
			if($line['proxy'])
			{
				print 'USIGN PROXY:';
				$proxyList = My_Main::getProxyList();
				foreach ($proxyList as $proxy)
				{
					print "\n\t".$proxy.': ';
					$curl->setProxy($proxy);
					$html = $curl->getPage($line['link']);

					if($curl->getError())
					{
						print $curl->getErrno();
						print " - ";
						print $curl->getError();
						print " - ";
						$html = '';
						print ' FALSE ; ';
					}else{
						break;
					}
				}

			}else{
				$html = $curl->getPage($line['link']);
				if($curl->getError())
				{
					print $curl->getErrno();
					print " - ";
					print $curl->getError();
					$html = '';
				}
			}

			if(!$html)
			{
				$this->__badLinks[] = $line['link'];
				print "FALSE";
				print "\n\n";
				continue;
			}
			print "OK";
			print "\n\n";
			$links = $this->__parseHTML($html, $line);
			$output[] = $links;

		}
		return $output;
	}



	public function parseAll()
	{
		$array = $this->loadAll();
		foreach ($array as $key => $arr)
		{
			$this->__output[$key] = $this->parse($arr);
		}
		return $this;
	}

	public function getOutput()
	{
		return $this->__output;
	}

	public function getBadlinks()
	{
		return $this->__badLinks;
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
		$file = array();
		$out = array();
		$date = date('Y.m.d-His');
		foreach ($this->__output as $key => $pages)
		{
			$file[$key] =array();
			foreach ($pages as $links)
			{
				foreach ($links as $link)
				{
					$plar = parse_url($link);
					$domen = substr($plar['host'], strrpos($plar['host'], '.')+1);
					$file[$key][$domen][] = $link;
				}
			}

			foreach ($file[$key] as $domen => $links)
			{
				$file[$key][$domen] = array_unique($links);
				$path = $this->__outputPath.'/'.$date.'.'.$domen.'.'.$key.'.txt';
				$out = array_merge($out, $file[$key][$domen]);
				$this->__save2file($path, $file[$key][$domen]);
			}
		}

		$this->__save2file($this->__outputPath.'/'.$date.'.ALL.LINKS.txt', array_unique($out));
		$this->__save2file($this->__outputPath.'/'.$date.'.BAD.LINKS.txt', array_unique($this->__badLinks));

		$out = array();
		foreach ($this->loadAll() as $links)
		{
			foreach ($links as $row)
			{
				$out[] = $row['link'];
			}
		}

		$this->__save2file($this->__outputPath.'/'.$date.'.ALL.PAGES.txt', array_unique($out));

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
							$newLink .= ($settingLinkArr['path']? $settingLinkArr['path'] : '');
						}
					}
					$newLink .= $link.($linkArr['query']? '?'.$linkArr['query']:'').($linkArr['fragment']? '?'.$linkArr['fragment']:'');
					$output[] = $newLink;
				}
			}
		}
		return $output;
	}

	private function __save2file($filename, $array)
	{
		natcasesort($array);
		file_put_contents($filename, implode("\r\n",$array));
		return true;
	}



}

?>