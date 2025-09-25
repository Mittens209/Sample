<?php
// Load environment variables
function loadEnv($path) {
    if (!file_exists($path)) {
        die("Environment file not found: $path");
    }
    
    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) {
            continue; // Skip comments
        }
        
        list($key, $value) = explode('=', $line, 2);
        $key = trim($key);
        $value = trim($value);
        
        if (!array_key_exists($key, $_SERVER) && !array_key_exists($key, $_ENV)) {
            putenv(sprintf('%s=%s', $key, $value));
            $_ENV[$key] = $value;
            $_SERVER[$key] = $value;
        }
    }
}

// Load .env file
loadEnv(__DIR__ . '/.env');

// Database connection
$servername = $_ENV['DB_HOST'];
$username = $_ENV['DB_USERNAME'];
$password = $_ENV['DB_PASSWORD'];
$dbname = $_ENV['DB_NAME'];
$port = $_ENV['DB_PORT'];

// connect database
$conn = new mysqli($servername, $username, $password, "", $port);

// create database
$conn->query("CREATE DATABASE IF NOT EXISTS $dbname");
$conn->select_db($dbname);

// create table
$create_table = "CREATE TABLE IF NOT EXISTS form_data (
    id INT AUTO_INCREMENT PRIMARY KEY,
    int_a INT NOT NULL,
    int_b INT NOT NULL,
    string_c VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";


$conn->query($create_table);

// form
if ($_POST) {
    $a = $_POST['a'];
    $b = $_POST['b'];
    $c = $_POST['c'];
    
    // insert to database
    $sql = "INSERT INTO form_data (int_a, int_b, string_c) VALUES ($a, $b, '$c')";
    $conn->query($sql);
    
    // Calculate sum
    $sum = $a + $b;
    
    // Reverse string c manually
    $reversed_c = "";
    for ($i = strlen($c) - 1; $i >= 0; $i--) {
        $reversed_c .= $c[$i];
    }
    
    echo "<h3>Results:</h3>";
    echo "<p>Sum of {a,b}: $sum</p>";
    echo "<p>Reversed string c: $reversed_c</p>";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Simple Form</title>
</head>
<body>
    <h2>Form with 3 Inputs</h2>
    <form method="POST">
        <label>Integer A:</label>
        <input type="number" name="a" required><br><br> 
        
        <label>Integer B:</label>
        <input type="number" name="b" required><br><br>
        
        <label>String C:</label>
        <input type="text" name="c" required><br><br>
        
        <input type="submit" value="Submit">
    </form>
</body>
</html>
