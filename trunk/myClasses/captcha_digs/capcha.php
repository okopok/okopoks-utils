<?php
	require($_SERVER['DOCUMENT_ROOT']."/classes/capchaClass.php");
	session_start();
	$codestr = uniqid('a');
	$code = substr($codestr, strlen($codestr)-5, 5);
	$_SESSION['captcha_code'] = $code;

	$c = new capcha(120, 50);
	$c->show();
?>