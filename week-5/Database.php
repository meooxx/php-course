<?php 

/** 
 *  database connections
 *  
 */
class Database {

	private $host = DB_HOST;
	private $user = DB_USER;
	private $password = DB_PASSWORD;
	private $dbname = DB_NAME;
	// this property will hold our actual conection
	private $pdoInstance  = null;

  // constructor method
	// this magic method automatically run the connection
	public function __construct($host, $dbname, $user, $password) {
		$this->host 		= $host;
		$this->dbname 	= $dbname;
		$this->user 		= $user;
		$this->password = $password;
		$this->connect();
	}

	// this method will connect to the database
	public function connect() {
		if($this->pdoInstance !== null) {
			return $this->pdoInstance;
		}
		// create a DSN(data source name) string
		$dsn = "mysql:host={$this->host};dbname={$this->dbname};charset=utf8mb4";
		// config pdo options
		// we configure pdo to change its default behaviors and easier to work with
		// 
		$options = [
			// tell php if anything goes wrong with sql crash with an
			// explicit readable error message

			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, 
			// tell formats the database rows as objects rather than
			// multi-dimensional arrays
			// it lets us type out $movie->title instead of 
			// $movie['title']
			PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
			// PDO::DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
	    PDO::ATTR_EMULATE_PREPARES => false,
	    

		];

		// try/catch block
		try {
			$this->pdoInstance = new PDO($dsn, $this->user, $this->password, $options);
			return $this->pdoInstance;
		} catch(PDOException $e)  {
			error_log('database connection failed'. 'Database.php');
			// 
			// die("Database connection failed: " . $e->message());
		}
		
	}




}
 



?>