<?php
//include ('v_define.php');
error_reporting(2047);
// ���� �����������
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

// ����� ��� �������
	$size = GetImageSize("$image");
	$w = $size[0];
	$h = $size[1];

// ����� ������������ ���������� ������� �����������

// ���������� ���������� �������� ��������
	$procW=round($max_height/($h/100)/100, 2);
//	$procH=round($max_wigth/($w/100)/100, 2); // ��� ���� �� �����
	if($h > $max_height)
	{
	  $tn_w = $w*$procW;
	  $tn_h = $max_height;
	}

// ������ ����������� �����������
	$src = imagecreatefromjpeg("$image") or die ("����������� �� ����� ���� �������");
	$dst = ImageCreateTrueColor($tn_w,$tn_h);
	imagecopyresized ($dst, $src, 0, 0, 0, 0, $tn_w, $tn_h, $w, $h);

// ������� �� � �������
	Header("Content-type: image/jpeg");
	imagejpeg($dst, null, -1);

// ����������� ��������� �������
	imagedestroy($src);
	imagedestroy($dst);
?>