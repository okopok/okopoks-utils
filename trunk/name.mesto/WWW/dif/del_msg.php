<?
# обьява переменных!
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

echo '<form action="del_msg.php" method="POST">';
if (isset($HTTP_POST_VARS['del'])):
	$id=$HTTP_POST_VARS['del'];
	mysql_query("DELETE FROM msg WHERE id=$id");
	echo "Введите индификатор сообщения!\n<br>\n";
	echo "<input type=\"text\" name=\"del\">\n<br>\n";
	echo "<b>Сообщение с индификатором \"$id\" было удалено.</b>\n<br>\n";
else:
	echo "Введите индификатор сообщения!\n<br>\n";
	echo "<input type=\"text\" name=\"del\">\n<br>\n";
endif;
echo '<input type="submit" name="submit" value="удалить">';
echo "</form>";

# mysql_query("UPDATE msg SET mail='well@mail.ru' WHERE id='10' ");
# mysql_query("DELETE FROM msg WHERE id='8'");
?>