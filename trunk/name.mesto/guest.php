<?
$title="��������";
include("start_page.php");
define('numPosts',40);
$guest_file='guest_file.lst';
//////////////// ����������
// ������ ���-�� ������
if(isset($_GET['numposts'])){
	$numposts=$_GET['numposts'];
}else{
	$numposts=numPosts;
}
// ������ �� ���������� ����� �����
if(isset($_POST['yes'])){
$a=0;
if(strlen($_POST['name'])>1){
$name=htmlspecialchars(rtrim(trim($_POST['name'])));
++$a;
}else{
echo '<h3>�� �� ����� ���</h3>';
}

if(strlen($_POST['message'])>1){
$message = htmlspecialchars($_POST['message']);
$message = eregi_replace("\|","I", $message);
$message = eregi_replace("\r","<br>",$message);
$message = eregi_replace("\n","", $message);
//////////////

// �������� ���� [url][/url]
$message = preg_replace('/(\[url\])(.*)(\[\/url\])/', '<a href="\\2">\\2</a>', $message);
// �������� ���� [url=][/url]
$message = preg_replace('/(\[url=)(.*)(\])(.*)(\[\/url\])/','<a href="\\2">\\4</a>',$message);
// �������� ���� [b][/b]
$message = preg_replace('/(\[b\])(.*)(\[\/b\])/',"<b>\\2</b>", $message);
// �������� ���� [i][/i]
$message = preg_replace('/(\[i\])(.*)(\[\/i\])/',"<i>\\2</i>", $message);

++$a;
}else{
echo '<h3>�� �� ����� ���������</h3>';
}
// ���� ��� ���� ����� �������, �� ��������� ������ � ������
if($a==2){
	$ar=file($guest_file);
	$num=sizeof($ar)+1;
	$str="\n".$num."|".$name.'|'.$message."|".date("H:i - d.m.y");
if(sizeof($ar)==0){
	$str=$num."|".$name.'|'.$message."|".date("H:i - d.m.y");
}
$fpp = fopen($guest_file, "a+");
fputs($fpp,$str);
fclose($fpp);
}
$_POST['message']='';
}
/////////////// ������ ����� ����� ////////////
?>
<!--
<form name="postbox" method="post" action="guest.html?numposts=<?=$numposts;?>" content="plain/text; charset=windows-1251">
<input type="hidden" name="yes">
�������:<br>
<input type="text" name="name" value="<?=@$_POST['name'];?>" size="40" maxlength="50" class="forms" /><br>
��������:
<br>
<textarea name="message" cols="30" class="forms" rows="3"><?=@$_POST['message'];?></textarea>
<br>
<input type="submit" value="���������" class="forms">
<input type="reset" value="�������" class="forms">
</form>
<div>���-�� ��������� �� ��������:
<a href="guest.html?numposts=10">10</a>,
<a href="guest.html?numposts=20">20</a>,
<a href="guest.html?numposts=50">50</a>,
<a href="guest.html?numposts=all">���</a><br>
�� �������� ��������� ���� <b>[b][/b]</b>, <b>[i][/i]</b>,
<b>[url]</b>http://link.ru<b>[/url]</b> � <b>[url=http://link.ru]</b>������<b>[/url]</b>
<br><br>
-->
<?

//////////////// ��������� �������� /////////////////
// ������ ������ �����, ��������� ���-�� ������
$fp = file($guest_file);
	$num=sizeof($fp);
	// ���� ������ �������� "���", ����������� $numposts=sizeof($fp);
	if($numposts=='all')$numposts=$num;
// �������������� ������, ��� ����, ����� ��������� ��������� ����� ������
$fp = array_reverse($fp);
// ������� ���������.

for($i=0,$showed=0; $i<$num; $i++,$showed++){
list(,$postmes) = each($fp);
// ��������� ���������� ������� ������ �� �������� �������
$rec_info = explode("|", $postmes);
if(isset($rec_info[1])){
print '<table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
  <tr>';
print '<td class="td_box_top">'.$rec_info[0].". ".$rec_info[1].'</td>';
print '
</tr>
<tr>
<td class="td_box">';
print '<div align="justify">'.$rec_info[2].'</div>';
print '<span class="date"> ����: '.$rec_info[3].'</span>';
print '
</td>
</tr>
</table>'."\n".'
<span class="probel">&nbsp;</span>'."\n";
}else{
}

}

if($showed==0)echo '<h1>��������� ���</h1>'; else echo '<br>�������� <b>'.$showed.'</b> ��������� �� <b>'.$num.'</b>';
//////////// ���������� �������� �����
include("end_page.php");
?>