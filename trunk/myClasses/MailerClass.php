<?php
include_once(__classes_dir__.'PHPMailer/class.phpmailer.php');
class Mailer extends PHPMailer
{
     public $priority = 3;

     public function __construct()
     {
          //$this->Host     = '192.168.10.3';
          //$this->Port     = SMTP_PORT;
          $this->Mailer   = 'smtp';
          $this->Sender   = 'noreply@avtv.ru';
          $this->From     = 'noreply@avtv.ru';
          //$this->Sender     = 'aleksander@bdirect.ru';
          //$this->From     = 'aleksander@bdirect.ru';
          $this->FromName = 'Интернет магазин AVTV.ru';

          $this->AltBody  = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
          $this->CharSet  = 'cp1251';
          $this->Lang('ru');
     }
}

?>