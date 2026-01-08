## Database Instructions

### Create database
   1. Laravel 11+ uses SQLite by default. Ensure the `database/database.sqlite` file exists.
   2. You can create it manually if it doesn't exist: `touch database/database.sqlite`

### Create tables
   1. Run the migrations to create the database schema:
   ```bash
   php artisan migrate
   ```

### Open in DB Browser for SQLite
   1. Download and install DB Browser for SQLite from https://sqlitebrowser.org/dl/
   2. Open the `database/database.sqlite` file from the project folder.

### Feed the database with test data
   1. Use the seeder to populate the database with initial test data:
   ```bash
   php artisan db:seed
   ```
   2. To refresh the database and re-seed (Caution: This deletes all data):
   ```bash
   php artisan migrate:fresh --seed
   ```

