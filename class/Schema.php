<?php

/** 
 * @Package: Login
 * @Author: SurajDott
 * @Date: 2020-05-01
*/

class Schema extends Database {

	function create($sql) {
		return $this->runQuery($sql);
	}

}