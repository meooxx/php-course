functions

```
function greet() {
echo "Hello!";
}

```

```
function add($a, $b) {
return $a + $b;
}
```

Arrays

```
$colors = array("Red", "Blue", "Green");
echo $colors[0]
```

```
$student = array(
	"name" => "Alice",
	"grade" => "A",
	"age" => 20
);
echo $student["name"];
```

loops

```
foreach ($colors as $color) {
	echo $color . "<br>";
	}
```

security

```
htmlspecialchars()
```

common php functions

```
int n = count()
bool isEmpty = empty()
bool isSet = isset()
int n = numer_format(n, digits)
Date date('Y-m-d')
Date date("H:i:s") 22:10:11
$_GET, get query
$_POST, $_POST['action']
$_SERVER, $_SERVER['REQUEST_METHOD']
$_SESSION

```

class

```
Encapsulation
▪ Bundling data (properties) and the
methods that operate on that data into
a class

inheritance
▪ Allows a new class (child class) to
inherit properties and methods from
an existing class (parent class).

Polymorphism
▪ "Many forms." Allows objects of
different classes to be treated as
objects of a common superclass.

Abstraction
▪ Hiding complex implementation details
and showing only the essential
features of the object


```

api

```
Application Programming Interface.
▪ It's a set of rules and protocols for building and interacting with software applications.

```

make api

```
$curl = curl_init()
curl_setopt_array($curl, [
	CURLOPT_URL=> url,
	CURLOPT_RETURNTRANSFER => True
])
$resp = curl_exec($curl)
curl_close($curl)
$jsonData = json_decode($resp)
```

PDO (php data object)

```
	$options = [
			// tell php if anything goes wrong with sql crash with an
			// explicit readable error message

			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
			// tell formats the database rows as objects rather than
			// multi-dimensional arrays
			// it lets us type out $movie->title instead of
			// $movie['title']
			PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
			// PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
	    PDO::ATTR_EMULATE_PREPARES => false,


		];
	$dsn = "mysql:host={$this->host};dbname={$this->dbname};charset=utf8mb4";
	$instance = new PDO($dsn, $this.username, $this->password, $options) // connection
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

```

✅ True or False: The isset() function is used to determine if a variable is set and is not NULL.

✅ True or False: A dynamic web page is that a page that is built dynamically is created using a program or script that is running on a server.

✅ True or False: PHP variable values can change over the course of the script.

Pick the correct answer: What does the initials of PHP stand for ? PHP: Hypertext Preprocessor.

✅ True or False: $count++; is the correct way to add 1 to the count variable.

❌ True or False: PHP does not need a apache environment to work.

✅ A semicolon (;) is mandatory at the end of every PHP statement.

Pick the correct answer: Which of the following operator is used to concatenate two strings? [.]

✅ True or False: OOP stand for Object Oriented Programming.

✅ True or False: In PHP, $this keyword references the current object of the class.

✅ True or False: When working with an array, we use the foreach loop.
❌ True or False: PDO stands for Programming Data Object.

✅ True or False: If the require statement fails it will create a fatal error.

❌ True or False: You can access a private variable from anywhere in your web application.

✅ True or False: The require_once function will first check to see if the file has already been called

Which function is used to check if a variable has been set and is not NULL? isset

❌ It is generally considered best practice to store database credentials directly in the public HTML directory.

✅ Using prepared statements helps prevent SQL injection attacks.

Which of the following functions will generate a recoverable warning but continue script execution if a required file is not found? include

Which PHP method is used to execute a prepared statement after the parameters have been bound? statement.exec()

```
$sql = "SELECT * FROM books WHERE genre = :genreName ORDER BY title ASC";

$statement.bindparam(:genreName, $genre)
$stmt->bindParam(':genreName', $genreName, PDO::PARAM_STR);

```
convert string to int
```
	$lessonActivePage = isset($_GET['page']) ? (int)$_GET['page'] : 1;	
```

class
```
define("TMDB_API_KEY", "78b2cd38b33cb20115460315cbe0e9bc");

class Student {
	private $targetUrl;
	private $securityKey;
	public function __construct($p, $d) {}
	
	public function fetchCurrentPopul
}
```
foreach 

```
	<?php
				foreach ($arrary as $item) {
					$validatedTitle = htmlspecialchars($title)
				?>
					
				<?php } ?>
```