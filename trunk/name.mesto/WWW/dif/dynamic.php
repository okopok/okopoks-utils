<?
// ������� ������ ��������

$contents = array("tutorials", "articles", "scripts", "contact");

// ��������� � ��������������� ������� ������ ������� �������

for ($i = 0; $i < sizeof($contents); $i++){

print " &#149; <a href = \"".$contents[$i].".php\">".$contents[$i]."</a><br>\n";
}
// &#149; - ����������� ����������� �����-������� endfor;
?>