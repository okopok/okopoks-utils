<?
echo "<a href='gbook.php'>добавить сообщение</a>";
define("DBName","gbook");
define("HostName","localhost");
define("UserName","root");
define("Password","");

if(!mysql_connect(HostName,UserName,Password)) 
{  echo "Не могу соединиться с базой
".DBName."!<br>"; 
   echo mysql_error();
   exit; 
}
mysql_select_db(DBName);
// Выводим все записи

// Выводим все записи
$r=mysql_query("select * from msg");
for($i=0; $i<mysql_num_rows($r); $i++)
{  $f=mysql_fetch_array($r);
echo '<table width="100%"  border="1">
  <tr>
    <th class="RNForm" scope="col">
<div align="left"><a href="mailto:';
echo $f['mail'];
echo'" class="RNForm">';
echo $f['name'];
echo'</a> </div>
    </th>
  </tr>
  <tr>
    <td><p align="justify"><font size="2">';
echo $f['message'];
echo '</p></td>
  </tr>
  <tr>
    <td class="GTForms"><div align="right" class="BGBlue"><font size="2"><b>';
echo $f['date'];
echo '</b></font></div></td>
  </tr>
</table>';
echo "<hr>\n";
}
?>
