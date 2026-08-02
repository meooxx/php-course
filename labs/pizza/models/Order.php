<?php
require_once 'models/Database.php';
class Order
{
	private PDO $conn;
	private string $table = 'orders';

	public function __construct()
	{
		$database = new Database();
		$this->conn = $database->getInstance();

	}

	public function placeOrder($data): bool
	{
		$this->conn->beginTransaction();
		// Update stock first
		$updateStock = "UPDATE products SET stock = stock - :quantity WHERE id = :product_id AND stock >= :quantity";
		$updateStmt = $this->conn->prepare($updateStock);
		$updateStmt->bindValue(':product_id', $data['product_id'], PDO::PARAM_INT);
		$updateStmt->bindValue(':quantity', $data['quantity'], PDO::PARAM_INT);
		if (!$updateStmt->execute() || $updateStmt->rowCount === 0) {
			$this->conn->rollBack();
			throw new Exception('Insufficient stock for product ID ' . $data['product_id']);
		}
		$query = "INSERT INTO {$this->table}
			(name, email, phone, product_id, size, crust, quantity, fulfillment)
			VALUES
			(:name, :email, :phone, :product_id, :size, :crust, :quantity, :fulfillment)";

		$stmt = $this->conn->prepare($query);
		$stmt->bindValue(':name', $data['name']);
		$stmt->bindValue(':email', $data['email']);
		$stmt->bindValue(':phone', $data['phone']);
		$stmt->bindValue(':product_id', $data['product_id'], PDO::PARAM_INT);
		$stmt->bindValue(':size', $data['size']);
		$stmt->bindValue(':crust', $data['crust']);
		$stmt->bindValue(':quantity', $data['quantity'], PDO::PARAM_INT);
		$stmt->bindValue(':fulfillment', $data['fulfillment']);
		$result =$stmt->execute();
		$this->conn->commit();
		return $result;

	}

	public function getOrders($page = 1, $count = 99): array
	{
		$query = "SELECT o.*, p.name AS product_name
			FROM {$this->table} o
			LEFT JOIN products p ON p.id = o.product_id
			
			ORDER BY o.created_at DESC, o.id DESC
			LIMIT :limit offset :offset";

		$stmt = $this->conn->prepare($query);

		$stmt->bindValue(':limit', $count, PDO::PARAM_INT);
		$stmt->bindValue(':offset', ($page - 1) * $count, PDO::PARAM_INT);
		if (!$stmt->execute()) {
			throw new Exception('Failed to load orders');
		}
		return $stmt->fetchAll();
	}
}
