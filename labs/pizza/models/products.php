<?php
class Product
{
	private PDO $conn;
	private string $table = 'products';
	public function __construct(PDO $conn)
	{
		$this->conn = $conn;
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
}


?>