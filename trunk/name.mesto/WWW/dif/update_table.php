
<form name="GUEST" method="POST" action="update_table.php">
  <b>id:</b>
<br>
<input name="id" type="text" class="RNForm" size="40">
  <b>товар:</b>
<br>
<input name="prod" type="text" class="RNForm" size="40">
  <br>
  <b>кол-во:</b><br>
  <input name="qua" type="text" class="BLForm" size="10">
  <br>
  <b>цена:</b>  
  <br>
<input name="price" type="text" class="BLForm" size="10">
  <br>
  <b>описание:</b>
  <br> 
<input name="descr" type="text" class="BLForm" size="40">
  <br>
  <b>буква категории:</b>
  <br>
<input name="cater" type="text" class="BLForm" size="1">
  <br>
  <input name="Submit" type="submit" value="отправить">
  <input type="reset" name="Submit2" value="Сбросить">
</form>

<?
# обьява переменных!
define("DBName","gbook");
define("HostName","localhost");
define("UserName","root");
define("Password","");

@$id=$HTTP_POST_VARS['id'];
@$prod=$HTTP_POST_VARS['prod'];
@$qua=$HTTP_POST_VARS['qua'];
@$price=$HTTP_POST_VARS['price'];
@$descr=$HTTP_POST_VARS['descr'];
@$cater=$HTTP_POST_VARS['cater'];

if(!mysql_connect(HostName,UserName,Password)) 
{  echo "Не могу соединиться с базой
".DBName."!<br>"; 
   echo mysql_error();
   exit; 
}

mysql_select_db(DBName);


   mysql_query("UPDATE inventory SET product=$prod, quantity=$qua, description=$descr, price=$price, category=$cater WHERE id=$id ");

# mysql_query("UPDATE msg SET mail='well@mail.ru' WHERE id='10' ");

?>