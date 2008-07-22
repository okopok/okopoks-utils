<?php

/**
 * На сколько я понял, альбомы буду искаться по номеру 0028947417323
 * для примера
 * http://www.en.imusic.dk/item/0028945772622/schwarzkopf-elisabeth-fischer-diskau-dietrich-moore-gerald-1998-spanisches-liederbuch-originals-cd
 * вытащить всю инфу
 * Картинка грабится по принципу
 * ПРЕВЬЮ   - http://www.en.imusic.dk/gfx/item/image/323/0028947417323.jpg
 * ОРИГИНАЛ - http://www.en.imusic.dk/gfx/item/reference/323/0028947417323.jpg
 * ТРЕКИ ЗАКЛЮЧЕНЫ В КОНТЕЙНЕРЫ <div class="tracks">
 *
 * многодисковые формат записи
 * Disk 1:|1. As Long As You're Happy, Baby|2. Ya-ya-da-da|3. (There's) Always Something There To Remind Me|Disk 2:|1. You've Not Changed|2. Don't Make Me Cry|3. Today|4. London|
 *
 *
 * В альбомах может и не быть треков
 *
 * Исходные CSV лежат в папке /input/
 * Конечные CSV в папке       /output/
 * Картинки лежат в папке     /output/images/
 * Классы в папке             /classes/
 */
define('__ROOT__',    strtr(dirname(__FILE__),'\\','/'));
define('__CLASSES__', __ROOT__.   '/classes/');
define('__OUTPUT__',  __ROOT__.   '/output/' );
define('__INPUT__',   __ROOT__.   '/input/' );
define('__CONFIG__',  __ROOT__.'/config.ini');
define('__IMAGES__',  __OUTPUT__. 'images/' );
include_once(__CLASSES__.'CurlGetContent.class.php');
//include_once(__CLASSES__.'ImageResizer.class.php');
//include_once(__CLASSES__.'Utils.class.php');
include_once(__CLASSES__.'Main.class.php');
include_once(__CLASSES__.'ProgressBar.class.php');
$aha = new Main;
$aha->parceInputFile();
?>
