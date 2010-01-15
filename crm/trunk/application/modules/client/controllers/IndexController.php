<?php

class Client_IndexController extends Zend_Controller_Action
{
	protected $_redirector = null;

    public function init()
    {
    	$this->_redirector = $this->_helper->getHelper('Redirector');
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    }

    public function editAction()
    {
        // action body
    }

    public function allAction()
    {
    	$cache = Zend_Registry::get('Cache');
    	if ($data = $cache->load('clients')) {
		   $this->view->assign('clients', $data);
		}
        // action body
    }

    public function addAction()
    {
        $cache = Zend_Registry::get('Cache');
        $id = ''; // cache id of "what we want to cache"
        $dataNew = array();
		if( $_POST['save']) {
			$dataNew[$_POST['login']] = array_map('trim', $_POST);
			$data = $cache->load('clients');
			if ($data) {
				if (!isset($data[$_POST['login']]))
				{
					array_push($data, $data);
			    	$cache->save($data);
				}
			} else {
				$cache->save($dataNew);
			}
			$this->_redirector->gotoSimple('all', 'index', 'client');
		}
    }

    public function deleteAction()
    {
        // action body
    }

    public function infoAction()
    {
        // action body
    }

}

















