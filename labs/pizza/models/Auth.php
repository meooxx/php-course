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
		if (!isset($userId)) {
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
		if (!$this->isLoggedIn()) {
			return false;
		}

		$database = new Database();
		$conn = $database->getInstance();
		$query = "SELECT user_id FROM pizza_admins WHERE user_id = :user_id LIMIT 1";
		$stmt = $conn->prepare($query);
		$stmt->bindValue(':user_id', Session::get('user_id'), PDO::PARAM_INT);
		if ($stmt->execute()) {
			return $stmt->fetch() !== false;
		}
		return false;
	}
	public function requireAdmin()
	{
		if (!$this->isAdmin()) {
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

	public function register($username, $password, $confirmPassword, $email, $role): array
	{
		if (!isset($username) || !isset($password) || !isset($email)) {
			throw new Exception("Username, password and email are required");
		}
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			throw new Exception("Invalid email format");
		}
		if ($password !== $confirmPassword) {
			throw new Exception("Passwords do not match");
		}

		$normalizedRole = strtolower(trim((string) $role));
		if (!in_array($normalizedRole, ['user', 'admin'], true)) {
			$normalizedRole = 'user';
		}
		if ($normalizedRole === 'admin' && !$this->isAdmin()) {
			throw new Exception("Only admin users can create another admin");
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
		$stmt->bindParam(':role', $normalizedRole);
		if ($stmt->execute()) {
			$userId = $conn->lastInsertId();
			// If the new account is created as an admin, also register it in pizza_admins.
			if ($normalizedRole === 'admin') {
				$checkAdminQuery = "SELECT user_id FROM pizza_admins WHERE user_id = :user_id LIMIT 1";
				$checkAdminStmt = $conn->prepare($checkAdminQuery);
				$checkAdminStmt->bindValue(':user_id', (int) $userId, PDO::PARAM_INT);
				$checkAdminStmt->execute();

				if ($checkAdminStmt->fetch() === false) {
					$adminQuery = "INSERT INTO pizza_admins (user_id) VALUES (:user_id)";
					$adminStmt = $conn->prepare($adminQuery);
					$adminStmt->bindValue(':user_id', (int) $userId, PDO::PARAM_INT);
					$adminStmt->execute();
				}
			}

			return ['success' => true, 'userId' => $userId];
		}
		return ['success' => false];
	}

	public function getUsers(): array
	{
		$database = new Database();
		$conn = $database->getInstance();
		$query = "SELECT * FROM pizza_users order by id DESC";
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
			$normalizedRole = strtolower(trim((string) $role));
			if ($normalizedRole !== 'admin') {
				$normalizedRole = 'user';
			}

			// Keep pizza_admins in sync with the chosen role.
			if ($normalizedRole === 'admin') {
				$checkAdminQuery = "SELECT user_id FROM pizza_admins WHERE user_id = :user_id LIMIT 1";
				$checkAdminStmt = $conn->prepare($checkAdminQuery);
				$checkAdminStmt->bindValue(':user_id', (int) $targetUserId, PDO::PARAM_INT);
				$checkAdminStmt->execute();

				if ($checkAdminStmt->fetch() === false) {
					$adminQuery = "INSERT INTO pizza_admins (user_id) VALUES (:user_id)";
					$adminStmt = $conn->prepare($adminQuery);
					$adminStmt->bindValue(':user_id', (int) $targetUserId, PDO::PARAM_INT);
					$adminStmt->execute();
				}
			} else {
				$adminQuery = "DELETE FROM pizza_admins WHERE user_id = :user_id";
				$adminStmt = $conn->prepare($adminQuery);
				$adminStmt->bindValue(':user_id', (int) $targetUserId, PDO::PARAM_INT);
				$adminStmt->execute();
			}

			return true;
		}
		throw new Exception("Update user failed");
	}


}