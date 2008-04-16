<?php

/**
 * ����� ��� ������������� �������� ������� dir, copy, move, rename
 * @author Molodtsov Aleksander <asid@mail.ru>
 * @since 28.03.2007
 * @version 1.0
 */
class FilesExec{

  public $getFiles = array();
  public $path     = '';

  /**
   * ���� ����� ���������� � ���������� ����, �� ��� ����� ������������ ������
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
   * ���� ����������
   *
   * @param string $dir - ���� ����������� ����������
   * @return array      - ��� � ���������� ����������
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
   * ���������������� ����� ��� ����������
   *
   * @param string $from  - ���� �� ����� ��� �����.
   * @param string $to    - ����� �������� ����� ��� �����, ��� ������� ����. ������ ���.
   */
  function renameExec($from, $to){
    $exec = 'rename '.escapeshellarg($from).' '.escapeshellarg($to);
    exec($exec);
  }

  /**
   * Enter description here...
   *
   * @param string $from  - ���� �� �����.
   * @param string $to    - ����� ���� �����.
   */
  function copyExec($from, $to){
    $exec = 'copy /N /Y "'.escapeshellarg($from).' '.escapeshellarg($to);
    exec($exec);
  }

  /**
   * Enter description here...
   *
   * @param string $from  - ���� �� �����.
   * @param string $to    - ����� ����� �����.
   */
  function moveExec($from, $to){
    $exec = 'move /Y "'.escapeshellarg($from).' '.escapeshellarg($to);
    exec($exec);
  }

  /**
   * ������� ������������ ������ �� �������� ����� ����� � �������� ������ �� ����
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