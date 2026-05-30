<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="description" content="this is a page showing dogs">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="robots" content="noindex, nofollow">
	<title>assignment-1 dogsss</title>
	<link rel="stylesheet" href="views/css/style.css">
</head>

<body>
	<main>
		<header>
			<h1>Dogs Gallery</h1>
		</header>
		<section>
			<section class="dog-list">
				<?php
				foreach ($result as $singleDogObject) {
					$breeds = $singleDogObject->breeds ?? [];
					$breed = count($breeds) > 0 ? $breeds[0] : [];
					$name = $breed->name ?? "Unnamed breed";
					$resolvedImgUrl = $singleDogObject->url
						? $singleDogObject->url
						: "https://placehold.co/600x400?text=No+Img";
					?>
					<div class="dog-card">
						<img class="dog-image" src="<?php echo $resolvedImgUrl; ?>" alt="dog img">
						<h3 class="dog-name">
							<?php echo htmlspecialchars($name); ?>
						</h3>

					</div>

					<?php
				}
				?>

			</section>
		</section>
		<!-- <section>
			<h2>Bay Retriever</h2>
			<section class="dog-list">
			
			</section>
		</section> -->

	</main>