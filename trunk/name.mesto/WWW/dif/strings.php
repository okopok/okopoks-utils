<?
$ip = "123.345.789.000"; // Канонический IP-адрес

$iparr = split ("\.", $ip); // Поскольку точка является служебным символом.

// ее необходимо экранировать.

print "$iparr[0] <br>"; // Выводит "123";
print "$iparr[1] <br>"; // Выводит "456";
print "$iparr[2] <br>"; // Выводит "789";
print "$iparr[3] <br>"; // Выводит "000";


$user_info = "Name: <b>Rasmus Lerdorf</b> <br> Title: <b>PHP Guru</b>";
preg_match_all ("/<b>(.*)<\/b>/U", $user_info, $pat_array);
print $pat_array[0][0]." <br> ".$pat_array[0][1]."\n";


$user_info="+wj+++Gilmore+++++wjgi]more@hotmail.com
+++++++Columbus+++OH";
$fields = preg_split("/\+{1,}/", $user_info);
$x=0; 
while ($x < sizeof($fields)):
print $fields[$x]. "<br>";
$x++;
endwhile;


$user_input = "The cookbook, entitled Cafe Francaise' costs < $42.25.";
$converted_input = htmlentities($user_input);
// $converted_input = "The cookbook, entitled 'Caf&egrave;
// Frac&ccediliaise' costs &lt; 42.25.";


$text_recipe = "
Party Sauce recipe:
1 can stewed tomatoes
3 tablespoons fresh lemon juice
Stir together, server cold.";
// Преобразовать символы новой строки в <br>
$htinl_recipe = nl2br($text_recipe);
?>