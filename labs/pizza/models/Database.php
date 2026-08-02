<?php

class Database
{

	private string $username = 'Shaoqiu200658199';
	private string $host = "172.31.22.43";
	private string $password = 'XdGti7iEA8';
	private string $database = 'Shaoqiu200658199';
	// private ?PDO $conn = null;
	private static ?PDO $instance = null;

	protected function connect()
	{
		$dsn = "mysql:host={$this->host};dbname={$this->database};charset=utf8mb4";
		try {
			$instance = new PDO($dsn, $this->username, $this->password);
			$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$instance->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
			self::$instance = $instance;

		} catch (PDOException $e) {
			throw new Exception("Database connection failed: " . $e->getMessage());
		}
		self::$instance = $instance;
		return self::$instance;
	}

	public function getInstance(): PDO
	{
		if (self::$instance === null) {
			$this->connect();
		}
		return self::$instance;
	}






	// the $PDO means it can either hold a real PDO




}
