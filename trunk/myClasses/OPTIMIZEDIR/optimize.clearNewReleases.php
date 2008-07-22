<?php
include('d:/htdocs/utils/classes/class.BaseOptimize.php');
$optim = new BaseOptimize;
// удаляем старые "новые релизы"
$optim->clearNewReleases();
?>