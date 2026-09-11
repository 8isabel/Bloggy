<?php
session_start();
require("../db/con.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($name === '' || $password === '') {
        echo "Vul alles in. <a href='../index.php'>Terug</a>";
        exit;
    }

    try {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $query = "INSERT INTO users (name, password) VALUES (:name, :password)";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':password', $hash);
        $stmt->execute();

        $_SESSION['user_id'] = $pdo->lastInsertId();
        $_SESSION['username'] = $name;
        header("Location: ../index.php");
        exit;
    } catch (PDOException $e) {
        echo "Registratie mislukt (naam bestaat misschien al). <a href='../index.php'>Terug</a>";
    }
}
