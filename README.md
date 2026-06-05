# petscare_sumaya  

A web‑based pet care management system built with PHP. It provides separate portals for **administrators**, **buyers**, and **doctors**, allowing them to manage users, pets, appointments, purchases, and support communications from a single codebase.

---

## Overview  

`petscare_sumaya` streamlines the workflow of a pet‑care business:

* **Admins** can oversee users, pets, appointments, and purchase records, as well as reply to messages.  
* **Buyers** can browse available pets, schedule appointments, place orders, and track order/appointment status.  
* **Doctors** can view and manage their appointment schedule.  

All data is stored in a MySQL database (`Database/petscare.sql`). The project follows a simple MVC‑like structure with dedicated folders for each role.

---

## Features  

| Role      | Core Capabilities |
|-----------|-------------------|
| **Admin** | Login / logout, dashboard, user management, pet management, appointment overview, purchase records, message replies, profile updates |
| **Buyer** | Home page, browse pets, schedule appointments, view/track orders, contact support, update profile, view messages |
| **Doctor**| View scheduled appointments |
| **Common**| Centralized configuration (`config.php`), reusable CSS (`css/style.css`), navigation bars for each role |

---

## Tech Stack  

| Layer | Technology |
|-------|------------|
| Backend | PHP 7.4+ |
| Database | MySQL (schema in `Database/petscare.sql`) |
| Front‑end | HTML5, CSS3 (custom stylesheet `css/style.css`) |
| Server | Apache / Nginx (compatible with any LAMP/LEMP stack) |

---

## Installation  

1. **Clone the repository**  

   ```bash
   git clone https://github.com/your-username/petscare_sumaya.git
   cd petscare_sumaya
   ```

2. **Create the database**  

   ```sql
   -- In MySQL client or phpMyAdmin
   SOURCE Database/petscare.sql;
   ```

3. **Configure database connection**  

   Edit `config.php` (and the role‑specific `config.php` files) and replace the placeholder values with your own credentials:

   ```php
   define('DB_HOST', 'YOUR_DB_HOST');
   define('DB_NAME', 'YOUR_DB_NAME');
   define('DB_USER', 'YOUR_DB_USER');
   define('DB_PASS', 'YOUR_DB_PASSWORD');
   ```

4. **Set up the web server**  

   - Place the project folder inside the web root (e.g., `htdocs` or `www`).  
   - Ensure the server points to `admin/admin_login.php` (admin), `buyer/buyer_home.php` (buyer), or `doctor/appointments.php` (doctor) as entry points.  
   - Enable `mod_rewrite` if you plan to use clean URLs.

5. **Install dependencies (if any)**  

   The project uses only core PHP, so no Composer packages are required.

---

## Usage  

### Admin Portal  
1. Navigate to `admin/admin_login.php`.  
2. Log in with admin credentials (default credentials can be set in the `users` table).  
3. Use the navigation bar to access dashboards, manage users/pets, view appointments, and reply to messages.

### Buyer Portal  
1. Open `buyer/buyer_home.php`.  
2. Browse pets, schedule appointments (`buyer/schedule_appointment.php`), or purchase a pet (`buyer/buy_pet.php`).  
3. Track order status (`buyer/order_status.php`) and appointment status (`buyer/appointment_status.php`).  

### Doctor Portal  
1. Access `doctor/appointments.php` to view upcoming appointments.  

All pages share a common look and feel defined in `css/style.css`. Adjust the stylesheet as needed to match your branding.

---

## License  

This project is licensed under the **MIT License**. See the `LICENSE` file for full details