<?php

include_once($_SERVER['DOCUMENT_ROOT'].'/classes/Main.class.php');
class Admin extends Main {
  //var $tpl;
  var $user_id = 0;


  /**
   * Enter description here...
   *
   */
  function __construct()
  {
    parent::__construct();
    $this->Main = parent::getClassObj();
    $this->Main->_smarty->template_dir = ADMIN_SMARTY_TEMPLATE_DIR;
    $this->Main->_smarty->compile_dir  = ADMIN_SMARTY_COMPILE_DIR;
      //$this->Main->_smarty->config_dir = '/web/www.example.com/guestbook/configs/'; // пока не задано
    $this->Main->_smarty->cache_dir    = ADMIN_SMARTY_CACHE_DIR;
    $this->Main->print_ar($this->Main->__VIRTUALS);
    //print $this->Main->_smarty->template_dir;
    //print $this->Main->tpl;

  }

  /**
   * Enter description here...
   *
   */
  function __destruct()
  {

  }

  /**
   * Enter description here...
   *
   * @param unknown_type $method_name
   * @param unknown_type $method_params
   * @return unknown
   */
  function __call($method_name, $method_params)
  {
    if(is_file(ADMIN_METHODS_DIR.$method_name.'.method.php'))
    {
      return (include(ADMIN_METHODS_DIR.$method_name.'.method.php'));
    }else{

      die("OOOOPS! Method '$method_name' does not exists in class '".__CLASS__."'!");
    }
  }


  /**
   * Enter description here...
   *
   * @param unknown_type $login
   * @param unknown_type $password
   * @return unknown
   */
  function checkLogin($login = '', $password = '')
  {
    if(isset($_COOKIE['adminLogon']['login']) and $login == '')
    {
      $login    = mysql_real_escape_string($_COOKIE['adminLogon']['login']);
    }else{
      $login    = mysql_real_escape_string(trim($login));
    }
    if(isset($_COOKIE['adminLogon']['password']) and $password == '')
    {
      $password = mysql_real_escape_string($_COOKIE['adminLogon']['password']);
    }else{
      $password = md5(mysql_real_escape_string(trim($password)));
    }
    print "'$login' => '$password'</br>";


    if($login == false and $password == false) return false;
     //print "'$login' => '$password'";
    $data = $this->_mysql->getData("
      SELECT * FROM ".DB_TABLE_REFIX."users WHERE users_login = '$login' and MD5(users_password) = '$password'
    ");
    if(count($data) > 0)
    {
      $this->user_id = $data[0]['pk_users_id'];
      return true;
    }else{
      return false;
    }
  }

  /**
   * Enter description here...
   *
   */
  function display()
  {
    //print $this->tpl;

    //$this->print_ar($this->Main->__VIRTUALS);
    $VIRT = $this->Main->__VIRTUALS;
   $this->print_ar($_POST);
    if(!isset($VIRT[1]))
    {
      $VIRT[1] = '';
    }
    $BRANDS_MODELS_HASH = $this->Main->caller('buildHashes', array('brands_models'));
    $BRANDS_HASH        = $this->Main->caller('buildHashes', array('brands'));

    // если юзверь не залогинен, то шлём его логится
    if((
       !isset($_COOKIE['adminLogon']['login']) or
       !isset($_COOKIE['adminLogon']['password']) or
       !$this->checkLogin()
       ) AND (!isset($_POST['adminLogin']) and !isset($_POST['adminPassword']))
      )
    {

      setcookie("adminLogon[login]", '', time()-60, ADMIN_URL_ROOT);
      setcookie("adminLogon[pass]",  '', time()-60, ADMIN_URL_ROOT);
      $this->print_ar($VIRT);
      if($VIRT[1] != 'login')
      {
        header("location: ".ADMIN_URL_ROOT."login/");
      }
    }
    // ......................................................
    switch ($VIRT[1])
    {
      case 'uploadXLS':
        $this->uploadXLS();
        $this->tpl = 'uploadXLS.form';
      break;
      // ......................................................
      case 'editbrands':

        if(isset($VIRT[2], $BRANDS_HASH[$VIRT[2]]))
        {
          if(isset($VIRT[3]) AND $VIRT[3] == 'edit')
          {
            $this->editBrands($BRANDS_HASH[$VIRT[2]]);
          }elseif(isset($VIRT[3], $BRANDS_MODELS_HASH[$VIRT[2]][$VIRT[3]])){
            $this->editModels($BRANDS_MODELS_HASH[$VIRT[2]][$VIRT[3]]);
          }else{
            $this->Main->caller('showModels', array($BRANDS_HASH[$VIRT[2]]));

          }
        }else{
          header('location: '.ADMIN_URL_ROOT.'showbrands/');
        }
      break;
      // ......................................................
      case 'showbrands':
        if(isset($VIRT[2], $BRANDS_HASH[$VIRT[2]]))
        {
          $this->Main->caller('showBrands', array($BRANDS_HASH[$VIRT[2]]));
          $this->Main->caller('showModels', array($BRANDS_HASH[$VIRT[2]]));
          $this->Main->_smarty->display('header.html');
          $this->Main->_smarty->display('brands.html');
          $this->Main->_smarty->display('models.html');
          $this->tpl = 'footer';
        }else{
          $this->Main->caller('showBrands',array());
          $this->Main->_smarty->display('header.html');
          $this->tpl = 'brands';
        }
      break;
      // ......................................................
      case 'login':
        // если юзверь уже залогинен, то шлём его на главную, ибо нех
        if($this->checkLogin())
        {
          header("location: ".ADMIN_URL_ROOT);
        }
        $this->login();
      break;
      // ......................................................
      case 'clear-cache':
        // если юзверь уже залогинен, то шлём его на главную, ибо нех
        $this->clearCache();
      break;
      // ......................................................
    }
    //print $this->Main->_smarty->template_dir.$this->tpl.'.html';
    $this->Main->_smarty->display($this->tpl.'.html');
  }
}