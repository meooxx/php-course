<?php
/**
 * 
 */
$userName 				= "Shaoqiu";
$userRole 				= "Student";
$accountBalance 	= 45.50;
$isGraduated 			= false;
$currentHour 			= (int)date("H"); 

// determing a greeting based on the hour 

if($currentHour < 12) {
	$greeting = "Good Morning";
} elseif ($currentHour < 17) {
	$greeting = "Good Afternoon";
} else {
	$greeting = "Good Evening";
}


// determing a css class based on the user role
if($userRole === "instructor") {
	$themeClass = "gold-border";
} else {
	$themeClass = "blue-border";
}

// logical operator: check if they are a student and have a balance
$needToPay = ($userRole == "Student" && $accountBalance > 0)

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>week 1 | Intro to PHP</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="robots" content="noindex, nofollow">
<head>

<body>
	<header>
		<h1>Week 1 Lesson</h1>
	</header>
	<main>
		<section class="card <?php echo $themeClass; ?>">
			<h2><?php echo $greeting . ", "  . $userName; ?></h2>
			<p>Your current role is: <mark><?php echo $userRole; ?></mark></p>
			<?php if($userRole == "Student"): ?>
				<p>Student tools: You have nice tools</p>
			<?php else: ?>
				<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Consectetur, quae provident? Veritatis dolore cupiditate aliquam, veniam provident ullam id quidem iusto, eligendi iure et quo!</p>
			<?php endif; ?>
			<!-- add a warning message using our and logic -->
			 <?php if($needToPay): ?>
				<div class="alert">
					<p>Notice: Pay up <?php echo number_format($accountBalance, 2); ?></p>
				</div>
			 <?php endif; ?>
			 
		</section>
	</main>
	<footer>
		<p>&copy <?php echo date("Y"); ?></p>
	</footer>

</body>
</html>