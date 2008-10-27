<?php

/**
 * @package utils
 * @copyright Molotdsov Sasha <asid@mail.ru>
 * @version 0.9
 */
class CurlGetContent
{
  protected $curlSRC   = null;     // ���� ����
  protected $inputs    = array();  // �����
  public    $cookies   = '';       // ���� �� ���
  public    $debug     = false;    // �������� ��������� ��������
  public    $timeOut   = 10;       // ��������� ������� ���������� � ��������


  /**
   * ��������� �����. ���� ���, �� ������ ����������, ���� ������, �� ������
   *
   * @return resourse
   */
  function getSrc()
  {
    if(!is_resource($this->curlSRC))
    {
      return $this->getNewSrc();
    }else{
      return $this->curlSRC;
    }
  }

  /**
   * �������� ����� ������ ����������
   * @return source
   */
  function getNewSrc()
  {
    if(!is_dir($this->cookies)) @mkdir(dirname(__FILE__).$this->cookies, 0777, true);
    $header[] = "Accept: text/xml,application/xml,application/xhtml+xml,text/html;q=0.9,text/plain;q=0.8,image/png,*/*;q=0.5";
    $header[] = "Cache-Control: max-age=0";
    $header[] = "Accept-Charset: windows-1251,utf-8;q=0.7,*;q=0.7";
    $header[] = "Accept-Language: ru-ru,ru;q=0.8,en-us;q=0.5,en;q=0.3";
    $header[] = "Pragma: "; // browsers keep this blank.

    $this->curlSRC = curl_init();
    curl_setopt($this->curlSRC, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.0; ru; rv:1.8.1.8) Gecko/20071008 Firefox/2.0.0.8');
    curl_setopt($this->curlSRC, CURLOPT_HTTPHEADER, $header);
    curl_setopt($this->curlSRC, CURLOPT_ENCODING, 'gzip,deflate');
    curl_setopt($this->curlSRC, CURLOPT_AUTOREFERER, true);

    curl_setopt($this->curlSRC, CURLOPT_COOKIEJAR,  $this->cookies.'.cookie.txt');
    curl_setopt($this->curlSRC, CURLOPT_COOKIEFILE, $this->cookies.'.cookie.txt');
    curl_setopt($this->curlSRC, CURLOPT_RETURNTRANSFER, 1);
    return $this->curlSRC;
  }

 /**
   * ���������� ����� �� ��������
   *
   * @param string $page  - url
   * @param string $refer - referer = ���� ���� �������, �� �������� ���
   * @param array $inputs - inputs = ���� ���� ������, �� ��������� �������� ������
   * @param bool $follow  - follow redirects = ��������� �� �����������
   * @param int $timeOut  - timeout = ������� ������ ����������
   * @return string
   */
  public function getPage($page, $refer = '', $inputs = array(), $follow = false, $timeOut = false)
  {
    $this->getSrc();
    $this->inputs = array_merge($inputs, $this->inputs);

    // ���� ���� �������, �� �������� ���
    if($refer != '')
    {
      curl_setopt ($this->curlSRC, CURLOPT_REFERER,   $refer);
    }
    // ���� ���� ������, �� ��������� �������� ������
    if(is_array($this->inputs) and count($this->inputs) > 0)
    {
      curl_setopt($this->curlSRC, CURLOPT_POST, 1);
      curl_setopt($this->curlSRC, CURLOPT_POSTFIELDS, $this->inputs);
    }
    // ��������� �� �����������
    if($follow == true)
    {
      curl_setopt ($this->curlSRC, CURLOPT_FOLLOWLOCATION, true);
    }

    // ������������� ������� ������ ����������
    if(is_numeric($timeOut)){
      curl_setopt($this->curlSRC, CURLOPT_TIMEOUT, $timeOut);
    }else{
      curl_setopt($this->curlSRC, CURLOPT_TIMEOUT, $this->timeOut);
    }

    // ���� �������, �� ���������� ��������� ��������
    if($this->debug) curl_setopt($this->curlSRC, CURLOPT_VERBOSE, true);

    curl_setopt($this->curlSRC, CURLOPT_URL, $page);
    $ret = curl_exec ($this->curlSRC);
    $this->inputs = array();
    return $ret;
  }

    function errno()
    {
        return curl_errno($this->curlSRC);
    }
    
    function error()
    {
        return curl_error($this->curlSRC);
    }
    
    function info()
    {
        return curl_getinfo($this->curlSRC);
    }

  /**
   * ������������ ������ ��� ���
   *
   * @param string $host ������ ������ �������. ���� 0, �� �������� ����� ��������� ��� ������. ��� ������ ������������
   * @param string $user �����
   * @param string $pass ������
   */
  function useProxy($host = 0, $user = '', $pass = '')
  {

    if($host != '0')
    {
      curl_setopt ($this->getSrc(), CURLOPT_PROXY,   $host);
      if($user != '' and $pass!='')
      {
        curl_setopt ($this->curlSRC, CURLOPT_PROXYUSERPWD, "$user:$pass");
      }
    }else{
      $this->getNewSrc();
    }

  }
}
?>