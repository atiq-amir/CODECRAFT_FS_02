#  Employee Management System (Admin Dashboard)

A lightweight, **responsive** web application that lets **authorised administrators** perform full **CRUD** operations on employee records while keeping data safe through solid authentication & validation.

---

##   Features
- **Secure login / logout** (bcrypt password hashing + PHP sessions)
- **Role-based access** – only users with `role = admin` can manage employees
- **Full CRUD**
  - **C** – add new employees (with validation)
  - **R** – paginated table with search-friendly layout
  - **U** – edit any employee
  - **D** – delete with JavaScript confirmation
- **Admin profile management** (name, email, phone, avatar upload)
- **Responsive UI** – works from 320 px phones to 4 K desktops (CSS-only)
- **Client + server side validation** (regex, HTML5, escaping)

---

##   Tech Stack
| Layer        | Technology               |
|--------------|--------------------------|
| Back-end     | PHP 7.4+ (procedural)    |
| Database     | MySQL / MariaDB          |
| Front-end    | HTML5, Bootstrap 5, pure CSS |
| Tooling      | **Zero** build tools or JS frameworks |

---

##   Project Tree
.
├── *.php              # All public pages (see list below)
├── config.php         # Database connection
├── images/            # Uploaded avatars
├── README.md          # This file
└── .gitignore         # Optional – add images/ if you want
Core scripts
├── login.php
├── signup.php
├── logout.php
├── admin.php          # Dashboard home
├── employees.php      # List + delete
├── add_employee.php
├── update_employee.php
├── settings.php       # Admin profile
└── forgot_password.php (placeholder)


---

##   Quick Start
1. **Clone / download** this repo to your web root (e.g. `htdocs/hireup`).
2. **Import** the SQL snippet (see next section) into a database named `hireup`.
3. **Create writable folder** for avatars:
   ```bash
   mkdir images
   chmod 755 images
4. Edit config.php – update DB credentials if needed.
5. Browse to http://localhost/hireup/login.php.
6. Register an account (role = admin) and log in.

   ## Minimal SQL

-- Admin/users table
CREATE TABLE admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    phone VARCHAR(20),
    password VARCHAR(255) NOT NULL,
    pfp VARCHAR(255) DEFAULT 'default.png',
    role ENUM('admin','user') DEFAULT 'user',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Employees table
CREATE TABLE employees (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    contact VARCHAR(20) NOT NULL,
    salary DECIMAL(10,2) NOT NULL,
    added_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);


---

## 📁  Project Tree
