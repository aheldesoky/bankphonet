<?php
/*
	Product :		   db, php tiny data access layer, based on SQL statements
	Developed by :	  Khalid Ahmed
	eMail :			 contact@khalidpeace.com
	Web Site :		  www.khalidpeace.com
	Creation Date :	 15 Oct 2008
	Last Update :	   19/11/2010
 * ==============================
 * Modified by:Samy Massoud saad
 * email : samymassoud@gmail.com
 * Comment : converted to singlton pattern  


*/

/**
 * @TODO: Rewirite this class using Object Oriented
 * MySQLi Extension Interface.
 */

// configurations
// --------------
define('DB_DEBUG', false);
define('DB_CACHE_URL', 'cache/db/');
define('DB_CACHE_EXPIRE', 1);






class Cdb
{

	//Singlton stuff
	private static $instance; //Will hold db instance
	
	private $db_host = "";
	private $db_user = "";
	private $db_pass = "";
	private $db_database = "";

	private $unicode = true;
	private $timezone = '';

	public $connection;
	
	private $caching = false;
	


	/**
	 * DB object init.
	 */
	public function __construct()
	{
		$this->db_host = DB_HOST;
		$this->db_user = DB_USER;
		$this->db_pass = DB_PASS;
		$this->db_database = DB_DATABASE;

		$this->connection = new mysqli($this->db_host, $this->db_user, $this->db_pass, $this->db_database);
		//SET NAMES
		if ($this->unicode) $this->execute("SET NAMES 'utf8'");
		//SET TIMEZONE
		if ($this->timezone) $this->execute("SET time_zone = '{$this->timezone}'");

	}
	
	//instansiate class using this method
	public static function singleton ()
	{
		//No instance created
		if(!isset(self::$instance)){
			$cls_name = __CLASS__; //get current class name
			self::$instance = new $cls_name ();
		}
		
		//return clas object
		return self::$instance;
	}
	
	


	public function connect()
	{
		if ($this->connection and DB_DEBUG) $this->error_box ('Db connection is already opened');
		
		// connect
		$this->connection = new mysqli($this->db_host, $this->db_user, $this->db_pass, $this->db_database);
		
		if (! $this->connection) return false;
		
		// unicode
		if ($this->unicode) $this->execute("SET NAMES 'utf8'");
		
		// timezone
		if ($this->timezone) $this->execute("SET time_zone = '{$this->timezone}'");
		
		return true;
	}


	public function execute($sql)
	{
		
		// check if it is insert sql or not
		$insert = false;
		$sql2 = strtoupper($sql);
		if (strpos($sql2, 'INSERT') !== false) $insert = true;
		
		
		$result = $this->connection->query($sql);

		if (! $result) {
			$this->error_box("db execute() error : $sql");
			return false;
		}
		
		if ($insert){
			$return_id = $this->connection->insert_id;
			
			// check if returns false means this table have no auto increment id
			if (! $return_id) return true;
			return $return_id;
		}
		else {
			return true;
		}
		
	}


        
        

        public function query($sql)
	{
		// if caching enabled, get from cache
		if ($this->caching) {
			$cache_key = base64_encode ($sql);
			$cache_key = str_replace ('/', '_', $cache_key);
			$cache_file = DB_CACHE_URL . $cache_key . '.txt';
			
			// check file exist
			if (file_exists($cache_file)) {
				$last_modified = filemtime($cache_file);
				$expire_time = strtotime('now -' . DB_CACHE_EXPIRE . ' minute');
				
				if ($last_modified > $expire_time) {
					// this data is within cache expire period, retrieve data from file
					$data = file_get_contents ($cache_file);
					$data = unserialize ($data);
					return $data;
				} else {
					// delete expired data file
					unlink ($cache_file);
				}
			}
		}
		
		// check connect
		
		$result = $this->connection->query($sql);

		if (! $result) {
			$this->error_box("db query() error : $sql");
			return false;
		}

		$data = array();
		$i = 0;
		while($row = $result->fetch_assoc()){
			$data[$i] = $row;
			$i++;
		}

		// if caching, then save data to cache file
		if ($this->caching) {
			$buffer = serialize ($data);
			file_put_contents ($cache_file, $buffer);
		}
		
		return $data;
	}




	public function query_record($sql)
	{
		$data = $this->query($sql);
		if ($data) $data = $data[0];
		return $data;
	}
	
	
	
	
	public function query_value($sql)
	{
		$data = $this->query($sql);
		if (! $data) return false;
		
		$data = $data[0];
		
		foreach ($data as $key => $value ) return $value;
		
		return false;
	}





	// error functions
	public function error_no()
	{
		return $this->connection->errno;
	}
	
	public function error_message()
	{
		return $this->connection->error;
	}

	public function error_box($message = '')
	{
		if (DB_DEBUG){
			$message = "<div style='background-color: #FF9999; border: 1px solid #CC3300; padding: 5px; '>$message <br>"
						. $this->error_message()
						. "</div>";
			die ($message);
		}
	}







	// used to add field = value parts to sql statements, like update set ... , or where ...
	public function add_sql_token(&$buffer, $field, $value, $seperator = ', ', $use_quotation = true, $operator = '=')
	{
		if ($value !== false) {
			if ($buffer <> '') $buffer .= $seperator;
			if ($use_quotation) {
				if (strtoupper($operator) == 'LIKE'){
					$buffer .= "$field LIKE '%$value%'";				
				}
				else{
					$buffer .= "$field $operator '$value'";				
				}			
			}
			else{
				$buffer .= "$field $operator $value";
			}
		}
	}
	
	
	
	
	// check for NOW() and NULL
	public function is_sql_token($expr)
	{
		$temp = trim(strtoupper($expr));
		
		if ($temp == 'NULL') return true;

		if (strpos($temp, 'NOW(') === 0 ) return true;
		
		return false;
	}

	
	
	
	
	// sql generation functions
	// ------------------------
	public function generate_where_sql ($where_fields_values = false, $where_sql = false)
	{
		$where_part = '';
		
		if (is_array($where_fields_values)) 
			foreach ($where_fields_values as $field => $value){
				if ($value !== false) {
					$value = $this->connection->real_escape_string($value);
					
					if ($where_part <> '') $where_part .= ' AND ';
					if (! $this->is_sql_token($value)) $value = "'$value'";
					
					if ($value == 'NULL')
						$where_part .= "$field IS NULL";
					else
						$where_part .= "$field = $value";
				}
			}
		
		if ($where_sql) {
			if ($where_part <> '') $where_part .= ' AND ';
			$where_part .= $where_sql;
		}
		
		if (! $where_part) $where_part = ' 1 = 1 ';
		return $where_part;
	}
	
	
	
	
	
		
	
	public function generate_select_sql ($table, $where_sql = false, $where_fields_values = false, $custom_select_sql = false, $order = false, $limit = false, $join_fields = false, $join_sql = false)
	{
		$where_part = '';
		
		if (is_array($where_fields_values)) 
			foreach ($where_fields_values as $field => $value){
				if ($value !== false) {
					$value = $this->connection->escape_string($value);
					
					if ($where_part <> '') $where_part .= ' AND ';
					if (! $this->is_sql_token($value)) $value = "'$value'";
					
					if ($value == 'NULL')
						$where_part .= "$field IS NULL";
					else
						$where_part .= "$field = $value";
				}
			}
		
		if ($where_sql) {
			if ($where_part <> '') $where_part .= ' AND ';
			$where_part .= $where_sql;
		}
		
		
		$sql = "SELECT {$table}.*";
		if ($custom_select_sql) $sql .= ", $custom_select_sql ";
		if ($join_fields) $sql .= ", $join_fields ";
		$sql .= " FROM $table";
		if ($join_sql) $sql .= " $join_sql";
		if ($where_part) $sql .= " WHERE $where_part";
		if ($order) $sql .= " ORDER BY $order";
		if ($limit) $sql .= " LIMIT $limit";
		
		return $sql;
	}
	
	




	public function generate_insert_sql ($table, $fields_values = false, $custom_sql_fields = false, $custom_sql_values = false)
	{
		$fields_part = '';
		
		if (is_array($fields_values)) 
			foreach ($fields_values as $field => $value){
				if ($value !== false) {
					if ($fields_part <> '') $fields_part .= ', ';
					$fields_part .= $field;
				}
			}
		
		if ($custom_sql_fields) {
			if ($fields_part <> '') $fields_part .= ', ';
			$fields_part .= $custom_sql_fields;
		}
		
		
		$values_part = '';
		
		if (is_array($fields_values)) 
			foreach ($fields_values as $field => $value){
				if ($value !== false) {
					$value = $this->connection->real_escape_string($value);
					
					if ($values_part <> '') $values_part .= ', ';
					if (! $this->is_sql_token($value)) $value = "'$value'";
					
					$values_part .= $value;
				}
			}
		
		if ($custom_sql_values) {
			if ($values_part <> '') $values_part .= ', ';
			$values_part .= $custom_sql_values;
		}
		
		
		$sql = "INSERT INTO $table ( $fields_part ) VALUES ( $values_part )";
		return $sql;		
	}
	
	
	
	
	
	
	public function generate_update_sql ($table, $update_fields_values = false, $where_sql = false, $custom_update_sql = false)
	{
		$set_part = '';
		
		if (is_array($update_fields_values)) 
			foreach ($update_fields_values as $field => $value){
				if ($value !== false) {
					$value = $this->connection->real_escape_string($value);
					
					if ($set_part <> '') $set_part .= ', ';
					if (! $this->is_sql_token($value)) $value = "'$value'";
					
					$set_part .= "$field = $value";
				}
			}
		
		if ($custom_update_sql) {
			if ($set_part <> '') $set_part .= ', ';
			$set_part .= $custom_update_sql;
		}
		
		
		$sql = "UPDATE $table SET $set_part";
		if ($where_sql) $sql .= " WHERE $where_sql";
		
		return $sql;
	}
	
	
	
	


	public function generate_delete_sql ($table, $where_sql = false, $where_fields_values = false)
	{
		$where_part = '';
		
		if (is_array($where_fields_values)) 
			foreach ($where_fields_values as $field => $value){
				if ($value !== false) {
					$value = $this->connection->real_escape_string($value);
					
					if ($where_part <> '') $where_part .= ' AND ';
					if (! $this->is_sql_token($value)) $value = "'$value'";
					
					if ($value == 'NULL')
						$where_part .= "$field IS NULL";
					else
						$where_part .= "$field = $value";
				}
			}
		
		if ($where_sql) {
			if ($where_part <> '') $where_part .= ', ';
			$where_part .= $where_sql;
		}
		
		
		$sql = "DELETE FROM $table";
		if ($where_part) $sql .= " WHERE $where_part";
		
		return $sql;
	}
	
	
	



	
	
	// direct data access functions
	// ----------------------------
	
	public function select ($table, $where_sql = false, $where_fields_values = false, $custom_select_sql = false, $order = false, $limit = false, $join_fields = false, $join_sql = false)
	{
		$sql = $this->generate_select_sql ($table, $where_sql, $where_fields_values, $custom_select_sql, $order, $limit, $join_fields, $join_sql);
		return $this->query($sql);
	}
	
	
	
	public function select_record ($table, $where_sql = false, $where_fields_values = false, $custom_select_sql = false, $order = false, $limit = false, $join_fields = false, $join_sql = false)
	{
		$data = $this->select($table, $where_sql, $where_fields_values, $custom_select_sql, $order, $limit, $join_fields, $join_sql);
		if ($data) $data = $data[0];
		return $data;
	}
	
	
	
	public function select_count ($table, $where_sql = false, $where_fields_values = false, $join_sql = false)
	{
		// todo to make better
		$sql = "SELECT COUNT(*)";
		$sql .= " FROM $table";
		if ($join_sql) $sql .= " $join_sql";
		$where_part = $this->generate_where_sql ($where_fields_values, $where_sql);
		if ($where_part) $sql .= " WHERE " . $where_part;

		return $this->query_value ($sql); 
	}



	public function insert($table, $fields_values = false, $custom_sql_fields = false, $custom_sql_values = false)
	{
		$sql = $this->generate_insert_sql ($table, $fields_values, $custom_sql_fields, $custom_sql_values);
		return $this->execute ($sql);		
	}
	
	
	
	public function update ($table, $update_fields_values = false, $where_sql = false, $custom_update_sql = false)
	{
		$sql = $this->generate_update_sql ($table, $update_fields_values, $where_sql, $custom_update_sql);
		return $this->execute ($sql);		
	}
	
	
	
	public function delete ($table, $where_sql = false, $where_fields_values = false)
	{
		$sql = $this->generate_delete_sql ($table, $where_sql, $where_fields_values);
		return $this->execute($sql);
	}
	
	




	// safety function using mysql
	public function safeit (&$var)
	{
		// check connect
		
		if (is_array($var)) {
			foreach ($var as $key => $value) $this->safeit ($var[$key]);
			return $var;
		}
		
		$var = $this->connection->real_escape_string ($var);		
	}
	




        /**
         * Transaction method
         * @param array $sql_arr 
         */
        public function transaction ($sql_arr){
            
            //Check array of sql's first
            if($sql_arr){
                //Loop through transactions
                //disable auto commit
                $this->connection->autocommit(false);
                foreach($sql_arr as $sql){
                    //if there are sql
                    if($sql)
                        $result = $this->connection->query($sql);
                    if($result !==TRUE){
                        $this->connection->rollback ();
                        return false; //Faield
                    }
                }
                
                $id = $this->connection->insert_id; // MUST BE CALLED beafore commit
                //if no error commit transaction
                $this->connection->commit();
                $this->connection->autocommit(true);
                //Fix if no insert in transaction
                return ($id) ? $id : true;
            }else{
                return false; //nothing to do
            }
        }
	
	// initialization & destruction
	// ----------------------------

	
	public function __destruct()
	{
		unset($this->connection);
	}


}



?>
