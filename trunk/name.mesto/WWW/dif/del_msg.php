<?
# ������ ����������!
define("DBName","gbook");
define("HostName","localhost");
define("UserName","root");
define("Password","");

if(!mysql_connect(HostName,UserName,Password)) 
{  echo "�� ���� ����������� � �����
".DBName."!<br>"; 
   echo mysql_error();
   exit; 
}
mysql_select_db(DBName);

echo '<form action="del_msg.php" method="POST">';
if (isset($HTTP_POST_VARS['del'])):
	$id=$HTTP_POST_VARS['del'];
	mysql_query("DELETE FROM msg WHERE id=$id");
	echo "������� ����������� ���������!\n<br>\n";
	echo "<input type=\"text\" name=\"del\">\n<br>\n";
	echo "<b>��������� � ������������� \"$id\" ���� �������.</b>\n<br>\n";
else:
	echo "������� ����������� ���������!\n<br>\n";
	echo "<input type=\"text\" name=\"del\">\n<br>\n";
endif;
echo '<input type="submit" name="submit" value="�������">';
echo "</form>";

# mysql_query("UPDATE msg SET mail='well@mail.ru' WHERE id='10' ");
# mysql_query("DELETE FROM msg WHERE id='8'");
?>