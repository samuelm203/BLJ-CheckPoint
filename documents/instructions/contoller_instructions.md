## Controller Instructions

### Create a new controller
   ```bash
   php artisan make:controller ControllerName
   ```

### Best Practices
   1. Keep controllers thin by moving business logic to Service classes or Models.
   2. Use Form Requests for validation. Create them with:
      ```bash
      php artisan make:request StoreItemRequest
      ```
   3. Use type hinting for dependencies in the constructor or method signatures.
   4. Return Eloquent Resources for API responses.

### Where to find the controller?
   Controllers are located in: `app/Http/Controllers/`
