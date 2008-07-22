<?php

/*  Класс Captcha
 *  Требования: Установленный ImageMagick версии 6.2.5 и выше, подключенный к PHP модуль MagickWand, смотри: http://imagemagick.net/script/api.php
 *  Свойства (основные):
 *           var $SuccessURL;    //Ссылка куда перенаправлять, в случае успеха
 *           var $NotSuccessURL; //Ссылка куда перенаправлять, в случае неуспеха
 *
 *  Методы:
 *           salt_add($string)
 *                    Действие: Служебная функция - добавляет "соль" к хешируемой строке
 *                    Параметры: Строка
 *                    Возвращаемые значения: "Подсоленная" строка
 *           start_session()
 *                    Действие: Запускает сессию
 *                    Параметры: --
 *                    Возвращаемые значения: --
 *           ShowImage()
 *                    Действие: Выкидывает в поток изображение (посылает header("Content-type: imgae/png") затем Blob картинки)
 *                    Параметры: --
 *                    Возвращаемые значения: --
 *           TestCaptcha($UserInput)
 *                    Действие: Проверяет совпадает ли текст в строке $UserInput с текстом на картинке, закрывает сессию
 *                    Параметры: Тестируемая строка
 *                    Возвращаемые значения: TRUE в случае успеха и FALSE в случе неуспеха
 *           TestAndProcess($UserInput)
 *                    Действие: Подобен методу TestCaptcha($UserInput) только в случае успеха перенаправляет на $SuccessURL, в случае неуспеха на $NotSuccessURL
 *                    Параметры: Тестируемая строка
 *                    Возвращаемые значения: --
 *           ShowCaptchaBlock()
 *                    Действие: Выдает блок запроса Capatcha. Пример Использования:
 *                              index.php:
 *                              
 *                              include_once('captcha.php');
 *                              $Cap=new Captcha();
 *                              global $action;
 *                              if($action =='image'){
 *                                      $Cap->ShowImage();
 *                              }else{
 *                                      $Cap->ShowCaptchaBlock();
 *                              }
 *                              
 *                    Параметры: --
 *                    Возвращаемые значения: --
 *
 * ЗАМЕЧАНИЕ: В папке, где происходит вызов методов ShowImage() и ShowCaptchaBlock() должна располагаться папка (название: fonts) со шрифтами (6 шрифтов с именами 0.ttf, 1.ttf, ... 5.ttf соответственно)
 */

class capture{
 var $SuccessURL;    //Ссылка куда перенаправлять, в случае успеха
 var $NotSuccessURL; //Ссылка куда перенаправлять, в случае неуспеха


 //Переменные, отвечающие за генерацию картинки
 //Использхуемые цвета
 var $AllColors;
 //Количество используемых цветов
 var $AllColorsCount;
 //Ширина картинки
 var $width;
 //Высота картинки
 var $height;
 //Координаты расположения текста
 var $textposX;
 var $textposY;
 //Количество используемых из папки fonts шрифтов
 var $fontcount;

 var $eff_swirl;
 var $eff_impolde;      //Величина Implode (от 0 до 1)
 var $eff_blur2;              //Величина Blur
 var $eff_wave1;            //амплитуда волны
 var $eff_wave2;          //Длина волны
 var $eff_shear1;
 var $eff_shear2;
 //$eff_spread=mt_rand(0, 1);           //Величина spread

 //Размер шрифта
 var $fontsize;
 //Число символов в картинке
 var $TextLength;

 //Диапазоны количества вертикальных и горизонтальных линий
 var $hor_lines_min;
 var $hor_lines_max;
 var $ver_lines_min;
 var $ver_lines_max;


 /* Конструктор класса.
  * Возможные параметры: SuccessURL, NotSuccessURL, RootURL (см выше)
  * Поумолчанию:   $SuccessURL='seccess.php'
  *                $NotSuccessURL_='http://192.168.10.41/index.php'
  *                $Complicate='hard' - сложность картинки 'hard' - сложная 'easy' - простая
  */
 function capture($Complicate='hard', $SuccessURL_='seccess.php', $NotSuccessURL_='http://192.168.10.41/index.php'){
          $this->SuccessURL=$SuccessURL_;
          $this->NotSuccessURL=$NotSuccessURL_;
          switch($Complicate){
           case 'hard':
           //Переменные, отвечающие за генерацию картинки
            //Использхуемые цвета
            $this->AllColors=array('#000000','#0054BB','#0F5E00','#74158F','#546302','#630250','#020563','#176302','#008082','#275D24','#5A5D24','#3F531D','#1D2B53','#4D164B','#4B571A','#AD5500','#488066','#5E0000');
            //Количество используемых цветов
            $this->AllColorsCount=18;
            //Ширина картинки
            $this->width=130;
            //Высота картинки
            $this->height=50;
            //Координаты расположения текста
            $this->textposX=0;
            $this->textposY=0;
            //Количество используемых из папки fonts шрифтов
            $this->fontcount=5;

            $this->eff_swirl=mt_rand(10, 30);
            $this->eff_impolde=mt_rand(0, 20)/100;      //Величина Implode (от 0 до 1)
            $this->eff_blur2=mt_rand(0, 1);              //Величина Blur
            $this->eff_wave1=mt_rand(15, 30);            //амплитуда волны
            $this->eff_wave2=mt_rand(200, 300);          //Длина волны
            $this->eff_shear1=mt_rand(0, 40)-20;
            $this->eff_shear2=mt_rand(0, 16)-8;
            //$eff_spread=mt_rand(0, 1);           //Величина spread

            //Размер шрифта
            $this->fontsize=mt_rand(40, 40);
            //Число символов в картинке
            $this->TextLength=6;

            //Диапазоны количества вертикальных и горизонтальных линий
            $this->hor_lines_min=5;
            $this->hor_lines_max=10;
            $this->ver_lines_min=10;
            $this->ver_lines_max=20;
           break;
           case 'easy':
           //Переменные, отвечающие за генерацию картинки
            //Использхуемые цвета
            $this->AllColors=array('#000000','#0054BB','#0F5E00','#74158F','#546302','#630250','#020563','#176302','#008082','#275D24','#5A5D24','#3F531D','#1D2B53','#4D164B','#4B571A','#AD5500','#488066','#5E0000');
            //Количество используемых цветов
            $this->AllColorsCount=18;
            //Ширина картинки
            $this->width=130;
            //Высота картинки
            $this->height=50;
            //Координаты расположения текста
            $this->textposX=0;
            $this->textposY=0;
            //Количество используемых из папки fonts шрифтов
            $this->fontcount=5;

            $this->eff_swirl=mt_rand(8, 10);
            $this->eff_impolde=mt_rand(0, 20)/100;      //Величина Implode (от 0 до 1)
            $this->eff_blur2=0;                           //Величина Blur
            $this->eff_wave1=mt_rand(15, 30);            //амплитуда волны
            $this->eff_wave2=mt_rand(200, 300);          //Длина волны
            $this->eff_shear1=0;//mt_rand(0, 40)-20;
            $this->eff_shear2=0;//mt_rand(0, 16)-8;
            //$eff_spread=mt_rand(0, 1);           //Величина spread

            //Размер шрифта
            $this->fontsize=mt_rand(40, 40);
            //Число символов в картинке
            $this->TextLength=3;

            //Диапазоны количества вертикальных и горизонтальных линий
            $this->hor_lines_min=0;
            $this->hor_lines_max=0;
            $this->ver_lines_min=0;
            $this->ver_lines_max=0;
           break;
           }
         }
 //Соль
 function salt_add($string){
         return "%^s.".$string."&#.$";
        }

 function start_session(){
          session_start();
         }

 function ShowImage($txt=''){
          $this->start_session();
		  if($txt=='')
		  	{
			  for($i=0; $i<$this->TextLength; $i++)
				  $txt=$txt.chr(mt_rand(97,122));
			  session_register('cap_text');
	          $_SESSION['cap_text']=md5($this->salt_add($txt));
			}
          $fntname=mt_rand(0, $this->fontcount);
          $textcolor=$this->AllColors[mt_rand(0, $this->AllColorsCount)];
          $backcolor='#ffffff';

          $hor_lines_count=mt_rand($this->hor_lines_min, $this->hor_lines_max);
          $ver_lines_count=mt_rand($this->ver_lines_min, $this->ver_lines_max);


          //Инициализация рисовальщика
          $mg_w = NewMagickWand();
          $dr_w = NewDrawingWand();

          //Изменение цвета текста
          DrawSetFillColor($dr_w, $textcolor);
          //Размер шрифта
          DrawSetFontSize($dr_w, $this->fontsize);
          //Шрифт
          DrawSetFont($dr_w, './fonts/'.$fntname.'.ttf');
          //Положение текста
          DrawSetGravity($dr_w, MW_CenterGravity);

          //Добавление самого текста
          DrawAnnotation($dr_w, $this->textposX, $this->textposY, $txt);


          //Создание изображения
          MagickNewImage($mg_w, $this->width, $this->height, "#ffffff");

          //Прорисовка текста
          MagickDrawImage($mg_w, $dr_w);

          //наложение эффектов
            //MagickMotionBlurImage($mg_w, 2, 5, 0);
            //MagickOilPaintImage($mg_w, 1);
            //MagickRadialBlurImage($mg_w, 10);
            //MagickReduceNoiseImage($mg_w, 0.10); //Шум
            //MagickSolarizeImage($mg_w, 23);
            //MagickChopImage($mg_w, 30, 30, 0, 0);
            //MagickEmbossImage($mg_w, 2, 1);

          //+Swirl
          MagickSwirlImage($mg_w, $this->eff_swirl);
           //+Wave
          MagickWaveImage($mg_w, $this->eff_wave1, $this->eff_wave2);
          //+Spread
          //MagickSpreadImage($mg_w, $eff_spread);
          //+Implode
          MagickImplodeImage($mg_w, $this->eff_impolde);
          //+Blur
          MagickBlurImage($mg_w, 0, $this->eff_blur2);
          //+Shear
          MagickShearImage($mg_w, $backcolor, $this->eff_shear1, $this->eff_shear2);

          //Обоезка до нужных размеров
          //MagickResizeImage($mg_w, $width, $height, MW_PointFilter, 1);
          MagickScaleImage($mg_w, $this->width, $this->height);


            //Лини
           ClearDrawingWand($dr_w);
           //DrawSetGravity($dr_w, MW_CenterGravity);
		   DrawSetStrokeWidth($dr_w, 15);
           for($i=0; $i<$hor_lines_count; $i++){
               $startline_y=mt_rand(0, $this->height-1);
               $finishline_y=mt_rand(0, $this->height-1);
                //Изменение цвета текста
               DrawSetFillColor($dr_w, "white");//$AllColors[mt_rand(0, $AllColorsCount)]);
               DrawLine($dr_w, 0, $startline_y, $this->width, $finishline_y);
           }
           for($i=0; $i<$ver_lines_count; $i++){
               $startline_x=mt_rand(0, $this->width-1);
               $finishline_x=mt_rand(0, $this->width-1);
                //Изменение цвета текста
               DrawSetFillColor($dr_w, "white");//$AllColors[mt_rand(0, $AllColorsCount)]);
               DrawLine($dr_w, $startline_x, 0, $finishline_x, $this->height);
           }
          //Прорисовка линий
          MagickDrawImage($mg_w, $dr_w);


          //Установка формата
          MagickSetImageFormat( $mg_w, 'PNG' );
          //Выкидивание изображения как blob
          //header('Content-Type: ' . MagickGetMimeType($mg_w));
          header('Content-Type: image/png');
          MagickEchoImageBlob($mg_w);

          //Чистка
          DestroyMagickWand($mg_w);
          DestroyDrawingWand($dr_w);
        }


 function TestCaptcha($UserInput){
          $UserInput=strtolower($UserInput);
          $this->start_session();
          if(session_is_registered('cap_text')){
              if(md5($this->salt_add($UserInput))==$_SESSION['cap_text']){
                      session_unregister('cap_text');
                      return true;
              }
              else{
                      session_unregister('cap_text');
                      return false;
              }
          }else
               return false;
          //Если текущая сессия не нужна, удаляем ее
          session_destroy();
         }

 function TestAndProcess($UserInput){
          $TestResult=$this->TestCaptcha($UserInput);
          if($TestResult)
             header("Location: ".$SuccessURL);
          else
             header("Location: ".$NotSuccessURL);
         }

 function ShowCaptchaBlock(){

          return "<style type=\"text/css\">
            .CaptchaText{font-size:13px; font-family:monospace;}
            .CaptchaForm{height: 22px; width: 130px; font-size: 13px; border: 1px solid #000000;}
            .CaptchaFormActive{background-color: #7DBADD; height: 22px; width: 130px; font-size: 13px; border: 1px solid #000000;}
           </style>
           <table border=0>
             <td valign=top><img border=1 src=\"?action=image\" name=\"captcha\"></td>
             <td valign=top>
               <form action=\"test.php\">
                <font class=\"CaptchaText\">Введите символы, показанные на рисунке (без учета регистра).</font><br>
                <input type=text name=UserInput class=\"CaptchaForm\">
                <input type=submit class=\"CaptchaForm\" onmouseover=\"this.className='CaptchaFormActive'\" onmouseout=\"this.className='CaptchaForm'\">
                <br><br>
                <font class=\"CaptchaText\">Если у вас не получается прочитать текст, </font><font style=\"font-size:13px;font-family:monospace;color:#007DC5;cursor:pointer;\" onclick=\"document.captcha.src='?action=image'\">нажмите сюда</font>
               </form>
             </td>
           </table>
           <br>";
          }
}
session_start();
$_SESSION['capture_text'] = substr(md5(microtime().time()), 0, 5);
if(!isset($_SESSION['capture_text']))
	die();
	
$cap=new capture('easy');
$cap->ShowImage($_SESSION['capture_text']);

?>