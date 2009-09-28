<?php
$path = dirname(__FILE__).'/';
require_once($path.'ImageResizer.class.php');
$img   = new ImageResizer;
$layer = new ImageResizer($path.'2.jpg');
/*
$img->setFile($path.'1.jpg')
    ->resize(1000,1000,true,true,true,'ffffff',false)   ->save($path.'new.jpg')
    ->crop(100,100,100,100)                             ->save($path.'new_crop.jpg')
    ->crop(0,0,300,0)                                   ->save($path.'new_crop2.jpg')
    ->flip(IMAGE_FLIP_BOTH)                             ->save($path.'new_flip.jpg')
    ->addLayer($layer->getSrc())                                  ->save($path.'new_layer.jpg');
    */
$img->setFile($path.'12.gif')->crop(10,10,10,10)->save($path.'123.gif');
$img->setFile($path.'121.gif')->crop(10,10,10,10)->resize(100,100)->save($path.'1231.gif');
$img->setFile($path.'200.png')->resize(200,300)->save($path.'1234.png');




$img = imagecreatefromgif($path.'12.gif');
imagegif($img, $path.'12123123.gif');

