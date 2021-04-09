<?php

class Connect
{
	
	protected $connect;
	
	function __construct() {
		$dsn = 'mysql:dbname=omega_tv;host=localhost';
		$user = 'root';
		$password = '';
		
		try {
			$this->connect = new PDO($dsn, $user, $password);
			$this->getConnection();
		} catch(PDOException $e) {
		}
        
    }
	
	
	function getConnection() {
		return $this->connect;
	}
	
	
}