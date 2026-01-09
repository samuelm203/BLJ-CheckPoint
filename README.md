# CheckPoint 🚩

CheckPoint is a modern, modular learning and task management system built with **Laravel 12**. Designed for educational institutions and corporate training, it streamlines progress tracking for both students and supervisors.

[![Laravel Version](https://img.shields.io/badge/Laravel-v12-FF2D20?style=flat-square&logo=laravel)](https://laravel.com)
[![PHP Version](https://img.shields.io/badge/PHP-v8.4-777BB4?style=flat-square&logo=php)](https://www.php.net)
[![Pest Testing](https://img.shields.io/badge/Tests-Pest-000000?style=flat-square)](https://pestphp.com)
[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg?style=flat-square)](https://opensource.org/licenses/MIT)

## ✨ Key Features

### 👤 Dual-Role Support
- **Supervisors**: Manage modules, register new accounts, and oversee the learning environment.
- **Students**: Track personal learning progress, complete tasks, and view achievements.

### 📂 Learning Management
- **Modular Structure**: Organize content into logical learning modules.
- **Granular Tasks**: Break down modules into actionable tasks for precise tracking.
- **Progress Insights**: Native tracking for completion status at both module and task levels.

### 🎨 Modern Experience
- **Responsive UI**: Built with Tailwind CSS for a seamless experience across all devices.
- **Clean Dashboards**: Tailored views for different user roles to maximize productivity.

## 🚀 Tech Stack

- **Framework**: [Laravel 12](https://laravel.com)
- **Language**: [PHP 8.4+](https://php.net)
- **Database**: PostgreSQL / MySQL / SQLite
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
   We've included a handy setup script to get you up and running quickly:
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

We maintain high standards through rigorous testing. Run the test suite using Pest:

```bash
php artisan test
```

## 📂 Project Structure

- `app/Models`: Core business logic (`User`, `Module`, `Task`).
- `app/Http/Controllers`: Request handling for Auth, Dashboards, and Modules.
- `database/migrations`: Relational schema for progress tracking.
- `resources/views`: Blade templates with a component-based architecture.
- `routes/web.php`: Defined access points for Students and Supervisors.

## 📄 License

The CheckPoint project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
