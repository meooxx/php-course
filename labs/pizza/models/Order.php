<?php

class Order
{
	private PDO $conn;
	private string $table = 'orders';

	public function __construct(PDO $conn)
	{
		$this->conn = $conn;
	}

	public function placeOrder(array $data) :bool
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
}
