<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {

    }


    public function beerAction()
    {
        print Default_Model_Beer_Beer::getTest();
        print "<br>";
        print Default_Model_Beer::getTest();
    }

    public function testAction()
    {
        print Default_Model_Test::getTest();
    }



}

