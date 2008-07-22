<?
$title="Наши люди";
include ("start_page.php");
// функция вывода супер ссылки :)
$path = "photos/names/";
?>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<div align="justify">
<?
$page = fopen ("people.lst", "r");
while (! feof($page)) :
	$chel = fgets($page, 4096);
	$inf = explode("|", $chel);
?>
<hr>
<table width="100%" height="10" border="0" cellpadding="1" cellspacing="0">
  <tr> 
<td colspan="2">
<b><? echo $inf[0]; ?></b>
</td></tr><tr> 
<td><b>Настоящее имя</b> - <? echo $inf[1]; ?>
</td>
<td rowspan="6" width="100" align="center"> <a href="<?=$path.$inf[7]; ?>">
<img src="v_tn_img.php?img=<?=$path.$inf[7];?>&h=100" border="0"></a>
</td></tr><tr> 
<td><b>День рождения</b> - <? echo $inf[2]; ?>
</td></tr><tr> 
<td><b>Место проживания</b> - <? echo $inf[3]; ?>
</td></tr><tr> 
<td><b>ICQ</b> - <? echo $inf[4]; ?>
</td></tr><tr> 
<td><b>mailto: </b><a href="mailto:<? echo $inf[5]; ?>"><? echo $inf[5]; ?>
</a></td></tr><tr>
<td><b>URL: </b><a href="<? echo $inf[6]; ?>" target="_blank"><? echo $inf[6]; ?>
</a></td></tr></table>

<?
	endwhile;
	fclose ($page);
echo "</div>";
include ("end_page.php");
?>