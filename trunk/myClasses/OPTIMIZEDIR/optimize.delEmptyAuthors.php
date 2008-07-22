<?php
include('d:/htdocs/utils/classes/class.BaseOptimize.php');
$optim = new BaseOptimize;
// удаляем пустых авторов
$optim->delEmptyAuthors();
?>