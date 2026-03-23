# 🛍️ E-Commerce Platform — Team 67

A full-stack e-commerce web application built as part of the CS2TP module at Aston University. The platform allows users to browse, search, and purchase clothing products, while administrators can manage inventory, orders, and customers through a dedicated dashboard.

---

## 👥 Team

| Name | Role |
|------|------|
| Hatim | Project Coordinator & Backend Engineer |
| Rohan | Backend Engineer & Database Engineer |
| Yusuf | Backend Engineer & Database Engineer |
| Wafa | Frontend Engineer & UI Developer |
| Arifa | Frontend Engineer & UI Developer |
| Zain | Testing & Quality Assurance |

---

## 🚀 Features

- **Product browsing** — grid layout with categories, filtering, and search
- **Product pages** — size selector, quantity input, descriptions, and pricing
- **Shopping cart** — add, update, and remove items with live price totals
- **User authentication** — register, login, and logout with session management
- **Order tracking** — view order history and account details from user dashboard
- **Reviews & feedback** — customers can leave product reviews
- **Admin dashboard** — manage products, inventory, orders, customers, and returns
- **Stock management** — real-time product availability tracking
- **Input validation** — form validation across login, register, and checkout pages

---

## 🛠️ Tech Stack

| Layer | Technology |
|-------|-----------|
| Frontend | HTML, CSS, JavaScript |
| Backend | PHP |
| Database | SQL |
| Version Control | Git & GitHub |
| Task Management | Trello |

---

## 📁 Project Structure

```
E-Commerce-Project/
├── admin/              # Admin panel pages
├── backend/middleware/ # Backend middleware
├── controllers/        # Application controllers
├── css/                # Stylesheets
├── js/                 # JavaScript files
├── static/             # Static assets
├── templates/          # HTML templates
├── images/             # Product and UI images
├── routes/             # Route definitions
├── docs/               # Documentation
├── index.php           # Entry point
├── login.php           # User login
├── register.php        # User registration
├── products.php        # Product listing
├── product_detail.php  # Individual product page
├── cart.php            # Shopping cart
├── checkout.php        # Checkout flow
├── orders.php          # Order history
└── admin.php           # Admin dashboard
```

---

## ⚙️ Getting Started

1. Clone the repository:
   ```bash
   git clone https://github.com/hat1m11/E-Commerce-Project.git
   ```

2. Set up a local PHP server (e.g. XAMPP or WAMP) and place the project in your `htdocs` folder.

3. Import the SQL database using your preferred tool (e.g. phpMyAdmin).

4. Update `config.php` with your database credentials.

5. Visit `http://localhost/E-Commerce-Project` in your browser.

---

## 🧪 Testing

Testing was carried out across all core features including user authentication, cart management, order processing, input validation, and admin functionality. The system was repeatedly tested during development to ensure reliability and stability.

---

## 📋 Project Management

- **Trello** was used to track tasks across "To Do", "In Progress", and "Complete" columns, with deadlines assigned to each task.
- **GitHub** was used for version control, allowing the team to collaborate safely and track all code changes.
- Weekly team meetings and a WhatsApp group chat kept communication consistent throughout development.

---

> Built with 💙 by Team 67 — Aston University, CS2TP
