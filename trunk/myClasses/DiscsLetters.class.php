<?php
/**
 * ����� ��� ��������� ���������� ���� � ������.
 * �� ����� ����� � ����� � ��������
 * @author �������� ��������� <asid@mail.ru>
 * @package mp3
 * @since 01.01.2007
 */
class DiscsLetters{

  public static $array       = null;
  public static $pathIniFile = 'discs.ini';

  /**
   * �������� ���� � ������ ������. ���� �� null, ����� ������ ����� ������� �� ���������� �������
   *
   * @var mixed
   */
  public static $path        = null;

  /**
   * ��������� ������� �� ini �����, ���� �� ��� �� ���������
   *
   * @return array
   */

  public function getArr(){


    if (is_null(self::$array))
    {
      if(self::$path == null){
        self::$path = dirname(__FILE__).'/'.self::$pathIniFile;
      }
      $iniarr = parse_ini_file(self::$path, true);
      foreach ($iniarr['discs'] as $key => $val){
        $arr['toLetter'][$key.':'] = "|^$val:|i";
        $arr['toMetka'][$val.':']  = "|^$key:|i";
      }
      $iniarr = $arr;
      self::$array = $iniarr;
    }else{
      $iniarr = self::$array;
    }
    return $iniarr;
  }


  public function getDiscs(){
    if(self::$path == null){
      self::$path = dirname(__FILE__).'/'.self::$pathIniFile;
    }
    $iniarr = parse_ini_file(self::$path, true);
    //print_r($iniarr);
    $array = array();
    foreach ($iniarr['discs'] as  $disc => $metka ) {
      $array[$disc] = $metka;
    }
    return $array;
  }

  /**
   * ������ ����� �� �����
   *
   * @param string $filename
   * @return string
   */
  public function toLetter($filename){
    $iniarr = self::getArr();
    return trim(preg_replace(array_values($iniarr['toLetter']), array_keys($iniarr['toLetter']),$filename));
  }

  /**
   * ������ ����� �� �����
   *
   * @param string $filename
   * @return string
   */
  public function toMetka($filename){
    $iniarr = self::getArr();
    return trim(preg_replace(array_values($iniarr['toMetka']), array_keys($iniarr['toMetka']),$filename));
  }


}
//print DiscsLetters::logal2prod(DiscsLetters::toMetka('g:/asd')); returns "disc03"
//print DiscsLetters::toLetter('i2:/asd');                         returns "g:"
//print DiscsLetters::toMetka('g:/asd');                           returns "i2:"

?>