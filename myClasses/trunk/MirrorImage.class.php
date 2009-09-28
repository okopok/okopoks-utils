<?php

include(dirname(__FILE__).'/ImageResizer.class.php');

class MirrorImage extends ImageResizer
{
  protected $gradientFile = "gradient.png";
  function setGradientFile($str)
  {
    if(is_file($str))
    {
      $this->gradientFile = $str;
    }else{
      echo 'no such gradient file!';
    }
  }
  function __construct($filename, $output, $mirrorSize = 50 , $gradient = false)
  {
    $this->gradientFile = dirname(__FILE__).'/'.$this->gradientFile;

    $src = $this->setAlpha($this->prepareIMGsrc($filename));
    $canvas = $this->createCanvas($src, $mirrorSize);
    $out = $this->buildMirror($src, $canvas, $mirrorSize, $gradient);
    $this->outputIMG($output, $out, 100);
    //$this->outputIMG($output.'asd.jpg',$this->prepareIMGsrc(dirname(__FILE__).'/gradients/50.png'));
  }
  function createCanvas($filesrc, $mirrorSize = 100)
  {
    $sizex  = imagesx($filesrc);
    $sizey  = imagesy($filesrc);
    $canvas = imagecreatetruecolor($sizex, $sizey+$mirrorSize);
    imagefill($canvas, 0 , 0, $this->getColor($canvas,'FFFFFF'));
    return $canvas;
  }

  function buildMirror($filesrc, $canvas, $mirrorSize = 100, $gradient = false)
  {
    $canvas     = $this->addLayerSRC($canvas, $filesrc, 'top');

    $imagesy    = imagesy($filesrc);
    $imagesx    = imagesx($filesrc);

    if($mirrorSize > $imagesy) $mirrorSize = $imagesy;

    $rotateCrop = $this->cropSRC( $this->ImageFlip($filesrc, 1) , 0, $imagesy - $mirrorSize);
    $new        = $this->addLayerSRC($canvas, $rotateCrop, 'top', $imagesy);

    if(is_file($this->gradientFile) AND $gradient == true)
    {
      //print $this->gradientFile;
      $gradient   = $this->prepareIMGsrc($this->gradientFile);
      $destin     = imagecreatetruecolor( $imagesx, $mirrorSize );
      imagealphablending($destin,false);
      imagecopyresampled($destin, $gradient, 0, 0, 0, 0, $imagesx, $mirrorSize, imagesx($gradient), imagesy($gradient));
      //$this->setAlpha($destin);
      return $this->addLayerSRC($new, $destin, 'top', $imagesy);
    }else{
      return $new;
    }
  }


}

new MirrorImage(dirname(__FILE__).'/collage.jpg', dirname(__FILE__).'/1/100.jpg', 100,true);
new MirrorImage(dirname(__FILE__).'/collage.jpg', dirname(__FILE__).'/1/200.jpg', 200, true);
new MirrorImage(dirname(__FILE__).'/collage.jpg', dirname(__FILE__).'/1/50.jpg',  50, true);
new MirrorImage(dirname(__FILE__).'/collage.jpg', dirname(__FILE__).'/1/480.jpg', 480, true);

new MirrorImage(dirname(__FILE__).'/collage.jpg', dirname(__FILE__).'/1/100_nograd.jpg', 100);
new MirrorImage(dirname(__FILE__).'/collage.jpg', dirname(__FILE__).'/1/200_nograd.jpg', 200);
new MirrorImage(dirname(__FILE__).'/collage.jpg', dirname(__FILE__).'/1/50_nograd.jpg',  50);
new MirrorImage(dirname(__FILE__).'/collage.jpg', dirname(__FILE__).'/1/480_nograd.jpg', 480);


?>