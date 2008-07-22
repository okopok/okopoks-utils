<?php
$files[SMARTY_CACHE_DIR] = scandir(SMARTY_CACHE_DIR);
$files[SMARTY_COMPILE_DIR] = scandir(SMARTY_COMPILE_DIR);
$files[HASHES_DIR] = scandir(HASHES_DIR);
foreach ($files as $dir => $arr)
{
  foreach ( $arr as $fl)
  {
    if($fl != '.' and $fl != '..') unlink($dir.$fl);
  }
}
?>