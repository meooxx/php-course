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
	public function newProduct($name, $description, $price, $image)
	{
		if(!isset($name) || !isset($description) || !isset($price) || !isset($image)) {
			throw new Exception("All product fields are required");
		}
		if(!str_starts_with($image, 'https://')) {
			throw new Exception("Image URL must be a url");
		}
		
		$query = "INSERT INTO {$this->table} (name, description, price, image) VALUES (:name, :description, :price, :image)";
		$stmt = $this->conn->prepare($query);
		$stmt->bindValue(':name', $name);
		$stmt->bindValue(':description', $description);
		$stmt->bindValue(':price', $price);
		$stmt->bindValue(':image', $image);
		if ($stmt->execute()) {
			return $this->conn->lastInsertId();
		}
		throw new Exception("Insert product failed");
	}
}


?>