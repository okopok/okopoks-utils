<?php
$arr['value1'] = 1;
$arr['value2'] = 2;
$arr['value3'] = 3;
$arr['text'] = <<<EOL
http://ru4.voyna-plemyon.ru/staemme.php?screen=overview_villages&intro
EOL;
print json_encode($arr);
?>