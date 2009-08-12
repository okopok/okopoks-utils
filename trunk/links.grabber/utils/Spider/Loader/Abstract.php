<?php


abstract class Spider_Loader_Abstract{

	private $__sHTML 		= null;
	private $__aPageLinks 	= array();
	private $__aAllLinks  	= array();

	abstract private function __parseHTML();

	abstract public function checkCaptcha();

	abstract public function printCaptchaForm();

	abstract public function auth();

	public function setHTML($sHTML){
		$this->__sHTML = $sHTML;
		$this->__parseHTML();
		return true;
	}

	public function getPage($sUrl){
		$sHTML = file_get_content($sUrl);
		$this->setHTML($sHTML);
		return $sHTML;
	}

	public function getHTML($sUrl){
		return $this->__sHTML;
	}

	public function getPageLinks(){
		return $this->__aPageLinks;
	}

	public function getAllLinks(){
		return $this->__aAllLinks;
	}

	public function getPages(){
		return $this->__oPages;
	}

	public function getPagesToParse(){

	}

	private function __init(){

	}

}