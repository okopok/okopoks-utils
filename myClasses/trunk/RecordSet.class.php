<?php

/**
 * ����� ��������� ������������� ������ ������� � ��
 * @author Kostya Pereverzev
 * @version 2.0
 */
 
 
 
class RecordSet {

	/**
	 * ����� ����������
	 *
	 * @var int
	 */
	var $records_count;

	/**
	 * ���������� �������
	 *
	 * @var int
	 */
	var $pages_count;

	/**
	 * ������� ��������
	 *
	 * @var int
	 */
	var $current_page;

	/**
	 * ������� ��������
	 *
	 * @var array
	 */
	var $page_scope = array('start' => 0, 'end' => 0);

	/**
	 * ������ �����������
	 *
	 * @var array
	 */
	var $result = array();

	/**
	 * ������ � �������� �������
	 *
	 * @var array
	 */
	var $pages;

	/**
	 * ������ ���������� ������� ������
	 *
	 * @param string $count_query ������ ������ ���������� �����������
	 * @param int $page_limit ���������� ����������� �� ��������
	 * @return int
	 */
	function __count_pages ($page_limit) {

		$result = mysql_query("SELECT FOUND_ROWS()");
		$this->records_count = intval(mysql_result($result, 0, 0));

		return ceil($this->records_count/$page_limit);

	}

	/**
	 * ������ ��������� ������
	 *
	 * @param ������� �������� $page_start
	 * @param ���������� ������� �� �������� $page_limit
	 * @return int
	 */
	function __get_start_record ($page_start, $page_limit) {

		return ($page_start - 1) * $page_limit;
	}

	/**
	 * ����� ������ �������
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
	 * ����������� ������ RecordSet
	 *
	 * @param string $result_query ������ �����������
	 * @param int $page_limit ���������� ����������� �� ��������
	 * @param int $page_start ����� �������� ��� ������ �����������
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

������

$sql = 'SELECT SQL_CALC_FOUND_ROWS * FROM asda';
$aha = new RecordSet($sql, 20, 1);
print_r($aha);
*/

?>