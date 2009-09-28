<?php

$hash = array(
'q'=>'é','w'=>'ö','e'=>'ó','r'=>'ê','t'=>'å','y'=>'í','u'=>'ã',
'i'=>'ø','o'=>'ù','p'=>'ç','['=>'õ',']'=>'ú','a'=>'ô','s'=>'û',
'd'=>'â','f'=>'à','g'=>'ï','h'=>'ð','j'=>'î','k'=>'ë','l'=>'ä',
';'=>'æ','\''=>'ý','z'=>'ÿ','x'=>'÷','c'=>'ñ','v'=>'ì','b'=>'è',
'n'=>'ò','m'=>'ü',','=>'á','.'=>'þ','Q'=>'É','W'=>'Ö','E'=>'Ó',
'R'=>'Ê','T'=>'Å','Y'=>'Í','U'=>'Ã','I'=>'Ø','O'=>'Ù','P'=>'Ç',
'{'=>'Õ','}'=>'Ú','A'=>'Ô','S'=>'Û','D'=>'Â','F'=>'À','G'=>'Ï',
'H'=>'Ð','J'=>'Î','K'=>'Ë','L'=>'Ä',':'=>'Æ','"'=>'Ý','Z'=>'ß',
'X'=>'×','C'=>'Ñ','V'=>'Ì','B'=>'È','N'=>'Ò','M'=>'Ü','<'=>'Á',
'>'=>'Þ');
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
