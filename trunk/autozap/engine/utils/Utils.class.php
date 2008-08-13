<?php
/**
@author  Molodtsvo Alex <molodtsov.sashs@gmail.com>
@package myClasses

*/

/*=============================================================================
����� ������������ MySQL ����
======

tegory
�������� � 2006 ����
��������� ����������: 21.02.2007
email: asid@mail.ru
======
�������� ��������� �������:
* connect       - ��������� ���������� � ���������� ��� � ������� ������
* setCodepage   - ������������� ��������� �����������
* newConnect    - ������������� ����� ����������� � ���������� ����������
* qr            - ��������� �������
* getData       - ����� ������ ������ �� �������
* getRow        - ����� ���� ������ �� �������.
======
����� ���� �������������� ������ � ������ ������ ��������� �����������
����� ��������� ������������ ��� ����� ���������� �������� ���
����� ������ ���������� ( DB_BASE, DB_HOST, DB_USER, DB_PASS )
=============================================================================*/

/**
 * @category database
 *
 */

class DB_Mysql{
  /**
   * @var resource ��������� �������� ���������
   */
  private $src;
  /**
   * @var resource ���������� ���������� �������
   */
  private $result;
  /**
   * @var string �������� ���� ������
   */
  public $base;
  /**
   * @var string ������ �����
   */
  public $host;
  /**
   * @var string ����� ������������
   */
  public $user;
  /**
   * @var string ������ ������������
   */
  public $pass;
  /**
   * @var string ��������� �����������
   */
  public $character    = 'cp1251';

  public $useConstants = 1;
  public $useINI       = 0;

  function __construct($base = 'test', $host = 'localhost', $user = 'root', $pass = '')
  {
    $this->base = $base;
    $this->host = $host;
    $this->user = $user;
    $this->pass = $pass;
  }

  /**
   * ������� ����� ��������� ����������� ����� ������ �\��� ini
   *
   * @since 21.02.2007
   */
  function setSettings(){
    if($this->useConstants == 1)
    {
      if(defined('DB_BASE')) $this->base = DB_BASE;
      if(defined('DB_HOST')) $this->host = DB_HOST;
      if(defined('DB_USER')) $this->user = DB_USER;
      if(defined('DB_PASS')) $this->pass = DB_PASS;
    }
    if(is_string($this->useINI) and file_exists($this->useINI))
    {
      $inifile = parse_ini_file($this->useINI, true);
      if(isset($inifile['MySQL']['DB_BASE'])) $this->base = $inifile['MySQL']['DB_BASE'];
      if(isset($inifile['MySQL']['DB_HOST'])) $this->host = $inifile['MySQL']['DB_HOST'];
      if(isset($inifile['MySQL']['DB_USER'])) $this->user = $inifile['MySQL']['DB_USER'];
      if(isset($inifile['MySQL']['DB_PASS'])) $this->pass = $inifile['MySQL']['DB_PASS'];
    }
  }

  /**
   * ��������� ���������� � ���� �� �� ������, �� ���������������� � ������ �����������
   *
   * @return resource
   */
  function connect(){
    $this->setSettings();
    if(!is_resource($this->src) or !mysql_ping($this->src))
    {
      $this->src = $this->newConnect($this->base,$this->host, $this->user, $this->pass, $this->character);
      if(!is_resource($this->src) or !mysql_ping($this->src))
      {
        echo "Can't connect to base '".$this->base."'!\n";
        echo mysql_error($this->src);
        exit;
      }
    }
    return $this->src;
  }

  /**
   * ����� ��������� �����������
   *
   * @param string $codepage
   * @param resource $src
   * @since 28.01.2007
   */
  function setCodepage($codepage = '', $src = ''){
    if($codepage == '') $codepage = $this->character;
    if(!is_resource($src)) $src = $this->connect();
    mysql_query( "SET NAMES '$codepage'",                    $src );
    mysql_query( "SET CHARACTER SET $codepage",              $src );
    mysql_query( "SET character_set_client     = $codepage", $src );
    mysql_query( "SET character_set_results    = $codepage", $src );
    mysql_query( "SET character_set_connection = $codepage", $src );
  }

  /**
   * ����� ����� ����������� � ���������� ����������
   *
   * @param string $base
   * @param string $host
   * @param string $user
   * @param string $pass
   * @param string $codepage
   * @since 28.01.2007
   * @return resource $src
   */
  function newConnect($base, $host = 'localhost', $user = 'root', $pass = '', $codepage = 'cp1251'){
    $src = mysql_connect($host, $user, $pass);
    // �������� ����
    mysql_select_db($base, $src );
    $this->setCodepage($codepage, $src);
    return $src;
  }

  // ������� ��������� �������� �����������
  function __destruct(){
    if(is_resource($this->src)) mysql_close($this->src);
  }

  /**
   * ������� ��������� ������.
   * ���� ������� ������ �������� SQL, �� ��������� ���, ���� ���, �� �������� ���������� ���������� ���������
   * ���� ������� ������ ��������, �� ������ ������ ����������� �� ����, ���� �� �������, �� ���� ���������.
   *
   * @param string SQL ������
   * @param resource ���������� �����������
   * @return resource $this->result ���������� ����������
   */
  function qr($sql = 0, $src = 0, $stop = true){
    if($src == 0) $src = $this->connect();
    if(!is_resource($src)) die("$src isn't mysql_source!");
    $res = mysql_query($sql, $src) or $this->myError($src, $sql, $stop);
    return $res;
  }

  /**
   * ������� ������� ������� ��� �������� ������ � � ������������� ��� �� �������� �! :-)
   *
   * @param unknown_type $src
   * @param unknown_type $stop
   */
  function myError($src, $sql, $stop){
    if($stop == true and is_resource($src))
    {
      $text = "</hr>
      OOOOPS! MySQL ERROR ���!</br>
      <pre>$sql</pre></br>
      mysql_errno: <b>".mysql_errno( $src )."</b></br>
      <pre>mysql_error: ".mysql_error( $src )."</pre></hr>
      ";
      die( $text );
    }

  }

  /**
   * ����� ���������� �� �������.
   *
   * @param string SQL ������
   * @return array
   */
  function getData($sql = 0, $src = false){
    if(!is_resource($src)) $src = $this->src;
    if(is_string($sql))
    {
      $res = $this->qr($sql, $src);
    }
    else
    {
      return false;
    }
    $data = array();
    while($row = mysql_fetch_assoc($res))
    {
      $data[] = $row;
    }
    mysql_free_result($res);
    return $data;
  }

  /**
   * ����� ���� ������ �� �������.
   *
   * @param string SQL ������
   * @return array
   */
  function getRow($sql = 0,$src = false){
    if(!is_resource($src)) $src = $this->src;
    if(is_string($sql))
    {
      $res = $this->qr($sql, $src);
    }
    else
    {
      return false;
    }
    $row = mysql_fetch_assoc($res);
    mysql_free_result($res);
    return $row;
  }
}

/*=============================================================================
����� � ���������� ���������
======
�����: �������� ����������
�������� � 2006 ����
��������� ����������: 21.11.06
email: asid@mail.ru
======
�������� ��������� �������:
* connect        - ���������� � ���� ��������� ����� MySQL
* url2array      - ���������� explode ������ ����
* replacer       - �������� ������ ���� � ������� (mp3)
* get_content    - file_get_contents ������ � ������������� ������
* rus2translit   - ������������� �� �������� � ��������� �����
* strtr          - ��������� �������
* tagger         - ���������� ����� ������ �� ����������� ��������
* RecursiveMkdir - ����������� �������� ����� ����������
* RecursiveRmdir - ����������� �������� ����� ���������� � ����� ��� ������
* RecursiveMovedir - ����������� ����������� (�����������) ����� ���������� � ����� ��� ������
* razbor         - ������ ���������� �������� � �������� ���� �������� � ������
* trim_unused    - �������� ��������� �� �������� ������� (mp3)
* prr            - �������� ����� ������ � ������ ��� � ������� ��� � ������
=============================================================================*/
class utils{

  // ����������� ������. ���� ������ 1, �� ���������� � ����
  function __construct($connect = ''){
  	ini_set('max_execution_time', 600000);
    ini_set('max_input_time',     600000);
    ini_set('memory_limit',       '512M');  //Maximum amount of memory a script may consume
    if($connect == 'connect'){
      $this->mysql = new DB_MySQL;
      $this->mysql->connect();
    }
  }

  function connect(){
    return $this->mysql->connect();
  }

  function url2array(){
    if( $_SERVER['REQUEST_URI'] <> '' ){
      $ic_razdel = array();
      if( strpos( $_SERVER['REQUEST_URI'], '?' ) )
      {
        $Query = explode( "/", substr( $_SERVER['REQUEST_URI'], 0, strpos( $_SERVER['REQUEST_URI'], '?' ) ) );
      }
      else
      {
        $Query = explode( "/", substr( $_SERVER['REQUEST_URI'], 0, strlen( $_SERVER['REQUEST_URI'] ) ) );
      }
      foreach( $Query as $key => $val){
        if( isset($Query[$key]) and $Query[$key] <> "" and $Query[$key] <> "undefined" )
        {
          $ic_razdel[$key] = $Query[$key];
        }
      }
      if(!isset($ic_razdel[1])){
        $ic_razdel[1] = 'index';
      }
      return $ic_razdel;
    }else{
      return false;
    }
  }


  // �������� ������ ���� � ������� � ������� ����� �������
  // ��� ���� ������� ��������� �� _
  function replacer($word){
    $preg_ar = array(
      '|(\svs\.\s)|i' => ' & ',
      '|(\swith\s)|i' => ' & ',
      '|(\+)|i'       => ' & ',
      '|(\sa\s)|i'    => ' & ',
      '|(\s/\s)|i'    => ' & ',
      '|(\sand\s)|i'  => ' & ',
      '|(\sund\s)|i'  => ' & ',
      '/^the |^the_|^the-|_the$|-the$| the$/i'=> '',
      '|(\svs\s)|i'   => ' & '
    );
    return trim(preg_replace(array_keys($preg_ar), array_values($preg_ar), $word));
  }


  // file_get_contents ������ � ������������� ������
  // var1 = (str) ���
  // var2 = (str) ����� ������ ������� � ������. �������� 192.168.10.1:80
  function get_content($url,$proxy = 0){
    if($proxy <> 0){
      $aContext = array(
       'http' => array(
                      'proxy' => "tcp://$proxy",
                      'request_fulluri' => True
                     )
       );
      $cxContext = stream_context_create($aContext);
      return file_get_contents($url,true,$cxContext);
    }else{
      return file_get_contents($url);
    }

  }


  // �������������� ����� �� ������� ��������� � ���������
  function rus2translit($word){
    $translit = array(
      '�'=>'A', '�'=>'B', '�'=>'V', '�'=>'G', '�'=>'D', '�'=>'E', '�'=>'E',
      '�'=>'J', '�'=>'Z', '�'=>'I', '�'=>'IY', '�'=>'K', '�'=>'L', '�'=>'M',
      '�'=>'N', '�'=>'O', '�'=>'P', '�'=>'R', '�'=>'S', '�'=>'T', '�'=>'U',
      '�'=>'F', '�'=>'H', '�'=>'Ts', '�'=>'Ch', '�'=>'Sh', '�'=>'Sch', '�'=>'',
      '�'=>'Y', '�'=>'', '�'=>'e', '�'=>'Ju', '�'=>'Ya', '�'=>'a', '�'=>'b',
      '�'=>'v', '�'=>'g', '�'=>'d', '�'=>'e', '�'=>'e', '�'=>'j', '�'=>'z',
      '��'=>'iy', '��'=>'iy', '�'=>'i', '�'=>'i', '�'=>'k', '�'=>'l', '�'=>'m',
      '�'=>'n', '�'=>'o', '�'=>'p', '�'=>'r', '�'=>'s', '�'=>'t', '�'=>'u',
      '�'=>'f', '�'=>'h', '�'=>'ts', '�'=>'ch', '�'=>'sh', '�'=>'sch', '�'=>'',
      '�'=>'y', '�'=>'', '�'=>'e','�'=>'ju', '�'=>'ya'
    );
    return strtr($word, $translit);
  }



  // ��������� ���� ������������ �� ����������� ������� � ��������� ���� � ����.
  // ������� ���������� �� _
  function tagger($word, $replace_by = '_'){
    $word = trim($word,'. ');
    $word = strtr($word, ' ',"$replace_by" );
    $word = preg_replace("|[^a-z�-�0-9$replace_by]|i", "$replace_by", $word);
    if($replace_by <> '') $word = preg_replace("/[$replace_by]{2,}/", "$replace_by", $word);
    $word = trim($word,"$replace_by");
    return strtolower($word);
  }


  // ����������� �������� ����������
  function RecursiveMkdir( $path ){
    if( !file_exists( $path ) ){
      $this->RecursiveMkdir( dirname( $path ) );
      mkdir( $path );
    }
  }

  /**
   * ����������� �������� ����������
   *
   * @param string $path         ���� � ����������
   * @param int $delete_sub_dirs ������� �������������
   * @param int $delete_files    ������� ����� ������
   */
  function RecursiveRmdir( $path, $delete_sub_dirs = 1, $delete_files = 1 ){
    $path = rtrim($path,'\\/');
    if( file_exists( $path ) ){
      if($delete_files == 1 or $delete_sub_dirs == 1){
        $scan_files = scandir($path);
        foreach($scan_files as $scan_file){
      	if($scan_file == '.' or $scan_file == '..') continue;
     		if(is_dir($path.'/'.$scan_file) and $delete_sub_dirs == 1) $this->RecursiveRmdir( $path.'/'.$scan_file, $delete_sub_dirs, $delete_files  );
     		if(is_file($path.'/'.$scan_file) and $delete_files) unlink($path.'/'.$scan_file);
     	  }
        if($delete_sub_dirs == 1) rmdir($path);
      }else{
        rmdir($path);
      }
    }
  }
  /**
   * ����������� ����������� ���������� � �� �����������
   *
   * @param string $path_from   - ���� � ���������� (������)
   * @param string $path_to     - ���� � ���������� (����)
   * @param bool   $copy        - (true) ����������, (false) ���������� (������ true)
   * @param bool   $first_dir   - true ���������� ���� �����, false ���������� ����������
   * @return unknown
   */
  function RecursiveMovedir($path_from, $path_to, $copy = true, $first_dir = true){

    if(!is_dir($path_from)) return false;
    $path_from = trim(strtr($path_from,'\\','/'),'/');
    $path_to   = trim(strtr($path_to,'\\','/'),'/');
    $files     = scandir($path_from);
    if($first_dir === true) $path_to .= '/'.basename($path_from);

    $this->RecursiveMkdir($path_to);

    foreach($files as $file)
    {
      if($file == '..' or $file == '.') continue;
      if(is_dir($path_from.'/'.$file)){
        $this->RecursiveMovedir($path_from.'/'.$file, $path_to.'/'.$file, $copy, false);
      }else{
        if($copy == true){
          copy($path_from.'/'.$file, $path_to.'/'.$file);
        }else{
          rename($path_from.'/'.$file, $path_to.'/'.$file);
        }
      }
    }
    if($copy <> true) rmdir($path_from);
    return true;
  }

  // ������ �������� � �������� ���� �������� � ������
  function  razbor($str)
  {
    return ereg_replace("[[:space:]]+"," ", implode(" ", explode("\n",$str)));
  }


  /*
  * �������� �������� � ��������� �����
  * var1 = (str) �����
  */
  function trim_unused($word){
    $word = preg_replace('|\[.*\]|','',$word);
    $word = preg_replace('|\(.*\)|','',$word);
    $word = preg_replace('|\|.*\||','',$word);
    $word = preg_replace('|\{.*\}|','',$word);
    $word = preg_replace('|\scd[\.\s][1-3]|i','',$word);
    $word = preg_replace('|\scd[1-3]|i','',$word);
    $word = preg_replace('|\svol[0-9]{1,}|i','',$word);
    $word = preg_replace('|\svol[\.\s][0-9]{1,}|i','',$word);
    $word = preg_replace("|[^\w-\s&]|i", '', $word);
    $word = trim($word, '<>.,?!:\(\)\[\]\{\}\'\"=-_ ');
    return $word;
  }



  /*
  * �������� ����� ������ � ������ ��� � ������� ��� � �������
  * var1 = (mix) ��� ��������
  * var2 = (int) ������� ����� ��� ���!
  */
  function prr($array, $die = true)
  {
     print "\n<xmp>\n";
     print_r($array);
     print "</xmp>\n";
     if ($die  == true ) die();
  }


}



/*=============================================================================
����� ��������� CSV ������
======
�����: �������� ����������
�������� � 2006 ����
��������� ����������: 23.11.06
email: asid@mail.ru
======
�������� ��������� �������:
* readCSV   - ������ CSV � ������ � ������ csv_contents
* writeCSV  - ������ CSV � ����
* CSV2SQL   - ������ CSV � ����
=============================================================================*/

class CSV
{
  public $delim_cols     = ';';      // ���������� �������
  public $delim_lines    = "\n";     // ���������� �����
  public $ekran          = '';       // ������������� �������
  public $continue_lines = 0;        // ���������� �����, ������� ����� ���������� � ������ CSV
  private $csv_contents  = array();  // ������ ������� ����� �������� ������� ����� ������� readCSV
  public $cols           = array();
/////////////////////////////////////////////////////////////
  function read($read_file = 0, $cols = array())
  {
    if(count($cols) > 0) $this->cols = $cols;
    if($read_file === 0)
    {
      return false;
    }else{
      $read_file_array = explode($this->delim_lines, file_get_contents($read_file));
    }
    $i = 0;
    $new_array   = array();
    $continue_lines = $this->continue_lines;
    $count_cols = count($this->cols);

    if(count($read_file_array) == 0) return false;

    foreach($read_file_array as $read_line)
    {
      if($continue_lines > 0)
      {
        --$continue_lines;
        continue;
      }
      if(trim($read_line) == '') continue;
      $read_row = explode($this->delim_cols, $read_line);
      foreach($read_row as $col => $val){
        $read_row[$col] =  trim($val, " {$this->ekran}\t\r\n");
      }
      if(count($read_row) > 0){
        if($count_cols > 0){
          foreach($this->cols as $name => $col){
            if(!isset($read_row[$col])) $read_row[$col] = '';
            $new_array[$name][$i] = $read_row[$col];
            $new_array[$col][$i]  = $read_row[$col];
          }
        }else{
          foreach($read_row as $col => $val){
            $new_array[$col][$i] =  $val;
          }
        }
      }
      ++$i;
    }
    $this->csv_contents = $new_array;
    return $new_array;
  }
/////////////////////////////////////////////////////////////
  function set_cols(){
    if(count($this->cols) > 0){
      foreach($this->cols as $col){
        $this->cols[$col] = $col;
      }
    }
  }

function Contents(){
  return $this->csv_contents;
}
/////////////////////////////////////////////////////////////
function write($write_filename = 0, $write_array = array()){
    if($write_filename === 0) return false;
    $save_ar = array();
    foreach($write_array as $cols){
      if(is_array($cols))
      {
        $line_ar = array();
        if(count($this->cols) > 0){
          foreach($cols as $col_name => $col_val){
            if(isset($this->cols[$col_name])){
              $line_ar[] = $col_val;
            }
          }
        }else{
          $line_ar = $cols;
        }
        $save_ar[] = $this->ekran.implode($this->ekran.$this->delim_cols.$this->ekran,$line_ar).$this->ekran;
      }else{
        $save_ar[] = $cols;
      }
    }
    file_put_contents($write_filename, implode($this->delim_lines,$save_ar));
    return true;
  }

/////////////////////////////////////////////////////////////
// �������� ������ ����
  function CSV2SQL($query = 0, $write_array = array(), $resource = 0){
    if(!is_resource($resource)){
      $mysql = new DB_MySQL;
      $resource = $mysql->connect();
    }
    if($query === 0 or count($write_array) == 0) return false;
    $this->set_which_lines();
    foreach($write_array as $line){
      $query_new = $query;
      foreach($this->cols as $name => $col){
        $query_new = str_ireplace("::$name::", mysql_escape_string($line[$name]),$query_new);
      }
      $queries[] = $query_new;
    }
    $queries = array_unique($queries);
    foreach($queries as $qr){
      print $qr."<br>";
      $mysql->qr($qr,$resource);
    }
    return true;
  }

}
?>