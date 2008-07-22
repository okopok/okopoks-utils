<?
define("DBName","gbook");
define("HostName","localhost");
define("UserName","root");
define("Password","");

if(!mysql_connect(HostName,UserName,Password)) 
{  echo "Ќе могу соединитьс€ с базой
".DBName."!<br>"; 
   echo mysql_error();
   exit; 
}
mysql_select_db(DBName);
// ¬ыводим все записи
@$sort=$HTTP_GET_VARS['sort'];
// ¬ыводим все записи
if (count($sort)>0):
$r=mysql_query("SELECT * FROM inventory ORDER BY $sort");
else:
$r=mysql_query("SELECT * FROM inventory ORDER BY id");
endif;


echo '<table width="100%"  border="1">';
echo '<tr>';
echo '<th><a href="table.php?sort=id">id</a></th>';
echo '<th><a href="table.php?sort=product">продукт</a></th>';
echo '<th><a href="table.php?sort=description">описание</a></th>';
echo '<th width=50><a href="table.php?sort=quantity">кол-во</a></th>';
echo '<th width=10><a href="table.php?sort=price">цена</a></th>';
echo '<th width=10>итого</th>';
echo '<th width=10><a href="table.php?sort=category">категори€</a></th>';
echo '</tr>';

for($i=0; $i<mysql_num_rows($r); $i++)
{  $f=mysql_fetch_array($r);
$itog=$f['price']*$f['quantity'];
echo '<tr><td>';
echo $f['id'];
echo '</td><td>';
echo $f['product'];
echo '</td><td>';
echo $f['description'];
echo '</td><td>';
echo $f['quantity'];
echo '</td><td>';
echo $f['price'];
echo '</td><td>';
echo $f['price']*$f['quantity'];
echo '</td><td>';
echo $f['category'];
echo '</td></tr>';
}
echo '</table>';

?>
