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

-- amdin seed sql
-- initially insert an admin user admin/1234
insert into pizza_users(username, password, email, role) values(
	'admin', 
  '$2y$12$sGRs00v.4aT/wTVVAaMeU.oM95IFYq3EPRT1q83GTLIKW6qdOGtBi',
	'admin@example.com',
	'admin');
SET @id := LAST_INSERT_ID();
INSERT INTO pizza_admins (user_id) 
VALUES (@id);