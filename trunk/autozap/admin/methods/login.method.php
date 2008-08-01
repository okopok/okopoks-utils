<?php

$this->tpl = 'login';
if(isset($_POST['adminLogin']) and isset( $_POST['adminPassword']))
{

  if($this->checkLogin($_POST['adminLogin'], $_POST['adminPassword']))
  {
    print __line__;
    setcookie('adminLogon[login]',       $_POST['adminLogin'],time()+3600*12, ADMIN_URL_ROOT);
    setcookie('adminLogon[password]',    md5($_POST['adminPassword']),time()+3600*12, ADMIN_URL_ROOT);
    setcookie('adminLogon[user_id]',     $this->user_id ,time()+3600*12, ADMIN_URL_ROOT);
    header("location: ".ADMIN_URL_ROOT);
  }else{
    $this->ERRORS[] = 'Неправильный логин или пароль!';
    return false;
  }
}
return false;
?>