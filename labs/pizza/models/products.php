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
	private function validateProductData($name, $description, $price, $image, $stock, $tag)
	{
		$auth = new Auth();
		$user = $auth->getUser();
		if (!$user || $user->role !== 'admin') {
			throw new Exception('Only admin users can add or update products.');
		}
		if (!isset($name) || !isset($description) || !isset($price) || !isset($image)) {
			throw new Exception("All product fields are required" . urlencode(" Name: $name, Description: $description, Price: $price, Stock: $stock, Pic: $image"));
		}
		if (!isset($stock) || !isset($tag)) {
			throw new Exception("Stock and tag are required");
		}
		if ($stock > 99 || $stock < 0) {
			throw new Exception("Stock must be between 0 and 99");
		}
	}
	public function newProduct($name, $description, $price, $image, $stock, $tag)
	{
		$this->validateProductData($name, $description, $price, $image, $stock, $tag);

		$query = "INSERT INTO {$this->table} (name, description, price, pic, stock, tag) VALUES (:name, :description, :price, :pic, :stock, :tag)";
		$stmt = $this->conn->prepare($query);
		$stmt->bindValue(':name', $name);
		$stmt->bindValue(':description', $description);
		$stmt->bindValue(':price', round($price, 2));
		$stmt->bindValue(':pic', $image);
		$stmt->bindValue(':stock', (int) $stock);
		$stmt->bindValue(':tag', $tag);
		if ($stmt->execute()) {
			return $this->conn->lastInsertId();
		}
		throw new Exception("Insert product failed");
	}
	public function updateProduct($id, $name, $description, $price, $image, $stock, $tag)
	{
		$this->validateProductData($name, $description, $price, $image, $stock, $tag);

		$query = "UPDATE {$this->table} SET name = :name, description = :description, price = :price, pic = :pic, stock = :stock, tag = :tag WHERE id = :id";
		$stmt = $this->conn->prepare($query);
		$stmt->bindValue(':id', $id, PDO::PARAM_INT);
		$stmt->bindValue(':name', $name);
		$stmt->bindValue(':description', $description);
		$stmt->bindValue(':price', round($price, 2));
		$stmt->bindValue(':pic', $image);
		$stmt->bindValue(':stock', $stock);
		$stmt->bindValue(':tag', $tag);
		if ($stmt->execute()) {
			return true;
		}
		throw new Exception("Update product failed");
	}
	public function deleteProduct($id)
	{
		$auth = new Auth();
		$user = $auth->getUser();
		if (!$user || $user->role !== 'admin') {
			throw new Exception('Only admin users can delete products.');
		}
		$query = "DELETE FROM {$this->table} WHERE id = :id";
		$stmt = $this->conn->prepare($query);
		$stmt->bindValue(':id', $id, PDO::PARAM_INT);
		if ($stmt->execute()) {
			return true;
		}
		throw new Exception("Delete product failed");
	}
}


?>