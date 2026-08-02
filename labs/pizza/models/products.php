<?php
require_once 'models/Database.php';
class Product
{
	private PDO $conn;
	private string $table = 'products';
	public function __construct()
	{
		$database = new Database();
		$this->conn = $database->getInstance();
	}

	public function getProducts()
	{
		$query = "SELECT * FROM {$this->table}";
		error_log("Query: " . $query); // Log the query for debugging
		$stmt = $this->conn->prepare($query);
		if ($stmt->execute()) {
			return $stmt->fetchAll();
		}
		throw new Exception("Query products failed");


	}

	public function getDetail(int $id) 
	{
		$query = "SELECT * FROM {$this->table} WHERE id = :id";
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(':id', $id, PDO::PARAM_INT);
		if ($stmt->execute()) {
			return $stmt->fetch();
		}
		throw new Exception("Query product detail failed");
	}
}


?>