<?php
return array(

	'cache' => array(
		'frontendOptions' => array(
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
		    'cache_dir' => get_include_path().'tmp/cache/'
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
		'cookies' => get_include_path().'tmp/cookies/'
	)

);
?>