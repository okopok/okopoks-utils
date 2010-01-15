<?php

class Emission_IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    }

    public function addAction()
    {
        $cache = Zend_Registry::get('Cache');
        $id = ''; // cache id of "what we want to cache"
        $dataNew = array();
		if( $_POST['save']) {
			$data = $cache->load('emissions');
			if ($data) {
				array_push($data, $_POST);
		    	$cache->save($data);
			} else {
				$cache->save(array($_POST));
			}
			$this->_redirector->gotoSimple('all', 'index', 'emission');
		}
    }

    public function allAction()
    {
    	$cache = Zend_Registry::get('Cache');
    	if ($data = $cache->load('emissions')) {
		   $this->view->assign('emissions', $data);
		}
        // action body
    }

    public function deleteAction()
    {
        // action body
    }

    public function viewAction()
    {
        // action body
    }

    public function listAction()
    {
        // action body
    }

    public function editAction()
    {
        // action body
    }

}













