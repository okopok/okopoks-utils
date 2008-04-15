<?php

/**
 * @author  - Molodtsov Sasha <asid@mail.ru>
 * @package - utils
 * @since   - 28.11.2007
 * @version - 1.4
 * @todo    - make graphical output, calculate time (estimate, finish, total, start, per proc, per iter)
 *
 * example:
 * $progBar = new ProgressBar(32112, 1);
 * or (for each counter)
 * $progBar->setEvery(10);
 * $progBar->setTotal(32112);
 *
 * for($i = 1; $i <= 32112; $i++)
 * {
 *   usleep(5);
 *   if($progBar->iterator($i))
 *   {
 *     print $this->printOut();
 *   }
 * }
 * print 'done';
 */


class ProgressBar
{
  var $total;
  var $oneProc;

  var $every    = 5;
  var $current  = 5;
  var $currIter = 0;

  var $lastIterTime       = 0;
  var $lastIterTimeStamp  = 0;
  var $midIterTime        = 0;
  var $startTime          = 0;
  var $printReady         = false;

  function ProgressBar($total = 0, $every = 5)
  {
    if($total > 0)
    {
      $this->setTotal($total);
    }
    $this->setEvery($every);
  }



  /**
   * set total iterations
   *
   * @param int $num
   */
  function setTotal($num)
  {
    if(!is_numeric($num) or $num == 0) die($num . ' - is not a number');
    $this->total    = $num;
    $this->oneProc  = $num / 100;
  }

  /**
   * set print when procent exists
   *
   * @param int $num
   */
  function setEvery($num)
  {
    if(!is_numeric($num) or $num == 0) die($num . ' - is not a number');
    $this->every    = $num;
    $this->current  = $num;
  }

  /**
   * get current procent
   *
   * @param int $num
   * @return int
   */
  function getCurrentProc($num)
  {
    if(!is_numeric($num)) die($num . ' - is not a number');
    return floor($num / $this->oneProc);
  }

  /**
   * get procents left
   *
   * @param int $num
   * @return int
   */
  function getLeftProc($num)
  {
    if(!is_numeric($num)) die($num . ' - is not a number');
    return (100 - $this->getCurrentProc($num));
  }

  /**
   * get iterations left
   *
   * @param int $num
   * @return int
   */
  function getLeftIters($num)
  {
    if(!is_numeric($num)) die($num . ' - is not a number');
    return ($this->total - $num);
  }



  /**
   * set's iterations and timer
   *
   * @param int $num
   * @return bool
   */
  function iterator($num)
  {
     $this->currIter = $num;
     $this->timer();
     if( $this->getCurrentProc($this->currIter) >= $this->current )
     {
       $this->current+= $this->every;
       return true;
     }else{
       return false;
     }
  }

  /**
   *
   * prints template if procent exists
   *
   * ::cp:: - get current procent
   * ::pl:: - get procents left
   * ::il:: - get iterations left
   * ::tl:: - get time left
   * ::ti:: - get this iteration time
   * ::ft:: - get finish time
   *
   * @param int $num
   * @param string $shab
   * @return string
   */
  function printOut($shab = '::cp::% - ::pl::% - ::il:: - ::tl:: - ::ti:: - ::ft::')
  {
    $shab = str_replace('::cp::', $this->getCurrentProc($this->currIter), $shab);
    $shab = str_replace('::pl::', $this->getLeftProc($this->currIter), $shab);
    $shab = str_replace('::il::', $this->getLeftIters($this->currIter), $shab);
    $shab = str_replace('::tl::', $this->getLeftTime($this->currIter), $shab);
    $shab = str_replace('::ti::', $this->getThisIterTime($this->currIter), $shab);
    $shab = str_replace('::mi::', $this->getMidIterTime(), $shab);
    $shab = str_replace('::ft::', $this->getFinishTime($this->currIter), $shab);
    return $shab;
  }


  /**
   * set times
   *
   */
  function timer()
  {
    if($this->startTime == 0)
    {
      $this->startTime = microtime(1);
    }

    if($this->lastIterTime > 0 and $this->lastIterTimeStamp > 0)
    {
      $this->midIterTime = ($this->lastIterTime + (microtime(1) - $this->lastIterTimeStamp)) / 2;
    }

    if($this->lastIterTimeStamp > 0)
    {
      $this->lastIterTime    =  microtime(1) - $this->lastIterTimeStamp;
      $this->allItersTimes[] = $this->lastIterTime;
    }
    $this->lastIterTimeStamp = microtime(1);
  }

  /**
   * get this iteration time
   *
   * @return int
   */
  function getThisIterTime()
  {
    if($this->lastIterTimeStamp > 0)
    {
      return microtime(1) - $this->lastIterTimeStamp;
    }else{
      return 0;
    }
  }

  function getTotalTime()
  {

  }

  /**
   * middle iteration time
   *
   * @param int $num
   * @return int
   */
  function getMidIterTime()
  {
    return $this->midIterTime;
  }

  /**
   * finish time in unix time
   *
   * @param int $num
   * @return int
   */
  function getFinishTime($num)
  {
    return ceil($this->getLeftTime($num) + time());
  }

  /**
   * time left in seconds
   *
   * @param int $num
   * @return int
   */
  function getLeftTime($num)
  {
    if(count($this->allItersTimes) > 0)
    {
      return abs(ceil(array_sum($this->allItersTimes) / count($this->allItersTimes) * $this->getLeftIters($num)));
    }else{
      return 0;
    }
  }

}

/*
  $progBar = new ProgressBar(32112, 1);
  //or (for each counter)
  $progBar->setEvery(10);
  $progBar->setTotal(32112);

  for($i = 1; $i <= 32112; $i++)
  {
    usleep(10);
    if($progBar->iterator($i))
    {
      print $progBar->printOut('::ti::')." sec | ";
      print $progBar->printOut('::mi::')." sec | ";
      print $progBar->printOut('::tl::')." sec | ";
      print date('r', $progBar->printOut('::ft::'))."\n";
    }
  }
 print 'done';
*/
?>