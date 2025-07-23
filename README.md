# 📝 Task Manager Application

A full-stack task management application built with **Laravel (API)** as the backend and **React + Vite** as the frontend. It supports task creation, assignment, filtering, status updates, and user management.

---

## 🚀 Features

- Create, view, edit, and delete tasks
- Assign tasks to users
- Filter tasks by status or assigned user
- Paginated task listing
- SweetAlert modals for confirmation and alerts
- Reusable modal components
- Status update via dropdown (pending / completed)

---

## 🛠️ Tech Stack

### Backend
- Laravel 10+
- RESTful API with Resource Controllers
- MySQL / MariaDB
- Repository Pattern (SOLID principles)
- Seeder and Factory support
---

## 📦 Installation

### Backend (Laravel)

```bash
cd backend
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan serve
Ensure you have a database configured in .env.

please run db:seed 
