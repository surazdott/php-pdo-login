<?php

/** 
 * @Package: Login
 * @Author: SurajDott
 * @Date: 2020-05-01
*/

abstract class Database {
	protected $conn; 
	private $stmt = null; // value should be nulled
	private $sql = null; // value should be nulled
	private $table = null; // $table store the table name

	/**
	* Objects can not be made of Abstracted Classes but can be extended in child class
	* Protected Variable and function is visible in all classes that extend current class including the parnet class
	* Private Varaiable and function can just call in its on class
	* Public function, varaible and class can be call in any parent and child class
	*/

	public function __construct() {
		try{
			$this->conn = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME.";", DB_USER, DB_PWD);
			$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
			$this->stmt = $this->conn->prepare("SET NAMES utf8");
			$this->stmt->execute();
			/**
			* try and catch statemnet are used for error handelling and exceptions
			* setAttribute manupulate and handle the certain PDO Data Classes values
			* prepare is used to generate the query of statement i.e $stmt
			* execute keyword excute the query generated in prepare statemen
			* SET NAMES utf8 for unicode
			*/

		} catch(PDOException $e) {
			error_log(date('Y-m-d h:i:s A').": (DB Connection): ".$e->getMessage()."\r\n", 3, ERROR_PATH."error.log"); 
			return false;

		} catch(Exception $e) {			
			error_log(date('Y-m-d h:i:s A').": (DB Connection): ".$e->getMessage()."\r\n", 3, ERROR_PATH."error.log");
			return false;
			/**
			* PDOException is defined class of php to Exception and Error in PDO, which is store in user defined variable
			* getMessage function print the error message in error folder as a error_log with data and time
			* Exception is defined class of php nand it handles the general error out of the database
			*/
		}
	}

	protected function getDataFromQuery($sql) {
		try{
			$this->sql = $sql;
			$this->stmt = $this->conn->prepare($this->sql);
			$this->stmt->execute();
			$data = $this->stmt->fetchAll(PDO::FETCH_OBJ);
			return $data;

		} catch(PDOException $e) {
			error_log(date('Y-m-d h:i:s A').": (DB GetData): ".$e->getMessage()."\r\n", 3, ERROR_PATH."error.log");
			return false;

		} catch(Exception $e) {			
			error_log(date('Y-m-d h:i:s A').": (DB GetData): ".$e->getMessage()."\r\n", 3, ERROR_PATH."error.log");
			return false;
		}

		/**
			* fetchAll function is defined in php to fetch all the data in PDO statement in Once time without looping
			* This getDataFromQuery function is created to get the sql database data
			* try and catch statement function is implemented to error handeling of database sql
			*/

	}
	
	protected function runQuery($sql) {
		/* Parent Function runQuery to make database table from Schema  */
		try {			
			$this->stmt = $this->conn->prepare($sql);
			return $this->stmt->execute();

		} catch(PDOException $e) {
			error_log(date('Y-m-d h:i:s A').": (DB RunQuery): ".$e->getMessage()."\r\n", 3, ERROR_PATH."error.log");
			return false;

		} catch(Exception $e) {			
			error_log(date('Y-m-d h:i:s A').": (DB RunQuery): ".$e->getMessage()."\r\n", 3, ERROR_PATH."error.log");
			return false;
		}
	}
 
	protected function table($_table) {
		$this->table = $_table;
		/**
		* table function and $_table is table name and compolsury argumets 
		* We do not use try catch condition becoz it does not gives error
		*/ 
	}

	protected final function select($args = array(), $is_die = false) {
		try {
			$this->sql = "SELECT ";

			/* Fields Set Started */
			if(isset($args['fields']) && !empty($args)) {
				if(is_array($args['fields'])) {
					$this->sql .= " ".implode(", ", $args['fields']);
				} else {
					$this->sql .= " ".$args['fields'];
				}
			} else {
				$this->sql .= " * ";
				/**
				* If you need the selected data or fields from database the use the fields
				* Or fileds statement are used in User class then it [implode] the selected fields data
				* else not used the fields ( * ) fetch all data form table fields 
				* implode seperate the array in comma
				*/
			}
			/* Fields Set Ended */


			/* Set table Started */
			if(!isset($this->table) || empty($this->table)) {
				throw new Exception("Table not set.");
				/**
				* throw is the element of try catch block
				* if you want to throw custome Exception in try catch block, then use the throw
				* new Exception() throw the object and excption message
				* If there are any errors in the throw new Exception, the codes under throw elememnt won't be run and throw the errors in try catch blocks
				*/
			}
			$this->sql .=" FROM ".$this->table;
			/* Set table Ended */


			/* Where Clause Condition Started */
			if(isset($args['where']) && !empty($args['where'])) {
				$this->sql .= " WHERE ";
				if(is_array($args['where'])) { # array data type
					# array # prepare key: value
					$temp_or = array();
					$temp_and = array();
					if(isset($args['where']['or']) && !empty($args['where']['or'])) {

						foreach($args['where']['or'] as $column_name => $value) {
							$str = $column_name." = :".$column_name;
							$temp_or[] = $str;
						}
						$this->sql .= implode(" OR ", $temp_or);
					}

					if(isset($args['where']['and']) && !empty($args['where']['and'])) {
						
						foreach($args['where']['and'] as $column_name => $value) {
							$str = $column_name." = :".$column_name;
							$temp_and[] = $str;
						}
						if(!empty($temp_or)) {
							$this->sql .= " AND ";
						}
						$this->sql .= implode(" AND ", $temp_and);

					}

				} else {
					$this->sql .= $args['where']; # string data type
				}
			}
			/* Where Clause Condition Ended */

			$this->stmt = $this->conn->prepare($this->sql);

			/* Value Binding Statement */
			if(isset($args['where']) && !empty($args['where']) && is_array($args['where'])) {

				/* Value Binding of WHERE OR Condition */
				if(isset($args['where']['or']) && !empty($args['where']['or'])){
					foreach ($args['where']['or'] as $column_name => $value) {
						if(is_int($value)) {
							$param = PDO::PARAM_INT;
						} else if(is_bool($value)) {
							$param = PDO::PARAM_BOOL;
						} else {
							$param = PDO::PARAM_STR;
						}
					}
					/**
					* If you use the array data type you have to blind the value
					* foreach loop are u$param = PDO::PARAM_BOOLsed to blind the all values 
					* if the data type is iterger the $param = PDO::PARAM_INT(predifined by PDO)
					* if not integer the or value is boolean then $param = PDO::PARAM_BOOL(predifined in PDO)
					* if the value is not integer or boolean, the value is string
					*/
					if(isset($param)) {
						$this->stmt->bindValue(":".$column_name, $value, $param);
						/**
						* in first arguments do ot use space 
						* if you binding the value second arguments must be the varaible
						* 3rd arguments is parameter i.e $param
						*/
					}
				}

				/* Value Binding of WHERE AND Condition */
				if(isset($args['where']['and']) && !empty($args['where']['and'])){
					foreach ($args['where']['and'] as $column_name => $value) {
						if(is_int($value)) {
							$param = PDO::PARAM_INT;
						} else if(is_bool($value)) {
							$param = PDO::PARAM_BOOL;
						} else {
							$param = PDO::PARAM_STR;
						}
					}
					/**
					* If you use the array data type you have to blind the value
					* foreach loop are u$param = PDO::PARAM_BOOLsed to blind the all values 
					* if the data type is iterger the $param = PDO::PARAM_INT(predifined by PDO)
					* if not integer the or value is boolean then $param = PDO::PARAM_BOOL(predifined in PDO)
					* if the value is not integer or boolean, the value is string
					*/
					if(isset($param)) {
						$this->stmt->bindValue(":".$column_name, $value, $param);
						/**
						* in first arguments do ot use space 
						* if you binding the value second arguments must be the varaible
						* 3rd arguments is parameter i.e $param
						*/
					}
				}
			}
			/* Value Binding Statement Ended */

			if($is_die){
				debugger($args);
				echo $this->sql;
				exit;
			}
			//debugger($this->sql);
			//debugger($this->stmt);

			$this->stmt->execute();
			$data = $this->stmt->fetchAll(PDO::FETCH_OBJ); // fetch all the users data
			return $data;

		} catch(PDOException $e) {
			error_log(date('Y-m-d h:i:s A').": (DB SELECT): (SQL: ".$this->sql." ) ".$e->getMessage()."\r\n", 3, ERROR_PATH."error.log");
			return false;

		} catch(Exception $e) {			
			error_log(date('Y-m-d h:i:s A').": (DB SELECT): (SQL: ".$this->sql." )".$e->getMessage()."\r\n", 3, ERROR_PATH."error.log");
			return false;
		}
		/**
		* Protected final function are made to protect the functins from over ride
		* $this->sql shows the errors if the error came from database or sql
		*/
	}

	protected final function update($data =array(), $args = array(), $is_die = false) {
		try {

			$this->sql = "UPDATE ";

			/* Set table for update Started */
			if(!isset($this->table) || empty($this->table)) {
				throw new Exception("Table not set.");
				/**
				* throw is the element of try catch block
				* if you want to throw custome Exception in try catch block, then use the throw
				* new Exception() throw the object and excption message
				* If there are any errors in the throw new Exception, the codes under throw elememnt won't be run and throw the errors in try catch blocks
				*/
			}
			$this->sql .= $this->table." SET ";
			/* Set table for update Ended */

			if(isset($data) && !empty($data)) {
				if(is_array($data)) {
					$temp = array();
					foreach ($data as $column_name => $value) {
						$str = $column_name." = :".$column_name;
						$temp[] = $str;
					}
					$this->sql .= implode(', ', $temp);

				} else {
					$this->sql .=$data;
				}

			} else {
				return -1;
			}

			/* Where Clause Condition Started */
			if(isset($args['where']) && !empty($args['where'])) {
				$this->sql .= " WHERE ";
				if(is_array($args['where'])) { # array data type
					# array # prepare key: value
					$temp_or = array();
					$temp_and = array();
					# WHERE OR Condition
					if(isset($args['where']['or']) && !empty($args['where']['or'])) {

						foreach($args['where']['or'] as $column_name => $value) {
							$str = $column_name." = :".$column_name;
							$temp_or[] = $str;
						}
						$this->sql .= implode(" OR ", $temp_or);
					}
					# WHERE AND Condition
					if(isset($args['where']['and']) && !empty($args['where']['and'])) {
						
						foreach($args['where']['and'] as $column_name => $value) {
							$str = $column_name." = :".$column_name;
							$temp_and[] = $str;
						}
						if(!empty($temp_or)) {
							$this->sql .= " AND ";
						}
						$this->sql .= implode(" AND ", $temp_and);

					}

				} else {
					$this->sql .= $args['where']; # string data type
				}
			}
			/* Where Clause Condition Ended */

			if($is_die) {
				echo $this->sql;
				echo "<br>";
				debugger($data);
				echo "<br>";
				debugger($args, true);
			}

			# Generating Query statement
			$this->stmt = $this->conn->prepare($this->sql);

			/* [DATA] Value Binding Statement */
			if(isset($data) && !empty($data) && is_array($data)) {

				foreach($data as $column_name => $value){
					if(is_int($value)){
						$param = PDO::PARAM_INT;
					} else if(is_bool($value)) {
						$param = PDO::PARAM_BOOL;
					} else {
						$param = PDO::PARAM_STR;
					}

					if(isset($param)) {
						$this->stmt->bindValue(":".$column_name, $value, $param);
					}
				}
			}
			/* [DATA] Value Binding Statement Ended */ 

			/* Value Binding Statement */
			if(isset($args['where']) && !empty($args['where']) && is_array($args['where'])) {

				/* Value Binding of WHERE OR Condition */
				if(isset($args['where']['or']) && !empty($args['where']['or'])){
					foreach ($args['where']['or'] as $column_name => $value) {
						if(is_int($value)) {
							$param = PDO::PARAM_INT;
						} else if(is_bool($value)) {
							$param = PDO::PARAM_BOOL;
						} else {
							$param = PDO::PARAM_STR;
						}
					}
					/**
					* If you use the array data type you have to blind the value
					* foreach loop are u$param = PDO::PARAM_BOOLsed to blind the all values 
					* if the data type is iterger the $param = PDO::PARAM_INT(predifined by PDO)
					* if not integer the or value is boolean then $param = PDO::PARAM_BOOL(predifined in PDO)
					* if the value is not integer or boolean, the value is string
					*/
					if(isset($param)) {
						$this->stmt->bindValue(":".$column_name, $value, $param);
						/**
						* in first arguments do ot use space 
						* if you binding the value second arguments must be the varaible
						* 3rd arguments is parameter i.e $param
						*/
					}
				}

				/* Value Binding of WHERE AND Condition */
				if(isset($args['where']['and']) && !empty($args['where']['and'])){
					foreach ($args['where']['and'] as $column_name => $value) {
						if(is_int($value)) {
							$param = PDO::PARAM_INT;
						} else if(is_bool($value)) {
							$param = PDO::PARAM_BOOL;
						} else {
							$param = PDO::PARAM_STR;
						}
					}
					/**
					* If you use the array data type you have to blind the value
					* foreach loop are u$param = PDO::PARAM_BOOLsed to blind the all values 
					* if the data type is iterger the $param = PDO::PARAM_INT(predifined by PDO)
					* if not integer the or value is boolean then $param = PDO::PARAM_BOOL(predifined in PDO)
					* if the value is not integer or boolean, the value is string
					*/
					if(isset($param)) {
						$this->stmt->bindValue(":".$column_name, $value, $param);
						/**
						* in first arguments do ot use space 
						* if you binding the value second arguments must be the varaible
						* 3rd arguments is parameter i.e $param
						*/
					}
				}
			}
			/* Value Binding Statement Ended */ 

			return $this->stmt->execute();


		} catch(PDOException $e) {
			error_log(date('Y-m-d h:i:s A').": (DB UPDATE): (SQL: ".$this->sql." ) ".$e->getMessage()."\r\n", 3, ERROR_PATH."error.log");
			return false;

		} catch(Exception $e) {			
			error_log(date('Y-m-d h:i:s A').": (DB UPDATE): (SQL: ".$this->sql." )".$e->getMessage()."\r\n", 3, ERROR_PATH."error.log");
			return false;
		}
	}

}