<?php

$host = "localhost";
$dbname = "bloggy";
$user = "bloggy";
$pass = "y5Osf!LOhh3e&2qt";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $pdo->exec("
        CREATE TABLE IF NOT EXISTS users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL
        )
    ");

    $pdo->exec("
        CREATE TABLE IF NOT EXISTS blogs (
            id INT AUTO_INCREMENT PRIMARY KEY,
            user_id INT NOT NULL,
            title VARCHAR(200) NOT NULL,
            author VARCHAR(100) NOT NULL,
            category VARCHAR(50) NOT NULL,
            content TEXT NOT NULL,
            layout VARCHAR(50) NOT NULL,
            image VARCHAR(255) DEFAULT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (user_id) REFERENCES users(id)
        )
    ");
} catch (PDOException $e) {
    die("Database verbinding mislukt: " . $e->getMessage());
}
