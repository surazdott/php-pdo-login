<?php

/** 
 * @Package: Login
 * @Author: SurajDott
 * @Date: 2020-05-01
*/

spl_autoload_register(function($class) {
	require CLASS_PATH.$class.".php";
	/**
	* spl_autoload_register call the class automatically, which helps to make objects easily
	* we include the autoload.php page to load the class to make objects in any page
	* $class in the class name (eg. if you make class name with database you should use $database instead of $class)
	* CLASS_PATH is defined in config page with server document root which gives directory of class folder
	* .php is used for auoload the page with the name
	*/
});