<?php



class Spider_Loader_Tagoo{


	private function __parseHTML(){

		preg_match_all("/\<a.*?href=(\'|\")(.*?)(\'|\").*?>/",$this->__sHTML, $matches);
		$output = array();
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
		$this->__aPageLinks = $output;
	}

	public function checkCaptcha(){

	}

	public function printCaptchaForm(){

	}

	public function auth(){

	}
}