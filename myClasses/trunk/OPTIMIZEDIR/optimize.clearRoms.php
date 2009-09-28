<?php
include('d:/htdocs/utils/classes/class.BaseOptimize.php');
$optim = new BaseOptimize;
// удаляем альбомы которые в РОМС
$optim->delRomsAuthors();
?>