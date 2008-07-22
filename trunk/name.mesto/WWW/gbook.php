<title>Форма ввода сообщения!</title>
	<link href="style.css" rel="stylesheet" type="text/css">
	<form name="GUEST" method="POST" action="gbook.php">
		<b>имя:<br>
		</b><input name="name" type="text" class="RNForm" size="40">
		<br>
		<b>mailto:<br>
		</b><input name="mail" type="text" class="BLForm" size="40">
		<br>
		<b>URL:<br>
		</b><input name="www" type="text" class="BLForm" size="40">
		<br>
		<b>мысль:<br>
		</b><textarea name="message" cols="50" rows="5" class="GTForms"></textarea>
		<br>
		<input name="Submit" type="submit" value="отправить" onClick="javascript:self.reload('guest.php');">
		<input type="reset" name="Submit2" value="Сбросить">
	</form>

<?

# обьява переменных!
define("DBName","gbook");
define("HostName","localhost");
define("UserName","root");
define("Password","");
	if(!mysql_connect(HostName,UserName,Password)) 
	{
	echo "Не могу соединиться с базой
".DBName."!<br>"; 
	echo mysql_error();
	exit; 
	}

	mysql_select_db(DBName);
	// Создаем таблицу t. Если такая таблица уже есть,
	// сообщение об ошибке будет подавлено, т.к. 
	// используется "@"

@mysql_query("CREATE TABLE msg (
id int(6) DEFAULT '0' NOT NULL auto_increment,  
datetime datetime DEFAULT '00-00-0000 00:00:00' NOT NULL,
name tinytext NOT NULL,
email tinytext,
www tinytext,
message text NOT NULL,
KEY (id),
PRIMARY KEY (id)
)");

function validEmail($mail) {
	if (eregi("^[a-z0-9]+([-_\.]?[a-z0-9])+@[a-z0-9]+([-_\.]?[a-z0-9])+\.[a-z]{2,4}", $mail)) {
	return true;
	}
}
function add_msg($n, $email, $www, $mes)
{
	mysql_query("insert into msg(name,email,www,message,datetime)
	values('".$n."','".$email."','".$www."','".$mes."',NOW())");
}

if(isset($HTTP_POST_VARS['name'])):
	$n = htmlspecialchars($HTTP_POST_VARS['name']);
else:
	$n = "";
endif;
if(isset($HTTP_POST_VARS['mail'])):
	$email = htmlspecialchars($HTTP_POST_VARS['mail']);
else:
	$email = "";
endif;

if (isset($HTTP_POST_VARS['www'])):
	$www = htmlspecialchars(trim($HTTP_POST_VARS['www']));
else:
	$www = "";
endif;

if (isset($HTTP_POST_VARS['message'])):
	$mes = nl2br(htmlspecialchars(trim($HTTP_POST_VARS['message'])));
else:
	$mes = "";
endif;


if(strlen($www) > 0){
	if(!ereg("^http://(.*)$", $www)){
	$www = 'http://'.$www;
	}
}


if ((strlen($n) > 0) and (strlen($mes) > 0)):
	if ((strlen($email) > 0) and  validEmail($email)):
		add_msg($n, $email, $www, $mes);
	elseif (strlen($email) == 0):
		add_msg($n, $email, $www, $mes);
	else:
		echo "Е-Мыло неправильно написано!";
	endif;

else:
	echo "<font size=2><b>заполните поля пожалуйста</b></font>";
endif;
?>