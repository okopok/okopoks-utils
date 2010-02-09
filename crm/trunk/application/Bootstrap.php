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

	public function _initNavigation()
    {
        $this->bootstrapView();
        $view = $this->getResource('view');

        $pages = array(
            array(
                'controller'	=> 'index',
                'label'         => 'main',
                'pages' => array (
                    array (
                    	'module'		=> 'default',
                        'controller'	=> 'index',
                        'action'        => 'beer',
						'resource'      => 'mvc:client',
                        'privilege'     => 'index',
                        'label'         => 'beer',
                    ),
                    array (
                    	'module'		=> 'default',
                        'controller'	=> 'index',
                        'action'        => 'test',
						'resource'      => 'mvc:client',
                        'privilege'     => 'new',
                        'label'         => 'test',
                    )
            	)
            )
        );

        $container = new Zend_Navigation($pages);
        $view->menu = $container;
        return $container;
    }


    /**
     * Инициализируем ACL.
     * Создаем роли и ресурсы. Раздаем права доступа
     *
     * @return Zend_Acl
     */
    protected function _initAcl()
    {
        $auth = Zend_Auth::getInstance();
        // Определяем роль пользователя.
        // Если не авторизирован - значит "гость"
        $role = ($auth->hasIdentity() && !empty($auth->getIdentity()->role))
            ? $auth->getIdentity()->role : 'guest';

        $acl = new Zend_Acl();

        // Создаем роли
        $acl->addRole(new Zend_Acl_Role('guest'))
            ->addRole(new Zend_Acl_Role('member'), 'guest')
            ->addRole(new Zend_Acl_Role('administrator'), 'member');

        // Создаем ресурсы
        // Я использую префиксы для наименования ресурсов
        // "mvc:" - для страниц
        $acl->add(new Zend_Acl_Resource('mvc:index'))
            ->add(new Zend_Acl_Resource('mvc:error'))
            ->add(new Zend_Acl_Resource('mvc:client'));

        // Пускаем гостей на "морду" и на страницу ошибок
        $acl->allow('guest', array('mvc:error', 'mvc:index'));

        // А также на страницы авторизации и регистрации
        $acl->allow('guest', 'mvc:client', array('login', 'registration'));
        // А мемберам уже облом :)
        $acl->deny('member', 'mvc:client', array('login', 'registration'));
        // Ну и т.д.
        $acl->allow('member', 'mvc:client', array('index', 'search', 'report'));
        $acl->allow('administrator', 'mvc:client', array('new', 'all'));

        // Цепляем ACL к Zend_Navigator
//        Zend_View_Helper_Navigation_HelperAbstract::setDefaultAcl($acl);
//        Zend_View_Helper_Navigation_HelperAbstract::setDefaultRole($role);

        return $acl;
    }
}

