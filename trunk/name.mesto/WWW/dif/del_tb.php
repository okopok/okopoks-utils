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

echo '<form action="del_tb.php" method="POST">';
if (isset($HTTP_POST_VARS['rad']) and isset($HTTP_POST_VARS['base'])):
$base=$HTTP_POST_VARS['rad'];
	if ($base="del"):
		mysql_drop_db($base);
	else:
if ($base="del"){
		mysql_create_db($base);}
	endif;
else:
echo '<input type="text" name="base" valu�="base">';
echo '<input type="radio" name="rad" valu�="del">������� ����';
echo '<input type="radio" name="rad" valu�="add">�������� ����';
endif;
echo '<input type="submit" name="submit" value="���������">';
# mysql_query("UPDATE msg SET mail='well@mail.ru' WHERE id='10' ");
# mysql_query("DELETE FROM msg WHERE id='8'");
?>