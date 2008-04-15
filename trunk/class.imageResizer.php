<?php
/**
* Универсальный класс для ресайза картинок
* @author Саша Молодцов <asid@mail.ru>
* @since 13.09.2006
* @version 1.28.02.2008
*
*/

class ImageResizer
{

  var $error = false;
  /**
   * функция создания новых директорий
   *
   * @param string $path путь
   */
  function RecursiveMkdir( $path )
  {
  	if( !file_exists( $path ) )
  	{
  	  $this->RecursiveMkdir( dirname( $path ) );
  	  mkdir( $path );
  	}
  }

  /**
   * Определяет тип фотки по mime типу
   *
   * @param string $filename - путь до фотки
   * @return string
   */
  function getType($filename)
  {
    $file_type = getimagesize( $filename );
    switch($file_type['mime'])
    {
  	  case 'image/jpeg'; return 'jpg'; break;
  	  case 'image/gif';  return 'gif'; break;
  	  case 'image/png';  return 'png'; break;
  	}
  	$this->error = 'bad file type';
    return false;
  }


  /**
   * Получаем ресурс фотки исходя из её типа
   *
   * @param strinh $file - путь до картинки
   * @return resourse    - полученный ресурс
   */
  function prepareIMGsrc($file)
  {
    $file_type = getimagesize( $file );
    switch($file_type['mime'])
    {
  	  case 'image/jpeg'; return @imagecreatefromjpeg($file); break;
  	  case 'image/gif';  return @imagecreatefromgif($file);  break;
  	  case 'image/png';  return @imagecreatefrompng($file);  break;
      $this->error = 'bad resourse type';
  	  default;           return false;
  	}
  }


  /**
   * Выводит в файл текущий ресурс фотки.
   * Заодно проверяет расширение файла и выдаёт нужный формат
   *
   * @param string $file     - путь нового файла
   * @param resourse $source - ресурс фотки
   * @param int $quality     - качество фотки от 0 до 100
   * @return bool
   */
  function outputIMG($file, $source, $quality = '75')
  {

    if(eregi('\.jpeg$|\.jpg$', $file)) $file_type = 'jpg';
  	if(eregi('\.gif$',         $file)) $file_type = 'gif';
  	if(eregi('\.png$',         $file)) $file_type = 'png';

  	switch($file_type)
  	{
  	  case 'jpg';
  	    imagejpeg( $source , $file , $quality);
  	  break;
  	  case 'gif';
  	    imagegif( $source , $file , $quality);
  	  break;
  	  case 'png';
  	    imagepng( $source , $file , $quality);
  	  break;
  	  default;
      $this->error = 'bad output type';
  	  return false;
  	}
  	imagedestroy($source);
  	return true;
  }

  // функция обработки картинки
  /**
   * функция обработки картинки (ресайза)
   *
   * @param int $resize_x ширина картинки
   * @param int $resize_y высота картинки
   * @param string $source_file исходный путь картинки
   * @param string $new_file новый путь картинки
   * @param array $array параметры (
   *  quality     => (int) - качество фотки от 0 до 100.                               default = 75
   *  fill_in_box => (int) - 0 или 1. Вписывать в квадрат или нет.                     default = 0
   *  color       => (str) - цвет заливки в квадрате в 16чной системе.                 default = 'ffffff'
   *  lowres      => (int) - использовать ли низкое разрешение (для ускорения работы). default = 0
   *  size_check  => (int) - проверять входящую картинку на размеры. Если подаваемые размеры такие же как и подаваемые для ресайза
   *  то не проводить ресайз, а просто копировать изображение
   * )
   * @return bool
   *
   * <code>
   * <?php
   * include('class.ImagesResizer.php');
   * $Resizer = new ImagesResizer;
   * $Resizer->resize(200,200, $pathFrom,$pathTo);
   * ?>
   * </code>
   */
  function resize($resize_x, $resize_y, $source_file, $new_file, $array = array('quality' => 75, 'fill_in_box' => 0,'color' => 'ffffff', 'lowres' => 0, 'size_check' => 1))
  {
    extract($array);
  	if(!isset($quality))     $quality     = 75;
  	if(!isset($fill_in_box)) $fill_in_box = 0;
  	if(!isset($color))       $color       = 'ffffff';
  	if(!isset($lowres))      $lowres      = 0;
  	if(!isset($size_check))  $size_check  = 1;
  	if(!file_exists($source_file))
    {
      $this->error = 'file not exists';
      return false;
    }

    $source      = $this->prepareIMGsrc($source_file);

  	$quality_num = 75;
  	if($quality == 'th')
  	{
  	  $quality_num = 50;
  	}
  	if(is_numeric($quality)) $quality_num = $quality;
  	if(!is_resource($source))
    {
      return false;
    }

  	if(imagesx($source) == $resize_x and imagesy($source) == $resize_y and $size_check == 1)
  	{
  	  if(!file_exists(dirname($new_file))) $this->RecursiveMkdir( dirname($new_file) );
  	  copy($source_file, $new_file);
      return true;
  	}
    if(imagesx($source) > imagesy($source))
  	{
  		$last_x = $resize_x;
     	$last_y = $resize_x / (imagesx($source) / imagesy($source));
     	if($last_y > $resize_y)
     	{
     		$last_y = $resize_y;
			  $last_x = $last_y * (imagesx($source) / imagesy($source));
     	}
  	}else{
	     $last_y = $resize_y;
    	 $last_x = $resize_y / (imagesy($source) / imagesx($source));
     	 if ($last_x > $resize_x)
    	 {
    		 $last_x = $resize_x;
     		 $last_y = $last_x * (imagesy($source) / imagesx($source));
    	 }
  	}

  	if($fill_in_box == 1)
  	{
  	  $destin = imagecreatetruecolor( $resize_x, $resize_y );
  	  sscanf($color, "%2x%2x%2x", $red, $green, $blue); // вычисляем цвет из 16ричной системы в РГБ
  	  $colorallocate  = imagecolorallocate($destin, $red, $green, $blue);
  	  imagefill($destin,0,0,$colorallocate);
  	  if($lowres == 1){
        $new = imagecopyresized( $destin, $source, (($resize_x - $last_x)/2), (($resize_y - $last_y)/2), 0, 0, $last_x, $last_y, imagesx($source), imagesy($source));
  	  }else{
  	    $new = imagecopyresampled( $destin, $source, (($resize_x - $last_x)/2), (($resize_y - $last_y)/2), 0, 0, $last_x, $last_y, imagesx($source), imagesy($source));
  	  }
  	}else{
  	  $destin = imagecreatetruecolor( $last_x, $last_y );
  	  if($lowres == 1){
        imagecopyresized( $destin, $source, 0, 0, 0, 0, $last_x, $last_y, imagesx($source), imagesy($source));
  	  }else{
  	    imagecopyresampled( $destin, $source, 0, 0, 0, 0, $last_x, $last_y, imagesx($source), imagesy($source));
  	  }
  	}
    $this->outputIMG($new_file, $destin, $quality_num );
    return true;
  }

  /**
   * Получает размер фотографии
   *
   * @param string $filename - путь до фотографии
   * @return array           - массив с размерами и данными о картинке
   */
  function getSize($filename){
    return getimagesize($filename);
  }

  /**
   * Отрезает от сторон картинки заданное кол-во пикселей
   *
   * @param string $source_file - исходный файл
   * @param string $new_file    - конечный файл
   * @param int $top            - сколько резать сверху
   * @param int $bottom         - сколько резать снизу
   * @param int $left           - сколько резать слева
   * @param int $right          - сколько резать справо
   * @param int $quality_num    - качество картинки
   */
  function crop($source_file, $new_file, $top = 0, $bottom = 0, $left = 0, $right = 0, $quality_num = 75){
    $source  = $this->prepareIMGsrc($source_file);
    $sizeX   = imagesx($source);
    $sizeY   = imagesy($source);
    $destin  = imagecreatetruecolor( $sizeX,  $sizeY );
    $destin2 = imagecreatetruecolor( $sizeX - $left - $right,  $sizeY - $top - $bottom );
    imagecopyresampled( $destin,  $source, 0, 0, $left, $top, $sizeX,  $sizeY, $sizeX,  $sizeY);
    imagecopyresampled( $destin2, $destin, 0, 0, 0, 0, $sizeX,  $sizeY, $sizeX,  $sizeY);
    $this->outputIMG($new_file, $destin2, $quality_num );
  }

  /**
   * alpha version
   * метод для установки рамки с круглыми краями :)
   * @todo - универсальные настройки бордеров, добавление рамок в любые фотки (ресурсы), настроки кропа, заливки и цветов бордеров
   * @param string $fileIn  - исходный файл
   * @param string $fileOut - выходной файл
   * @param int    $size    - размер фотки (квадратной пока-что)
   * @param int    $margin  - размер отступа в точках
   *
   */
  function roundBorders($fileIn, $fileOut, $size = 100, $margin = 10, $text = '', $font = 'verdana.ttf')
  {
    //загрузка изображения
    $im_good = $this->prepareIMGsrc($fileIn);

    // предустановленные размеры / квадратные
    $predef = $size;
    $width  = $predef;
    $height = $predef;
    $mx     = $predef;


    // изменение радиуса для мелких изображений
    if( $mx < 130 ){
      $radius = 11;
    }else{
      $radius = round( $mx * 0.10 );
    }

    $img = imagecreatetruecolor($width, $height);

    $white   = imagecolorallocate($img, 255, 255, 255);
    $red     = imagecolorallocate($img, 255,   0,   0);
    $green   = imagecolorallocate($img,   0, 255,   0);
    $blue    = imagecolorallocate($img,   0,   0, 255);
    $border  = imagecolorallocate($img, 153, 153, 153);
    $bgcolor = imagecolorallocate($img, 254, 252, 253);
    $black   = imagecolorallocate($img,   0,   0,   0);

    imagefill($img, 0, 0, $white);

    $k    = ($mx - $margin) / max( imagesx($im_good), imagesy($im_good) );
    $posx = ($width  - round( $k * imagesx($im_good)) ) / 2;
    $posy = ($height - round( $k * imagesy($im_good)) ) / 2;

    imagecopyresampled($img, $im_good, $posx, $posy, 0, 0, round($k*imagesx($im_good)), round($k*imagesy($im_good)), imagesx($im_good), imagesy($im_good));

    imagearc($img, ($radius),          ($radius),           2*$radius,  2*$radius,  180, 270, $border);
    imagearc($img, ($radius),          ($radius-1),         2*$radius,  2*$radius,  180, 270, $border);
    imagearc($img, ($radius-1),        ($radius),           2*$radius,  2*$radius,  180, 270, $border);
    imagearc($img, ($radius-1),        ($radius-1),         2*$radius,  2*$radius,  180, 270, $border);

    imagearc($img, ($radius),          ($height-$radius),   2*$radius,  2*$radius,   90, 180, $border);
    imagearc($img, ($radius),          ($height-$radius-1), 2*$radius,  2*$radius,   90, 180, $border);
    imagearc($img, ($radius-1),        ($height-$radius),   2*$radius,  2*$radius,   90, 180, $border);
    imagearc($img, ($radius-1),        ($height-$radius-1), 2*$radius,  2*$radius,   90, 180, $border);

    imagearc($img, ($width-$radius),   $radius-1,           2*$radius,  2*$radius,  270, 360, $border);
    imagearc($img, ($width-$radius),   $radius,             2*$radius,  2*$radius,  270, 360, $border);
    imagearc($img, ($width-$radius-1), $radius,             2*$radius,  2*$radius,  270, 360, $border);
    imagearc($img, ($width-$radius-1), $radius-1,           2*$radius,  2*$radius,  270, 360, $border);

    imagearc($img, ($width-$radius),   ($height-$radius),   2*$radius,  2*$radius,    0,  90, $border);
    imagearc($img, ($width-$radius),   ($height-$radius-1), 2*$radius,  2*$radius,    0,  90, $border);
    imagearc($img, ($width-$radius-1), ($height-$radius-1), 2*$radius,  2*$radius,    0,  90, $border);
    imagearc($img, ($width-$radius-1), ($height-$radius),   2*$radius,  2*$radius,    0,  90, $border);


    imageline($img, $radius-1, 0,         ($width-$radius-1), 0,                   $border);
    imageline($img, $radius-1, 1,         ($width-$radius-1), 1,                   $border);
    imageline($img, $radius-1, $height-1, ($width-$radius-1), $height-1,           $border);
    imageline($img, $radius-1, $height-2, ($width-$radius-1), $height-2,           $border);
    imageline($img, 0,         $radius-1, 0,                  ($height-$radius-1), $border);
    imageline($img, 1,         $radius-1, 1,                  ($height-$radius-1), $border);
    imageline($img, $width-1,  $radius-1, $width-1,           ($height-$radius-1), $border);
    imageline($img, $width-2,  $radius-1, $width-2,           ($height-$radius-1), $border);
    if(is_string($text) and strlen($text) > 0 and is_file(dirname(__file__).'/'.$font))
    {
      imagettftext($img, round(0.05*$mx), 0, $width-round(0.5*$mx), $height-round(0.05*$mx), $black, dirname(__file__).'/'.$font, $text);
    }
    $this->outputIMG($fileOut, $img);
  }


  /**
   * Получаем координаты для фотографии из исходной фразы
   *
   * @param string $place     - фраза для получения координат действительны следующие фразы.
   * top-left, top-right, top, top-center, middle-left, left, middle, center, middle-right, center-right, right, bottom-left, bottom-right, bottom-center, bottom
   * @param int $sizeX        - ширина большей картинки
   * @param int $sizeY        - высота большей картиники
   * @param int $sizeXL       - ширина нового слоя
   * @param int $sizeYL       - высота нового слоя
   * @param int $marginTop    - отступ сверху
   * @param int $marginBottom - отступ снизу
   * @param int $marginLeft   - отступ слева
   * @param int $marginRight  - отступ справа
   *
   * @return array [x] - координата на оси Х. [y] - координата на оси y
   */

  function getCoords($place,$sizeX,$sizeY,$sizeXL,$sizeYL, $marginTop = 0, $marginBottom = 0, $marginLeft = 0, $marginRight = 0){

    switch($place){
      case 'top-left':      return array('x'=>$marginLeft,'y'=>$marginTop);                                           break;
      case 'top-right':     return array('x'=>$marginRight + $sizeX - $sizeXL,'y'=>$marginTop);                       break;
      case 'top':
      case 'top-center':    return array('x'=>($sizeX - $sizeXL)/2,'y'=>$marginTop);                                  break;
      case 'middle-left':
      case 'center-left':
      case 'left':          return array('x'=>$marginLeft,'y'=>($sizeY-$sizeYL)/2);                                   break;
      case 'middle':
      case 'center':        return array('x'=>($sizeX - $sizeXL)/2,'y'=>($sizeY - $sizeYL) / 2);                      break;
      case 'middle-right':
      case 'center-right':
      case 'right':         return array('x'=>$marginRight + $sizeX-$sizeXL,'y'=>($sizeY-$sizeYL)/2);                 break;
      case 'bottom-left':   return array('x'=>0,'y'=>$marginBottom + $sizeY - $sizeYL);                               break;
      case 'bottom-right':  return array('x'=>$marginRight + $sizeX - $sizeXL,'y'=>$marginBottom + $sizeY - $sizeYL);          break;
      case 'bottom-center':
      case 'bottom':        return array('x'=>($sizeX - $sizeXL) / 2,'y'=>$marginBottom + $sizeY - $sizeYL);          break;
      default:              return array('x'=>0,'y'=>0);                                                              break;
    }
  }

  /**
   * Накладывает одну картинку на другую.
   *
   * @param string $source_file - фон
   * @param string $layer_file  - то что накладываем (должна быть меньше чем фон)
   * @param string $new_file    - конечный файл
   * @param string $place       - место для наложения
   * @param int    $marginTop   - отступ сверху
   * @param int    $marginBottom - отступ снизу
   * @param int    $marginLeft  - отступ слева
   * @param int    $marginRight - отступ справа
   * @param int    $alpha       - степень прозрачности от 0 до 100
   * @param int    $quality_num - качество
   */
  function addLayer($source_file, $layer_file, $new_file, $place = 'top-left', $marginBottom = 0, $marginLeft = 0, $marginRight = 0, $alpha = 0, $quality_num = 75 ){

    $sourceBack   = $this->prepareIMGsrc($source_file);
    $sourceLayer  = $this->prepareIMGsrc($layer_file);
    ImageAlphaBlending($sourceBack, true);
    $sizeX        = imagesx($sourceBack);
    $sizeY        = imagesy($sourceBack);
    $sizeXL       = imagesx($sourceLayer);
    $sizeYL       = imagesy($sourceLayer);
    $coords       = $this->getCoords($place,$sizeX,$sizeY,$sizeXL,$sizeYL);
    if($alpha > 0){
      imagecopymerge($sourceBack, $sourceLayer, $coords['x'], $coords['y'], 0, 0, $sizeXL, $sizeYL, $alpha);
    }else{
      ImageCopy($sourceBack, $sourceLayer, $coords['x'], $coords['y'], 0, 0, $sizeXL, $sizeYL);
    }
    $this->outputIMG($new_file, $sourceBack, $quality_num );
  }


}


?>