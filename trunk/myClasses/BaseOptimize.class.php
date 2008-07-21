<?php
/**
 * Класс для оптимизации музыкальной коллекции
 *
 */

class BaseOptimize{
  /**
   * Путь до инклюдных классов
   * @var string
   */
  private $CLASSESDIR        = 'd:/htdocs/utils/classes/';
  private $MP3ADMINDIR       = 'd:/htdocs/MP3/mp3-server/functions/';
  public  $MP3ADMINDIRImages = 'd:/htdocs/MP3/mp3-server/images/';

  private $OPTIMIZEDIR       = 'OPTIMIZEDIR/';

  protected $DB_USER         = 'root';
  protected $DB_PASS         = 'svasva';
  protected $DB_HOST         = 'localhost';
  protected $DB_BASE         = 'test';

  protected $LOGFILEPATH     = 'logs/';
  protected $LOGFILENAME     = '';
  public $write_trends       = false;
  public $write_logs         = false;
  public static $LOGFILE     = array();



  function __construct(){
    include_once($this->CLASSESDIR.'class.utils.php');

    $this->OPTIMIZEDIR = $this->CLASSESDIR.$this->OPTIMIZEDIR;
    @mkdir($this->OPTIMIZEDIR,0777,true);
    $this->LOGFILENAME = date('Y.m.d-Hi').'.txt';

    $this->mysql = new DB_MySQL($this->DB_BASE,$this->DB_HOST, $this->DB_USER, $this->DB_PASS);
    $this->ut    = new Utils;

    $this->mysql->connect();
  }

  function __destruct(){
    if($this->write_logs == true)
    {
      @mkdir($this->OPTIMIZEDIR.$this->LOGFILEPATH,0777,true);
      file_put_contents($this->OPTIMIZEDIR.$this->LOGFILEPATH.$this->LOGFILENAME, implode("\n",self::$LOGFILE));
    }

  }

  /**
   * Удалятор пустых артистов.
   * Если у артиста нет ниодного валидного альбома, то он удаляется
   */
  public function delEmptyAuthors(){
    $this->myPrint("Удаляем пустых артистов\n--");
    $rows = $this->mysql->getData("
    SELECT a.id
    FROM mp3_authors as a
    left join mp3_catalog as c
    ON a.id = c.authorid
    GROUP by a.id
    HAVING count(c.id) = '0'
    ");

    foreach ($rows as $rowid)
    {
      if(file_exists($this->MP3ADMINDIRImages.substr($rowid['id'],0,2).'/'.$rowid['id'].'/'))
      {
        $this->ut->RecursiveRmdir($this->MP3ADMINDIRImages.substr($rowid['id'],0,2).'/'.$rowid['id'].'/');
      }
      $this->mysql->qr("DELETE FROM mp3_authors WHERE id = '{$rowid['id']}'");
    }
    $this->myPrint(count($rows)." пустых артистов удалено!<br>");
  }

  /**
   * Очистка таблицы "новые релизы"
   *
   * @param int $monthes срок жизни (в месяцах) записей у новых релизах.
   */
  public function clearNewReleases($monthes = 1){
    $this->myPrint("Очистка таблицы \"новые релизы\"");
    $sql = "DELETE FROM mp3_new_releases WHERE released <= '".strtotime('-'.$monthes.' month')."'";
    $this->myPrint($sql);
    $this->mysql->qr($sql);
    $this->myPrint(mysql_affected_rows()." полей удалено из новых релизов!");
  }


  /**
   * Удаление артистов и альбомов по базе РОМС
   *
   */
  public function delRomsAuthors(){
    $this->myPrint("Удаление артистов и альбомов по базе РОМС\n--");
    $ArtistsData = $this->mysql->getData("
      SELECT a.id, a.title FROM mp3_authors as a
      INNER JOIN mp3_catalog as c
      ON a.id = c.authorid
      WHERE c.admin_status in('online','new') or c.admin_status LIKE '%ready%'
      and c.admin_comment not like '%РОМС%'
      GROUP BY a.id
      ORDER BY a.title
    ");
    $ROMSDATA = $this->mysql->getData("SELECT * FROM mp3_roms");
    $ROMSARTS = $romsArr = array();
    foreach ($ROMSDATA as $row)
    {
      $romsArr[$row['name']] = $row['name'];
      if($row['expr'] <> '0' or $row['expr'] <> '')
      {
        $row['expr'] = str_replace('*','.*', str_replace('.','\.', $row['expr']));
        
        $romsArr[$row['expr']] = $row['name'];

      }
    }
    $countArt = count($ArtistsData);
    $b = 500;
    $a = $b;
    foreach ($ArtistsData as $i => $row)
    {
      
      $trimmedName =  $this->ut->replacer(trim($row['title']));
      foreach ($romsArr as $key => $name)
      {
        $key = trim(str_replace('\.\*','.*',preg_quote($key)));
         
        if((trim($key) <> '' and $row['title'] <> '') and (eregi("^$key$", $trimmedName) or $name == $trimmedName))
        {
          $ROMSARTS[] = $row['id'];
          $this->myPrint(count($ROMSARTS).". ($i of $countArt) | $name ( $key ) = {$row['title']} ( $trimmedName )");
          break;
        }
        
      }
      if($i > $a)
      {
        $this->myPrint("$a из $countArt артистов просканировано");
        $a+=$b;
      }
    }
    $ROMSARTS = array_unique($ROMSARTS);
    if(sizeof($ROMSARTS) > 0 )
    {
      $sql = "
      UPDATE mp3_catalog
      SET admin_comment = 'ИСКЛЮЧЕНИЕ РОМС',
          admin_status = 'delete'
      WHERE authorid in (".implode(',',$ROMSARTS).")";

      $this->mysql->qr("$sql");
      $this->myPrint(count($ROMSARTS)." артистов было помеченок как ИСКЛЮЧЕНИЕ РОМС!");
      $this->myPrint(mysql_affected_rows()." альбомов было помеченок как ИСКЛЮЧЕНИЕ РОМС!");
    }

  }

  /**
   * удаление альбомов которые помечены флагом full_delete и статусом deleted
   *
   */
  public function delFull_delete(){
    $this->myPrint("Удаление альбомов которые помечены флагом full_delete и статусом deleted\n--");
    include_once($this->CLASSESDIR.'class.DiscsLetters.php');
    $data = $this->mysql->getData("
                    SELECT f.id, f.catid, f.filename, c.authorid
                    FROM mp3_files as f
                    INNER JOIN mp3_catalog as c
                    ON c.id = f.catid
                    WHERE flags like ('%full_delete%') and filename <> '0' and admin_status in ('deleted')
                  ");
    $catids = array();
    $files = $dirs = $totalSize = 0;

    foreach($data as $row){

      @unlink($this->MP3ADMINDIRImages.substr($row['authorid'],0,2).'/'.$row['authorid'].'/alb_'.$row['catid'].'_original.jpg');
      @unlink($this->MP3ADMINDIRImages.substr($row['authorid'],0,2).'/'.$row['authorid'].'/alb_'.$row['catid'].'_big.jpg');
      @unlink($this->MP3ADMINDIRImages.substr($row['authorid'],0,2).'/'.$row['authorid'].'/alb_'.$row['catid'].'_sm.jpg');
      @unlink($this->MP3ADMINDIRImages.substr($row['authorid'],0,2).'/'.$row['authorid'].'/alb_'.$row['catid'].'_th.jpg');

      $path = DiscsLetters::toLetter($row['filename']).'/';
      $catids[$row['catid']] = dirname($path);
      if(file_exists($path))
      {
        $totalSize += filesize($path);
        @unlink($path);
        ++$files;
        $this->myPrint($row['id'].": ".$path);

        if(count(scandir(dirname($path))) == 2)
        {
          rmdir(dirname($path));
          ++$dirs;
        }
      }
    }
    if(count($catids) > 0)
    {
      mysql_query("UPDATE mp3_files SET `filename` = '0' WHERE catid IN (".implode(',',array_keys($catids)).")");
      $this->myPrint("UPDATE mp3_files SET `filename` = '0' WHERE catid IN (".implode(',',array_keys($catids)).")");
      mysql_query("UPDATE mp3_catalog SET admin_status = 'deleted' `status` = 'trash', `update_time` = UNIX_TIMESTAMP() WHERE id IN (".implode(',',array_keys($catids)).")");
      $this->myPrint(sizeof($catids)." альбомов было удалено!");
      $this->myPrint("$files файлов было удалено!");
      $this->myPrint("$dirs папок было удалено!");
      $this->myPrint(round($totalSize/1024/1024,2)." мб было усвобождено!");
    }

  }


  /**
   * Оптимизация и починка базы средствами MYSQL
   *
   */
  public function optimize_base(){
    $this->myPrint("Оптимизация и починка базы средствами MYSQL...");
    exec("D:/servers/mysql/bin/mysqlcheck -uroot -psvasva -hlocalhost --repair --analyze --optimize  --databases test --auto-repair", $output);
    $this->myPrint($output);
    $this->myPrint("done!");
  }

  public static function obrez($name){
    $dig = 5;
    $simv[','] = ',';
    $simv['-'] = '-';
    $simv['('] = '\(';

    if(strlen($name) > $dig)
    {
      $first  = substr($name,0,$dig);
      $second = substr($name,$dig,strlen($name));
      foreach ($simv as $simbol => $ereg){
        if(eregi($ereg, $second)) $second = substr($second, 0, strpos($second, $simbol));
      }
      $second = preg_replace('|\s{2,}|i',' ',$second);
      return preg_replace('/^(the )|( the)$/i','', $first.$second);
    }else{
      return preg_replace('/^(the )|( the)$/i','', $name);
    }
  }


  public function curlGetFile($method_params){
    require($this->MP3ADMINDIR."function.curlGetFile.php");
    return $output;
  }
  /**
   * Стянуть с гугла рейтинги исполнителей
   *
   * @param bool $all если true, то тянем инфу ко всем артистам, а не только к тем у кого нет рейтинга
   * @param int $limit лимит на кол-во запросов. Если 0, то нет лимита
   * @param int $sleeptime - время в секундах между запросами
   */
  public function getEpRating($all = false, $limit = 0, $sleeptime = 1){
    $this->myPrint("Стянуть с гугла рейтинги исполнителей\n--");
    $name  = '"Elvis Presley"';
    $ERROR[] = '- could not be interpreted.';
    //$ERROR[] = 'No news articles were found.';
    $URL   = 'http://www.google.com/trends?date=2007&geo=US&ctab=1&sa=N&q='.urlencode($name);

    if($limit == '0'){
      $limit = '';
    }else{
      $limit = "LIMIT $limit";
    }
    if($all){
      $where = '';
    }else{
      $where = "WHERE ep_rating = '0'";
    }
    $data = $this->mysql->getData("SELECT id, title,ep_rating FROM mp3_authors $where ORDER BY id $limit");
     if($this->write_trends == true)
    {
      @mkdir($this->OPTIMIZEDIR.'googleTrends/',0777,true);
    }
    $stop = 0;
    foreach ($data as $row){
      $row['title'] = $this->obrez($row['title']);
      $link = $URL.urlencode(',"'.trim($row['title']).'"');
      //print $link; die;
      $info = file_get_contents($link);
      if($this->write_trends == true)
      {
        file_put_contents($this->OPTIMIZEDIR.'googleTrends/'.$row['id'].'.html',$info);
      }
      foreach($ERROR as $err){
        if(eregi($err, $info))
        {
          @rename(dirname(__FILE__).'/temp/'.$row['id'].'.html', dirname(__FILE__).'/temp/error.'.$row['id'].'.html');
          $this->myPrint("ERROR! => {$row['id']} -> {$row['title']}");
          $this->mysql->qr("UPDATE mp3_authors SET ep_rating = '-1000' WHERE id = '{$row['id']}'");
          $stop = 1;
          break;
        }
      }
      if($stop == 1)
      {
        $stop = 0;
        continue;
      }

      preg_match_all('|<table class=.*?bar.*?.*?width=.*?([0-9]{1,}).*?>|', $info, $matches);
       
      if(count($matches[1]) > 1)
      {
        $Firts = $matches[1][count($matches[1])-2];
        $Last  = $matches[1][count($matches[1])-1];
      }
      //print "$Firts and $Last";
      //die;
      if(is_numeric($Firts) and is_numeric($Last))
      {
        $ep_proc = $Firts/100;
        $ep_new  = round($Last/$ep_proc,3);
        //print " = $ep_proc and $ep_new";
        
        $this->myPrint($row['title']." = $ep_new\n");
        $this->mysql->qr("UPDATE mp3_authors SET ep_rating = '$ep_new' WHERE id = '{$row['id']}'");
        //die;
      }else{
        $this->myPrint("NO MATCHES! \n\n --- \n$link\n ---\n{$row['id']} -> {$row['title']}\n-----");
      }
      sleep($sleeptime);
    }
  }

  public static function myPrint($string = '', $delemiter_start = "\n", $delemiter_end = "\n"){

    echo $delemiter_start;
    if(is_array($string) or is_object($string))
    {
      ob_start();
      print_r($string);
      $string = ob_get_flush();
    }else{
      echo convert_cyr_string($string, 'w','d');
    }
    echo $delemiter_end;
    self::$LOGFILE[] = $string;
  }

  /**
   * Замена всякого хлама в базе артистов, альбомов и файлов
   *
   */
  public function replacingWords(){
    $this->myPrint("Замена всякого хлама в базе артистов, альбомов и файлов\n--");
    $dataAuthors = $this->mysql->getData("SELECT id, title FROM mp3_authors WHERE title like '%+%' or title like '%&%' or title REGEXP 'disc (one|two|three|four|five|six|seven|eight|nine|ten)' or title REGEXP 'disc ([ \.0-9])'");
    $dataAlbums  = $this->mysql->getData("SELECT id, title FROM mp3_catalog  WHERE title like '%+%' or title like '%&%' or title REGEXP 'disc (one|two|three|four|five|six|seven|eight|nine|ten)' or title REGEXP 'disc ([ \.0-9])'");
    $dataFiles   = $this->mysql->getData("SELECT id, title FROM mp3_files   WHERE title like '%+%' or title like '%&%' or title REGEXP 'disc (one|two|three|four|five|six|seven|eight|nine|ten)' or title REGEXP 'disc ([ \.0-9])'");

    $discs['++']         = ' and ';
    $discs['+']          = ' and ';
    $discs['&&']         = ' and ';
    $discs['&']          = ' and ';

    $discs['disc one']   = 'CD1 ';
    $discs['disc two']   = 'CD2 ';
    $discs['disc three'] = 'CD3 ';
    $discs['disc four']  = 'CD4 ';
    $discs['disc five']  = 'CD5 ';
    $discs['disc six']   = 'CD6 ';
    $discs['disc seven'] = 'CD7 ';
    $discs['disc eight'] = 'CD8 ';
    $discs['disc nine']  = 'CD9 ';
    $discs['disc ten']   = 'CD10 ';
    $discs['disc ']      = 'CD';

    foreach ($dataAuthors as $row){
      $str = 'WAS "'.$row['title'].'"';
      $row['title'] = trim(preg_replace('|\s{2,}|i',' ',str_ireplace(array_keys($discs),array_values($discs),$row['title'])));
      $str .= ' -> NOW "'.$row['title'].'"';
      $this->myPrint($str);
      $this->mysql->qr("UPDATE mp3_authors SET title = '".mysql_real_escape_string($row['title'])."' name_tag = '".$this->ut->tagger($row['title'])."'  WHERE id = '{$row['id']}'");
    }
    foreach ($dataAlbums as $row){
      $row['title'] = trim(preg_replace('|\s{2,}|i',' ',str_ireplace(array_keys($discs),array_values($discs),$row['title'])));
      $this->mysql->qr("UPDATE mp3_catalog SET title = '".mysql_real_escape_string($row['title'])."' name_tag = '".$this->ut->tagger($row['title'])."'  WHERE id = '{$row['id']}'");
    }
    foreach ($dataFiles as $row){
      $row['title'] = trim(preg_replace('|\s{2,}|i',' ',str_ireplace(array_keys($discs),array_values($discs),$row['title'])));
      $this->mysql->qr("UPDATE mp3_files SET title = '".mysql_real_escape_string($row['title'])."' name_tag = '".$this->ut->tagger($row['title'])."'  WHERE id = '{$row['id']}'");
    }
    $this->myPrint(count($dataAuthors)." записей подчищено в таблице артистов");
    $this->myPrint(count($dataAlbums)."  записей подчищено в таблице альбомов");
    $this->myPrint(count($dataFiles)."   записей подчищено в таблице файлов");
  }
  /**
   * Удаление пустых директорий с проверкой на возможность удаления
   *
   * @param string $startDir начальная директория
   */
  function delEmptyFolders($startDir){
    $startDir = rtrim(strtr($startDir,'\\','/'),'/');
    $files = scandir($startDir);
    if(count($files) > 2)
    {
      $deleted = 0;
      foreach ($files as $file)
      {
        if ($file != "." && $file != "..")
        {
          if(is_dir("$startDir/$file")){
            if(is_writable("$startDir/$file")){

              $this->delEmptyFolders("$startDir/$file");
            }else{
              $this->myPrint("Dir '$startDir/$file' is writeProtected!");
              return false;
            }
          }
        }
      }
    }else
    {
      if(is_writable("$startDir")){
        $this->myPrint("delete $startDir");
        $deleted = 1;
        rmdir("$startDir");
      }else{
        $this->myPrint("Dir '$startDir' is writeProtected!");
        return false;
      }
    }
    if($deleted == 0 and count(scandir($startDir)) <= 2)
    {
      $this->myPrint("delete $startDir");
      rmdir("$startDir");
    }
  }




}
/*
$optim = new BaseOptimize;
$optim->myPrint('---------------------');
$optim->delEmptyAuthors();
$optim->myPrint('---------------------');
$optim->delFull_delete();
$optim->myPrint('---------------------');
$optim->replacingWords();
$optim->myPrint('---------------------');
$optim->getEpRating(false,10);
//BaseOptimize::myPrint('BUGAGA');
//BaseOptimize::myPrint(array('aha','ho','no','print','gogog'));
*/
?>