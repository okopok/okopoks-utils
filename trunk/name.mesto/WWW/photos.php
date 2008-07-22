<?
$title="Наши фотки";
include("start_page.php");
include("photo_func.php");
$path='photos/';

if(isset($_GET['mdir'])) $path.=$_GET['mdir'].'/';

if(isset($_GET['page'])){
	$path.=$_GET['page'];
	$photo_page = opendir($path);
	$i=0;
	@$page = fopen ($path.'/readme.txt', "r");
	@$name = fgets($page, 4096);
	@fclose ($page);

	echo '<table align="center" border=0>
	<tr><th colspan=5>'.$name.'</th></tr>
	<tr class="text" align="center" valign="top">';
	$f=0;
	while ($file  = readdir($photo_page)){
		$rash = substr($file, -3);
		if(($rash=='JPG') or ($rash=='jpg')){
			$i=1;
			$f++;
			}else{
				continue;
		}
echo '	<td>
	<a href="'.$path.'/'.$file.'">
	<img src="v_tn_img.php?img='.$path.'/'.$file.'" border="0">
	</a><br>'.$file.'</td>
';
		if($f==7){
			echo '</tr><tr class="text" align="center" valign="top">';
			$f=0;
		}
	}
	echo '</tr></table>';
}else{
echo '<span class="text">';
list_dirs();
echo '</span>';
}
include("end_page.php");

?>