<?php

/** 
 * @Package: Login
 * @Author: SurajDott
 * @Date: 2020-05-01
*/

ob_start();
session_start();

if($_SERVER['SERVER_ADDR'] == "127.0.0.1" || $_SERVER['SERVER_ADDR'] == "::1") {
	define('ENVIRONMENT', 'DEVELOPMENT');
} else {
	define('ENVIRONMENT', 'PRODUCTION');
}

if(ENVIRONMENT == 'DEVELOPMENT') {

	/**
	* Server configuration for local host
	* error_reporting is required for localhost
	*/

	error_reporting(E_ALL);
	define('DB_HOST', 'localhost');
	define('DB_USER', 'root');
	define('DB_PWD', '');
	define('DB_NAME', 'login');
	define('SITE_URL', 'http://localhost/login/');

	
} else {

	/**
	* DB_HOST = localhost or Your server host name
	* DB_USER = Your database username
	* DB_PWD = Your database password
	* DB_NAME = Your database name
	* SITE_URL = Your website name 
	* error_reporting should e zero in live server
	*/

	error_reporting(0);
	define('DB_HOST', '');
	define('DB_USER', '');
	define('DB_PWD', '');
	define('DB_NAME', '');
	define('SITE_URL', 'http://meropasal.com/');

}

/**
----CMS Configuration -----
* CMS_URL = path of CMS folder from document root 
* CMS_INCLUDE = path of cms inc from document root 
* CMS_ASSETS = path of assets from document root 
*/
define('SITE_NAME', 'Login');
define('CMS_URL', SITE_URL."/cms/");
define('CMS_INCLUDE', $_SERVER['DOCUMENT_ROOT'].'cms/inc/');
define('CMS_ASSETS', CMS_URL.'assets/');
define('CMS_CSS', CMS_ASSETS.'css/');
define('CMS_JS', CMS_ASSETS.'js/');
define('CMS_IMAGES', CMS_ASSETS.'images/');

/**
* ERROR_PATH define the path of error folder to store the error log
* CLASS_PATH define the path of the class folder to load the files
* $_SERVER['DOCUMENT_ROOT']. 'folder_name' == root name with path name
*/


/**
* ERROR_PATH = error path from document root 
* CLASS_PATH = class path from document root 
* CONFIG_PATH = config path from document root 
*/

define('ERROR_PATH', $_SERVER['DOCUMENT_ROOT'].'/login/error/');
define('CLASS_PATH', $_SERVER['DOCUMENT_ROOT'].'/login/class/');
define('CONFIG_PATH', $_SERVER['DOCUMENT_ROOT'].'/login/config/');

