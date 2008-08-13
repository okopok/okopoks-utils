<?php
/**
 * МиниКласс для получения списка виртуальных и не очень директорий
 * @author Molodtsov Alex <molodtsov.sasha@gmail.com>
 * @example print_r(Virtuals::dirs('http://localhost/new/pivo'));
 * @version 1.0
 * @since 06.02.2007
 */
class Virtuals{
  /**
   * static function
   * @static dirs()
   * @return Array
   */
  static function dirs($url = ''){
    if($_SERVER['REQUEST_URI'] <> '' and $url == '')
    {
      $url = $_SERVER['REQUEST_URI'];
    }
    elseif($_SERVER['REQUEST_URI'] == '' and $url == '')
    {
      return array();
    }
    $_VIRTALS = parse_url($url);
    return explode('/', trim(strtr($_VIRTALS['path'],'\\','/'),'/'));
  }
}
?>