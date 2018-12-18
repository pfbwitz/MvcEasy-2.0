<?php
	define("USR_TABLE", "USERS");
	define("URE_TABLE", "USERROLES");
	define("ROL_TABLE", "ROLES");
	define("ELG_TABLE", "ERRORLOG");
	
	define("INNER_JOIN", "INNER JOIN");
	define("LEFT_JOIN", "LEFT JOIN");
	define("RIGHT_JOIN", "RIGHT JOIN");

	define("_WHERE", " WHERE ");
	define("_AND", " AND ");
	define("OR", " OR ");
	define("_LIMIT", " LIMIT ");
	define("_ON", " ON ");
	define("_SET", " SET ");
	define("_FROM", " FROM ");
	define("_INSERT", " INSERT INTO ");
	define("_UPDATE", " UPDATE ");
	define("_DELETE", " DELETE FROM ");
	define("_SELECT", " SELECT * FROM ");
	define("_ORDERBY", " ORDER BY ");
	
	class DatabaseEngine 
	{
		private $_query;

		private $_parameters;

		private $_where;
		private $_joins;
		private $_tablename;
		private $_result;
		private $_limit;
		private $_columns;
		private $_orderby;

		private $_intransaction = false;
		
		private $_mysqli;
		
		function __construct($mysqli = null)
		{
			$this->reset();
			
			if($mysqli != null) {
				$this->_mysqli = $mysqli;
			}
			
			return $this;
		}
		
		function getRawQuery(){
			return $this->_query;
		}
		
		function rawSelect($statement){
			$this->_tablename = "*";
			$s = "SELECT " . $statement;
			
			if($this->_mysqli == null)
				$this->_mysqli = Data_ConnectionHelper::getConnection();
			if ($result = $this->_mysqli->query($s)) {
				while($obj = $result->fetch_object()) { 
					$this->_result[] = $obj;
				} 
				
				$result->close();
				$this->_mysqli->close();
				unset($this->_mysqli); 
			}
			
			return $this->all();
		}
		
		function executeRawQuery($query){
			if($this->_mysqli == null)
				$this->_mysqli = Data_ConnectionHelper::getConnection();
			
			
			
			if ($result = $this->_mysqli->query($query)) {
				if(startWith(_INSERT)) {
					while($obj = $result->fetch_object()) { 
						$this->_result[] = $obj;
					} 
				}
				
				$result->close();
				$this->_mysqli->close();
				unset($this->_mysqli); 
				
				if(startWith(_INSERT)) {
					return $this->_result;
				}
			}
		}
		
		private function reset(){
			$this->_msqli = null;
			$this->_where = array();
			$this->_joins = array();
			$this->_parameters = array();
			$this->_result = array();
			$this->_columns = array();
		}
		
		function beginTransaction()
		{
			$this->_intransaction = true;
			if($this->_mysqli == null)
				$this->_mysqli = Data_ConnectionHelper::getConnection();
			
			$this->_mysqli->begin_transaction(MYSQLI_TRANS_START_READ_ONLY);
		}
		
		function commitTransaction()
		{
			if(_intransaction)
				$this->_mysqli->commit();
		}
		
		function rollbackTransaction()
		{
		if(_intransaction)
				$this->_mysqli->rollback();	
		}

		function table($tablename)
		{
			$this->_tablename = $tablename;
			return $this;
		}

		function select()
		{
			$this->_query = _SELECT . $this->_tablename;
			return $this;
		}

		function where($where)
		{
			$concat = _WHERE;
			if(sizeof($this->_where) > 0)
				$concat = _AND;
			
			$this->_where[] = $concat . " " . $where;
			return $this;
		}

		function OrWhere($where)
		{
			$this->_where[] = _OR . $where;
			return $this;
		}
		
		function orderBy($order, $direction)
		{
			$this->_orderby = _ORDERBY . $order . " " . $direction;
			return $this;
		}

		function join($type, $leftTable, $leftColumn, $rightTable, $rightColumn)
		{
			$this->_joins[] = $type . " " . $leftTable . _ON . $leftTable . "." . $leftColumn . 
			" = " . $rightTable . "." . $rightColumn;
			return $this;
		}

		function limit($limit)
		{
			$this->_limit = _LIMIT . $limit;
			return $this;
		}

		function getQueryString()
		{
			$q = $this->_query;
			foreach($this->_joins as $j) {
				$q .= " " . $j;
			}
			
			foreach($this->_where as $w) {
				$q .= " " . $w;
			}
			
			foreach($this->_parameters as $p) {
				$q .= " " . $p;
			}
			
			$q .= $this->_orderby;
			$q .= $this->_limit;
			
			return $q;
		}

		function fetch()
		{
			if(!isset($this->_tablename))
				throw new Exception("Table not set");

			if(strpos(_SELECT, $this->_query) != 0)
				throw new Exception("No fetch query defined"); 

			$fields = "*";
			if(sizeof($this->_columns) == 0){
				
			}
			if($this->_mysqli == null)
				$this->_mysqli = Data_ConnectionHelper::getConnection();

			$query = $this->getQueryString();

			if ($result = $this->_mysqli->query($query)) {
				while($obj = $result->fetch_object()) { 
					$this->_result[] = $obj;
				} 
				$result->close();
				$this->_mysqli->close();
				unset($this->_mysqli); 
			}
			
			return $this;
		}

		function single()
		{
			$r = $this->_result[0];
			$this->reset();
			return $r;
		}

		function singleOrDefault()
		{
			$r = null;
			if(count($this->_result) > 0)
			{
				$r = $this->_result[0];
			}
			$this->reset();
			return $r;
		}

		function all()
		{
			$r = $this->_result;
			$this->reset();
			return $r;
		}

		function update($id){
			$id = func_get_args()[0];
			$values = array();
			$columns = array();
			$parameters = func_get_args();
			
			array_shift($parameters);
			
			$count = count($parameters);
			
			$columnvalues = "";
			
			for($i = 0;$i<$count;$i+=2) {
				array_push($columns, $parameters[$i]);
			}
			
			for($i = 1;$i<$count + 1;$i+=2) {
				array_push($values, addslashes($parameters[$i]));
			}
			
			for($i=0;$i<$count/2;$i++) {
				$columnvalues .= ($i > 0 ? ',' : '') . $columns[$i] . '=\'' . $values[$i].'\'';
			}
			$tableConstant = array_search($this->_tablename, get_defined_constants(true)["user"]);
			$idCol = explode("_", $tableConstant)[0] . "_ID";
			$this->_query = _UPDATE . $this->_tablename . _SET . $columnvalues . _WHERE . $idCol .
			"=" . $id;	
			
			return $this;
		}
		
		function countTotal(){
			if(!isset($this->_tablename))
				throw new Exception("Table not set");
			
			if($this->_mysqli == null)
				$this->_mysqli = Data_ConnectionHelper::getConnection();
	
			$query = "SELECT COUNT(*) FROM " . $this->_tablename;

			$result = mysqli_query($this->_mysqli,$query);
			$rows = mysqli_fetch_row($result);
			return $rows[0];
			
			$this->reset();
		}

		function delete($id=null)
		{
			if(isset($id)) {
				$this->where($this->getTablePrimaryKey() . "=" . $id);			
			}
			
			$this->_query = _DELETE . $this->_tablename;
			return $this;
		}

		function insert()
		{
			$param = "";
			$columns = "";
			$parameters = func_get_args();
			
			$count = count($parameters);
			for($i = 0;$i<$count;$i+=2) {
				$columns .= ($i > 0 ? ", " : "") . $parameters[$i];
			}
			
			for($i = 1;$i<$count + 1;$i+=2) {
				$param .= ($i > 1 ? ", " : "") . "'" . addslashes($parameters[$i]) . "'";
			}
			
			$this->_query = _INSERT . $this->_tablename . " (" . $columns . ") VALUES (" . $param . ")";
			
			return $this;
		}

		function execute()
		{
			if(!isset($this->_tablename))
				throw new Exception("Table not set");
			
			if($this->_mysqli == null)
				$this->_mysqli = Data_ConnectionHelper::getConnection();
	
			$query = $this->getQueryString();

			$this->_mysqli->query($query);
			
			$id="";
			if(strrpos($query, _INSERT, -strlen($query)) !== false)
				$id = $this->_mysqli->insert_id;
			
			$this->_mysqli->close();
			unset($this->_mysqli); 
			if(strrpos($query, _INSERT, -strlen($query)) !== false)
				return $id;
			
			$this->reset();
			return true;
		}
		
		function getTablePrimaryKey()
		{
			$tableConstant = array_search($this->_tablename, get_defined_constants(true)["user"]);
			return explode("_", $tableConstant)[0] . "_ID";
		}
	}
?>