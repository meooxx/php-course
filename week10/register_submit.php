<?php 
    required_once 'inc/Database.php';
		required_once 'inc/UserCRUD.php';	
		include_once "templates/header.php";
		if($_SERVER['REQUEST_METHOD'] !== 'POST') {
			header("Location: register.php");
			exit;
		}
		echo "<section>Registration processing status!</section>";
		try {
			$username = trim($_POST['username']);
			$email = trim($_POST['email']);
			$password = trim($_POST['password']);
			$confirm_password = trim($_POST['confirm_password']);
			if($password !== $confirm_password) {
				throw new Exception("Passwords do not match");
			}
			/*
			* we never save plain text passwords. 
			* password_hash() scrambles  the password
			*/	

			$hashed_password = password_hash($password, PASSWORD_DEFAULT);

			if($hashed_password === false) {
				throw new Exception("Password hashing runtime error");
				exit;
			}
			$database = new Database();
			$userCRUD = new UserCRUD($database);
			if($userCRUD->create_user($username, $email, $hashed_password)) {
				echo "<div class='alert alert-success'>User created</div>";
			} 
		}catch(Exception $e) {
			if($e->getCode() === 23000) {
				echo "<div class='alert alert-danger'>Registration failed... the  username or email has already been taken</div>";
			}else  {
				echo "<div class='alert alert-danger'>Database Error</div>";
			}
		}	
		include_once "templates/footer.php";
		



?>