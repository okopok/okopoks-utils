<?php

/**
 * tests user functions for speed
 *
 * @param string $medthod - user func
 * @param array $args - arguments
 * @param int $iterations - number of calls
 * @param bool $printOutput - print output of user funcs or not
 * @return array - middle time of all iterations and total time of test
 */
function speedTest($medthod, $args = array(), $iterations = 1000, $showArguments = false, $printOutput = false){
  if(!is_callable($medthod))
  {
    print "Method $medthod isn't callable!";
    die;
  }
  $ttime = microtime(true);
  $times = array();
  if($printOutput == false) ob_start();
  for ($i = 0; $i < $iterations; ++$i){
    $st = microtime(true);
    call_user_func_array($medthod,$args);
    $times[] = microtime(true) - $st;
  }
  $content = ob_get_clean();

  $mtime = array_sum($times) / count($times);
  $ttime = microtime(true) - $ttime;
  $arr = array(
    'medthodName' => $medthod,
    'arguments'   => $args,
    'iteratioons' => $iterations,
    'middleTime'  => $mtime,
    'totalTime'   => $ttime,
    'content'     => $content
  );
  if($showArguments == false) unset($arr['arguments']);
  if($printOutput   == false) unset($arr['content']);
  return $arr;
}

