# Doomino's Pizza Lab

A fictional online pizza shop built for a college PHP / web design course. The site is inspired by the layout patterns of [dominos.ca](https://www.dominos.ca/en/) but uses an original student brand name, **Doomino's**, so it is not affiliated with Domino's Pizza.


## Technologies

| Area | Tools |
|------|--------|
| Markup / logic | HTML5, PHP |
| Styling | [Tailwind CSS](https://tailwindcss.com/) (CDN), `css/styles.css` |
| Theme config | `css/tailwind-config.js` |
| Fonts | **Oswald** (headings) and **Nunito Sans** (body) via Google Fonts |
| Database | MySQL + PDO (`models/Database.php`) |
| Server | PHP built-in server or any PHP + MySQL host |

## Pages

| Page | File | Description |
|------|------|-------------|
| Home | `index.php` | Promo tiles (dominos.ca-style layout) + Pepsi banner |
| About | `about.php` | Project story and brand disclaimer |
| Menu / Shop | `shop.php` | Product grid loaded from the database |
| Product / Order | `detail.php` | Product detail + pizza order form |
| Contact | `contact.php` | Store info + contact form layout |
| Orders | `orders.php` | Order list with search and simple role gate |
| Status | `status.php` | Generic success / failure message (`?success=1` or `0`) |

Shared layout: `templates/header.php`, `templates/nav.php`, `templates/footer.php`.

## Visual design

### Color scheme

| Token | Value | Use |
|-------|--------|-----|
| Domino's-inspired blue | `rgb(0, 144, 226)` | Header, titles, primary actions |
| Deep blue | `rgb(12, 89, 125)` | Hover states |
| Red accent | `rgb(227, 24, 55)` | Badges |
| Cream | `#f7f4ef` | Page background |
| Line / muted | `#d5d0c8` / `#666666` | Borders and secondary text |

Defined in `css/tailwind-config.js`.


### logo

- Fictional name: **Doomino's**
- Logo: student SVG (`images/logo.svg`) — red half with **two** dots on top, blue half with **one** dot on the bottom (intentionally different from Domino's)

## Database structure

Schema: `models/orders.sql`.  
PHP models: `models/products.php`, `models/Order.php`.

## Setup instructions

```bash
cd labs/pizza
```

### 3. Run locally

```bash
php -S localhost:8080
```

Open [http://localhost:8080/](http://localhost:8080/).

### 4. Typical flow
1. Browse **index**		
2. Browse **Menu** (`shop.php`) to find all the products
3. Open a product (`detail.php?id=…`) and submit the order form  
4. Redirect to **Status** (`status.php?success=1` or `0`)
5. View **Orders** (`orders.php`)


## disclaimer

- Layout patterns and some promotional images are adapted from [dominos.ca](https://www.dominos.ca/en/) for **educational use only**.
- This project is **not** affiliated with Domino's.
- **Doomino's** branding and logo are student-created for coursework.
- Additional drink photography may come from stock sources such as Unsplash.
- Do not deploy as a real commercial Domino's storefront.
