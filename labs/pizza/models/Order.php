<?php
require_once 'models/Database.php';
require_once 'models/Auth.php';
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
		$auth = new Auth();
		$user = $auth->getUser();
		$userId = $user ? $user->id : null;
		if(!isset($userId)) {
			throw new Exception('User must be logged in to place an order.');
		}
		$this->conn->beginTransaction();
		// Update stock first
		$updateStock = "UPDATE products SET stock = stock - :quantity WHERE id = :product_id AND stock >= :quantity";
		$updateStmt = $this->conn->prepare($updateStock);
		$updateStmt->bindValue(':product_id', $data['product_id'], PDO::PARAM_INT);
		$updateStmt->bindValue(':quantity', $data['quantity'], PDO::PARAM_INT);
		error_log($updateStmt->rowCount() . " rows affected by stock update.");
		if (!$updateStmt->execute() || $updateStmt->rowCount() === 0) {
			$this->conn->rollBack();
			throw new Exception('Insufficient stock for product ID ' . $data['product_id']);
		}
		$query = "INSERT INTO {$this->table}
			(name, email, phone, product_id, size, crust, quantity, fulfillment, user_id)
			VALUES
			(:name, :email, :phone, :product_id, :size, :crust, :quantity, :fulfillment, :user_id)";

		$stmt = $this->conn->prepare($query);
		$stmt->bindValue(':name', $data['name']);
		$stmt->bindValue(':email', $data['email']);
		$stmt->bindValue(':phone', $data['phone']);
		$stmt->bindValue(':product_id', $data['product_id'], PDO::PARAM_INT);
		$stmt->bindValue(':size', $data['size']);
		$stmt->bindValue(':crust', $data['crust']);
		$stmt->bindValue(':quantity', $data['quantity'], PDO::PARAM_INT);
		$stmt->bindValue(':fulfillment', $data['fulfillment']);
		if (isset($userId)) {
			$stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
		} else {
			$stmt->bindValue(':user_id', null, PDO::PARAM_NULL);
		}
		$result = $stmt->execute();
		$this->conn->commit();
		return $result;

	}

	public function getOrders($page = 1, $count = 99): array
	{
		$auth = new Auth();
		$user = $auth->getUser();
		if(!$auth->isLoggedIn()) {
			return [];
		}
		$userId = $user ? $user->id : null;
		$role = $user ? $user->role : null;
		$query = "SELECT o.*, 
			p.name AS product_name,
			p.pic as product_image
			FROM {$this->table} o
			LEFT JOIN products p ON p.id = o.product_id
			WHERE :role = 'admin' OR (:userId IS not NULL and o.user_id = :userId) 
			ORDER BY o.created_at DESC, o.id DESC
			LIMIT :limit offset :offset";

		$stmt = $this->conn->prepare($query);
		$stmt->bindValue(':userId', $userId, $userId === null ? PDO::PARAM_NULL : PDO::PARAM_INT);
		$stmt->bindValue(':role', $role, PDO::PARAM_STR);
		$stmt->bindValue(':limit', $count, PDO::PARAM_INT);
		$stmt->bindValue(':offset', ($page - 1) * $count, PDO::PARAM_INT);
		if (!$stmt->execute()) {
			throw new Exception('Failed to load orders');
		}
		return $stmt->fetchAll();
	}
}
