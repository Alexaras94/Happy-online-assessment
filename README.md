# Happy Online Blog API

A RESTful API for a blog application built with **Laravel 12**.  
This application manages **Users, Posts, Comments, Categories, and Tags** using a professional **Repository–Service** architecture.

---

## 📋 Table of Contents

- [Features](#-features)
- [Requirements](#-requirements)
- [Installation](#-installation)
- [Running the Application](#-running-the-application)
- [API Documentation](#-api-documentation)

---

## ✨ Features

- **Authentication:**  
  JWT-based authentication (Login, Register, Refresh, Logout)

- **Posts:**  
  CRUD operations  
  Filtering by **Author**, **Tag**, **Category**  
  Pagination

- **Comments:**  
  Add comments to posts  
  View user comments

- **Categories:**  
  Hierarchical category structure

- **Logic Automations:**  
  Auto-tagging **"new"** on create  
  Auto-tagging **"edited"** on update  
  Email notification to authors on new comments

- **Security:**  
  Strict policies ensuring users can only edit/delete their own content

---

## 🛠 Requirements

- **PHP >= 8.2**
- **Composer**
- **MySQL** (or SQLite/PostgreSQL)

---

## 🚀 Installation

### 1. Clone the repository

```bash
git clone <your-repo-url>
cd happy-online-api
```

### 2. Install Dependencies

```bash
composer install
```

### 3. Environment Setup

```bash
cp .env.example .env
```

Update `.env`:

- **Set your database credentials:**

```ini
DB_DATABASE=your_db
DB_USERNAME=your_user
DB_PASSWORD=your_pass
```

- **To test email notifications without using a mail server:**

```ini
MAIL_MAILER=log
```

### 4. Generate Application Key

```bash
php artisan key:generate
```

### 5. Generate JWT Secret

```bash
php artisan jwt:secret
```

### 6. Run Migrations and Seeders

```bash
php artisan migrate:fresh --seed
```

---

## 🏃 Running the Application

Start local development server:

```bash
php artisan serve
```

Your API will be available at:

```bash
http://localhost:8000/api
```

---

## 📖 API Documentation

A full **OpenAPI (Swagger)** specification is available in the `http://localhost:8000/swagger/documentation#/` route.

### Key Endpoints

| Method | Endpoint             | Description                     | Auth Required |
|--------|-----------------------|---------------------------------|---------------|
| POST   | /api/auth/register   | Register a new user             | No            |
| POST   | /api/auth/login      | Login and get Token             | No            |
| GET    | /api/posts           | List all posts (Filterable)     | No            |
| POST   | /api/posts           | Create a new post               | Yes           |
| GET    | /api/posts/{id}      | View a single post              | No            |
| PUT    | /api/posts/{id}      | Update a post (Author only)     | Yes           |
| DELETE | /api/posts/{id}      | Delete a post (Author only)     | Yes           |
| POST   | /api/comments        | Add a comment to a post         | Yes           |
| GET    | /api/categories      | List all categories             | No            |

---



```bash
php artisan test
```

### Manual Testing (Postman)

- **Login:**  
  Send a POST request to `/api/auth/login` to obtain a Bearer Token.

- **Authorization:**
  ```
  Authorization: Bearer <token>
  ```

- **Filters Example:**
  ```
  GET /api/posts?tag=laravel&author_id=1
  ```


---
