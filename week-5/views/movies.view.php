<main>

	<section>
		<h2>Popular Movies</h1>
	</section>
	<section>
		<?php foreach ($lessonMovieRecords as $singleMoviewObject) {
			// securely handle text  data with htmlSpecialChars() function
			$validTitle 					= htmlspecialchars($singleMoviewObject->title ?? "unknown title");
			$validatedRelease 		= htmlspecialchars($singleMoviewObject->release_date ?? "N/A");
			$validatedDescription = htmlspecialchars($singleMoviewObject->description ?? "No description available");
			$validatedActors 			= htmlspecialchars($singleMoviewObject->main_actors ?? "N/A");
			$validatedGenre       = htmlspecialchars($singleMoviewObject->genre ?? "uncategorized");
		?>
			<div>
				<div>
					<span>
						<?php echo $validatedGenre ?>
					</span>
					<h3>
						<?php echo $validTitle; ?>
					</h3>
					<p>
						<?php echo $validatedRelease; ?>
					</p>
					<p>
						<?php echo $validatedDescription; ?>
					</p>
					<p>
						<?php echo $validatedActors; ?>
					</p>
				</div>
			</div>
		<?php } ?>
	</section>
	<section>
		<div>
			<?php 
				$previousStep = max(1, $lessonActivePage - 1);
				$nextStep = $lessonActivePage + 1;
				if ($lessonActivePage > 1) {
					echo "<a href='?page={$previousStep}'>Prev</a>";
				}
				echo "<a href='?page={$nextStep}'>Next</a>";
			
			?>
		</div>

	</section>


</main>