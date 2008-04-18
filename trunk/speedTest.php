<?php

/**
 * tests user functions for speed
 *
 * @param string  $medthod_name  - user func
 * @param array   $args          - arguments
 * @param int     $iterations    - number of calls
 * @param bool    $showArguments - print argument to output hash. It can be usefull if arguments has a lof of text
 * @param bool    $printOutput   - print output of user funcs or not
 * @param bool    $flushReturns  - flushing methods return for memory cleaning if return makes a lot of stuff
 * @return array                 - middle time of all iterations and total time of test
 */
function speedTest($medthod_name, $args = array(), $iterations = 1000, $showArguments = false, $printOutput = false, $flushReturns = false){
  if(!is_callable($medthod_name))
  {
    print "Method $medthod_name isn't callable!";
    die;
  }
  $ttime = microtime(true);
  $times = $output = array();


  for ($i = 0; $i < $iterations; ++$i)
  {
    ob_start();
    $st       = microtime(true);
    $output[] = call_user_func_array($medthod_name,$args);
    $times[]  = microtime(true) - $st;
    if($printOutput == true)
    {
      $content[] = ob_get_flush();
    }else{
      $content[] = ob_get_clean();
    }
    if($flushReturns == true) $output = array();
  }
  $mtime = array_sum($times) / count($times);
  $ttime = microtime(true) - $ttime;
  $arr = array(
    'medthodName' => $medthod_name,
    'arguments'   => $args,
    'iteratioons' => $iterations,
    'middleTime'  => $mtime,
    'totalTime'   => $ttime,
    'output'      => $output,
    'content'     => $content
  );
  if($showArguments == false) unset($arr['arguments']);
  return $arr;
}

