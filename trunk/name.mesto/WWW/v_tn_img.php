<?php
//include ('v_define.php');
error_reporting(2047);
// берём изображение
	$image=$_GET['img'];

	if(isset($_GET['w'])):
	  $max_wigth=$_GET['w'];
	else:
	  $max_wigth=100;
	endif;

	if(isset($_GET['h'])):
	  $max_height=$_GET['h'];	
	else:
	  $max_height=60;
	endif;

// узнаём его размеры
	$size = GetImageSize("$image");
	$w = $size[0];
	$h = $size[1];

// узнаём максимальное допустимые размеры изображения

// производим вычисление размеров картинок
	$procW=round($max_height/($h/100)/100, 2);
//	$procH=round($max_wigth/($w/100)/100, 2); // это пока не нужно
	if($h > $max_height)
	{
	  $tn_w = $w*$procW;
	  $tn_h = $max_height;
	}

// создаём виртуальные изображения
	$src = imagecreatefromjpeg("$image") or die ("Изображение не может быть открыто");
	$dst = ImageCreateTrueColor($tn_w,$tn_h);
	imagecopyresized ($dst, $src, 0, 0, 0, 0, $tn_w, $tn_h, $w, $h);

// выводим их в браузер
	Header("Content-type: image/jpeg");
	imagejpeg($dst, null, -1);

// освобождаем системные ресурсы
	imagedestroy($src);
	imagedestroy($dst);
?>