<?php

include('d:/htdocs/utils/classes/class.BaseOptimize.php');
$optim = new BaseOptimize;
// удаляем пустые директории
$folders = array('h:/mp3/', 'l:/mp3/', 'm:/mp3/' , 't:/mp3/', 'f:/mp3/', 'g:/mp3/', 'i:/mp3/', 'j:/mp3/', 'n:/mp3/', $optim->MP3ADMINDIRImages);
foreach($folders as $fold){
  $optim->myPrint("Scaning '$fold'...");
  $optim->delEmptyFolders($fold);
  $optim->myPrint("done!");
}


?>