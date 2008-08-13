<?php
/**
@author  Molodtsvo Alex <molodtsov.sashs@gmail.com>
@package myClasses

*/

/*=============================================================================
Класс обслуживания MySQL базы
======

tegory
написана в 2006 году
последнее обновление: 21.02.2007
email: asid@mail.ru
======
Содержит следующие утилиты:
* connect       - проверяет ресурслинк и возвращает его в случает успеха
* setCodepage   - устанавливает кодировку подключения
* newConnect    - устанавливает новое подключение и возвращает ресурслинк
* qr            - выполняет запросы
* getData       - Выдаёт массив данных из запроса
* getRow        - Выдаёт одну строку из запроса.
======
Могут быть предварительно заданы в вызове класса параметры подключения
через параметры конструктора или через назначение обьектов или
через дефайн переменные ( DB_BASE, DB_HOST, DB_USER, DB_PASS )
=============================================================================*/

/**
 * @category database
 *
 */

class DB_Mysql{
  /**
   * @var resource последний заданный ресурслин
   */
  private $src;
  /**
   * @var resource ресурслинк последнего запроса
   */
  private $result;
  /**
   * @var string название базы данных
   */
  public $base;
  /**
   * @var string адресс хоста
   */
  public $host;
  /**
   * @var string логин пользователя
   */
  public $user;
  /**
   * @var string пароль пользователя
   */
  public $pass;
  /**
   * @var string кодировка подключения
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
   * Функция задаёт параметры подключения через дефайн и\или ini
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
   * проверяем ресурслинк и если он не ресурс, то переподключаемся с дефолт параметрами
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
   * задаём кодировку подключения
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
   * созаём новое подключение и возвращаем ресурслинк
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
    // выбираем базу
    mysql_select_db($base, $src );
    $this->setCodepage($codepage, $src);
    return $src;
  }

  // убиваем последнее заданное подключение
  function __destruct(){
    if(is_resource($this->src)) mysql_close($this->src);
  }

  /**
   * функция выполняет запрос.
   * Если передан первый параметр SQL, то выполняем его, если нет, то вытаемся возвратить предыдущий результат
   * Если передан второй параметр, то меняет ресурс подключения на него, если не передан, то берёт дефолтный.
   *
   * @param string SQL запрос
   * @param resource ресурслинк подключения
   * @return resource $this->result ресурслинк результата
   */
  function qr($sql = 0, $src = 0, $stop = true){
    if($src == 0) $src = $this->connect();
    if(!is_resource($src)) die("$src isn't mysql_source!");
    $res = mysql_query($sql, $src) or $this->myError($src, $sql, $stop);
    return $res;
  }

  /**
   * Простая функция которая или печатает ошибку и её возникновении или не печатает её! :-)
   *
   * @param unknown_type $src
   * @param unknown_type $stop
   */
  function myError($src, $sql, $stop){
    if($stop == true and is_resource($src))
    {
      $text = "</hr>
      OOOOPS! MySQL ERROR нах!</br>
      <pre>$sql</pre></br>
      mysql_errno: <b>".mysql_errno( $src )."</b></br>
      <pre>mysql_error: ".mysql_error( $src )."</pre></hr>
      ";
      die( $text );
    }

  }

  /**
   * Выдаёт информацию из запроса.
   *
   * @param string SQL запрос
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
   * Выдаёт одну строку из запроса.
   *
   * @param string SQL запрос
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
Класс с различными утилитами
======
автор: Молодцов Александдр
написана в 2006 году
последнее обновление: 21.11.06
email: asid@mail.ru
======
Содержит следующие утилиты:
* connect        - конектится к базе использую класс MySQL
* url2array      - возвращает explode массив УРЛа
* replacer       - удаление частей слов и альбома (mp3)
* get_content    - file_get_contents только с ипользованием прокси
* rus2translit   - траслитирация из русского в англицкий текст
* strtr          - рапечатка массива
* tagger         - усреднение любой строки до однотипного значения
* RecursiveMkdir - рекурсивное создание любой директории
* RecursiveRmdir - рекурсивное удаление любой директории и всего что внутри
* RecursiveMovedir - рекурсивное перемещение (копирование) любой директории и всего что внутри
* razbor         - разбор полученной страницы и сливание всей страницы в строку
* trim_unused    - удаление ненужного из названия альбома (mp3)
* prr            - Печатает любой массив в скобки или в браузер или в консол
=============================================================================*/
class utils{

  // конструктор класса. Если принял 1, то конектится к базе
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


  // удаление частей слов и альбома и вырезка всего ненужно
  // все спец символы заменются на _
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


  // file_get_contents только с ипользованием прокси
  // var1 = (str) урл
  // var2 = (str) номер прокси сервера с портом. Например 192.168.10.1:80
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


  // транслитирация слово из русской кодировки в англицкую
  function rus2translit($word){
    $translit = array(
      'А'=>'A', 'Б'=>'B', 'В'=>'V', 'Г'=>'G', 'Д'=>'D', 'Е'=>'E', 'Ё'=>'E',
      'Ж'=>'J', 'З'=>'Z', 'И'=>'I', 'Й'=>'IY', 'К'=>'K', 'Л'=>'L', 'М'=>'M',
      'Н'=>'N', 'О'=>'O', 'П'=>'P', 'Р'=>'R', 'С'=>'S', 'Т'=>'T', 'У'=>'U',
      'Ф'=>'F', 'Х'=>'H', 'Ц'=>'Ts', 'Ч'=>'Ch', 'Ш'=>'Sh', 'Щ'=>'Sch', 'Ъ'=>'',
      'Ы'=>'Y', 'Ь'=>'', 'Э'=>'e', 'Ю'=>'Ju', 'Я'=>'Ya', 'а'=>'a', 'б'=>'b',
      'в'=>'v', 'г'=>'g', 'д'=>'d', 'е'=>'e', 'ё'=>'e', 'ж'=>'j', 'з'=>'z',
      'ий'=>'iy', 'ый'=>'iy', 'и'=>'i', 'й'=>'i', 'к'=>'k', 'л'=>'l', 'м'=>'m',
      'н'=>'n', 'о'=>'o', 'п'=>'p', 'р'=>'r', 'с'=>'s', 'т'=>'t', 'у'=>'u',
      'ф'=>'f', 'х'=>'h', 'ц'=>'ts', 'ч'=>'ch', 'ш'=>'sh', 'щ'=>'sch', 'ъ'=>'',
      'ы'=>'y', 'ь'=>'', 'э'=>'e','ю'=>'ju', 'я'=>'ya'
    );
    return strtr($word, $translit);
  }



  // вырезание всех спецсимволов за исключением русских и англицких букв и цифр.
  // Пробелы заменяются на _
  function tagger($word, $replace_by = '_'){
    $word = trim($word,'. ');
    $word = strtr($word, ' ',"$replace_by" );
    $word = preg_replace("|[^a-zа-я0-9$replace_by]|i", "$replace_by", $word);
    if($replace_by <> '') $word = preg_replace("/[$replace_by]{2,}/", "$replace_by", $word);
    $word = trim($word,"$replace_by");
    return strtolower($word);
  }


  // рекурсивное создание директорий
  function RecursiveMkdir( $path ){
    if( !file_exists( $path ) ){
      $this->RecursiveMkdir( dirname( $path ) );
      mkdir( $path );
    }
  }

  /**
   * рекурсивное убивание директорий
   *
   * @param string $path         путь к директории
   * @param int $delete_sub_dirs убивать потдиректории
   * @param int $delete_files    убивать файлы внутри
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
   * рекурсивное перемещение директорий и их содержимого
   *
   * @param string $path_from   - путь к директории (откуда)
   * @param string $path_to     - путь к директории (куда)
   * @param bool   $copy        - (true) копировать, (false) перемещать (дефолт true)
   * @param bool   $first_dir   - true копировать саму папку, false перемещать содержимое
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

  // разбор страницы и сливание всей страницы в строку
  function  razbor($str)
  {
    return ereg_replace("[[:space:]]+"," ", implode(" ", explode("\n",$str)));
  }


  /*
  * обрезаем ненужное в названиях альба
  * var1 = (str) слово
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
  * Печатает любой массив в скобки или в браузер или в консоль
  * var1 = (mix) что печатаем
  * var2 = (int) умирать после или нет!
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
Класс обработки CSV файлов
======
автор: Молодцов Александдр
написана в 2006 году
последнее обновление: 23.11.06
email: asid@mail.ru
======
Содержит следующие утилиты:
* readCSV   - чтение CSV и запись в обьект csv_contents
* writeCSV  - запись CSV в файл
* CSV2SQL   - запись CSV в базу
=============================================================================*/

class CSV
{
  public $delim_cols     = ';';      // разделение колонок
  public $delim_lines    = "\n";     // разделение строк
  public $ekran          = '';       // экранирование колонок
  public $continue_lines = 0;        // количество строк, которые нужно пропустить в начале CSV
  private $csv_contents  = array();  // массив который будет заполнен данными после запуска readCSV
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
// делается запрос вида
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