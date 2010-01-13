<?php
/**
 * Block class to agregate html blocks of code with php vars and compile it
 * Note: PHP4 compatible
 *
 * @name Mailbot_Block
 * @author Sasha Molodtsov <asid@mail.ru>
 * @since 27.04.2009
 * @package Mailbot
 */
class Mailbot_Block
{
	var $_id 	= null;
	var $_dataKeys  		= array('name','summary','body','update_ts');
	var $_dataContiue 		= array(
								'update'=>array('update_ts'),
								'create'=>array('update_ts')
							);

	var $_isValid 			= false;
	var $_data 				= array();
	var $_db 			= null;
	var $_Compiller			= null;
	var $_childs			= array();
	var $_childsRecursive 	= array();

	var $_registeredVars	= array();
	var $_varsByBlock  		= array();
	var $_varsById			= array();
	var $_errors			= array();

	/**
	 * Contstructor
	 *
	 * @param int $id
	 * @param Adapter_Db_Abstract $db
	 * @return Mailbot_Block
	 */
	function Mailbot_Block($id = 0,$db = null)
	{
		require_once('system/Mailbot/Adapter/Compiller/Smarty.php');
		$this->_Compiller = new Adapter_Compiller_Smarty();

		$this->setDb($db);

		if ((int)$id)
		{
			$this->load((int)$id);
		}
	}

	/**
	 * Load block
	 *
	 * @param int $key - block_id
	 * @return array
	 */
	function load($key)
	{
		$sql = "SELECT id, ".implode(', ', $this->_dataKeys)." FROM mailbot_block WHERE ";
		$db = $this->getDb();

		if(is_numeric($key))
		{
			$sql .= " id = ".(int)$key;
		}else{
			$sql .= " name = '".$db->quote($key)."'";
		}
		$sql .= " LIMIT 1";
		$data = $db->fetch($sql);

		if(is_array($data))
		{
			$this->_id = $data['id'];
			unset($data['id']);
			$this->_data = $data;
			return $data;
		}
		return false;
	}

	/**
	 * Returns block data
	 *
	 * @return array
	 */
	function getData()
	{
		return $this->_data;
	}

	/**
	 * Delete Block
	 *
	 * @return bool
	 */
	function delete()
	{
		if(!$this->_id)
		{
			$this->_errors[] = 'id is not set in '.__FILE__.' :: '.__CLASS__.' :: '.__FUNCTION__.' :: line '.__LINE__; return false;
		}
		$sql = "DELETE FROM mailbot_block WHERE id = ".(int)$this->_id;
		$db = $this->getDb();
		$db->query($sql);
		return true;
	}

	/**
	 * Update block
	 *
	 * @param array $array - array of data to update block
	 * @return bool
	 */
	function update($array)
	{
		if(!$this->_id)
		{
			$this->_errors[] = 'id is not set in '.__FILE__.' :: '.__CLASS__.' :: '.__FUNCTION__.' :: line '.__LINE__; return false;
		}
		$str = array();
		$db = $this->getDb();
		foreach ($array as $key=>$val)
		{
			if(in_array($key,$this->_dataContiue['update'])) continue;
			$str[] = $key.' = "'.$db->quote($val).'"';
		}
		$sql = "UPDATE mailbot_block SET ".implode(' , ', $str)." WHERE id = ".(int)$this->_id;
		$db->query($sql);
		if($db->affected_rows() > 0)
		{
			$this->load(reset($db->fetch('SELECT LAST_INSERT_ID()')));
			return true;
		}
		return false;
	}

	/**
	 * Create block
	 *
	 * @param array $array - array of data to create block
	 * @return bool
	 */
	function create($array)
	{
		$str = array();
		$db = $this->getDb();
		foreach ($array as $key=>$val)
		{
			if(in_array($key, $this->_dataContiue['create'])) continue;
			$str[] = $key.' = "'.$db->quote($val).'"';
		}
		$sql = "INSERT INTO mailbot_block SET ".implode(' , ', $str);
		$db->query($sql);
		if($db->affected_rows() > 0)
		{
			$this->load(reset($db->fetch('SELECT LAST_INSERT_ID()')));
			return true;
		}
		return false;
	}

	/**
	 * Get compiller registered vars
	 *
	 * @return array
	 */
	function getRegisteredVars()
	{
		return $this->_registeredVars;
	}

	/**
	 * get errors
	 *
	 * @return array
	 */
	function getErrors()
	{
		return $this->_errors;
	}

	/**
	 * get vars from this block
	 *
	 * @param int $id - block_id
	 * @return array
	 */
	function getVars($id = false)
	{
		if($id == false)
		{
			if(!$this->_id)
			{
				$this->_errors[] = 'id is not set in '.__FILE__.' :: '.__CLASS__.' :: '.__FUNCTION__.' :: line '.__LINE__; return false;
			}
			$id = $this->_id;
		}
		if(!isset($this->_varsByBlock[$id]))
		{
			$db = $this->getDb();
			$sql = "
				SELECT
					v.id, v.name, v.summary, v.is_mandatory, v.default, bv.block_id
				FROM mailbot_variable AS v
				INNER JOIN mailbot_block_var AS bv ON bv.variable_id = v.id
				WHERE block_id = ".(int)$id."
			";
			$data = $db->fetch($sql);
			if(is_array($data) and !empty($data))
			{
				$this->_setVarsAssoc(array($data));
			}else{
				$this->_varsByBlock[$id] = array();
			}
		}
		return $this->_varsByBlock[$id];
	}

	/**
	 * get vars from block and his subblocks
	 *
	 * @param bool $by_id - is key of vars will be int or string
	 * @return array
	 */
	function getAllVars($by_id = false)
	{
		if(!$this->_id)
		{
			$this->_errors[] = 'id is not set in '.__FILE__.' :: '.__CLASS__.' :: '.__FUNCTION__.' :: line '.__LINE__; return false;
		}
		$childs 	= $this->getChilds();
		$childs[]	= $this->_id;

		$data = array();

		foreach ($childs as $block_id)
		{
			$data = array_merge($data, $this->getVars($block_id, $by_id));
		}
		if($by_id)
		{
			return $this->_varsById;
		}
		return $data;
	}

	/**
	 * get subblocks of this block
	 *
	 * @param int $id - block_id
	 * @return array
	 */
	function getChilds($id = false)
	{

		if($id == false)
		{
			if(!$this->_id)
			{
				$this->_errors[] = 'id is not set in '.__FILE__.' :: '.__CLASS__.' :: '.__FUNCTION__.' :: line '.__LINE__; return false;
			}
			$id = $this->_id;
			if(isset($this->_childsRecursive[$id]) && is_array($this->_childsRecursive[$id]))
			{
				return $this->_childs;
			}
		}

		if(!isset($this->_childsRecursive[$id]))
		{
			$db = $this->getDb();
			$sql = "SELECT include_id FROM mailbot_block_inc WHERE block_id = ".(int)$id;
			$data = $db->fetchAll($sql);
			if(is_array($data) and !empty($data))
			{
				foreach ($data as $val)
				{
					$this->_childsRecursive[$id][] = $val['include_id'];
				}
			}
		}

		if(isset($this->_childsRecursive[$id]) && is_array($this->_childsRecursive[$id]))
		{

			foreach ($this->_childsRecursive[$id] as $val)
			{
				$this->_childs[] = $val;
				$this->getChilds($val);
			}
		}
		natcasesort($this->_childsRecursive);
		sort($this->_childs);
		return array_unique($this->_childs);
	}

	/**
	 * gets database adapter
	 *
	 * @return Adapter_Db_Abstract
	 */
	function getDb()
	{
		if(is_object($this->_db))
		{
			return $this->_db;
		}else{
			die('DB ADAPTER IS NOT SET IN '.__METHOD__);
		}
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
			$this->_db = $db;
			$this->_Compiller->setDb($db);
			return true;
		}
		return false;
	}

	/**
	 * Set vars to compiller with validation
	 *
	 * @param array $data - hash with key=>val data
	 * @param bool $by_id - set is key is int or string
	 * @return bool
	 */
	function setVars($data, $by_id = false)
	{
		foreach ($this->getAllVars($by_id) as $key => $var)
		{
			// if field is mandatory, it is not set or it's emptry and default field is empty, then set errors mes that filen is not valid
			if($var['is_mandatory'] && (!isset($data[$key]) || !strlen($data[$key])) && !strlen($var['default']))
			{
				if(!isset($data[$key]))
				{
					$var[errors][] = 'not set and there is no default value';
				}elseif(!strlen($data[$key]))
				{
					$var[errors][] = 'is empty and there is no default value';
				}
				$this->_errors['lostvars'][] = $var;
				$this->_isValid = false;
				return $this->_isValid;
			}
		}

		$this->_isValid = true;
		foreach ($this->getAllVars($by_id) as $key => $var)
		{
			$assign_key = $key;
			if($by_id)
			{
				$assign_key = $var['name'];
			}
			if(isset($data[$key]) && strlen($data[$key]))
			{
				$this->_Compiller->assign($assign_key, $data[$key]);
				$this->_registeredVars[$assign_key] = $data[$key];
			}else if(strlen($var['default']))
			{
				$this->_Compiller->assign($assign_key, $var['default']);
				$this->_registeredVars[$assign_key] = $var['default'];
			}
		}
		return $this->_isValid;
	}

	/**
	 * set vars to assoc arrays
	 *
	 * @access private method
	 * @param array $data
	 */
	function _setVarsAssoc($data)
	{
		foreach ($data as $arr)
		{
			$this->_varsById[$arr[id]] 						= $arr;
			$this->_varsByBlock[$arr[block_id]][$arr[name]] = $arr;
		}

	}

	/**
	 * answer if block is valid
	 *
	 * @return bool
	 */
	function isValid()
	{
		return $this->_isValid;
	}

	/**
	 * compile and return the block
	 *
	 * @return string
	 */
	function fetch()
	{
		if(!$this->_id)
		{
			$this->_errors[] = 'id is not set in '.__FILE__.' :: '.__CLASS__.' :: '.__FUNCTION__.' :: line '.__LINE__; return false;
		}
		if(!$this->isValid())
		{
			$this->_errors[] =  'block is not valid in '.__FILE__.' :: '.__CLASS__.' :: '.__FUNCTION__.' :: line '.__LINE__; return false;
		}
		$out = $this->_Compiller->fetch($this->_data['name']);
		$this->_Compiller->clearAssigned();
		return $out;
	}

}