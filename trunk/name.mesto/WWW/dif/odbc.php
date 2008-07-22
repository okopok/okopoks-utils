<?php
// Подключиться к источнику данных ODBC 'ContactDB' ;
$connect=odbc_connect("sms", "","");
// Создать текст запроса
$query = "SELECT код, Ник, Имя, Фамилия, Телефон FROM tbАбоненты ORDER BY код";
// Подготовить запрос
$result = odbc_prepare($connect,$query);
// Выполнить запрос и вывести результаты
odbc_execute($result);

odbc_result_all($result, "border=1, width=100%");
// Обработка результатов закончена, освободить память 
odbc_free_result($result);
// Закрыть соединение 
odbc_close($connect);

?>