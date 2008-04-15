<?php

/**
 * Класс обработки постраничного вывода запроса к БД
 * @author Kostya Pereverzev
 * @version 2.0
 */
 
 
 
class RecordSet {

	/**
	 * Длина результата
	 *
	 * @var int
	 */
	var $records_count;

	/**
	 * Количество страниц
	 *
	 * @var int
	 */
	var $pages_count;

	/**
	 * Текущая страница
	 *
	 * @var int
	 */
	var $current_page;

	/**
	 * Границы страницы
	 *
	 * @var array
	 */
	var $page_scope = array('start' => 0, 'end' => 0);

	/**
	 * Массив результатов
	 *
	 * @var array
	 */
	var $result = array();

	/**
	 * Массив с номерами страниц
	 *
	 * @var array
	 */
	var $pages;

	/**
	 * Расчет количества страниц вывода
	 *
	 * @param string $count_query запрос общего количества результатов
	 * @param int $page_limit количество результатов на страницу
	 * @return int
	 */
	function __count_pages ($page_limit) {

		$result = mysql_query("SELECT FOUND_ROWS()");
		$this->records_count = intval(mysql_result($result, 0, 0));

		return ceil($this->records_count/$page_limit);

	}

	/**
	 * Расчет начальной записи
	 *
	 * @param текущая страница $page_start
	 * @param количество записей на страницу $page_limit
	 * @return int
	 */
	function __get_start_record ($page_start, $page_limit) {

		return ($page_start - 1) * $page_limit;
	}

	/**
	 * Вывод списка страниц
	 *
	 * @return array
	 */
	function __list_page_numbers () {

		$pages = array();

		for ($i=1; $i<=$this->pages_count; $i++) {
			$pages[] = $i;
		}

		return $pages;
	}

	/**
	 * Конструктор обекта RecordSet
	 *
	 * @param string $result_query запрос результатов
	 * @param int $page_limit количество результатов на страницу
	 * @param int $page_start номер страницы для вывода результатов
	 * @return RecordSet
     
     

	 */
	function RecordSet($result_query, $page_limit = 20, $page_start = 1, $print_query = false ) {

		$page_start = intval($page_start);
		$this->current_page = $page_start;
		$result_query = $result_query . " LIMIT " . $this->__get_start_record($page_start, $page_limit) . ", $page_limit";
		//

		if($print_query == true)
		{
		  print "<br/><xmp>\n".$result_query."\n</xmp>\n<br/>\n";
		}
		$result = mysql_query($result_query) or die(mysql_error());

		$this->pages_count = $this->__count_pages($page_limit);

		$i = $this->__get_start_record($page_start, $page_limit) + 1;

		$this->page_scope['start'] = $i;

		while ($line = mysql_fetch_assoc($result))
		{
			$this->result[$i] = $line;
			$this->page_scope['end'] = $i;
			$i++;
		}

		$this->pages = $this->__list_page_numbers();

	}

}

/*

пример

$sql = 'SELECT SQL_CALC_FOUND_ROWS * FROM asda';
$aha = new RecordSet($sql, 20, 1);
print_r($aha);
*/

?>