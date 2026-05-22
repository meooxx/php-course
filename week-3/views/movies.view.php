<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>week-3</title>
</head>

<body>
	<main>
		<section>
			<h1>Popular Movies Page: <?php echo $lessonActivePage; ?>
			</h1>
			<section>
				<?php
				foreach ($lessonMovieRecords as $singleMovieObject) {
					$validatedTitle = htmlspecialchars($singleMovieObject->title ?? "Untitled Movie");
					$validatedRelease = htmlspecialchars($singleMovieObject->release_date ?? "N/A");
					$extractedPoster = $singleMovieObject->poster_path ?? null;
					$resolvedImgUrl = $extractedPoster
						? "https://image.tmdb.org/t/p/w500" . $extractedPoster
						: "https://via.placeholder.com/100x150.png?text=No+Image";
				?>
					<div>
						<img class="movie-poster" src="<?php echo $resolvedImgUrl; ?>" alt="<?php echo $validatedTitle; ?>">
						<h3><?php echo $validatedTitle; ?></h3>
						<p><?php echo $validatedRelease; ?></p>
					</div>

				<?php
				}		?>


			</section>
			<section>
				<?php 
					$previousStep = max(1, $lessonActivePage - 1);
					$nextStep = $lessonActivePage + 1;
					if($lessonActivePage > 1) {
						echo "<a href='?page={$previousStep}'>Previous Page</a>";
					}
					echo "<a href='?page={$nextStep}'>Next Page &raquo;</a>";	
				?>
			</section>

		</section>
	</main>

</body>



</html>