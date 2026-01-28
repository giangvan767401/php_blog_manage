# Blog Management System

A powerful, modern blog management system built with Laravel 11, designed for ease of use and efficient content management.

## 🌟 Features

### For Users
- **Secure Authentication:** Built-in registration and login system.
- **Easy Content Creation:** Rich text editor (Summernote) for crafting beautiful blog posts.
- **Image Support:** Upload cover images for your news/articles.
- **Categorization & Tagging:** Organize content with categories and multiple tags.
- **Interactive Comments:** Engage with other authors through a dedicated comment system.
- **Personal Dashboard:** Manage your own posts (edit, delete, view status).
- **Notifications:** Get notified when your post is approved or when you receive new comments.

### For Admins
- **Content Moderation:** Review, approve, or reject pending posts with admin notes.
- **Featured Content:** Mark posts as "Hot/Trending" to highlight them on the homepage.
- **Category Management:** Full CRUD operations for global categories.
- **User Activity Overview:** Track views and engagement across the platform.

## 🛠️ Tech Stack

- **Backend:** [Laravel 11](https://laravel.com/) (PHP 8.2+)
- **Frontend:** 
  - [Tailwind CSS](https://tailwindcss.com/) for modern UI styling.
  - [Blade](https://laravel.com/docs/blade) Template Engine.
  - [Alpine.js](https://alpinejs.dev/) for interactive elements.
  - [Summernote](https://summernote.org/) for WYSIWYG editing.
- **Database:** MySQL / MariaDB.
- **Frontend Build Tool:** [Vite](https://vitejs.dev/).

## 🚀 Installation Guide

Follow these steps to set up the project locally:

### 1. Clone the Repository
```bash
git clone <your-repository-url>
cd blog_manage
```

### 2. Install Dependencies
```bash
composer install
npm install
```

### 3. Environment Configuration
Copy the `.env.example` to `.env` and update your database credentials:
```bash
cp .env.example .env
```
Generate the application key:
```bash
php artisan key:generate
```

### 4. Database Setup
Run the migrations to create the necessary tables:
```bash
php artisan migrate
```

### 5. Running the Application
Compile assets and start the development server:
```bash
npm run dev
php artisan serve
```
Access the application at `http://localhost:8000`.

## 📁 Project Structure

- `app/Models/`: Eloquent models (News, Category, Tag, Comment, User).
- `app/Http/Controllers/`: Core business logic and request handling.
- `routes/news.php`: Custom route definitions for blog functionalities.
- `resources/views/`: Blade templates for the frontend UI.
- `database/migrations/`: Database schema definitions.

## 📝 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
