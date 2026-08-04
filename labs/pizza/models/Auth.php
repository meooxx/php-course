<?php
require_once 'models/Database.php';
require_once 'models/Session.php';

class Auth
{
	static private $user;
	public function __construct()
	{
		Session::start();
	}

	public function isLoggedIn(): bool
	{
		return Session::get('user_id') !== null;
	}
	public function getUserById($userId)
	{
		if(!isset($userId)) {
			throw new Exception("User ID is required");
		}

		$database = new Database();
		$conn = $database->getInstance();
		$query = "SELECT * FROM pizza_users WHERE id = :id";
		$stmt = $conn->prepare($query);
		$stmt->bindValue(':id', $userId, PDO::PARAM_INT);
		if ($stmt->execute()) {
			$user = $stmt->fetch();
			if (!$user) {
				throw new Exception("User not found");
			}
			return $user;
		}
		return null;
	}
	public function getUser()
	{
		if (self::$user !== null) {
			return self::$user;
		}
		if ($this->isLoggedIn()) {
			$userId = Session::get('user_id');

			try {
				$user = $this->getUserById($userId);
				self::$user = $user;
				return $user;

			} catch (Exception $e) {
				$this->logout();
				throw new Exception("User not found. Please log in again.");
			}
		}
		return null;
	}
	public function isAdmin(): bool
	{
		$user = $this->getUser();
		return $user && $user->role === 'admin';
	}
	public function requireAdmin()
	{
		$user = $this->getUser();
		if (!$user || $user->role !== 'admin') {
			header('Location: status.php?message=You must be logged in as an admin to access this page.');
			exit;
		}
	}
	public function requireLogin()
	{
		if (!$this->isLoggedIn()) {
			header('Location: index.php');
			exit;
		}
	}

	public function login($username, $password): bool
	{
		$database = new Database();
		$conn = $database->getInstance();
		$query = "SELECT * FROM pizza_users WHERE username = :username";
		$stmt = $conn->prepare($query);
		$stmt->bindParam(':username', $username);

		if ($stmt->execute()) {
			$stmt->debugDumpParams();
			$user = $stmt->fetch();
			if ($user && password_verify($password, $user->password)) {
				Session::set('user_id', $user->id);

				return true;
			} else {
				throw new Exception("Invalid username or password");
			}
		}
		return false;
	}
	public function logout()
	{
		Session::destroy();
	}

	public function register($username, $password, $confirmPassword, $email, $role): bool
	{
		if (!isset($username) || !isset($password) || !isset($email)) {

			if (!isset($username)) {
				throw new Exception("Username is required");
			}
			if (!isset($password)) {
				throw new Exception("Password is required");
			}
			if (!isset($email)) {
				throw new Exception("Email is required");
			}
			if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
				throw new Exception("Invalid email format");
			}
			if ($password !== $confirmPassword) {
				throw new Exception("Passwords do not match");
			}
		}
		$database = new Database();
		$conn = $database->getInstance();
		// restrain username to be unique
		$usernameQuery = "SELECT * FROM pizza_users WHERE username = :username";
		$usernameStmt = $conn->prepare($usernameQuery);
		$usernameStmt->bindParam(':username', $username);
		if ($usernameStmt->execute()) {
			if ($usernameStmt->rowCount() > 0) {
				throw new Exception("Username already exists");
			}
		} else {
			throw new Exception("Failed to check username existence");
		}
		// restrain email to be unique
		$emailQuery = "SELECT * FROM pizza_users WHERE email = :email";
		$emailStmt = $conn->prepare($emailQuery);
		$sanitizedEmail = filter_var($email, FILTER_SANITIZE_EMAIL);
		$emailStmt->bindValue(':email', $sanitizedEmail);
		if ($emailStmt->execute()) {
			if ($emailStmt->rowCount() > 0) {
				throw new Exception("Email already exists");
			}
		} else {
			throw new Exception("Failed to check email existence");
		}
		$query = "INSERT INTO pizza_users (username, password, email, role) VALUES (:username, :password, :email, :role)";
		$stmt = $conn->prepare($query);
		$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
		$stmt->bindParam(':username', $username);
		$stmt->bindParam(':password', $hashedPassword);
		$stmt->bindParam(':email', $sanitizedEmail);
		$stmt->bindParam(':role', $role);
		if ($stmt->execute()) {
			$userId = $conn->lastInsertId();
			Session::set('user_id', $userId);
			return true;
		}
		return false;
	}

	public function getUsers(): array
	{
		$database = new Database();
		$conn = $database->getInstance();
		$query = "SELECT * FROM pizza_users";
		$stmt = $conn->prepare($query);
		if ($stmt->execute()) {
			return $stmt->fetchAll();
		}
		throw new Exception("Query users failed");
	}

	public function deleteUser($targetId): bool
	{
		if ($targetId === null) {
			throw new Exception("User ID is required for deletion");
		}
		if (!$this->isAdmin()) {
			throw new Exception("Only admin users can delete users");
		}
		$database = new Database();
		$conn = $database->getInstance();
		$query = "DELETE FROM pizza_users WHERE id = :id";
		$stmt = $conn->prepare($query);
		$stmt->bindParam(':id', $targetId, PDO::PARAM_INT);
		if ($stmt->execute()) {
			return true;
		}
		throw new Exception("Delete user failed");
	}

	public function updateUser($targetUserId, $username, $email, $role): bool
	{
		if ($targetUserId === null) {
			throw new Exception("User ID is required for update");
		}
		if (!$this->isAdmin()) {
			throw new Exception("Only admin users can update users");
		}
		if (!isset($username) || !isset($email)) {
			throw new Exception("Username and email are required for update");
		}
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			throw new Exception("Invalid email format");
		}
		$database = new Database();
		$conn = $database->getInstance();

		// restrain email to be unique
		$emailQuery = "SELECT * FROM pizza_users WHERE email = :email AND id != :id";
		$emailStmt = $conn->prepare($emailQuery);
		$sanitizedEmail = filter_var($email, FILTER_SANITIZE_EMAIL);
		$emailStmt->bindValue(':email', $sanitizedEmail);
		$emailStmt->bindValue(':id', $targetUserId, PDO::PARAM_INT);
		if ($emailStmt->execute()) {
			if ($emailStmt->rowCount() > 0) {
				throw new Exception("Email already exists");
			}
		} else {
			throw new Exception("Failed to check email existence");
		}

		$query = "UPDATE pizza_users SET  email = :email, role = :role WHERE id = :id";
		$stmt = $conn->prepare($query);
		$stmt->bindParam(':id', $targetUserId, PDO::PARAM_INT);
		// $stmt->bindParam(':username', $username);
		$stmt->bindParam(':email', $email);
		$stmt->bindParam(':role', $role);
		if ($stmt->execute()) {
			return true;
		}
		throw new Exception("Update user failed");
	}


}