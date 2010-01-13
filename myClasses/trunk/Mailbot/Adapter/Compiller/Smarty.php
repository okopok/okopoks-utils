<?php
/**
 * Smarty compiller adapter
 * Note: PHP4 compatible
 *
 * @author Sasha Molodtsov <amolodtsov@devz.ru>
 * @name Mailbot_Adapter_Compiller_Smarty
 * @category Mailbot
 * @package Mailbot_Adapter
 * @subpackage Compiller
 * @uses Mailbot_Adapter_Compiller_Abstract
 */
require_once('Abstract.php');
class Mailbot_Adapter_Compiller_Smarty extends Mailbot_Adapter_Compiller_Abstract
{
	var $__Smarty 				= null;
	var $__plugginsRegistered 	= false;
	var $__mysql 				= null;

	function Adapter_Compiller_Smarty()
	{
		require_once('system/Mailbot/External/Smarty/Smarty.class.php');
		$this->__Smarty = new Smarty();
		//$this->__Smarty->register_postfilter(array(&$this, '__smarty_save_compile'));
		$this->__Smarty->compile_dir 	= 'system/Mailbot/tmp/blocks_compile/';
		$this->__Smarty->compile_check = true;
		//$this->__Smarty->force_compile = true;
		//$this->__Smarty->debugging = true;
	}

	/**
	 * Set the database adapter
	 *
	 * @param Adapter_Db_Abstract $db
	 * @return bool
	 */
	function setDb(&$db)
	{
		if(is_object($db))
		{
			$this->__mysql = $db;
			return true;
		}else{
			return false;
		}
	}

	/**
	 * gets database adapter
	 *
	 * @return Adapter_Db_Abstract
	 */
	function getDb()
	{
		if(is_object($this->__mysql))
		{
			return $this->__mysql;
		}else{
			die('DB ADAPTER IS NOT SET IN '.__METHOD__);
		}
	}

	/**
	 * Регистрируем плаггины, только если они не были зарегистрированны и существует коннект к базе
	 *
	 * @return bool
	 */
	function __registerPluggins()
	{
		if(is_object($this->__mysql) && $this->__plugginsRegistered === false)
		{
			$this->__Smarty->register_resource("db",
								 array(&$this,
								 		"__smarty_db_get_template",
                                       	"__smarty_db_get_timestamp",
                                       	"__smarty_db_get_secure",
                                       	"__smarty_db_get_trusted")
                                       );
           $this->__plugginsRegistered = true;
		}
		return true;
	}

	/**
	 * назначаем переменные блоков
	 *
	 * @param string $key
	 * @param mixed $val
	 */
	function assign($key, $val)
	{
		$this->__Smarty->assign($key,$val);
	}

	/**
	 * Очищает массив, одну или все назначенные переменные смарти.
	 *
	 * @param string|array $key - может быть массивом или строкой
	 * @return bool
	 */
	function clearAssigned($key = null)
	{
		if($key)
		{
			$this->__Smarty->clear_assign($key);
		}else{
			$this->__Smarty->clear_all_assign();
		}
		return true;
	}

	/**
	 * парсим блок и возвращаем его содержимое
	 *
	 * @param string $name - название блока
	 * @return string
	 */
	function fetch($name)
	{
		//$smarty = $this->getSmarty();
		$this->__registerPluggins();
		return $this->__Smarty->fetch('db:'.$name);
	}

	/**
	 * выводим блок на экран
	 *
	 * @param string $name - название блока
	 * @return string
	 */
	function display($name)
	{
		//$smarty = $this->getSmarty();
		$this->__registerPluggins();
		return $this->__Smarty->display('db:'.$name);
	}

	function __smarty_save_compile($tpl_source, &$smarty)
	{
		if($this->__compile == null)
		{
			$this->__compile	 = $tpl_source;
		}

	    return $tpl_source;
	}
	// код в вашем скрипте
	function __smarty_db_get_template ($tpl_name, &$tpl_source, &$smarty_obj)
	{
	    // обращаемся к базе, запрашиваем код шаблона,
	    // перегружаем его в $tpl_source
	    $sql = $this->getDb();

	    if ($row = $sql->fetch("SELECT body FROM mailbot_block WHERE name='$tpl_name'"))
	    {
	        $tpl_source = $row['body'];
	        return true;
	    } else {
	        return false;
	    }
	}

	function __smarty_db_get_timestamp($tpl_name, &$tpl_timestamp, &$smarty_obj)
	{
	    // обращаемся к базе, запрашиваем поле $tpl_timestamp.
	    $sql = $this->getDb();
	    if ($row = $sql->fetch("SELECT update_ts FROM mailbot_block	WHERE name='$tpl_name'"))
	    {
	        $tpl_timestamp = strtotime($row['update_ts']);
	        return true;
	    } else {
	        return false;
	    }
	}

	function __smarty_db_get_secure($tpl_name, &$smarty_obj)
	{
	    // предполагаем, что наши шаблоны совершенно безопасны
	    return true;
	}

	function __smarty_db_get_trusted($tpl_name, &$smarty_obj)
	{
	    // не используется для шаблонов
	}

}