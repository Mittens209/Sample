# Test_DB Project - AI Coding Agent Instructions

## Project Overview
This is a simple PHP database testing application that demonstrates form handling, MySQL database operations, and basic HTML rendering. The project consists of two main files serving different purposes.

## Architecture & Key Components

### Core Files
- **`sample.php`**: Main application file combining PHP backend logic with HTML frontend
- **`.php-preview-router.php`**: Development router for HTML preview extensions with enhanced error handling

### Database Pattern
The project uses a direct MySQL connection pattern:
- Connection details stored in `.env` file (never commit this file!)
- Environment variables loaded via custom `loadEnv()` function in `sample.php`
- Auto-creates database and table `form_data` if they don't exist
- Uses basic mysqli without prepared statements (security consideration for production)

### Form Processing Flow
1. HTML form accepts 3 inputs: two integers (a, b) and one string (c)
2. PHP processes POST data directly without validation
3. Data inserted into `form_data` table with auto-generated ID and timestamp
4. Results calculated: sum of integers + manual string reversal
5. Results displayed immediately above the form

## Development Patterns

### File Structure Convention
- Single-file application pattern: PHP logic and HTML in same file
- Router file uses security measures: directory traversal prevention, CORS headers
- No separation of concerns (MVC) - everything in one file for simplicity

### Database Operations
```php
// Pattern used throughout project
$conn = new mysqli($servername, $username, $password, "", $port);
$conn->query("CREATE DATABASE IF NOT EXISTS $dbname");
$conn->select_db($dbname);
```

### String Processing
Manual string reversal implementation instead of using `strrev()`:
```php
for ($i = strlen($c) - 1; $i >= 0; $i--) {
    $reversed_c .= $c[$i];
}
```

## Development Workflow

### Running the Application
- Requires PHP with mysqli extension and MySQL server running on localhost:3306
- Access via web server or PHP built-in server
- Uses `.php-preview-router.php` for development preview capabilities

### Database Requirements
- MySQL server with root access (configure credentials in `.env` file)
- Copy `.env.example` to `.env` and update with your database credentials
- No manual database setup required - application auto-creates schema
- Table structure: `id (INT AUTO_INCREMENT), int_a (INT), int_b (INT), string_c (VARCHAR(255)), created_at (TIMESTAMP)`

## Code Conventions

### Variable Naming
- Simple single-letter variables for form inputs: `$a`, `$b`, `$c`
- Descriptive names for computed values: `$sum`, `$reversed_c`
- Database variables use full names: `$servername`, `$username`, `$dbname`

### Error Handling
- Router implements try-catch for PHP execution errors
- Database operations use basic query execution without error checking in main file
- Form validation relies on HTML `required` attributes only

## Security Notes
- Direct SQL insertion without prepared statements (vulnerability present)
- Database credentials stored in `.env` file (excluded from version control)
- Router prevents directory traversal attacks
- CORS enabled for all origins in development router

## When Modifying This Codebase
- Maintain single-file simplicity for `sample.php`
- Keep manual string processing pattern for educational purposes
- Preserve auto-database-creation functionality
- Consider security implications when adding new database operations