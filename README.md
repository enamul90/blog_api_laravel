<p align="center">
  <a href="https://laravel.com" target="_blank">
    <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo">
  </a>
</p>

<p align="center">
  <a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
  <a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
  <a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
  <a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## 🚀 Overview
This project is a **Laravel REST API** that provides:
- 🔐 User authentication (register, login, logout, password reset, OTP verification)
- 📂 Category management (CRUD operations)
- 📝 Blog management (CRUD operations with category linkage and image handling)

---

## ⚙️ Requirements
- PHP >= 8.1
- Composer
- Laravel >= 10.x
- MySQL or PostgreSQL
- Postman / cURL for API testing

---

## 🔐 Authorization APIs
| Method | Endpoint | Description |
|--------|----------|-------------|
| POST   | `/api/register` | Register a new user |
| POST   | `/api/login` | Login and get token |
| POST   | `/api/logout` | Logout user |
| POST   | `/api/password/reset` | Request password reset |
| POST   | `/api/otp/send` | Send OTP via email |
| POST   | `/api/otp/verify` | Verify OTP |

---

## 📂 Category APIs
| Method | Endpoint | Description |
|--------|----------|-------------|
| POST   | `/api/categories` | Create category (name + description) |
| GET    | `/api/categories` | Get all categories |
| GET    | `/api/categories/{id}` | Get category by ID |
| PUT    | `/api/categories/{id}` | Update category |
| DELETE | `/api/categories/{id}` | Delete category |

---

## 📝 Blog APIs
| Method | Endpoint | Description |
|--------|----------|-------------|
| POST   | `/api/blogs` | Create blog (title, content, category, image) |
| GET    | `/api/blogs` | Get all blogs |
| GET    | `/api/blogs/{id}` | Get blog by ID |
| GET    | `/api/blogs/category/{id}` | Get blogs by category (with category name + description) |
| PUT    | `/api/blogs/{id}` | Update blog (including image) |
| DELETE | `/api/blogs/{id}` | Delete blog |

---





