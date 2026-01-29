# CheckPoint

CheckPoint is a Laravel 12 application designed for supervisors (coaches) and students (learners) to manage modules and tasks. It provides a structured way for supervisors to assign modules to students, track their progress, and manage educational content.

## Features

- **Dual Role System**: Separate dashboards and functionalities for Supervisors (Coaches) and Students (Learners).
- **Module Management**: Create, assign, and track educational modules.
- **Task Tracking**: Supervisors can add tasks to modules, and students can mark them as completed.
- **Student Management**: Supervisors can manage their list of students.
- **Progress Monitoring**: Real-time progress tracking for students within assigned modules.

## Tech Stack

- **Framework**: [Laravel 12](https://laravel.com)
- **PHP**: 8.2+
- **Frontend**: [Tailwind CSS 4](https://tailwindcss.com), [Vite](https://vitejs.dev)
- **Database**: SQLite (default)
- **Testing**: [Pest 4](https://pestphp.com)

## Requirements

- PHP 8.2 or higher
- Composer
- Node.js & NPM
- SQLite (or another supported database)

## Setup & Installation

1.  **Clone the repository**:
    ```bash
    git clone <repository-url>
    cd CheckPoint
    ```

2.  **Run the setup script**:
    The project includes a convenient setup command that handles dependency installation, environment configuration, and database migrations.
    ```bash
    composer run setup
    ```
    This script will:
    - Install PHP dependencies (`composer install`)
    - Create `.env` from `.env.example` (if it doesn't exist)
    - Generate an application key
    - Run database migrations
    - Install NPM dependencies
    - Build frontend assets

3.  **Alternative Manual Setup**:
    If you prefer to run steps manually:
    ```bash
    composer install
    cp .env.example .env
    php artisan key:generate
    touch database/database.sqlite # For SQLite
    php artisan migrate
    npm install
    npm run build
    ```

## Development

To start the development environment (including the Vite dev server, Laravel server, and queue listener):

```bash
composer run dev
```

Or run them separately:
```bash
php artisan serve
npm run dev
```

## Available Scripts

Defined in `composer.json`:
- `composer run setup`: Full project initialization.
- `composer run dev`: Starts all development services concurrently.
- `composer run test`: Clears config and runs Pest tests.

Defined in `package.json`:
- `npm run dev`: Starts Vite development server.
- `npm run build`: Builds frontend assets for production.

## Environment Variables

Key variables to configure in your `.env` file:
- `DB_CONNECTION`: Default is `sqlite`.
- `APP_URL`: Your application URL (default: `http://localhost`).
- `QUEUE_CONNECTION`: Default is `database`.

Refer to `.env.example` for a full list of available variables.

## Testing

The project uses Pest for testing. To run the test suite:

```bash
composer run test
```

Or using Artisan:
```bash
php artisan test
```

## Project Structure

- `app/Http/Controllers`: Application logic and request handling.
- `database/migrations`: Database schema definitions.
- `resources/views`: Blade templates for the UI.
- `routes/web.php`: Web route definitions.
- `tests/`: Feature and Unit tests using Pest.

## TODOs

- [ ] Implement full content for Privacy and Terms pages.
- [ ] Add more comprehensive unit tests for core logic.
- [ ] Documentation for API endpoints (if any are added).

## License

This project is open-sourced software licensed under the [MIT license](LICENSE).
