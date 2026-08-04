create table if not exists pizza_users (
	id INT AUTO_INCREMENT PRIMARY KEY,
	username varchar(255) unique not null,
	password varchar(255) not null,
	email varchar(255) unique not null,
	created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	Role enum("admin", "user") DEFAULT "user" not null
);

create table if not exists pizza_admins (
	id INT AUTO_INCREMENT PRIMARY KEY,
	user_id INT NOT NULL UNIQUE,
	created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	CONSTRAINT fk_pizza_admin_user
		FOREIGN KEY (user_id) REFERENCES pizza_users(id)
		ON DELETE CASCADE
);