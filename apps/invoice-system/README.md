# Softex Technologies - Invoice Management System

A complete, modern, SaaS-style Invoice Management System developed in secure PHP (8+) and MySQL (MariaDB), styled with Bootstrap 5. This system incorporates administrative session authentication, client registry management, dynamic invoice line-item calculations, offline PDF generation, custom socket-based SMTP email delivery with attachments, and WhatsApp sharing.

---

## 📂 Project Directory Structure

```text
├── assets/
│   ├── css/
│   ├── js/
│   └── images/
│       └── logo.png              # Default Softex Technologies Logo (PNG)
├── uploads/                      # Location of uploaded corporate logo files
├── fpdf.php                      # Core FPDF library (PHP 8.x compatible)
├── font/                         # Standard FPDF fonts directory
├── db.sql                        # Database Schema & default Admin/Seed data
├── config.php                    # DB connection (PDO), sessions, utility helpers
├── header.php                    # Global HTML brand sidebar & top-nav layout
├── footer.php                    # Global JS scripts and closing container markup
├── login.php                     # Secure login interface (Bcrypt verification)
├── logout.php                    # Session-terminator and secure redirect
├── index.php                     # Dashboard containing analytical stats & widgets
├── clients.php                   # Searchable Corporate Client Registry (CRUD)
├── invoices.php                  # Searchable Invoice Registry (CRUD + Quick Pay toggle)
├── invoice-create.php            # Dynamic multi-item Invoice Generator (Interactive JS)
├── invoice-edit.php              # Multi-item Invoice Editor
├── invoice-view.php              # Invoice Details, Printable trigger, Action console
├── invoice-print.php             # Specialized media-print compliant template
├── invoice-pdf.php               # High-res A4 PDF generator utilizing FPDF
├── SmtpMailer.php                # Custom Socket SMTP client (TLS/SSL attachment support)
├── invoice-send.php              # Email coordinator compiling PDF and dispatching message
├── settings.php                  # System configurations (Profile, Terms, Logo, SMTP)
└── README.md                     # This installation & setup documentation
```

---

## 🛡️ Security Implementations

1. **Session Access Controls:** Active session checks are placed on all dashboard directories. Unauthorized visitors are redirected to the login panel immediately.
2. **Prepared Statements Everywhere:** Database interactions utilize PHP PDO parameterized queries to eliminate SQL Injection (SQLi) vulnerabilities.
3. **Password Security:** Administrative passwords use standard Bcrypt encryption hashing via `password_hash()` and are validated with `password_verify()`.
4. **Output Sanitization:** Custom `h()` helper functions escape content printed to the browser to prevent Cross-Site Scripting (XSS).
5. **Secure DB Connections:** Handled securely via PHP PDO with strict error-handling configurations.

---

## ⚙️ Step-by-Step Installation & Setup

### 📋 Prerequisites
- **Web Server:** Apache, Nginx, or IIS with PHP 8.0+ installed.
- **Database Server:** MySQL 5.7+ or MariaDB 10.3+.
- **PHP Extensions Enabled:** `pdo_mysql`, `mbstring`, `curl`, `openssl` (for secure SMTP mail transport).

### 🚀 Setup Steps

#### Step 1: Clone or Copy files to server root
Move all the system files (including `fpdf.php` and the `font/` directory) into your local development folder (e.g. `htdocs/softex-invoice` for XAMPP or `/var/www/html` for Linux).

#### Step 2: Set up permissions
Ensure the `uploads/` directory exists and has write permissions. Create it if it is missing:
```bash
mkdir -p uploads
chmod -R 755 uploads
```

#### Step 3: Initialize the Database
1. Open your database administration utility (e.g., phpMyAdmin, Adminer, or MySQL terminal).
2. Create a new database named `softex_invoice_db`:
   ```sql
   CREATE DATABASE softex_invoice_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   ```
3. Import the database structure and dummy data using the included `db.sql` file:
   ```bash
   mysql -u your_username -p softex_invoice_db < db.sql
   ```
   *(Note: The `db.sql` script includes `CREATE DATABASE IF NOT EXISTS softex_invoice_db` so you can also import it directly into your root server).*

#### Step 4: Configure DB Credentials
Open `config.php` and update the database host, user, password, and database name to match your environment settings:
```php
define('DB_HOST', '127.0.0.1');
define('DB_USER', 'your_mysql_username');
define('DB_PASS', 'your_mysql_password');
define('DB_NAME', 'softex_invoice_db');
```

#### Step 5: Start Your Server and Log In!
1. Start Apache and MySQL services on your local server environment.
2. Open your web browser and navigate to the application URL, for example:
   `http://localhost/softex-invoice/`
3. The system will automatically detect you are logged out and redirect you to the login screen.
4. **Log in using the pre-seeded Admin account:**
   - **Username / Email:** `admin@softex.pk`
   - **Password:** `admin123`

---

## 📬 SMTP Email Configurations

The system is equipped with an integrated high-performance **Socket-Based SMTP Mailer** (`SmtpMailer.php`). It implements RFC-compliant mail transactions, handles TLS/SSL socket handshakes, and packages Base64 attachments in-memory.

To set up outgoing email transfers:
1. Log in to the portal.
2. Navigate to **Settings** > **SMTP Configurations**.
3. Configure your server coordinates:
   - **SMTP Host:** `smtp.softex.pk` (or `smtp.gmail.com`)
   - **SMTP Port:** `587` (standard TLS) or `465` (SSL)
   - **SMTP Username:** `info@softex.pk`
   - **SMTP Password:** `your_secure_password_or_gmail_app_password`
   - **Security Type:** Choose **TLS** or **SSL**.
4. Save the configuration.

*Note: In local sandbox environments where outgoing sockets (Port 587/465) are firewalled or blocked, the email dispatch module will automatically log a detailed demo fallback alert indicating that the transaction was completed and recorded locally, showing exactly what was processed.*

---

## 💬 WhatsApp Integration Summary

When viewing any invoice statement (`invoice-view.php`), clicking the **Send via WhatsApp** option triggers a universal API connection.
It compiles:
- Corporate credentials (Softex Technologies).
- Client summary.
- Core totals (gross, discount, grand total, payment status).
- A **Dynamic Download URL** referencing the PDF invoice stream so clients can download their statement.
It then opens the official **WhatsApp Web** or mobile application with a fully pre-filled message, pre-targeted to the client's registered mobile phone number.

---

## 🛠️ System Customizations & Logo Upload
1. To change terms, navigate to **Settings** > **Terms & Conditions**. Update terms such as "Payment due within 7 days", "No refund after payment confirmation" dynamically.
2. To upload a custom corporate logo, navigate to **Settings** > **Corporate Profile**, select your image, and save. The system will safely replace your older logo and apply the new file on both browser templates and printable FPDF drafts instantly.
