<?php


include('d:/htdocs/utils/classes/class.BaseOptimize.php');

$optim = new BaseOptimize;


// грабим гугл на рейтинг
//print_r($argv); sleep(10);die;
$optim->getEpRating();
?>