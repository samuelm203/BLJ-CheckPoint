## Pint
**Description:**
Laravel Pint is an opinionated PHP code style fixer

### Install pint
Open the terminal and run the following command:
```bash
  composer require laravel/pint --dev   
  ```

### Run pint
   Open the terminal and run the following command to format the entire project:
   ```bash
   vendor/bin/pint
   ```

### Run pint on changed files only
   ```bash
   vendor/bin/pint --dirty
   ```

### Run pint on a specific directory or file
   ```bash
   vendor/bin/pint app/Http/Controllers
   vendor/bin/pint app/Models/User.php
   ```
