# CheckPoint 🚩

CheckPoint is a modern, modular learning and task management system built with **Laravel 12**. It helps users track their progress through various modules and tasks with ease and precision.

[![Laravel Version](https://img.shields.io/badge/Laravel-v12-FF2D20?style=flat-square&logo=laravel)](https://laravel.com)
[![PHP Version](https://img.shields.io/badge/PHP-v8.4-777BB4?style=flat-square&logo=php)](https://www.php.net)
[![Pest Testing](https://img.shields.io/badge/Tests-Pest-000000?style=flat-square)](https://pestphp.com)
[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg?style=flat-square)](https://opensource.org/licenses/MIT)

## ✨ Features

- 📂 **Module Management**: Organize learning content into structured modules.
- ✅ **Task Tracking**: Detailed tasks within modules to track granular progress.
- 👤 **User Profiles**: Custom user roles and extended profile fields (first name, surname).
- 📊 **Progress Completion**: Native tracking for user module and task completion.
- 🎨 **Modern UI**: Styled with Tailwind CSS for a sleek, responsive experience.

## 🚀 Tech Stack

- **Framework**: [Laravel 12](https://laravel.com)
- **Language**: [PHP 8.4+](https://php.net)
- **Database**: PostgreSQL / MySQL / SQLite (Laravel compatible)
- **Frontend**: [Tailwind CSS](https://tailwindcss.com) & [Vite](https://vitejs.dev)
- **Testing**: [Pest PHP](https://pestphp.com)
- **Tooling**: Laravel Boost & Laravel Herd

## 🛠️ Getting Started

### Prerequisites

- PHP 8.4 or higher
- Composer
- Node.js & NPM
- [Laravel Herd](https://herd.laravel.com) (Recommended) or Laravel Sail

### Installation

1. **Clone the repository:**
   ```bash
   git clone https://github.com/your-username/checkpoint.git
   cd checkpoint
   ```

2. **Run the setup command:**
   We've included a handy setup script in `composer.json` to get you up and running quickly:
   ```bash
   composer run setup
   ```
   *This will install dependencies, create your `.env` file, generate an app key, run migrations, and build your frontend assets.*

3. **Start the development server:**
   ```bash
   composer run dev
   ```

4. **Access the application:**
   Visit `http://checkpoint.test` (if using Herd) or the URL provided by `php artisan serve`.

## 🧪 Testing

We take quality seriously. Run the test suite using Pest:

```bash
composer test
```
Or directly via artisan:
```bash
php artisan test
```

## 📂 Project Structure

- `app/Models`: Contains `User`, `Module`, and `Task` models.
- `database/migrations`: Defined schema for users, modules, tasks, and progress tracking.
- `resources/views`: Blade templates using a unified layout component.
- `routes/web.php`: Application entry points (Home, About, Contact).

## 📄 License

The CheckPoint project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
