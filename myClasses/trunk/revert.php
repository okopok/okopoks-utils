<?php

$hash = array(
'q'=>'�','w'=>'�','e'=>'�','r'=>'�','t'=>'�','y'=>'�','u'=>'�',
'i'=>'�','o'=>'�','p'=>'�','['=>'�',']'=>'�','a'=>'�','s'=>'�',
'd'=>'�','f'=>'�','g'=>'�','h'=>'�','j'=>'�','k'=>'�','l'=>'�',
';'=>'�','\''=>'�','z'=>'�','x'=>'�','c'=>'�','v'=>'�','b'=>'�',
'n'=>'�','m'=>'�',','=>'�','.'=>'�','Q'=>'�','W'=>'�','E'=>'�',
'R'=>'�','T'=>'�','Y'=>'�','U'=>'�','I'=>'�','O'=>'�','P'=>'�',
'{'=>'�','}'=>'�','A'=>'�','S'=>'�','D'=>'�','F'=>'�','G'=>'�',
'H'=>'�','J'=>'�','K'=>'�','L'=>'�',':'=>'�','"'=>'�','Z'=>'�',
'X'=>'�','C'=>'�','V'=>'�','B'=>'�','N'=>'�','M'=>'�','<'=>'�',
'>'=>'�');
$hash = array_merge ($hash, array_flip($hash));

function revert($word)
{
	global $hash;
	$newWord = '';
	for($i = 0; $i < strlen($word); $i++)
	{
	  $bukva = $word[$i];
	  foreach($hash as $buk1 => $buk2){
		if($word[$i] == $buk1)
		{
			$bukva = $buk2;
			break;
		}
	  }
	  $newWord .= $bukva;
	}
	return $newWord;
}


if(isset($_FILES['list']['tmp_name']))
{
	$file = file($_FILES['list']['tmp_name']);
	$implode = array();
	foreach ($file as $line)
	{
		$implode[]	= '"'.trim($line).'";"'.revert(trim($line)).'"';
	}
	file_put_contents(dirname(__FILE__).'/reverter.csv', implode("\n", $implode));
	print "<a href='reverter.csv'>file</a>";
}

?>

<form enctype="multipart/form-data" method="POST">
	<input type="file" name="list">
	<input type="submit">
</form>
