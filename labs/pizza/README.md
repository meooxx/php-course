# Doomino's Pizza Lab

Doomino's is a fictional pizza store built for the final project in *Intro to Web Programming Using PHP*. The site combines a public product catalog with an admin side for inventory and user management. The visual style is inspired by modern pizza ordering sites[dominos.ca](https://www.dominos.ca/en/), but the branding, structure, and code are original student work.

## Project goal

The project is designed as an inventory management system with two main roles:

- Guests can browse products, open a single product page, place orders, and register a new account.
- Admins can manage products and manage users after signing in.


## Main features

### Public features

- Homepage
- Register page
- Product listing page
- Single product and Order page
- Header login form
- Shared header and footer

### Admin features

- Add product
- Edit product
- Delete product
- Update user
- Delete user
- Create another admin account through the registration flow when already signed in as an admin

### Extra features
For other assignments(php previous assignments and css couse project)
- Order form on the single product page
- Order placement with stock decrement
- Orders page
- About page
- Contact page
- Status/feedback page 

## Pages and files

### Public pages

- `index.php` - homepage
- `shop.php` - all products / menu
- `detail.php` - single product page
- `auth.php?act=register` - register page
- `auth.php?act=login` - login page
- `about.php` - about page
- `contact.php` - contact page
- `status.php` - status/result page

### Admin pages

- `product.php` - inventory list
- `product_edit.php` - add/edit product form
- `users.php` - user management
- `orders.php` - orders list

### Shared templates

- `templates/header.php`
- `templates/nav.php`
- `templates/footer.php`

### PHP classes

- `models/Database.php` - database connection
- `models/Auth.php` - auth, user CRUD, admin checks
- `models/products.php` - product CRUD and validation
- `models/Order.php` - order placement logic
- `models/Session.php` - session helper

### Controllers

Page request logic is handled in controllers. Models still do the database work.

- `controllers/AuthController.php` - register, login, logout, update/delete user
- `controllers/ProductController.php` - add, edit, delete product
- `controllers/OrderController.php` - place order

### SQL files

- `models/users.sql`
- `models/product.sql`
- `models/orders.sql`

### Styling and assets

- `css/styles.css`
- `css/tailwind-config.js`
- `images/`

## Technologies used

- PHP
- HTML5
- CSS
- Tailwind CSS
- MySQL
- Sessions

## Database design

The project currently uses these main tables:

### `pizza_users`

Stores all account records:

- `id`
- `username`
- `password`
- `email`
- `created_at`
- `role`

Passwords are stored using `password_hash()`.

### `pizza_admins`

Stores admin membership:

- `id`
- `user_id`
- `created_at`

This table links admin access back to `pizza_users.id`. The application checks admin permission by seeing whether the logged-in user exists in `pizza_admins`.

### `products`

Stores inventory data:

- `id`
- `tag`
- `name`
- `description`
- `price`
- `pic`
- `stock`

### Orders

The project also includes an orders table for php previous assigments.
`id`,
`name`,
`email`,
`phone`,
`product_id(foreign key)`,
`user_id (foreign key)`,
`size`,
`crust`,
`quantity`,
`fulfillment`,


## Admin logic

Regular users and admins both exist in `pizza_users`, but actual admin permission is controlled through `pizza_admins`. I initially used the role field to check if a user is an admin. However, to meet the assignment requirements, I added this table.

Current behavior:

- A guest can only register as a normal user.
- A non-admin cannot assign the `admin` role from the form.
- If someone manually submits `role=admin`, the backend checks whether the current user is already an admin.
- When a user is promoted to admin, the app checks whether the user already exists in `pizza_admins`. If not, it inserts the user there.
- When a user is changed back to a normal user, the matching record is deleted from `pizza_admins`.


## Local setup

### 1. Clone the repository

```bash
git clone git@github.com:meooxx/php-course.git
cd php-course/labs/pizza
```

### 2. Create a database

Create a MySQL database and update fields in `Datebase.php`

### Run the site

```bash
# php environment required
php -S localhost:8080
```

Then open:

- [http://localhost:8080/](http://localhost:8080/)

## Suggested test flow

### Guest flow

1. Open the homepage.
2. Use the header navigation to open the menu.


### Admin flow

1. Sign in through the header login form.
2. Open `product.php`.
3. Add a product.
4. Edit a product.
5. Delete a product.
6. Open `users.php`.
7. Update a user.
8. Delete a user.

### Order flow

1. Browse `shop.php`
2. Open a product in `detail.php`.
3. Submit the order form.

## Known issues / development notes

These are useful to mention:

- One bug encountered during development was **global variable pollution**, especially those very common variables like `$user`, `productId`, `$userId`.
- Another issue was **deleting the currently logged-in user**. If an admin deletes their own account, the session can become invalid. 
- An error occurring inside status.php would trigger a redirection to itself, resulting in an infinite redirect loop

## Disclaimer

Doomino's is a fictional student project made for educational use only. It is not affiliated with Domino's Pizza. Some layout ideas and visual patterns were studied from commercial pizza sites, but the final code and project structure are student work.
