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
	public function getUser()
	{
		if (self::$user !== null) {
			return self::$user;
		}
		if ($this->isLoggedIn()) {
			$userId = Session::get('user_id');
			$database = new Database();
			$conn = $database->getInstance();
			$query = "SELECT * FROM pizza_users WHERE id = :id";
			$stmt = $conn->prepare($query);
			$stmt->bindValue(':id', $userId, PDO::PARAM_INT);
			if ($stmt->execute()) {
				$user = $stmt->fetch();
				self::$user = $user;
				return $user;
			}

		}
		return null;
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
			error_log("Attempting login for username: " . $username);
			error_log("User data: " . print_r($user, true));
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

	public function register($username, $password, $confirmPassword, $email): bool
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
		$query = "INSERT INTO pizza_users (username, password, email) VALUES (:username, :password, :email)";
		$stmt = $conn->prepare($query);
		$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
		$stmt->bindParam(':username', $username);
		$stmt->bindParam(':password', $hashedPassword);
		$stmt->bindParam(':email', $sanitizedEmail);
		if ($stmt->execute()) {
			$userId = $conn->lastInsertId();
			Session::set('user_id', $userId);
			return true;
		}
		return false;
	}
}


?>