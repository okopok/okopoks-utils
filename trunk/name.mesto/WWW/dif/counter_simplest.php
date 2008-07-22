<?
    $fp=fopen("count.txt","r")or die ("Can't open file");
    $counted=fgets($fp,1024);
    fclose($fp);
    $counted=$counted+1;
    $fp=fopen("count.txt","w");
    fwrite($fp,$counted);
    fclose($fp);
    print "¬сего переходов по страницам сделано $counted";

?>
