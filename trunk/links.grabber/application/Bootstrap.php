<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
	public static $frontController = null;
	public static $root = '';
	public static $registry = null;

	public function run()
	{
		self::$root = APPLICATION_PATH.'/..';
		self::prepare();
		$response = self::$frontController->dispatch();


		self::sendResponse($response);
	}


	public static function prepare()
	{
		//self::setupEnvironment();
		//self::setupRegistry();
		//self::setupConfiguration();
		self::setupFrontController();
		//self::setupErrorHandler();
		//self::setupController();
		self::setupView();
		//self::setupDatabase();
		//self::setupSessions();
		//self::setupTranslation();
		self::setupRoutes();
		//self::setupAcl();

	}


	public static function setupFrontController()
    {
        self::$frontController = Zend_Controller_Front::getInstance();
        self::$frontController->throwExceptions(true);
        self::$frontController->returnResponse(true);
print  self::$root . '/application/controllers';
        self::$frontController->setControllerDirectory(self::$root . '/application/controllers');

        Zend_Loader::loadClass("Zend_Layout");
    	Zend_Loader::loadClass("Zend_Controller_Front");

        $o_layout          = Zend_Layout::startMvc(array(
        	'layout'     => 'main',
        	'layoutPath' => self::$root . '/application/layouts',
		    'contentKey' => 'MAIN')
	    );

        self::$frontController->setParam('registry', self::$registry);
    }

	public static function setupView()
	{


		$view = new Zend_View(array('encoding'=>'UTF-8'));
		$view->addHelperPath('GSD/View/Helper', 'GSD_View_Helper_');
		$viewRendered = new Zend_Controller_Action_Helper_ViewRenderer($view);
		Zend_Controller_Action_HelperBroker::addHelper($viewRendered);
		Zend_Layout::startMvc(
			array(
			'layoutPath' => self::$root . '/application/layouts',
			'layout' => 'main'
			)
		);
	}

	public static function sendResponse(Zend_Controller_Response_Http $response){
		$response->sendResponse();
	}

	public static function setupRoutes()
	{
		// define some routes (URLs)
		$router = self::$frontController->getRouter();
		$config = new Zend_Config(require self::$root . '/application/configs/routes.php');
		$router->addConfig($config);

	}
}

