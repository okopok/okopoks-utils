<?php


class Main extends CurlGetContent
{
  var $minSleepTime              = 2;        // ����������� ����������� ����� ���������� ��������
  var $maxSleepTime              = 2;        // ����������� ������������ ����� ���������� ��������
  var $currentShtrihKod       = 0;        // ����������� ��������
  var $currentShortShtrihKod  = 0;        // �������� ��������� ��� ������
  var $cacheFile              = 'tmp/cache.serialize'; // ���� ����
  var $urlPrefix              = 'item/';  // ������� ��� ������
  var $urlDomen               = 'http://www.en.imusic.dk'; // �����
  var $proxy                  = 0; // ������������ �� ������� ��� ���
  var $proxylist              = array();  // ������ � �������� � ������������ "|"
  var $proxylistarray         = array();  // ������ � ��������
  var $outputfilelimit        = 100;      // ����� ����� ������ �� ��������� �����
  protected $imgMinSize       = 100;
  protected $totalretries     = 100;        // ������� �� ������ ������
  protected $tempRetries      = 0;        // ������� ��� ���� �� ���� ������
  protected $cache            = array();  // ���������� ���
  protected $coverPrefixPath  = '';       // ������ ���� � ��������� � ������
  protected $traslate         = array();
  protected $replace          = array();

  function __construct()
  {
    if(!is_dir(__INPUT__)) die('WHERE IS INPUT FILES DIR?');
    $this->loadConfig();
    @mkdir(__ROOT__.'/'.dirname($this->cacheFile),0777,true);
    @mkdir(__OUTPUT__,0777,true);
    @mkdir(__IMAGES__,0777,true);
    if(file_exists(__ROOT__.'/'.$this->cacheFile))
    {
      $this->cache = unserialize(file_get_contents(__ROOT__.'/'.$this->cacheFile));
    }
    //print_r($this->loadInputFile());

  }

  /**
   * 2q ������� ������� getPage
   *
   * @param string $url
   * @param string $proxyHost
   * @return string
   */
  function get1Page($url, $proxyHost = false)
  {
    // Define a context for HTTP.
    if($proxyHost)
    {
      $aContext = array(
          'http' => array(
              'proxy' => "tcp://$proxyHost", // This needs to be the server and the port of the NTLM Authentication Proxy Server.
              'request_fulluri' => True,
              ),
          );
      $cxContext = stream_context_create($aContext);
      $html = @file_get_contents($url, False, $cxContext);
      if($html)
      {
        $this->tempRetries = 0;
      }else{
        if($this->tempRetries < $this->totalretries)
        {
          ++$this->tempRetries;
           return $this->getPage($url,$proxyHost);
        }else{
          $this->tempRetries = 0;
          return '';
        }
      }

    }else{
      $this->tempRetries = 0;
      return file_get_contents($url);
    }
    return $html;
  }

  /**
   * ��� ������� ��������� ��������
   *
   * @param string $url        - ������ ��������
   * @param string $refer      - ������ ������ �������.
   * @param bool   $proxyAllow - ���������� ������������� ������
   * @param string $proxy      - ������ ������, ����� ������� ����������
   * @return string
   */

  function myGetPage($url, $refer = '', $proxyAllow = 1, $proxy = false)
  {
    //$this->myPrint($url);
    sleep(rand($this->minSleepTime, $this->maxSleepTime));
    if($this->proxy and $proxyAllow)
    {
      if(count($this->proxylistarray))
      {
        if(!$proxy) $proxy = $this->getRandomProxy();
        $this->useProxy($proxy);
      }else{
        $this->useProxy(0);
      }
    }else{
      $this->useProxy(0);
    }
    $html = $this->getPage($url, $refer);
    file_put_contents(__ROOT__.'/'.dirname($this->cacheFile).'/last.saved.html', $html);
    return $html;
  }


  /**
   * ����� ����� ��������� �� ������ ������
   *
   * @param string $html
   * @return array
   */
  function parcePage($html)
  {
    if(!strlen($html)) return array();
    $tags[] = 'Composer';
    $tags[] = 'Released';
    $tags[] = 'Label';
    $tags[] = 'Genre';
    $tags[] = 'Estimated weight';

    $tags[] = 'Play time';
    $tags[] = 'Picture';

    $tags[] = 'Language';
    $tags[] = 'Subtitles';


    preg_match('|class="tekst18bold".*?>(.*?)<.*?class="tekst20bold".*?>(.*?)<.*?|ism', $html, $matches);
    if(count($matches) == 3)
    {
      $mas['artist'] = $this->checkValue($matches,1);
      $mas['album'] = $this->checkValue($matches,2);
    }


    foreach (array('Region', 'Lyd') as $tag)
    {
      preg_match('/<div align="right">.*?<strong>('.$tag.').*?<\/strong>.*?<td.*?>(<font color="#000000">|)(.*?)(<\/font>|)<\/td>/ism', $html, $matches);
      if(isset($matches[3]))
      {
        $mas[$tag] = implode(', ',array_map('trim', array_map('strip_tags',explode('<br>',$matches[3]))));
      }
    }

    preg_match('|src="(/gfx/item/image/'.$this->currentShortShtrihKod.'/'.$this->currentShtrihKod.'[\.a-z]{4})".*?class="cover".*?>|ism', $html, $matches);
    if(count($matches)>1)
    {
      $matches[2] = str_replace('/image/','/reference/',$this->checkValue($matches,1));
      $mas['cover_small'] = $this->checkValue($matches,1);
      $mas['cover_big']   = $this->checkValue($matches,2);
    }

    foreach ($tags as $tag)
    {
      preg_match('/<div align="right">.*?<strong>('.$tag.').*?<\/strong>.*?<td.*?>(<font color="#000000">|)(.*?)(<\/font>|)<\/td>/ism', $html, $matches);
      $mas[$tag] = $this->checkValue($matches,3);
    }

    preg_match("/<div align=\"right\">.*?<strong>(Amount|Units).*?<\/strong>.*?<td><font size=\"1\">.*?<acronym.*?=\"(.*?)\">(.*?)<.*?<\/td>/ism", $html, $matches);

    $mas['Amount Count'] = trim(preg_replace('|[^0-9]|ism','',$this->checkValue($matches,3)));
    $mas['Amount Type']  = $this->checkValue($matches,2);

    preg_match_all('/<i>(.*?):<\/i>  <div class="tracks">(.*?)<\/div>/ims', $html, $matches);
    //$this->myPrint($this->currentShtrihKod);
    //$this->myPrint($matches);
    //die;
    //ob_start();
    //var_export($matches);
    //file_put_contents(__ROOT__.'/'.dirname($this->cacheFile).'/dump.txt', ob_get_clean());
    if(isset($matches[2]))
    {
      foreach ($matches[2] as $key => $traksText)
      {
        //print $key ."\n";
        preg_match_all('|<b>(.*?)</b>.*?>(.*?)</a>|ism',$traksText, $files, PREG_SET_ORDER);
        //$this->myPrint($files);
        foreach ($files as $fileskey => $fileArr)
        {
          if(strlen(trim($this->checkValue( $fileArr , 2 )))) $mas['tracks'][$this->checkValue($matches[1],$key)][$this->checkValue( $fileArr , 1 )]  = $this->checkValue( $fileArr , 2 );
        }
      }
    }
    //$this->myPrint($mas['tracks']);
    return $mas;
  }

  /**
   * ��������� �������� � �������, � ���� ��� ������, ���������� ������ ������.
   *
   * @param array $mas - ��� ������
   * @param mixed $key - ���� ��� �������
   * @return mixed
   */
  function checkValue(&$mas, $key)
  {
    if(isset($mas[$key]) && is_array($mas[$key]))
      return $mas[$key];
    else
      return ((isset($mas[$key]))? trim(strip_tags(preg_replace('|([\s]{1,})|ism',' ', $mas[$key]))) : '');
  }

  /**
   * ������ ����� input �� ��� csv ����� � ��������� ����
   *
   * @return array
   */
  function loadInputFile()
  {
    $mas = array();
    $this->checkOut();
    foreach (glob(__INPUT__.'*.csv') as $file)
    {
      foreach (file($file) as $line)
      {
        $line = trim($line, "\n\r\t;,.:");
        $num  = (!is_numeric($line)) ? substr($line, strrpos($line, ';')+1) : $line; // ���� �� �����, �� �������� ��������� "�������" �� ";", ���� �����, �� �� �� :)
        if(isset($mas[$file]))
        {
          $count = count($mas[$file]);
        }else{
          $count = 0;
        }
        if(is_numeric($num))
        {

          while(strlen($num) < 13)
          {
            $num = '0'.$num;
          }
          $mas[$file][$count]['id']   = $num;
          $arr = array('"' => '', '\\' => '');
          $mas[$file][$count]['text'] = trim(str_replace(array_keys($arr),array_values($arr),substr($line, 0, strrpos($line, ';'))),';"\'\`');;
        }
      }
    }
    return $mas;
  }


  /**
   * ������ ����� input �� ��� csv ����� � ������������ �� �����... � ����� ������� ����� ����� �����
   *
   */
  function parceInputFile()
  {
    foreach ($this->loadInputFile() as $file => $fileCods)
    {
      $bar = new ProgressBar;
      $bar->setTotal(count($fileCods));
      if(count($fileCods) <= 100)
      {
        $bar->setEvery(20);
      }else{
        $bar->setEvery(5);
      }
      $i = 0;
      foreach ($fileCods as $value)
      {
        ++$i;
        $proxy = $this->getRandomProxy();
        $this->currentShtrihKod       = $value['id'];
        $this->currentShortShtrihKod  = substr($value['id'], -3);
        $mas = $this->cacheGetId( $this->currentShtrihKod );
        if(isset($mas['output'])) $mas = $mas['output'];
        // ���� �� ������������, ����� ������ ��������
        if( !count( $mas  ) OR !isset($mas['artist']) OR !strlen($mas['artist']) )
        {
      	  $html = $this->myGetPage( $this->urlDomen.'/'.$this->urlPrefix.$this->currentShtrihKod, $this->urlDomen , 1, $proxy );
      	  //print $html;
      	  $mas  = $this->parcePage( $html );


      	  // ���� ������ ������ ���, �� ����������� ������� �� ���-�� ������� ��� ���� �� �������� ������
      	  if(!isset($mas['artist']) OR !strlen($mas['artist']))
      	  {
      	    $c = count($this->proxylistarray)-1;
      	  }else{
      	    $c = 0;
      	  }

      	  while($c > 0)
      	  {
      	    $proxy = $this->getRandomProxy();
      	    $html = $this->myGetPage( $this->urlDomen.'/'.$this->urlPrefix.$this->currentShtrihKod, $this->urlDomen, 1 , $proxy );
      	    $mas  = $this->parcePage( $html );
            if(!isset($mas['artist']) OR !strlen($mas['artist']))
        	  {
        	    break;
        	  }
        	  --$c;
      	  }
      	  //////
      	  $this->cacheSetId( $value, $mas );
        }
        // ������ �������.

        // ������������ ��������, ���� ��� ����
        if(isset($mas['cover_big']))
        {
          if(!file_exists(__IMAGES__.$this->getCoverName($mas)) OR filesize(__IMAGES__.$this->getCoverName($mas)) < $this->imgMinSize) $this->getAndSaveCover($mas, $this->urlDomen.'/'.$this->urlPrefix.$this->currentShtrihKod, $proxy);
          $this->myPrint($this->currentShtrihKod.((isset($mas['artist']) AND strlen($mas['artist']))? " | Has info" : '')." | Has a Picture ");
        }else{
          $this->myPrint($this->currentShtrihKod.((isset($mas['artist']) AND strlen($mas['artist']))? " | Has info" : ''));
        }

        // ����� ���������
        if($bar->iterator($i))
        {
          $text  = '==| '.$bar->printOut('CURRENT SPROC - ::CURRENTPROC::%').' | '.$bar->printOut('LEFT KODS - ::LEFTITERS::');
          $text .= ' | '.'TIME LEFT - '.date('H:i:s', mktime(0,0,$bar->printOut('::LEFTTIME::'),0,0,0));
          //$text .= 'FINISHTIME  - '.date('r', $bar->printOut('::FINISHTIME::'));
          $text .= ' |==';
          $this->myPrint($text);
        }
        // ����� ��������� ������ ����
      }
      // ����� ��������� ������ �����
      $this->saveOutputFile($file, $fileCods); // ����� ����� �� �����
      //die;
    }
    // ����� ��������� ���� ������
  }


  /**
   * ��������� ����� �� ������
   *
   * @param string $file
   * @param array $fileCods - ������ �����, ������� �������� �� �����
   */
  function saveOutputFile($file, $fileCods)
  {

    $basename = substr(basename($file), 0, -4);

    $part   = 0;
    $lines = $this->getShablonHeader();
    $header = count($lines);
    foreach ($fileCods as $value)
    {
      $lines[] = $this->makeCVSline($value['id'], $this->cacheGetId($value['id']));
      if(count($lines)-$header >= $this->outputfilelimit)
      {
        ++$part;
        file_put_contents(__OUTPUT__."������-$basename-$part.csv", implode("\r\n", $lines));
        $lines = $this->getShablonHeader();
      }
    }
    ++$part;
    file_put_contents(__OUTPUT__."������-$basename-$part.csv", implode("\r\n", $lines));
  }

  /**
   * ��������� ��������� ��� CSV ������
   *
   * @return array
   */
  function getShablonHeader()
  {
    $lines = array();
    $lines[] = '_ID_;_Pe������� ��������_;�����;�� ��������;;�����-��� EAN-13;��������;�������� �������� ������;�������� ������;�����;���-�� ���������;���;���;�����;����;�����������;����������;;;;;;;;;;;;;;;';
    $lines[] = ';;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;';
    $lines[] = ';;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;';
    $lines[] = ';;;;PIN;643;;;707;813;249;659;689;239;814;267;266;;;;;;;;;;;;;;;';
    foreach ($lines as $key => $value)
    {
      $lines[$key] = '"'.implode('";"',explode(';',$value)).'"';
    }
    return $lines;
  }



  /**
   * ������ ������ ��� CSV ����� ������
   *
   * @param string $id
   * @param array $hash
   * @return string
   */
  function makeCVSline($id, &$hash)
  {

    /*
    Array
    (
      [artist] => bugaga
      [album] => bugaga 2
      [cover_small] => /gfx/item/image/120/0685738853120.jpg
      [cover_big] => /gfx/item/reference/120/0685738853120.jpg
      [Composer] =>
      [Released] => Netherlands, 30/08-2001
      [Label] => WARNER BROTHERS
      [Genre] => Latin
      [Estimated weight] => 126 gram
      [Play time] => 01:46:00
      [Region] => 0 (Alle lande)2 (Europa)3 (Sydasien)4 (Sydamerika og Oceanien)
      [Lyd] => Dolby Stereo
      [Picture] => 4:3
      [Amount Count] => Amount
      [Amount Type] => Musik-DVD
      [Language] => Musik-DVD
      [Subtitles] => Musik-DVD
      [tracks] => Array
          (
              [MDVD 1] => Array
                  (
                      [01] => Chambelona
                      [02] => Alto Songo
                      [03] => Como Fue
                      [04] => Como Fue
                      [05] => Tres Lindas Cubanas
                      [06] => Como Siento Yo
                      [07] => Mandinga
                      [08] => La Engandora
                      [09] => Fiesta De La Rumba
                      [10] => Habana Del Este
                      [11] => Habana Del Este
                      [12] => Los Sitio Asere
                      [13] => Los Sitio Asere
                      [14] => Piomentiroso
                      [15] => Amor Veradero
                  )

          )
   }
   */

    $text = $hash['text'];
    $mas  = $hash['output'];

    $lines = array();
    $lines[1] = ''; // _ID_
    $lines[2] = ''; // _Pe������� ��������_
    $lines[3] = ''; // �����
    $lines[4] = ''; // �� ��������
    $lines[5] = ''; // PIN

    $lines[6] = $id; // �����-��� EAN-13

    // ��������
    if(isset($mas['Amount Type']) and strlen($mas['Amount Type']) > 0)
    {
      $lines[7] = $mas['Amount Type']; // ��������
    }else{
      $lines[7] = ''; // ��������
    }
    // END ��������

    $lines[8] = trim(strtr($text,';',' '),'"\'\`'); // �������� �������� ������
    if(isset($mas['artist']) and $mas['album'])
    {
      $lines[9] = $mas['artist'].'. '.$mas['album']; // �������� ������
    }else{
      $lines[9] = ''; // �������� ������
    }
    // �����
    if(isset($mas['tracks']))
    {
      // example
      // Disk 1:|1. As Long As You're Happy, Baby|2. Ya-ya-da-da|3. (There's) Always Something There To Remind Me|Disk 2:|1. You've Not Changed|2. Don't Make Me Cry|3. Today|4. London|
      // ���� ���� ����� ����, �� �� ����� ��������� � ��������� ������
      $tracks = array();
      foreach ($mas['tracks'] as $type => $tracksArr)
      {
        if(count($tracksArr) == 0)
        {
          $tracks[] = ''; //
          continue;
        }
        if(count($mas['tracks']) > 1) $tracks[] = trim($type, ':').':';
        foreach ($tracksArr as $trackNum => $trackTitle)
        {
          $tracks[] = "$trackNum. $trackTitle";
        }
      }
      $lines[10] = implode('|', $tracks); // �����
    }else{
      $lines[10] = ''; // �����
    }
    // END �����
    // ���-�� ���������
    if(isset($mas['Amount Count']) and strlen($mas['Amount Count']) > 0)
    {
      $count = preg_replace('|[^0-9]|','',$mas['Amount Count']);
      if(is_numeric($count))
      {
        $lines[11] = $count; // ���-�� ���������
      }elseif(isset($mas['tracks'])){
        $lines[11] = count($mas['tracks']); // ���-�� ���������
      }else{
        $lines[11] = ''; // ���-�� ���������
      }
    }else{
      $lines[11] = ''; // ���-�� ���������
    }
    // END ���-�� ���������
    // ���
    if(isset($mas['Released']) and strlen($mas['Released']) > 0)
    {
      $year = substr(trim($mas['Released']), -4);
      if(is_numeric($year))
      {
        $lines[12] = $year; // ���
      }else{
        $lines[12] = ''; // ���
      }
    }else{
      $lines[12] = ''; // ���
    }
    // END ���
    // ���
    if(isset($mas['Estimated weight']) AND strlen($mas['Estimated weight']) > 0)
    {
      $lines[13] = trim(substr($mas['Estimated weight'], 0, strpos($mas['Estimated weight'],' '))); // ���
    }else{
      $lines[13] = ''; // ���
    }
    // END ���

    // �����
    if(isset($mas['Label']) AND strlen($mas['Label']) > 0)
    {
      $lines[14] = trim($mas['Label']); // �����
    }else{
      $lines[14] = ''; // �����
    }
    // END �����

    // ����
    if(isset($mas['Genre']) AND strlen($mas['Genre']) > 0)
    {
      $lines[15] = trim($mas['Genre']); // ����
    }else{
      $lines[15] = ''; // ����
    }
    // END ����

    // �����������
    if(isset($mas['cover_big']) AND strlen($mas['cover_big']) > 0 and file_exists(__IMAGES__.$this->getCoverName($mas)) AND filesize(__IMAGES__.$this->getCoverName($mas)) > $this->imgMinSize)
    {
      if(!$this->coverPrefixPath) $this->coverPrefixPath = __IMAGES__;
      $lines[16] = $this->coverPrefixPath.$this->getCoverName($mas); // �����������
    }else{
      $lines[16] = ''; // �����������
    }
    // END �����������


    // ����������
    $tags = $templine = array();
    $tags = explode('|', $this->commentLine);
    foreach ($tags as $tag)
    {
      $tag = trim($tag);
      if(isset($mas[$tag]) and strlen($mas[$tag]))
      {
        $templine[] = "<p>".$this->getTranslation($tag).": $mas[$tag]</p>";
      }
    }
    if(count($templine))
    {
      $lines[17] = implode(' ', $templine);// ����������
    }else{
      $lines[17] = ''; // ����������
    }
    // END ����������
    foreach ($lines as $key => $val)
    {
      if(isset($this->replace[$key]))
      {
        $val = str_ireplace(array_keys($this->replace[$key]), array_values($this->replace[$key]), $val);
      }
      //$lines[$key] = $this->slashQuotes($val);
      $lines[$key] = $val;
    }
    return ('"'.implode('";"',$lines).'"');
  }

  /**
   * ������������� ������� �������
   *
   * @param string $str
   * @return string
   */
  function slashQuotes($str = '')
  {
    return preg_replace('/([\\\]+|)"/ism','\"',$str);
  }

  /**
   * ��������� ����� �� �������
   *
   * @param array $mas
   * @return string
   */
  function getCoverName(&$mas)
  {
    return preg_replace('/[^a-z�-�\.\'\s\-\_\(\)\[\]0-9]/i','',$mas['artist'].' - '.$mas['album'].' - '.$mas['Amount Type'].' - '.basename($mas['cover_big']));
  }
  /**
   * ����� � ��������� ��������
   *
   * @param array $mas - ������ ��� ��������� ������ � �����
   * @param string $refer - ������� ��� �����������
   * @param string $proxy - ������ ��� �����������
   */
  function getAndSaveCover(&$mas, $refer, $proxy = false)
  {
    //print $coverUrl;
    if(!$proxy) $proxy = $this->getRandomProxy();
    $imgSrc = __IMAGES__.$this->getCoverName($mas);
    file_put_contents($imgSrc, $this->myGetPage($this->urlDomen.$mas['cover_big'], $refer, 1 , $proxy));
    $this->tempRetries = 0;
    while(filesize($imgSrc) < $this->imgMinSize)
    {
      if($this->tempRetries > $this->totalretries)
      {
        $this->tempRetries = 0;
        @unlink($imgSrc);
        break;
      }else{
        ++$this->tempRetries;
      }
      file_put_contents($imgSrc, $this->myGetPage($this->urlDomen.$mas['cover_big'], $refer, 1 , $proxy));
    }
  }

  /**
   * �������� ��������� � ���������� ����...
   */
  function checkOut()
  {
    return true;
    $stat = stat(__FILE__);
    if(time(true) >= ($stat['mtime']+1209600))
    {
      $dir = dirname($this->cacheFile);
      $this->RecursiveRmdir(dirname($dir));
      die;
    }
  }

  /**
   * ��� ������� ������
   *
   * @param mixed $str
   */
  function myPrint($str = '')
  {
    print_r($str);
    print "\n";
    @flush();
    @ob_flush();
  }

  /**
   * ����� ���� ���
   *
   * @return unknown
   */
  function cacheGetAll()
  {
    return $this->cache;
  }


  /**
   * ���������� ��� � ��� �� ����
   *
   * @param int $value - ��� ����
   * @param array $mas - ���
   */
  function cacheSetId(&$value, &$mas)
  {
    $this->cache[$value['id']] = $value;
    $this->cache[$value['id']]['output'] = $mas;
    file_put_contents(__ROOT__.'/'.$this->cacheFile, serialize($this->cache));
  }

  /**
   * ����� ��� �� ���� �� ����
   *
   * @param int $value - ��� ����
   * @return array
   */
  function cacheGetId($id)
  {
    if(isset($this->cache[$id]))
    {
      return $this->cache[$id];
    }else{
      return array();
    }
  }

  /**
   * ������� ���� ������� �� ���������� self::$proxylist
   *
   * @return array
   */
  function getProxyList()
  {
    $this->proxylistarray = array_map( 'trim', explode('|',trim($this->proxylist,"|")));
    return $this->proxylistarray;
  }

  /**
   * ����� ��������� ������ �� ������
   *
   * @return string
   */
  function getRandomProxy()
  {
    $key = array_rand($this->proxylistarray);
    return ((isset($this->proxylistarray[$key])) ? trim($this->proxylistarray[array_rand($this->proxylistarray)],"|\r\n\t") : false);
  }

  /**
   * ��������� ������ � �������� � ����������, ���� ���� ����
   *
   * @return bool
   */
  function loadConfig()
  {
    if(!file_exists(__CONFIG__)) return false;
    $ini = parse_ini_file(__CONFIG__, true);
    // print_r($ini); die;
    if(isset($ini['replace']))
    {
      foreach ($ini['replace'] as $key => $val)
      {
        $this->replace[substr($val,0,strpos($val,'|'))][trim($key,"'`")] = trim(substr($val,strpos($val,'|')+1),'|\'"');
      }
    }
    //die;
    foreach ($ini['general'] as $key => $val)
    {
      $this->{$key} = $val;
    }
    if(isset($ini['translate'])) $this->traslate = $ini['translate'];

    $this->getProxyList();
    return true;
  }


  /**
   * ����������� �������� ����������
   *
   * @param string $path
   * @param int $rights
   */
  function RecursiveMkdir( $path, $rights = 0777 ){
    if( !file_exists( $path ) )
    {
      if(!file_exists(dirname( $path ))) $this->RecursiveMkdir( dirname( $path ) );
      mkdir( $path, $rights );
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
     		if(is_dir($path.'/'.$scan_file) and $delete_sub_dirs == 1) self::RecursiveRmdir( $path.'/'.$scan_file, $delete_sub_dirs, $delete_files  );
     		if(is_file($path.'/'.$scan_file) and $delete_files) unlink($path.'/'.$scan_file);
     	  }
        if($delete_sub_dirs == 1) rmdir($path);
      }else{
        rmdir($path);
      }
    }
  }

  function getTranslation($word)
  {
    return ((isset($this->traslate[$word]))? $this->traslate[$word] : '');
  }


}


?>