<?php
#
class Bootstrap{

	public static $frontController = null;
	public static $root = '';
	public static $registry = null;

	public static function run()
	{
		self::prepare();
		$response = self::$frontController->dispatch();
		self::sendResponse($response);
	}


	public static function prepare()
	{
		self::setupEnvironment();
		self::setupRegistry();
		self::setupConfiguration();
		self::setupFrontController();
		self::setupErrorHandler();
		self::setupController();
		self::setupView();
		self::setupDatabase();
		self::setupSessions();
		self::setupTranslation();
		self::setupRoutes();
		self::setupAcl();

	}


	public static function setupEnvironment()
	{

		error_reporting(E_ALL ^ E_NOTICE);
		ini_set('display_errors', true);
		//date_default_timezone_set('Europe/Bucharest');

		self::$root = dirname(dirname(__FILE__));
		$configType = (isset($_SERVER['SERVER_NAME']) &amp;&amp; ($_SERVER['SERVER_NAME'] == '127.0.0.1' OR $_SERVER['SERVER_NAME'] == 'localhost')) ? 'development' : 'production';
		define('APPLICATION_ENVIRONMENT', $configType);
			define('HTMLPURIFIER_PREFIX', self::$root . '/library');

	}


	public static function setupRegistry()
	{

		self::$registry = new Zend_Registry(array(), ArrayObject::ARRAY_AS_PROPS);
		Zend_Registry::setInstance(self::$registry);

	}


	public static function setupConfiguration()
	{


		$config = new Zend_Config_Ini(
		self::$root . '/application/config/main.ini',
		APPLICATION_ENVIRONMENT
		);
			self::$registry->configuration = $config;
			//save $siteRootDir in registry:
		self::$registry->set('siteRootDir', self::$root );
		self::$registry->set('applicationRootDir', self::$root . '/application' );
			self::$registry->set('siteRootUrl', 'http://' . $_SERVER['HTTP_HOST'] );

	}


	public static function setupFrontController()
	{
		self::$frontController = Zend_Controller_Front::getInstance();
		self::$frontController->throwExceptions(true);
		self::$frontController->returnResponse(true);
			self::$frontController->addModuleDirectory(self::$root . '/application/modules');
			self::$frontController->setParam('registry', self::$registry);
			self::$frontController->setParam('env', APPLICATION_ENVIRONMENT);
			$response = new Zend_Controller_Response_Http; // Set default Content-Type
		$response->setHeader('Content-Type', 'text/html; charset=UTF-8', true);
		self::$frontController->setResponse($response);

	}


	public static function setupErrorHandler()
	{

		self::$frontController->throwExceptions(false);
			self::$frontController->registerPlugin(new Zend_Controller_Plugin_ErrorHandler(
		array(
		'module'     =&gt; 'default',
		'controller' =&gt; 'error',
		'action'     =&gt; 'error')
		));
			$writer = new Zend_Log_Writer_Firebug();
		$logger = new Zend_Log($writer);
		Zend_Registry::set('logger',$logger);
	}

	public static function setupController()
	{
		// place to put in your Controll Action Helpers
		// ex: Zend_Controller_Action_HelperBroker::addHelper(new GSD_Controller_Action_Helper_AuthUsers());

	}


	public static function setupView()
	{


		$view = new Zend_View(array('encoding'=&gt;'UTF-8'));
		$view->addHelperPath('GSD/View/Helper', 'GSD_View_Helper_');
			$viewRendered = new Zend_Controller_Action_Helper_ViewRenderer($view);
		Zend_Controller_Action_HelperBroker::addHelper($viewRendered);
			Zend_Layout::startMvc(
		array(
		'layoutPath' =&gt; self::$root . '/application/layouts',
		'layout' =&gt; 'default'
		)
		);
		}
			public static function sendResponse(Zend_Controller_Response_Http $response){
		$response->sendResponse();

	}


	public static function setupDatabase()
	{
		$config = self::$registry->configuration;
		$db = Zend_Db::factory($config->db->adapter, $config->db->toArray());
		$profiler = new Zend_Db_Profiler_Firebug('All DB Queries');
		$profiler->setEnabled(true);
		$db->setProfiler($profiler);
		$db->query("SET NAMES 'utf8'");
		self::$registry->database = $db;
		Zend_Db_Table::setDefaultAdapter($db);
		$frontendOptions = array(
			'automatic_serialization' =&gt; true
		);
		$backendOptions  = array(
			'cache_dir'                =&gt; self::$root . '/data/cache/db_table'
		);
		$cache = Zend_Cache::factory('Core',
			'File',
			$frontendOptions,
			$backendOptions
		);
		// Next, set the cache to be used with all table objects
		Zend_Db_Table_Abstract::setDefaultMetadataCache($cache);
	}

	public static function setupSessions()
	{
		// Now set session save handler to our custom class which saves the data in MySQL database
		$sessionManager = new GSD_Session_Manager();
		Zend_Session::setOptions(array(
			'gc_probability' =&gt; 1,
			'gc_divisor' =&gt; 5000
		));
		Zend_Session::setSaveHandler($sessionManager);
		$defSession = new Zend_Session_Namespace('Main', true);
		Zend_Registry::set('defSession', $defSession);
	}

	public static function setupTranslation()
	{
		$options = array(
			'scan' =&gt; Zend_Translate::LOCALE_FILENAME,
			'disableNotices' =&gt; true,
		);
		$translate = new Zend_Translate('gettext', Zend_Registry::get('siteRootDir') . '/application/languages/', 'auto', $options);
		Zend_Registry::set('Zend_Translate', $translate);
		if (self::$frontController) {
			self::$frontController->registerPlugin(new GSD_Controller_Plugin_Language());
		}
	}

	public static function setupRoutes()
	{
		// define some routes (URLs)
		$router = self::$frontController->getRouter();
		$config = new Zend_Config_Ini(
		self::$root . '/application/config/routes.ini',
			'development'
		);
		$router->addConfig($config, 'routes');

	}


	public static function setupAcl()
	{
		self::$frontController->registerPlugin(new GSD_Controller_Plugin_Acl());
	}
#
}
