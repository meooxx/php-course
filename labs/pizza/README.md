# Doomino's — Interface Design Using CSS (Selling Out!)

Doomino's is a fictional pizza storefront built for the **Interface Design Using CSS** main project. 
It is a public-facing product website: browse the menu, open product pages, and use the contact page. (separate from the PHP final-project build).

---

## Product

**Doomino's** sells specialty pizzas (academic demo only).  
---

## Color scheme

**Complementary**

| Role | Color |
|------|--------|
| Brand blue | `rgb(0, 144, 226)` |
| Accent red | `rgb(227, 24, 55)` |
| Page background (cream) | `#f7f4ef` |

Defined in `css/tailwind-config.js` and used across pages with Tailwind utilities.

---

## Typography

| Role | Font |
|------|------|
| Display (headings, nav, labels) | Oswald |
| Body | Nunito Sans |

Letter-spacing is used on navigation, tags, and call-to-action text.

Shared chrome:

- `templates/header.php` — metadata, fonts, Tailwind CDN, CSS
- `templates/nav.php` — logo, navigation, Order Online CTA
- `templates/footer.php` — company / contact information

---

## Technologies

- HTML5
- CSS3 + Tailwind CSS (CDN)
- PHP (page includes + product queries)
- MySQL (PDO)
- Google Fonts (Oswald, Nunito Sans)

---

## Database setup

Create a MySQL database on the target server.

Product pages(e.g.):

- `detail.php?id=1`
- `detail.php?id=2`
- `detail.php?id=3`

---

### Local preview

```bash
cd /path/to/this-folder
php -S localhost:8080
```

Visit http://localhost:8080/


