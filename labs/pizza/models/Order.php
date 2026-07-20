<?php

class Order
{
	private PDO $conn;
	private string $table = 'orders';

	public function __construct(PDO $conn)
	{
		$this->conn = $conn;
	}

	public function placeOrder($data): bool
	{
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

		return $stmt->execute();
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
