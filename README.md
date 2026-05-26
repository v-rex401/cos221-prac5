# Tripistry

Tripistry is a travel-package platform built for COS 221 Practical Assignment 5.

## Tech stack

- **PHP 8** — server-side logic
- **MariaDB / MySQL** — relational database
- **HTML5, CSS, JavaScript** — front-end
- **Apache** — web server (via XAMPP)
- **Composer** — PHP dependency manager (see [Dependency management](#dependency-management))

## Prerequisites

Install the following before you begin:

1. **XAMPP** — provides Apache, MariaDB and PHP 8. Download: https://www.apachefriends.org
2. **Composer** — PHP dependency manager. Download: https://getcomposer.org/download
   During installation, when asked for the PHP executable, point it to
   `C:\xampp\php\php.exe`.

## Setup and installation

### 1. Place the project in the web root

Extract (or clone) the project into XAMPP's `htdocs` folder so the path is:

```
C:\xampp\htdocs\cos221-prac5
```

### 2. Install PHP dependencies

Open a terminal in the project root and run:

```
composer install
```

This creates the `vendor/` folder containing the project's only dependency,
`vlucas/phpdotenv`.

### 3. Configure the database connection

Copy the example environment file to `.env`:

```
copy .env.example .env
```

Open `.env` and set your database credentials. For a default XAMPP install no
changes are needed (user `root`, empty password):

```
DB_HOST=localhost
DB_NAME=u24611400_Tripistry
DB_USER=root
DB_PASSWORD=
```

### 4. Create and populate the database

1. Open phpMyAdmin at http://localhost/phpmyadmin
2. Create a new database named exactly **`u24611400_Tripistry`**
    CREATE DATABASE IF NOT EXISTS u24611400_Tripistry;
    USE u24611400_Tripistry;
   (collation `utf8mb4_general_ci`). This name must match `DB_NAME` in your `.env`.
3. Select the database, open the **Import** tab, choose **`final_dump.sql`** from
   the project root, and click **Go**.


### 5. Start the servers

In the XAMPP Control Panel, start **Apache** and **MySQL**.

### 6. Open the application

Visit: http://localhost/cos221-prac5/

## Default logins

The imported sample data includes these demo accounts:

| Role      | Email                   | Password        |
|-----------|-------------------------|-----------------|
| Traveller | `test1@gmail.com`       | `Test1Unicorn?` |
| Agency    | `jet2holiday@gmail.com` | `password123*` |

You can also register new Traveller or Agency accounts from the Sign Up page.

## Dependency management

This project uses **Composer** as its package manager. The only dependency is
`vlucas/phpdotenv`, which loads database credentials from a `.env` file so that
secrets are kept out of version control. `composer.json` and `composer.lock` are
committed to the repository; the `vendor/` folder and the `.env` file are not —
run `composer install` and create your `.env` as described above.

## External APIs

The application calls a few public APIs at runtime for enhancement features
(destination images via Pexels, currency conversion via exchangerate-api). These
are non-critical: the core application runs without them. The data-population
script `api/populateDatabase.php` was used to gather seed data.

