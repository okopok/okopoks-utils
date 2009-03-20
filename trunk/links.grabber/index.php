<?php

define('__ROOTDIR__', dirname(__FILE__).'/');

set_include_path(
	__ROOTDIR__.'system/'
	);

require_once('Zend/Loader.php');

Zend_Loader::loadClass('My_Main');
Zend_Loader::loadClass('My_Data');
$config = My_Main::getConfig();
//print_r($config);
//$out = $config->setDir(__ROOTDIR__.'system/configs/')->setExtension('csv')->load('main');
//print_r($out);
$cache = My_Main::getCache();

$data = new My_Data();

$data->setInputPath(__ROOTDIR__.'input');
$data->setOutputPath(__ROOTDIR__.'output');
//$data->parseAll();
$data->parseAll()->save();
//print_r($out);
$curl = My_Main::getCurl();

die;
foreach (My_Main::getProxyList() as $proxy)
{
	print $proxy.': ';
		$curl->setTimeout(20)
			->setDebug(false)
			->setProxy($proxy)
			->getPage('http://ya.ru');
			print $curl->getErrno();
			print " - ";
			print $curl->getError();
			print "\n\n";
			//->getPage('http://ya.ru'));
}

?>