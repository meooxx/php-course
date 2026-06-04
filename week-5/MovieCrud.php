<?php

// movie crud class
// this class will handle the actual sql data logic
class MovieCrud
{
	// this property will store the data connection
	private $dbConnection;
	/**
	 * dependency injection constructor
	 * the built-in pdo class to only accept a valid,  working instance of  the built-in  pdo class
	 * 
	 */
	public function __construct(PDO $activePdoConnection)
	{
		$this->dbConnection = $activePdoConnection;
	}

	// read operation
	public function readAllPoluar($select = 1)
	{
		//  basic pagination
		$recordsPerPage = 12;
		$offset = ($select - 1) * $recordsPerPage;
		// prepared statements & named placeholders
		$sqlQuery = "SELECT  * FROM lessonMovies order by popularity DESC LIMIT :limit OFFSET :offset";
		try {
			// prepare the query template with the database server
			$statement = $this->dbConnection->prepare($sqlQuery);
			// bind value
			$statement->bindParam(':limit', $recordsPerPage, PDO::PARAM_INT);
			$statement->bindParam(':offset', $offset, PDO::PARAM_INT);
			$statement->execute();
			return $statement->fetchAll();
		} catch (PDOException $e) {
			error_log('movie crud line 33');
			// echo "Error: " . $e->message();
			return [];
		}
	}
}
