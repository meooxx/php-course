<?php 
	require_once 'config.php';
	require_once 'Database.php';
	require_once 'MovieCrud.php';

	$lessonActivePage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
	// instantiate the database class
	$dbEngine = new Database(DB_HOST, DB_NAME, DB_USER, DB_PASSWORD);
	// ask the database manager to run its connect action and save its connection
	$activeConnection = $dbEngine->connect();
	// create our crud
  $movieWorker = new MovieCrud($activeConnection);
	// tell the worker to fetch the rows for the specific page
	$lessonMovieRecords = $movieWorker->readAllPoluar($lessonActivePage);
	require_once 'templates/header.php';
	require_once 'views/movies.view.php';
	require_once 'templates/footer.php';

?>