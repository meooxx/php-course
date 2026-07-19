

create table if not exists products (
	id INT AUTO_INCREMENT PRIMARY KEY,
	tag enum("popular", "Veggie", "meat" ) not null,
	name varchar(255) not null,
	description text not null,
	price decimal(10,2) not null,
	pic varchar(255) not null
)

insert into products (tag, name, description,  price, pic) values
("popular", "Pepperoni pizza", "Loads of pepperoni with mozzarella.", 12.99, 'pizza-pepperoni.jpg'),
("popular", "Margherita pizza", "Classic delight with 100% real mozzarella cheese", 10.99, 'pizza-margherita.jpg'),
("Veggie", "Farmhouse", "Delightful combination of onion, capsicum, tomato & grilled mushroom", 7.99, 'pizza-farmhouse.jpg'),
("meat", "Pepper Barbecue Chicken", "Pepper barbecue chicken for that extra zing", 8.99, 'pizza-pepper-barbecue-chicken.jpg');