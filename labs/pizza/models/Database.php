<?php

class Database
{

	private string $username = 'Shaoqiu200658199';
	private string $host = "172.31.22.43";
	private string $password = 'XdGti7iEA8';
	private string $database = 'Shaoqiu200658199';
	private ?PDO $conn = null;

	public function connect()
	{
		if ($this->conn !== null) {
			return $this->conn;
		}
		$dsn = "mysql:host={$this->host};dbname={$this->database};charset=utf8mb4";
		try {
			$this->conn = new PDO($dsn, $this->username, $this->password);
			$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
		} catch (PDOException $e) {
			throw new Exception("Database connection failed: " . $e->getMessage());
		}
		return $this->conn;
	}






	// the $PDO means it can either hold a real PDO




}
