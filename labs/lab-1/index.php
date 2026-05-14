<?php
$students = [
	["name" => "Qiu", "score" => 55, "subject" => "Math"],
	["name" => "Adam", "score" => 45, "subject" => "Networking"],
	["name" => "Alic", "score" => 30, "subject" => "Database"],
	["name" => "Jessica", "score" => 99, "subject" => "Networking"],
];

function getGrade($score)
{
	if ($score >= 50) {
		return "<span class='pass'>Pass</span>";
	} else {
		return "<span class='fail'>Fail</span>";
	}
}





?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Week Two | lab-1</title>
	<meta name="description" content="lab-1">
	<meta name="robots" content="noindex, nofollow">
</head>

<body>
	<main>
		<section>
			<h1 class="student">Student Grades</h1>
			<ul>
				<?php foreach ($students as $student): ?>
					<li>
						<h3><?php echo htmlspecialchars($student['name']); ?></h3>
						<p>
							<span>subject: <?php echo htmlspecialchars($student['subject']) ?> </span>

						</p>
						<p>score: <?php echo getGrade($student['score']) ?> </p>

					</li>
				<?php endforeach; ?>
				<div class="product-card">
			</ul>
		</section>

	</main>
	<footer>
		<p>System Status: total student evaluated: <?php echo count($students); ?> </p>
		<p>evaluation time: <?php echo date('Y'); ?></p>
	</footer>

</body>