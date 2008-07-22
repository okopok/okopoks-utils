<?
// Создать массив разделов

$contents = array("tutorials", "articles", "scripts", "contact");

// Перебрать и последовательно вывести каждый элемент массива

for ($i = 0; $i < sizeof($contents); $i++){

print " &#149; <a href = \"".$contents[$i].".php\">".$contents[$i]."</a><br>\n";
}
// &#149; - специальное обозначение точки-маркера endfor;
?>