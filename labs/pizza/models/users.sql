create table users (
	id INT AUTO_INCREMENT PRIMARY KEY,
	username varchar(255) not null,
	password varchar(255) not null,
	email varchar(255) not null,
	created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	Role enum("admin", "user") DEFAULT "user" not null
)