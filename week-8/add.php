<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Add User</title>
</head>

<body>
	<main>
		<?php
		require_once('crud.php');
		require_once('validate.php');
		$crud = new Crud();
		$validate = new Validate();
		if (isset($_POST['Submit'])) {
			$name = $crud->escape_string($_POST['name']);
			$email = $crud->escape_string($_POST['email']);
			$age = $crud->escape_string($_POST['age']);
			$fields = array('name', 'email', 'age');
			$msg = $validate->checkEmpty($_POST, $fields);
			$checkAge = $validate->validAge($age);
			$checkEmail = $validate->validEmail($email);
			if ($msg != null) {
				echo "<p>$msg</p>";
				echo "<a href='javascript:history.back();'>GO back</a>";

			} elseif (!$checkAge) {
				echo "<p>must be a valid age</p>";
			} elseif (!$checkEmail) {
				echo "<p>Email is not valid</p>";
			} else {
				echo "<p>Record created</p>";
				echo "<a href='index.php'>Go Home</a>";
				$result = $crud->execute("INSERT INTO week8phpusers(name, email, age) VALUES ('$name', '$email', '$age')");

			}


		}


		?>
	</main>
</body>

</html>