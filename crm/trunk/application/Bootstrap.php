<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{

	protected function _initAutoload()
    {
        $autoloader = new Zend_Application_Module_Autoloader(array(
            'namespace' => 'Default_',
            'basePath'  => dirname(__FILE__),
        ));
        return $autoloader;
    }

	protected function _initDoctype()
    {
        $this->bootstrap('view');
        $view = $this->getResource('view');
        $view->doctype('XHTML1_STRICT');
    }

    protected function _initCache()
    {
    	$frontendOptions = array(
		   'lifetime' => null,
		   'debug_header' => true, // for debugging,
		   'automatic_serialization' => true
		);

		$backendOptions = array(
		    'cache_dir' => APPLICATION_PATH . '/../tmp/'
		);
		// getting a Zend_Cache_Frontend_Page object
		$cache = Zend_Cache::factory('Core',
		                             'File',
		                             $frontendOptions,
		                             $backendOptions);
         Zend_Registry::set('Cache', $cache);
    }
}

