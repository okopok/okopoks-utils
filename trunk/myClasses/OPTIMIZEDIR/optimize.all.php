<?php
include('d:/htdocs/utils/classes/class.BaseOptimize.php');
$optim = new BaseOptimize;
// удаляем музыку, которая full_delete
$optim->delFull_delete();

// удаляем альбомы которые в РОМС
$optim->delRomsAuthors();

// удаляем пустых авторов
$optim->delEmptyAuthors();

// заменяем плохие символы на хорошие
$optim->replacingWords();

// грабим гугл на рейтинг
$optim->getEpRating();

// удаляем старые "новые релизы"
$optim->clearNewReleases();

// удаляем пустые директории

$optim->delEmptyFolders('h:/mp3/');
$optim->delEmptyFolders('l:/mp3/');
$optim->delEmptyFolders('m:/mp3/');
$optim->delEmptyFolders('t:/mp3/');
$optim->delEmptyFolders('f:/mp3/');
$optim->delEmptyFolders('g:/mp3/');
$optim->delEmptyFolders('i:/mp3/');
$optim->delEmptyFolders('j:/mp3/');
$optim->delEmptyFolders('n:/mp3/');
$optim->delEmptyFolders($optim->MP3ADMINDIRImages);

// оптимизируем базу
$optim->optimize_base();



?>