<?php 

/**

вызывается вот так
     $sql_template = array(
          "select" => "*",
          "from" => DB_MESSAGES_TABLE."",
          "where" => ""
     );
     
     $pager = new pager($sql_template,$mysql,10,10);
     
     prr($pager->get_messages(1));

*/
class pager
{
	var $mysql;
	
	var $status = array();
	var $errors = array();
		
	var $mess_on_page;
	var $pages_count;
	var $all_mess_count;
	
	var $sql_from;
	var $sql_select;
	var $sql_where;
	var $sql_order;
	
	function pager($sql_template,&$mysql,$mess_on_page,$pages_count)
	{
		$this->add_status("Конструктор");
		
		if (!is_array($sql_template))
		{
			$this->add_errors("Не передан шаблон построения sql");
		}
		else if (!isset($sql_template['from']))
		{
			$this->add_errors("Не задан обязательный элемент 'from'");
		}
		else 
		{
			$this->sql_from = mysql_real_escape_string($sql_template['from']);
			
			if (isset($sql_template['select']))
			{
				$this->sql_select = mysql_real_escape_string(trim($sql_template['select']));
			}
			else 
			{
				$this->sql_select = "*";
			}
			
			if (isset($sql_template['where']))
			{
				$this->sql_where = mysql_real_escape_string(trim($sql_template['where']));
			}
			else 
			{
				$this->sql_where = "";
			}

			if (isset($sql_template['order']))
			{
				$this->sql_order = mysql_real_escape_string(trim($sql_template['order']));
			}
			else 
			{
				$this->sql_order = "";
			}
		}
		
		if($mysql)
		{
			$this->mysql = $mysql;
		}
		else 
		{
			$this->add_errors("Не передан класс mysql");
		}
		
		if (intval($mess_on_page) && $mess_on_page > 0)
		{
			$this->mess_on_page = abs(intval($mess_on_page));
		}
		else 
		{
			$this->add_errors("Количество сообщений на странице не верно задано");
		}
		
		if (intval($pages_count) && $pages_count > 0)
		{
			$this->pages_count = abs(intval($pages_count));
		}
		else 
		{
			$this->add_errors("Количество страниц неверно задано");
		}
		
		if (!($this->all_mess_count = $this->get_all_mess_count()))
		{
			$this->add_errors("Не удалось получить общее количество страниц. Ошибка:".print_r($this->mysql->get_error(),1));
		}
		
		$this->add_status("Конструктор закончен");
	}
	
	function get_messages($page)
	{
		if (!intval($page) || (intval($page) * $this->mess_on_page) > $this->all_mess_count)
		{
			$this->add_errors("Неверно задан номер страницы");
			return false;
		}
		
		if (count($this->errors))
		{
			return false;
		}
		
		if ($sql = $this->prepare_sql(intval($page)))
		{
			if ($result = $this->mysql->getData($sql))
			{
				return $result;
			}
			else 
			{
				$this->add_errors("Не удалось получить сообщения. Ошибка:".print_r($this->mysql->get_error(),1));
				return false;
			}
		}
		else 
		{
			$this->add_status("Не удалось собрать запрос");
			return false;
		}
	}
	
	function prepare_sql($page)
	{
		$sql = "SELECT ".$this->sql_select." FROM ".$this->sql_from." ";
		
		if (strlen($this->sql_where))
		{
			$sql .= "WHERE ".$this->sql_where." ";
		}
		
		if (strlen($this->sql_order))
		{
			$sql .= "ORDER BY ".$this->sql_order." ";
		}
		
		$limit_start	= $this->mess_on_page * $page;
				
		$sql .= "LIMIT ".$limit_start.",".$this->mess_on_page." ";
		
		return $sql;
	}
	
	function get_all_mess_count()
	{
		$this->add_status("Пытаемся получить общее количество страниц");
		
		$sql = "SELECT count(*) AS count FROM ".$this->sql_from." ";
		
		if (strlen($this->sql_where))
		{
			$sql .= "WHERE ".$this->sql_where;
		}
		
		$result = $this->mysql->getData($sql);
		
		if ($this->mysql->returned_rows)
		{
			return $result[0]['count'];
		}
		else 
		{
			return false;
		}
	}
	
	function add_status($str)
	{
		$this->status[time()] = $str;
	}
	
	function add_errors($str)
	{
		$this->add_status(time()." ошибка");
		$this->errors[time()] = $str;
	}
	
	function get_status()
	{
		return $this->status;
	}
	
	function get_errors()
	{
		return $this->errors;
	}
}
?>