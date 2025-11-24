# 📌 Laravel 12 RESTful API — Authentication & Simple Post CRUD

Proyek ini adalah RESTful API sederhana yang dibangun menggunakan **Laravel 12** dengan **Sanctum** untuk autentikasi berbasis token. API ini menyediakan fitur:

-   🔐 Registrasi User
-   🔑 Login menggunakan Bearer Token
-   🚪 Logout & revoke token
-   📝 CRUD Post sederhana
-   🧑‍💼 Post hanya bisa diubah/dihapus oleh pemiliknya
-   🛡 Menggunakan middleware proteksi sanctum

## 🚀 Features

### 🔐 Authentication

-   Register User
-   Login (get Bearer Token)
-   Logout (revoke Token)
-   Protect API Routes using Sanctum

### 📝 Post CRUD

-   Create Post
-   Read All Posts (pagination optional)
-   Read Single Post
-   Update Post (only owner)
-   Delete Post (only owner)

---

## 🧰 Tech Stack

-   **Framework : Laravel 12**
-   **Token-based authentication : Sanctum Authentication**
-   **Database : MySQL**
-   **Dokumentasi API : Swagger**
-   **PHP 8.3+**

---

## 📦 Installation

### 1️⃣ Clone Repository

```bash
git clone https://github.com/esnurohman/RestApi-laravel.git
cd RestApi-laravel
```

### 2️⃣ Instal Dependencies

```bash
composer install
```

### 3️⃣ Copy Environment File

```bash
cp .env.example .env
```

### 4️⃣ Generate App Key

```bash
php artisan key:generate
```

### 5️⃣ Configure Database

Edit file .env

```bash
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### 6️⃣ Run Migration

```bash
php artisan migrate
```

### 7️⃣ Install Sanctum

```bash
php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
```

## 📁 Project Structure

```bash
app/
 ├── Http/
 │    ├── Controllers/
 │    │     ├── AuthController.php
 │    │     └── PostController.php
 │    └── Middleware/
 ├── Models/
 │    ├── User.php
 │    └── Post.php
routes/
 ├── api.php

```

## 🧪 Testing with Postman

1. Register → Login

2. Copy Bearer Token

3. Pada Authorization:

-   **Type: Bearer Token**

-   **Paste Token**

4. Akses semua route CRUD Post

## 📝 License

MIT License — bebas digunakan dan dikembangkan.

## ⭐ Support

Jika repository ini membantu, jangan lupa kasih ⭐ Star di GitHub!
