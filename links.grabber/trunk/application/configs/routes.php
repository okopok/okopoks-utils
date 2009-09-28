<?php
return
	array(
		'spider'=>array(
			'type' => 'Zend_Controller_Router_Route',
			'route' => '/spider/',
			'defaults'  => array(
				'username' => '',
	    		'controller' => 'index',
	    		'action' => 'index',
	    		'module' => 'spider'
			),
		),
		/*
		'bidAddViewRoute'=>array(
			'type' 	=> 'Zend_Controller_Router_Route',
			'route' => '/bid/add/:mode/:product_id/:category_id',
			'map' 	=> '',
			'defaults'  => array(
				'product_id' 	=> '',
				'mode'	 		=> 'offer',
	    		'controller' 	=> 'bid',
	    		'action' 		=> 'add',
	    		'category_id'	=> ''
			),
			'reqs' => array(
				'product_id' => '\d+',
				'category_id'=> '\d+',
				'mode'	 => '\w+'
			)
		),
		*/
)
?>
