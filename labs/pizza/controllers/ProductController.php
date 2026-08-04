<?php
require_once __DIR__ . '/../models/Auth.php';
require_once __DIR__ . '/../models/products.php';

class ProductController
{
	private $auth;

	public function __construct()
	{
		$this->auth = new Auth();
	}

	public function requireAdmin()
	{
		$this->auth->requireAdmin();
	}

	public function handlePost($post)
	{
		if (($post['action'] ?? '') == 'delete') {
			$this->delete($post);
		}

		$pId = trim($post['targetId'] ?? '');
		if (!empty($pId)) {
			$this->update($post);
		} else {
			$this->create($post);
		}
	}

	public function loadForEdit($id)
	{
		$productId = '';
		$name = '';
		$des = '';
		$pic = '';
		$price = '';
		$tag = '';
		$stock = '';
		$validPic = '';

		if ($id !== null && $id !== '') {
			$data = $this->read($id);
			$productId = $data['productId'];
			$name = $data['name'];
			$des = $data['des'];
			$pic = $data['pic'];
			$price = $data['price'];
			$tag = $data['tag'];
			$stock = $data['stock'];
			$validPic = $data['validPic'];
		}

		return [
			'productId' => $productId,
			'name' => $name,
			'des' => $des,
			'pic' => $pic,
			'price' => $price,
			'tag' => $tag,
			'stock' => $stock,
			'validPic' => $validPic,
		];
	}

	public function create($post)
	{
		$name = trim($post['name'] ?? '');
		$description = trim($post['description'] ?? '');
		$stock = (int) ($post['stock'] ?? 0);
		$pic = trim($post['pic'] ?? '');
		$tag = trim($post['tag'] ?? '');
		$price = (float) ($post['price'] ?? 0);

		if (empty($name) || empty($description) || $price <= 0 || $stock > 99 || $stock <= 0 || empty($pic)) {
			header('Location: status.php?success=0&message=Invalid input.' . urlencode(" Name: $name, Description: $description, Price: $price, Stock: $stock, Pic: $pic"));
			exit;
		}

		try {
			$productModel = new Product();
			$productModel->newProduct($name, $description, $price, $pic, $stock, $tag);
			header('Location: status.php?success=1&message=Product added successfully.');
			exit;
		} catch (Exception $e) {
			header('Location: status.php?success=0&message=' . urlencode($e->getMessage()));
			exit;
		}
	}

	public function read($productId)
	{
		try {
			$productModel = new Product();
			$product = $productModel->getDetail((int) $productId);
			if (!$product) {
				throw new Exception('Product not found');
			}
			$validPic = !empty($product->pic) ? $product->pic : 'https://placehold.co/800x800?text=no+image';
			return [
				'productId' => $productId,
				'validPic' => $validPic,
				'name' => $product->name ?? '',
				'des' => $product->description ?? '',
				'pic' => str_starts_with($validPic, 'https://') ? $validPic : "images/{$validPic}",
				'price' => $product->price ?? '',
				'tag' => $product->tag ?? '',
				'stock' => $product->stock ?? '',
			];
		} catch (Exception $e) {
			header('Location: status.php?success=0&message=Product not found.');
			exit;
		}
	}

	public function update($post)
	{
		$name = trim($post['name'] ?? '');
		$description = trim($post['description'] ?? '');
		$stock = (int) ($post['stock'] ?? 0);
		$pic = trim($post['pic'] ?? '');
		$tag = trim($post['tag'] ?? '');
		$price = (float) ($post['price'] ?? 0);
		$pId = trim($post['targetId'] ?? '');

		if (empty($name) || empty($description) || $price <= 0 || $stock > 99 || $stock <= 0 || empty($pic)) {
			header('Location: status.php?success=0&message=Invalid input.' . urlencode(" Name: $name, Description: $description, Price: $price, Stock: $stock, Pic: $pic"));
			exit;
		}

		try {
			$productModel = new Product();
			$productModel->updateProduct($pId, $name, $description, $price, $pic, $stock, $tag);
			header('Location: status.php?success=1&message=Product updated successfully.');
			exit;
		} catch (Exception $e) {
			header('Location: status.php?success=0&message=' . urlencode($e->getMessage()));
			exit;
		}
	}

	public function delete($post)
	{
		$deleteId = $post['deleteId'] ?? null;
		if (isset($deleteId)) {
			$productModel = new Product();
			try {
				$productModel->deleteProduct($deleteId);
				header('Location: status.php?success=1&message=Product deleted successfully.');
				exit;
			} catch (Exception $e) {
				header('Location: status.php?success=0&message=' . urlencode($e->getMessage()));
				exit;
			}
		}
		exit;
	}
}
