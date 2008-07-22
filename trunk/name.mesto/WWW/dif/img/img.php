<?php 
$size = GetImageSize("sqr.bmp");
$a_pic = array ("1" => "GIF", "2" => "JPG", "3" => "PNG", "6" => "BMP");

echo '<IMG SRC="sqr.bmp" ';
echo $size[3]." >\n<br>\n";
echo "width=\"$size[0]\"<br>\n";
echo "height=\"$size[1]\"<br>\n";
echo "$size[3]<br>\n";
echo "Картинка в формате " . $a_pic["$size[2]"] . "<br>\n";
echo "Индификатор формата " . $size[2] . "<br>\n";

$xr= $size[0]/2;
$yr= $size[1]/2;
echo $xr;
echo $yr;
echo '<IMG SRC="sqr.bmp" ';
echo "width=\"$xr\"";
echo "height=\"$yr\">";

?>