<?php 

class Database {
	private $username = 'Shaoqiu200658199';
	private $host =  "172.31.22.43";
	private $password = 'XdGti7iEA8';
	private $database = 'Shaoqiu200658199';
	protected $connection;
	
	/**
	 * constructor method
	 */
	public function __construct(){
		if(!isset($this->connection)){
			$this->connection = new mysqli($this->host, $this->username, $this->password, $this->database);
		}
		if(!$this->connection) {
			echo '<p>Could not connect to the database</p>	';
		}
		return $this->connection;
	}
	
}


?>
