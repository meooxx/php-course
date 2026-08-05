# PHP course project

Doomino's is a fictional pizza **inventory** system for the final project in *Intro to Web Programming Using PHP*. This branch (`php-course`) is split from the full-stack app (auth + inventory + users)

## Visual theme

Most layout uses **Tailwind CSS** utility classes. Colors live in `css/tailwind-config.js` — change hex values only; do not add or remove token keys.

Current palette (black + cyan):

| Token | Value | Role |
|-------|--------|------|
| `dominos-blue` | `#0a0a0a` | Header / primary dark |
| `dominos-blue-deep` | `#000000` | Darker hover / overlays |
| `dominos-red` | `#00b4d8` | Accent (buttons, tags) |
| `dominos-red-deep` | `#0090ad` | Accent hover |
| `dominos-red-soft` | `#d6f4fb` | Soft accent surface |


Fonts: Oswald (display) + Nunito Sans (body). 

Homepage: video-only hero; brand title **Inventory**. Hero video: `videos/hero.mp4`.

## Project goal

Inventory management with two roles:

- Guests browse products, open a single product page, and register.
- Admins manage products and users after signing in.


### Admin

- Add / edit / delete product
- Update / delete user
- Create another admin via registration when already signed in as admin


### Shared templates

- `templates/header.php`
- `templates/nav.php`
- `templates/footer.php`

### PHP classes

- `models/Database.php` — database connection
- `models/Auth.php` — auth, user CRUD, admin checks
- `models/products.php` — product CRUD and validation
- `models/Session.php` — session helper

### Controllers

- `controllers/AuthController.php`
- `controllers/ProductController.php`

### SQL

- `models/users.sql`
- `models/product.sql`

### Styling and assets

- `css/styles.css` — small overrides 
- `css/tailwind-config.js` — theme tokens

## Technologies

- PHP, CSS, Tailwind CSS (CDN), MySQL, Sessions

## Database design

### `pizza_users`

- `id`, `username`, `password`, `email`,  `role`
- Passwords use `password_hash()`

### `pizza_admins`

- `id`, `user_id`, 
- Admin access is checked via membership in this table (linked to `pizza_users.id`)

### `products`

- `id`, `tag`, `name`, `description`, `price`, `pic`, `stock`

## Admin logic

Regular users and admins both live in `pizza_users`; real admin permission is `pizza_admins`.

- Guests can only register as normal users
- Non-admins cannot assign `admin` from the form


## Local setup

```bash
# php environment required
cd php-course/labs/pizza
```

Create a MySQL database 

```bash
php -S localhost:8080
```

Open [http://localhost:8080/](http://localhost:8080/).


## Known issues / notes

- Watch for **global variable pollution** (`$user`, product ids, etc.)
- Deleting the **currently logged-in** user can invalidate the session
- Errors inside `status.php` page once caused an infinite redirect loop

## Disclaimer

Homepage hero video: [Pexels 6093658](https://www.pexels.com/video/6093658/) (academic use; local file `videos/hero.mp4`).
