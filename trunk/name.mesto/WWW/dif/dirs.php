<?
$dh = opendir('.');
while ($file = readdir($dh)) :
print "$file <br>";
endwhile;
closedir($dh);
chdir('.');
?>