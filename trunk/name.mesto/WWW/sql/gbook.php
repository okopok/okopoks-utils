
<form name="GUEST" method="POST" action="gbook.php">
  <b>���:<br>
  </b>  <input name="name" type="text" class="RNForm" size="40">
  <br>
  <b>mailto:<br>
  </b>  <input name="mail" type="text" class="BLForm" size="40">
  <br>
  <b>�����:<br>
  </b>  <textarea name="message" cols="50" rows="5" class="GTForms"></textarea>
  <br>
  <input name="Submit" type="submit" value="���������">
  <input type="reset" name="Submit2" value="��������">
</form>

<?
# ������ ����������!
define("DBName","gbook");
define("HostName","localhost");
define("UserName","root");
define("Password","");

if(isset($HTTP_POST_VARS['name'])):
$n=$HTTP_POST_VARS['name'];
else:
$n="";
endif;
if(isset($HTTP_POST_VARS['mail'])):
$m=$HTTP_POST_VARS['mail'];
else:
$m="";
endif;
if (isset($HTTP_POST_VARS['message'])):
$mes=$HTTP_POST_VARS['message'];
else:
$mes="";
endif;
if ((strlen($n) > 0) and (strlen($m) > 0) and (strlen($mes) > 0)){
if(!mysql_connect(HostName,UserName,Password)) 
{  echo "�� ���� ����������� � �����
".DBName."!<br>"; 
   echo mysql_error();
   exit; 
}

mysql_select_db(DBName);
// ������� ������� t. ���� ����� ������� ��� ����,
// ��������� �� ������ ����� ���������, �.�. 
// ������������ "@"
@mysql_query("create table msg(name text,mail text,message text,date text)");
$date=date("d.m.Y");
   mysql_query("insert into msg(name,mail,message,date)
   values('$n','$m','$mes','$date')");

echo "<a href='guest.php'>���������� �������</a>\n<br>";   

echo "$n\n <br>\n";
echo "$m\n <br>\n";
echo "$mes\n <br>\n";
}
?>