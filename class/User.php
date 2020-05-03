<?php

/** 
 * @Package: Login
 * @Author: SurajDott
 * @Date: 2020-05-01
*/

class user extends Database {

	public function __construct() {
		Database::__construct();
		$this->table('users');
		/**
		* user class is extended from parent class database and construct the database connection
		* Here database:: == Your database root name and class name || Must be same name 
		* $this->table('users'); = every time when user class is called, the user object call the users 	table
		* user table should be defined in Database class to call the fuction in evry time and every sql table
		*/

	}

	public function getUserByUsername($user_name, $is_die=false) {
		$args = array(
			//'fields' => ['id', 'email', 'full_name', 'password', 'status'],
			//'where' => "email = '".$user_name."'"
			'where' => array(
				/*'or' => array(
					'email' => $user_name,
					'user_name' => $user_name
					), */ // OR condition
				'and' => array(
					'email' => $user_name,
					//'user_name' => $user_name
					)
				//'email' => $user_name

				/**
				* "'email' = '".$user_name."' OR status = 1 AND password IS NOT NULL" for OR Condition
				* "'email' = '".$user_name."' OR username = '".$user_name."' for OR username or email condition
				*/
			)
			
			/**
			* If you need selected fields only then use the fields otherwise not
			* 'where' => "email = '".$user_name."'" is string data type and other is aray data type
			*/
		);

		$data = $this->select($args, $is_die);
		return $data;
	}

	public function updateUser($data, $id, $is_die = false) {
		$args = array(
				'where' => array(
						'and' => array('id' => $id)
				)
		);
		/**
		* specific function to get the user data
		* user specified data are taken from arguments and array condition
		*/
		return $this->update($data, $args, $is_die);
	}

	public function getUserByToken($token, $is_die = false) {
		$args = array(
				'where' => array(
					'and' =>array('session_token' => $token)

				)
		);
		/**
		* Generic function to get user token
		*/
		return $this->select($args, $is_die);
	}

	public function getUser($args = array(), $is_die = false) {
		$args = array(
			'where' => array(
				'and' =>$args
			)
		);
		/**
		* Generic function to get the user
		* argument set in array condtion of AND codition
		* argument and is_die send in select function 
		*/
		return $this->select($args, $is_die);
	}

}