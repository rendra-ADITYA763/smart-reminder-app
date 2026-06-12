<?php
$host = 'localhost';
$user = 'root';
$pass = ''; // Default XAMPP password is empty
$dbname = 'smart_reminder';

$conn = new mysqli($host, $user, $pass);

if ($conn->connect_error) {
    die(json_encode(['error' => 'Database connection failed: ' . $conn->connect_error]));
}

// Create database if not exists
$conn->query("CREATE DATABASE IF NOT EXISTS $dbname");
$conn->select_db($dbname);

// Create tables if they don't exist
$conn->query("CREATE TABLE IF NOT EXISTS habits (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL DEFAULT 1,
    activity VARCHAR(255) NOT NULL,
    hour INT NOT NULL,
    completedToday TINYINT(1) DEFAULT 0,
    lastNotified INT DEFAULT -1
)");

$conn->query("CREATE TABLE IF NOT EXISTS schedule (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL DEFAULT 1,
    subject VARCHAR(255) NOT NULL,
    day VARCHAR(50) NOT NULL,
    time VARCHAR(50) NOT NULL
)");

$conn->query("CREATE TABLE IF NOT EXISTS events (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL DEFAULT 1,
    name VARCHAR(255) NOT NULL,
    date DATE NOT NULL,
    loc VARCHAR(255) NOT NULL
)");

$conn->query("CREATE TABLE IF NOT EXISTS logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL DEFAULT 1,
    type VARCHAR(50) NOT NULL,
    message TEXT NOT NULL,
    time VARCHAR(100) NOT NULL
)");

// Migrate existing tables to include user_id if it doesn't exist
$tables = ['habits', 'schedule', 'events', 'logs'];
foreach ($tables as $table) {
    $result = $conn->query("SHOW COLUMNS FROM `$table` LIKE 'user_id'");
    if ($result->num_rows == 0) {
        $conn->query("ALTER TABLE `$table` ADD user_id INT NOT NULL DEFAULT 1");
    }
}

$conn->query("CREATE TABLE IF NOT EXISTS user_profile (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL DEFAULT 'Stranger'
)");

// Users table for authentication
$conn->query("CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'user') NOT NULL DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)");

// Insert default profile
$conn->query("INSERT INTO user_profile (id, name) SELECT 1, 'Stranger' WHERE NOT EXISTS (SELECT 1 FROM user_profile WHERE id = 1)");

// Seed default admin account (password: admin123)
$defaultAdminHash = password_hash('admin123', PASSWORD_DEFAULT);
$conn->query("INSERT INTO users (name, email, password, role) 
    SELECT 'Administrator', 'admin@smart-reminder.com', '$defaultAdminHash', 'admin' 
    WHERE NOT EXISTS (SELECT 1 FROM users WHERE email = 'admin@smart-reminder.com')");

return $conn;
?>
