<?

// Подключиться к серверу и выбрать базу данных
@mysql_connect("localhost", "web". "4tf9zzzf")
or die("Could not connect to MySQL server!");
@mysql_select_db("company") or die("Could not select company database!");
// Создать запрос
$query = "UPDATE products SET prod_name = \"cantaloupe\" WHERE prod_id = \'10001pr\'";
// Выполнить запрос $result = mysql_query($query);
// Определить количество обновленных записей
print "Total row updated; ".mysql_affected_rows( );
mysql_close( );

#Функция mysql_affected_rows( ) не работает с запросами, основанными на команде SELECT.

?>



<?
##Пример использования mysql_num_rows( ): 
// Подключиться к серверу и выбрать базу данных @mysql_connect("localhost", "web", "4tf9zzzf")
or die("Could not connect to MySQL server!");
@mysql_select_db("company") or die("Could not select company database!");
// Выбрать все товары, названия которых начинаются с 'р'
$query = "SELECT prod_name FROM products WHERE prod_name LIKE \"p*\"";
// Выполнить запрос $result = mysql_query($query);
print "Total rows selected: ".mysql_num_rows($result);
mysql_close( );

?>

<?
$form =
"<form action=\"Listing11-5.php\" method=\"post\">
<input type=\"hidden\" name=\"seenform\" value=\"y\">
Keyword:<br>
<input type=\"text\" name=\"keyword\" size=\"20\" maxlength=\"20\" value=\"\"><br>
Search Focus:<br>
<select name=\"category\">
<option value=\"\">Choose a category:
<option value-\"cust_id\">Customer ID
<option value=\"cust_name\">Customer Name
<option value=\"cust_eman\">Customer Email
</select><br>
<input type-\"submit\" value=\"search\"> ,
</form>";
// Если форма еще не отображалась - отобразить ее
if ($seenform != "у") :
print $form; 
else :
// Подключиться к серверу MySQL и выбрать базу данных
@mysql_connect("localhost", "web", "ffttss")
or die("Could not connect to MySQL server!");
@mysql_select_db("company")
or die("Could not select company database!");
// Построить и выполнить запрос
$query = "SELECT cust_id. cust_name, cust_email
FROM customers WHERE $category = '$keyword'";
$result = mysql_query($query);
// Если совпадения не найдены, вывести сообщение
// и заново отобразить форму
if (mysql_num_rows($result) == 0) :
print "Sorry, but no matches were found. Please try your search again:";
print $form;
// Найдены совпадения. Отформатировать и вывести результаты, 
else :
// Отформатировать и вывести значения полей.
list($id, $name, $email) = mysql_fetch_row($result);
print "<h3>Customer Information:</h3>";
print "<b>Name:</b> $name <br>";
print "<b>Identification #:</b> $id <br>";
print "<b>Email:</b> <a href-\"mailto:$email\">$email</a> <br>";
print "<h3>Order History:</h3>";
// Построить и выполнить запрос к таблице 'orders'
$query = "SELECT order_id, prod_id, quantity
FROM orders WHERE cust_id = '$id'
ORDER BY quantity DESC";
$result = mysql_query($query):
print "<table border = 1>";
print "<tr><th>0rder ID</th><th>Product ID</th><th>Quantity</th></tr>";
// Отформатировать и вывести найденные записи.
while (list($order_id, $prod_id, $quantity) = mysql_fetch_row($result));
print "<tr>";
print "<td>$order_id</td><td>$prod_id</td><td>$quantity</td>";
print "</tr>";
endwhile;
print "</table>";
endif;
endif;
?>