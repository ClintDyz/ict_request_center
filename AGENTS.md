# AGENTS.md - Resource System Development Guide

This document provides guidance for agentic coding agents working in this Laravel-based resource system codebase.

## Project Overview

- **Framework**: Laravel 8.x
- **PHP Version**: ^7.3|^8.0
- **Testing**: PHPUnit 9.x
- **Frontend**: Laravel Mix (Bootstrap, Sass, Axios)
- **Key Dependencies**: Maatwebsite Excel, TCPDF, PHPSpreadsheet

---

## Build / Test Commands

### Installation
```bash
composer install
cp .env.example .env
php artisan key:generate
npm install
```

### Development
```bash
# Start Laravel server
php artisan serve

# Watch frontend assets
npm run watch

# Build frontend for production
npm run prod
```

### Running Tests
```bash
# Run all tests
php artisan test

# Or using PHPUnit directly
./vendor/bin/phpunit

# Run a single test class
./vendor/bin/phpunit tests/Unit/ExampleTest.php

# Run a single test method
./vendor/bin/phpunit --filter test_example

# Run specific test suite
./vendor/bin/phpunit --testsuite Unit
./vendor/bin/phpunit --testsuite Feature
```

### Database
```bash
php artisan migrate
php artisan migrate:fresh --seed
php artisan db:seed
```

---

## Code Style Guidelines

### PHP Formatting
- Follow PSR-12 coding standard
- Use 4 spaces for indentation (no tabs)
- Maximum line length: 120 characters
- Use strict types: `declare(strict_types=1);` at top of PHP files

### Naming Conventions
- **Classes**: `PascalCase` (e.g., `RstblController`, `AccreditationService`)
- **Methods/Functions**: `camelCase` (e.g., `getResourceSpeaker()`, `processAccreditation()`)
- **Variables**: `camelCase` (e.g., `$resourceList`, `$accreditationData`)
- **Constants**: `UPPER_CASE` with underscores (e.g., `MAX_UPLOAD_SIZE`)
- **Database Tables**: `snake_case` (e.g., `rstbl`, `accreditations`)
- **Database Columns**: `snake_case` (e.g., `created_at`, `user_id`)

### File Organization
```
app/
  Http/
    Controllers/    # Controller classes
    Middleware/     # Custom middleware
    Requests/       # Form requests (create validation classes here)
  Models/           # Eloquent models
  Services/         # Business logic (create this directory for services)
  Mail/             # Mailable classes
  Providers/        # Service providers
database/
  migrations/       # Database migrations
  seeders/          # Database seeders
  factories/        # Model factories
```

### Imports
- Use absolute namespace imports
- Group vendor imports separately from app imports
- Sort alphabetically within groups

```php
use App\Models\Accreditation;
use App\Models\Rstbl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
```

### Models (Eloquent)
- Extend `Model` class
- Define `$table` if not following convention
- Use `$fillable` for mass assignment protection
- Define relationships using method names that reflect the relationship type

```php
class Rstbl extends Model
{
    protected $table = 'rstbl';
    protected $fillable = ['name', 'email', 'status'];

    public function trainings()
    {
        return $this->hasMany(RsTraining::class, 'rs_id');
    }
}
```

### Controllers
- Use dependency injection for services/models
- Return consistent response types (JSON or View)
- Keep controllers thin - delegate logic to services

```php
public function index(Request $request)
{
    $resources = $this->resourceService->getAll($request->filters());
    return view('resources.index', compact('resources'));
}
```

### Error Handling
- Use try-catch for operations that may fail
- Log exceptions using `Log::error()`
- Return meaningful error messages to users
- Use Laravel's validation for form inputs

```php
try {
    $this->accreditationService->process($data);
} catch (\Exception $e) {
    Log::error('Accreditation processing failed: ' . $e->getMessage());
    return back()->with('error', 'Failed to process accreditation.');
}
```

### Database Migrations
- Use descriptive migration names
- Always use `up()` for changes and `down()` for reversal
- Use `foreignId()` for relationships

```php
public function up()
{
    Schema::create('accreditations', function (Blueprint $table) {
        $table->id();
        $table->foreignId('rstbl_id')->constrained()->onDelete('cascade');
        $table->string('accreditation_type');
        $table->timestamps();
    });
}
```

### Views
- Use Blade templates with `.blade.php` extension
- Use semantic HTML
- Include proper CSRF tokens in forms
- Use Laravel Mix assets (`mix()` helper)

### Routes
- Use resource routes when appropriate: `Route::resource('resources', ResourceController::class);`
- Group routes by middleware: `Route::middleware(['auth'])->group(() => { ... });`

---

## Common Patterns

### Service Layer Pattern
Create service classes in `app/Services/` for business logic:

```php
// app/Services/AccreditationService.php
namespace App\Services;

class AccreditationService
{
    public function process(array $data): Accreditation
    {
        // Business logic here
    }
}
```

### Form Requests
Extract validation logic to request classes:

```php
// app/Http/Requests/StoreResourceRequest.php
class StoreResourceRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
        ];
    }
}
```

---

## Notes

- This is a resource speaker management system with accreditation tracking
- Primary models: `Rstbl` (resource speaker), `Accreditation`, `RsTraining`
- Uses TCPDF for PDF generation
- Uses Maatwebsite Excel for spreadsheet exports
