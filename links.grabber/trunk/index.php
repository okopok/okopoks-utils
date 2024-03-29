<?php
/**
 * Enter description here...
 * @version $Id$
 */
define('__ROOTDIR__', dirname(__FILE__).'/');
define('__ZEND_DIR__',__ROOTDIR__.'../Zend_Framework/library/');
set_include_path(
	  get_include_path() 	. PATH_SEPARATOR .
	  __ROOTDIR__.'system/' . PATH_SEPARATOR .
	  __ZEND_DIR__
	);

require_once('Zend/Loader.php');
Zend_Loader::loadClass('My_Logger');

	My_Logger::setConfig(array(
		'extension' 		=> '.log',
		'timestampFormat' 	=> 'Y-m-d H:i:s',
		'timestamp'			=> true,
		'dirs'				=> array(
			'LOG' 		=> __ROOTDIR__.'output'.'/LOG.LOG.txt',
		)
	));

	My_Logger::startTag('LOG');

Zend_Loader::loadClass('My_Main');
	My_Main::getConfig();
	My_Main::debug('My_Logger Loaded');
	My_Main::debug('My_Main Loaded');

Zend_Loader::loadClass('My_Data');

	My_Main::debug('My_Data Loaded');


$data  = new My_Data();

	My_Main::debug('setInputPath '.__ROOTDIR__.'input');

$data->setInputPath(__ROOTDIR__.'input');

	My_Main::debug('setOutputPath '.__ROOTDIR__.'output');

$data->setOutputPath(__ROOTDIR__.'output');

	My_Main::debug('parseAll');

$data->parseAll()->save();

	My_Logger::endTag('LOG');
die(__LINE__."\n");
?>
