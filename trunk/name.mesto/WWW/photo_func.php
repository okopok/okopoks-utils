<?
function list_dirs(){
global $path;
$dh = opendir($path);
while ($file  = readdir($dh)){
	if(eregi('\.',$file)==true){
		continue;
	}
	if(is_dir($path.$file.'/')){
		$f=0;
		$mdirname='';
		@$page = fopen ($path.$file.'/readme.txt', "r");
		@$mdirname = fgets($page, 4096);
		@fclose ($page);
		
		echo "<font size=3><b>";
		if(@$mdirname){ echo $mdirname; }else{ echo $file;}
		echo "</b></font> <br>";
		$a_dirs[]=$file;
		$dvl = opendir($path.$file);
		while ($file_vl  = readdir($dvl)){
		if(eregi('\.',$file_vl)==true){
			continue;
		}
		$dfiles = opendir($path.$file.'/'.$file_vl);
		$i=0;
		while ($files  = readdir($dfiles)){
			$rash = substr($files, -3);
			if(($rash=='JPG') or ($rash=='jpg')){
				$i=1;
				@$page = fopen ($path.$file.'/'.$file_vl.'/readme.txt', "r");
				@$name = fgets($page, 4096);
				@fclose ($page);
			}else{
				continue;
			}
		}
		if(strlen($name)==0) $name='посмотреть';
		echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
		echo '<a href=photos.html?mdir='.$file.'&page='.$file_vl.'><b>'.$name.'</b></a> - папка '.$file_vl;
		closedir($dfiles);
		echo '<br>';
		$a_dirs_vl[]=$file_vl;
		$f=1;
		}
		if($f==0){ 
		echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
		echo '<a href=photos.html?page='.$file.'><b>посмотреть</b></a>';
		}
		closedir($dvl);
		echo "<br><br>";
	}
}
closedir($dh);
}

?>