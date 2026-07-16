<?php 
	require_once 'Database.php';
	class UserCRUD {
		private PDO $conn;
		private string $table = 'users';
		public function __construct(Database $db)  {
			$this->conn = $db->connect();
		}

		public function create_user(string $username, string $email, string $hashed_password): bool {
			$query = "INSERT INTO {$this->table} (username, email, password) VALUES (:username, :email, :password)";
			$stmt = $this->conn->prepare($query);
			$stmt->bindParam(':username', $username);
			$stmt->bindParam(':email', $email);
			$stmt->bindParam(':password', $hashed_password);
			if($stmt->execute()) {
				return true;
			}
			// the failsafe: if  something
			throw new Exception("Something failed inside the UserCRUD class");
		}
	}

    
?>