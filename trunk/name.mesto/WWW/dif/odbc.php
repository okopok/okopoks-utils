<?php
// ������������ � ��������� ������ ODBC 'ContactDB' ;
$connect=odbc_connect("sms", "","");
// ������� ����� �������
$query = "SELECT ���, ���, ���, �������, ������� FROM tb�������� ORDER BY ���";
// ����������� ������
$result = odbc_prepare($connect,$query);
// ��������� ������ � ������� ����������
odbc_execute($result);

odbc_result_all($result, "border=1, width=100%");
// ��������� ����������� ���������, ���������� ������ 
odbc_free_result($result);
// ������� ���������� 
odbc_close($connect);

?>