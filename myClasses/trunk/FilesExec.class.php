<?php

/**
 * Класс для использования виндовых функций dir, copy, move, rename
 * @author Molodtsov Aleksander <asid@mail.ru>
 * @since 28.03.2007
 * @version 1.0
 */
class FilesExec{

  public $getFiles = array();
  public $path     = '';

  /**
   * Если класс вызывается с параметром пути, то ему сразу возвращается массив
   *
   * @param unknown_type $path
   * @return unknown
   */
  function __construct($path = false){
    $this->path = $path;
    if(strlen($path) > 0)
    {
      $this->scandirExec($path);
    }
  }

  /**
   * Скан директории
   *
   * @param string $dir - путь сканируемой директории
   * @return array      - хэш с содержимым директории
   */
  function scandirExec($dir){

    $exec = 'dir /x /-c '.escapeshellarg($dir).'';
    $var = '';
    exec($exec, $var);
    //print $exec."\n\n";
    $mas = array();

    array_shift($var);
    array_shift($var);
    array_shift($var);
    array_shift($var);
    array_shift($var);
    array_pop($var);
    array_pop($var);

    for ($i = 0; $i < sizeof($var); ++$i){
      $line = $var[$i];
      $matches = array();
      preg_match_all('/(\S+)/',convert_cyr_string($line,'d','w'), $matches);
      unset($matches[0]);
      $matches[1]    = array_map('trim',$matches[1]);
      $shortFilename = '';
      if(isset($matches[1][4]))
      {
        $filename = '';
        $shortFilename = $matches[1][3];
        for($b = 4; $b < sizeof($matches[1]); ++$b)
        {
          $filename .= ' '.$matches[1][$b];
        }
      }else{
        $filename = $matches[1][3];
      }
      if(trim($filename) == '.' or trim($filename) == '..') continue;
      $mas[$i]['long']  = trim($filename);
      $mas[$i]['short'] = trim($shortFilename);
      $mas[$i]['date']  = trim($matches[1][0]);
      $mas[$i]['time']  = trim($matches[1][1]);
      $mas[$i]['size']  = trim($matches[1][2]);
    }
    sort($mas);
    $this->getFiles = $mas;
    return $mas;
  }


  /**
   * Переименовывание файла или директории
   *
   * @param string $from  - путь до файла или папки.
   * @param string $to    - новое название папки или файла, без полного пути. Только имя.
   */
  function renameExec($from, $to){
    $exec = 'rename '.escapeshellarg($from).' '.escapeshellarg($to);
    exec($exec);
  }

  /**
   * Enter description here...
   *
   * @param string $from  - путь до файла.
   * @param string $to    - новый путь файла.
   */
  function copyExec($from, $to){
    $exec = 'copy /N /Y "'.escapeshellarg($from).' '.escapeshellarg($to);
    exec($exec);
  }

  /**
   * Enter description here...
   *
   * @param string $from  - путь до файла.
   * @param string $to    - новый пусть файла.
   */
  function moveExec($from, $to){
    $exec = 'move /Y "'.escapeshellarg($from).' '.escapeshellarg($to);
    exec($exec);
  }

  /**
   * Обходим получившийся массив по длинному именя файла и получаем сводку по нему
   *
   * @param unknown_type $name
   * @return unknown
   */
  function getHashByLong($name){
    if(count($this->getFiles) > 0)
    {
      foreach ($this->getFiles as $arr){
        if($arr['long'] == $name) return $arr;
      }
    }
    return false;
  }

}

/*
$SNF = new FilesExec(dirname(__FILE__));
print_r($SNF->getFiles);
$SNF->scandirExec(dirname(__FILE__).'/..');
print_r($SNF->getFiles);
print_r($SNF->getHashByLong('debug'));
*/
?>