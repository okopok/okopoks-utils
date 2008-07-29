<?php

class bd
{
  static $mysql = false;
  static function init()
  {
    $mysql= new DB_MySQL;
    $mysql->connect();
    self::$mysql = $mysql;
  }

  static function getData($sql)
  {
    return self::$mysql->getData($sql);
  }

  static function query($sql)
  {
    return self::$mysql->qr($sql);
  }
}

?>