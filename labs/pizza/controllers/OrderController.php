<?php
require_once __DIR__ . '/../models/Order.php';

class OrderController
{
	public function placeFromPost($post)
	{
		$success = false;
		$orderModel = new Order();
		$name = trim($post['name'] ?? '');
		$email = trim($post['email'] ?? '');
		$phone = trim($post['phone'] ?? '');
		$productId = (int) ($post['product_id'] ?? 0);
		$size = $post['size'] ?? 'medium';
		$crust = $post['crust'] ?? 'hand_tossed';
		$quantity = max(1, min(99, (int) ($post['quantity'] ?? 1)));
		$fulfillment = $post['fulfillment'] ?? 'carryout';

		if (empty($name) || empty($email) || empty($phone) || $productId <= 0) {
			$ok = false;
		} else {
			$ok = true;
		}

		if ($ok) {
			try {
				$success = $orderModel->placeOrder([
					'name' => $name,
					'email' => $email,
					'phone' => $phone,
					'product_id' => $productId,
					'size' => $size,
					'crust' => $crust,
					'quantity' => $quantity,
					'fulfillment' => $fulfillment,
				]);
				if ($success) {
					header('Location: status.php?success=1');
					exit;
				} else {
					header('Location: status.php?success=0&message=Failed to place order.');
					exit;
				}
			} catch (Exception $e) {
				header('Location: status.php?success=0&message=' . urlencode($e->getMessage()));
				exit;
			}
		}
		exit;
	}
}
