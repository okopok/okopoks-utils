<title>����� ����� ���������!</title>
<link href="style.css" rel="stylesheet" type="text/css">
<form name="GUEST" method="POST" action="mail.php">
	<b>���� ������:</b>
	<br>
	<input name="name" type="text" class="RNForm" size="40">
	<br>
	<b>mailto:<br>
	</b>
	<input name="mail" type="text" class="BLForm" size="40">
	<br>
	<b>�����:<br>
	</b>
	<textarea name="message" cols="50" rows="5" class="GTForms"></textarea>
	<br>
	<input name="hid" type="hidden" value="1">
	<input name="Submit" type="submit" value="���������">
	<input type="reset" name="Submit2" value="��������">
</form>
<?

if(isset($HTTP_POST_VARS["hid"])){
	@$n=htmlspecialchars($HTTP_POST_VARS['name']);
	@$m=htmlspecialchars($HTTP_POST_VARS['mail']);
	@$mes=htmlspecialchars($HTTP_POST_VARS['message']);
	echo '<a href="mailto:'.$m.'?subject='.$n.'&body='.$mes.'">�������, ����� ��������!</a>';
}
?>