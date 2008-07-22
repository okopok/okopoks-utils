
<form name="GUEST" method="POST" action="shop_inv_add.php">
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

@mysql_query("CREATE TABLE inventory (
  product tinytext NOT NULL,
  quantity tinytext NOT NULL,
  id int(4) DEFAULT '0' NOT NULL auto_increment,
  description tinytext NOT NULL,
  price float(10,2) DEFAULT '0.00' NOT NULL,
  category char(1) DEFAULT '' NOT NULL,
  KEY id (id),
  PRIMARY KEY (id),
  KEY price (price)
)");
   mysql_query("insert into inventory(product,quantity,description,price,category)
   values('$prod','$qua','$descr','$price','$cater')");

?>