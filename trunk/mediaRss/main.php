<?php
require_once(dirname(__FILE__).'/config.php');
class Main
{
	protected $xml = null;
	private $xmlType = 'Rss';
	
	function setXml($xml)
	{
		
	}
	
	function getXml()
	{
		return $this->xml;
	}
	
	function getType()
	{
		require_once(CLASSES_DIR.'Detector.php');
		$xml = $this->getXml();
		$detector = new Detector($xml);
		$detector->detect();
	}
}
$aha = new Main();
$aha->getType();
?>