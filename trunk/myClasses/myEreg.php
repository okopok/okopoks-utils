<?php
///print_r(MyEreg('1 pivo','pivo 1246 234'));
/**
 * Вырезает все лишние символы из строк и запускает функция проверки на схожесть
 *
 * @param string $str1 - строка 1
 * @param string $str2 - строка 2
 * @return array
 */
function MyEreg($str1, $str2, $make = true){
  if($make == true)
  {
    $str1 = trim(preg_replace('|[_]{2,}|','_', preg_replace('|[^a-zа-я0-9]|i', '_', $str1)),'_');
    $str2 = trim(preg_replace('|[_]{2,}|','_', preg_replace('|[^a-zа-я0-9]|i', '_', $str2)),'_');
  }
  if($str1 == $str2) return array(0,0);
  return array(matrixEregi($str1,$str2),checkStrings($str1,$str2, $make));
}


/**
 * Возвращает разницу в буквах между двумя строками
 *
 * @param string $str1 - строка 1
 * @param string $str2 - строка 2
 * @return int
 */
function matrixEregi($str1, $str2){
    $str1_chars  = count_chars($str1,1);
    $str2_chars = count_chars($str2,1);
    $limiter = 0;

    if(count($str1_chars) >= count($str2_chars)){
      $char_mas_big = $str1_chars;
      $char_mas_sml = $str2_chars;
    }else{
      $char_mas_big = $str2_chars;
      $char_mas_sml = $str1_chars;
    }
    $nums_sml = $nums_big = array();
    foreach($char_mas_big as $let_key => $num_lets){
      if(isset($char_mas_sml[$let_key]))
      {

        if($char_mas_sml[$let_key] > $num_lets){
          $limiter = abs(abs($limiter) + ($char_mas_sml[$let_key] - $num_lets));
        }else{
          $limiter = abs(abs($limiter) + ($num_lets - $char_mas_sml[$let_key]));
        }
        unset($char_mas_sml[$let_key]);
        unset($char_mas_big[$let_key]);
      }
    }
    foreach($char_mas_sml as $let_key => $num_lets){
     $limiter = abs($limiter) + $num_lets;
    }
    foreach($char_mas_big as $let_key => $num_lets){
     $limiter = abs($limiter) + $num_lets;
    }
    return $limiter;
  }

  /**
   * функция меняет слова местами и если сравнивает слова. Если все слова совпадают, то строки одинаковые
   *
   * @param string $str1 - строка 1
   * @param string $str2 - строка 2
   * @param string $exploder - тип пробелов между слов
   * @return int
   */
  function checkStrings($str1, $str2,  $make = true, $exploder = '_')
  {
    if($make == true)
    {
      $str1 = strtolower(trim(preg_replace("|[$exploder]{2,}|",$exploder, preg_replace('|[^\w]|i',$exploder,$str1)),$exploder));
      $str2 = strtolower(trim(preg_replace("|[$exploder]{2,}|",$exploder, preg_replace('|[^\w]|i',$exploder,$str2)),$exploder));
    }
    if(strlen($str1) != strlen($str2)) return false;
    $str1Mas = explode($exploder, $str1);
    $str2Mas = explode($exploder, $str2);
    if(sizeof(array_diff($str1Mas,$str2Mas)) == 0 and sizeof(array_diff($str2Mas,$str1Mas)) == 0){
      return true;
    }else{
      return false;
    }
  }

?>