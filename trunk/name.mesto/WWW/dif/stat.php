<?
/*
В элементах массива возвращается следующая информация:
0 Устройство
1 Индексный узел (inode)
2 Режим защиты индексного узла
3 Количество ссылок
4 Идентификатор пользователя владельца
5 Идентификатор группы владельца
6 Тип устройства индексного узла
7 Размер в байтах
8 Время последнего обращения
9 Время последней модификации
10 Время последнего изменения
11 Размер блока при вводе/выводе в файловой системе
*/
$file = "stat.php";

list($dev, $inode, $inodep, $nlink, $uid, $gid, $inodev, $size, $atime, $mtime, $ctime,

$bsize) = stat($file);
echo "Last modified: ".date( "H:i:s a", getlastmod( ) );
echo "<br>";
print "$file is $size bytes. <br>";
print "Last access time: $atime <br>";
print "Last modification time: $mtime <br>";
echo "Last access: ".date( "H:i:s a", $atime)."<br>";
echo "Last modification: ".date( "H:i:s a", $mtime)."<br>";
echo "CurTime: ".date( "H:i:s a")."<br>";
?>