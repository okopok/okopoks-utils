<?php
ini_set(”memory_limit”,”768M”);
define('DEBUG',true);
return array(

	'cache' => array(
		'frontendOptions' => array(
		   'automatic_serialization' => true,
		   'lifetime' => 7200,
		   'debug_header' => true, // for debugging
		   'regexps' => array(
		       // cache the whole IndexController
		       '^/$' => array('cache' => true),

		       // cache the whole IndexController
		       '^/index/' => array('cache' => true),

		       // we don't cache the ArticleController...
		       '^/article/' => array('cache' => false),

		       // ... but we cache the "view" action of this ArticleController
		       '^/article/view/' => array(
		           'cache' => true,

		           // and we cache even there are some variables in $_POST
		           'cache_with_post_variables' => true,

		           // but the cache will be dependent on the $_POST array
		           'make_id_with_post_variables' => true
		       )
		   )
		),
		'backendOptions' => array(
		    'cache_dir' => dirname(__FILE__).'/tmp/cache/'
		)
	),

	'csv' => array(
		'delimiter' => ';',
		'quotes'	=> true,
		'vars'		=> array(
			'ext'	=> 0,
			'limitFrom'	=> 1,
			'limitTo'	=> 2,
			'proxy'	=> 3,
			'link'	=> 4
		),
		'pagerRegex'=> '(*)',
	),

	'curl' => array(
		'cookies' => dirname(__FILE__).'/tmp/cookies/',
		'timeout' => 6
	),
	'timeout' => 3

);
?>